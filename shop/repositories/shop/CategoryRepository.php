<?php

namespace shop\repositories\shop;

use shop\entities\shop\Category;
use yii\web\NotFoundHttpException;

class CategoryRepository
{
    public function get($id)
    {
        if (!$category = Category::findOne($id)) throw new NotFoundHttpException('Tag is not found.');
        return $category;
    }

    public function save(Category $category)
    {
        if (!$category->save()) throw new \RuntimeException('Saving error.');
    }

    public function remove(Category $category)
    {
        $category->status = 0;
        if (!$category->save()) throw new \RuntimeException('Removing error.');
    }
}