<?php

namespace shop\services\admin\shop;

use shop\entities\Meta;
use shop\entities\shop\product\Product;
use shop\entities\shop\Tag;
use shop\forms\admin\shop\product\CategoriesForm;
use shop\forms\admin\shop\product\ModificationForm;
use shop\forms\admin\shop\product\PhotosForm;
use shop\forms\admin\shop\product\ProductCreateForm;
use shop\forms\admin\shop\product\ProductEditForm;
use shop\repositories\shop\BrandRepository;
use shop\repositories\shop\CategoryRepository;
use shop\repositories\shop\ProductRepository;
use shop\repositories\shop\TagRepository;
use shop\services\TransactionManager;
use yii\helpers\Inflector;

class ProductService
{
    private $products;
    private $brands;
    private $categories;
    private $tags;
    private $transaction;

    public function __construct()
    {
        $this->products = new ProductRepository();
        $this->brands = new BrandRepository();
        $this->categories = new CategoryRepository();
        $this->tags = new TagRepository();
        $this->transaction = new TransactionManager();
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
        $this->setTags($form, $product);

        return $product;
    }

    public function edit($id, ProductEditForm $form)
    {
        $product = $this->products->get($id);
        $brand = $this->brands->get($id);
        $product->edit(
            $brand->id,
            $form->code,
            $form->name,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords),
        );
        foreach ($form->values as $value) {
            $product->setValue($value->id, $value->value);
        }
        $product->revokeTags();
        $this->setTags($form, $product);

        return $product;
    }

    private function setTags($form,Product $product) {
        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $product->assignTag($tag->id);
        }
        $this->transaction->wrap(function () use ($form, $product){
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, Inflector::slug($tagName));
                    $this->tags->save($tag);
                }
                $product->assignTag($tag->id);
            }
            $this->products->save($product);
        });
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

    public function addRelatedProduct($id, $otherId): void
    {
        $product = $this->products->get($id);
        $other = $this->products->get($otherId);
        $product->assignRelatedProduct($other->id);
        $this->products->save($product);
    }

    public function removeRelatedProduct($id, $otherId): void
    {
        $product = $this->products->get($id);
        $other = $this->products->get($otherId);
        $product->revokeRelatedProduct($other->id);
        $this->products->save($product);
    }

    public function addModification($id, ModificationForm $form): void
    {
        $product = $this->products->get($id);
        $product->addModification(
            $form->code,
            $form->name,
            $form->price,
        );
        $this->products->save($product);
    }

    public function editModification($id, $modificationId, ModificationForm $form): void
    {
        $product = $this->products->get($id);
        $product->editModification(
            $modificationId,
            $form->code,
            $form->name,
            $form->price,
        );
        $this->products->save($product);
    }

    public function removeModification($id, $modificationId): void
    {
        $product = $this->products->get($id);
        $product->removeModification($modificationId);
        $this->products->save($product);
    }

    public function remove($id)
    {
        $product = $this->products->get($id);
        $this->products->remove($product);
    }
}