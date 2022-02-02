<?php


namespace services\admin\shop;


use entities\Meta;
use entities\shop\Brand;
use entities\shop\Category;
use forms\admin\shop\BrandForm;
use forms\admin\shop\CategoryForm;
use repositories\shop\BrandRepository;
use repositories\shop\CategoryRepository;
use yii\helpers\Inflector;

class CategoryService
{
    private $categories;

    public function __construct()
    {
        $this->categories = new CategoryRepository();
    }

    public function create(CategoryForm $form)
    {
        $parent = $this->categories->get($form->parentId);
        $category = Category::create(
            $form->name,
            Inflector::slug($form->name),
            $form->title,
            $form->description,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords),
        );
        $category->appendTo($parent);
        $this->categories->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $category->edit(
            $form->name,
            Inflector::slug($form->name),
            $form->title,
            $form->description,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords),
        );
        if ($form->parentId !== $category->parent->id) {
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $this->categories->remove($category);
    }

    private function assertIsNotRoot(Category $category)
    {
        if ($category->isRoot()) {
            throw new \DomainException('Update to manage the root category.');
        }
    }
}