<?php

namespace shop\services\admin\shop;

use shop\entities\Meta;
use shop\entities\shop\Category;
use shop\forms\admin\shop\CategoryForm;
use shop\repositories\shop\CategoryRepository;
use shop\repositories\shop\ProductRepository;
use yii\helpers\Inflector;

class CategoryService
{
    private $categories;
    private $products;

    public function __construct()
    {
        $this->categories = new CategoryRepository();
        $this->products = new ProductRepository();
    }

    public function create(CategoryForm $form)
    {
        $parent = $this->categories->get($form->parentId);
        $category = Category::create(
            $form->name,
            Inflector::slug($form->name),
            $form->title,
            $form->description,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords)
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
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords)
        );
        if ($form->parentId !== $category->parent->id) {
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }
        $this->categories->save($category);
    }

    public function moveUp($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($prev = $category->prev) {
            $category->insertBefore($prev);
        }
        $this->categories->save($category);
    }

    public function moveDown($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($next = $category->next) {
            $category->insertAfter($next);
        }
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($this->products->existByMainCategory($category->id)) {
            throw new \DomainException('Unable to remove brand with products.');
        }
        $this->categories->remove($category);
    }

    private function assertIsNotRoot(Category $category)
    {
        if ($category->isRoot()) {
            throw new \DomainException('Update to manage the root category.');
        }
    }
}