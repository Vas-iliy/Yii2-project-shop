<?php


namespace services\admin\shop;


use entities\Meta;
use entities\shop\product\Product;
use entities\shop\Tag;
use forms\admin\shop\product\CategoriesForm;
use forms\admin\shop\product\PhotosForm;
use forms\admin\shop\product\ProductCreateForm;
use repositories\shop\BrandRepository;
use repositories\shop\CategoryRepository;
use repositories\shop\ProductRepository;
use repositories\shop\TagRepository;
use yii\helpers\Inflector;

class ProductService
{
    private $products;
    private $brands;
    private $categories;
    private $tags;

    public function __construct()
    {
        $this->products = new ProductRepository();
        $this->brands = new BrandRepository();
        $this->categories = new CategoryRepository();
        $this->tags = new TagRepository();
    }

    public function create(ProductCreateForm $form)
    {
        $brand = $this->brands->get($form->brandId);
        $category = $this->categories->get($form->categories->main);
        $product = Product::create(
            $brand->id,
            $category->id,
            $form->code,
            $form->name,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords),
        );
        $product->setPrice($form->price->new, $form->price->old);

        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }
        foreach ($form->values as $value) {
            $product->setValue($value->id, $value->value);
        }
        foreach ($form->photos->files as $file) {
            $product->addPhoto($file);
        }
        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $product->assignTag($tag->id);
        }
        foreach ($form->tags->newNames as $tagName) {
            if (!$tag = $this->tags->findByName($tagName)) {
                $tag = Tag::create($tagName, Inflector::slug($tagName));
                $this->tags->save($tag);
            }
            $product->assignTag($tag->id);
        }

        $this->products->save($product);
        return $product;
    }

    public function changeCategories($id, CategoriesForm $form)
    {
        $product = $this->products->get($id);
        $category = $this->categories->get($form->main);
        $product->changeMainCategory($category->id);
        $product->revokeCategories();
        foreach ($form->others as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }
        $this->products->save($product);
    }

    public function addPhotos($id, PhotosForm $form)
    {
        $product = $this->products->get($id);
        foreach ($form->files as $file) {
            $product->addPhoto($file);
        }
        $this->products->save($product);
    }

    public function movePhotoUp($id, $photoId)
    {
        $product = $this->products->get($id);
        $product->movePhotoUp($photoId);
        $this->products->save($product);
    }

    public function movePhotoDown($id, $photoId)
    {
        $product = $this->products->get($id);
        $product->movePhotoDown($photoId);
        $this->products->save($product);
    }

    public function removePhoto($id, $photoId)
    {
        $product = $this->products->get($id);
        $product->removePhoto($photoId);
        $this->products->save($product);
    }

    public function remove($id)
    {
        $product = $this->products->get($id);
        $this->products->remove($product);
    }
}