<?php

namespace shop\repositories\shop;

use shop\entities\shop\product\Product;
use yii\web\NotFoundHttpException;

class ProductRepository
{
    public function get($id)
    {
        if (!$product = Product::findOne($id)) throw new NotFoundHttpException('Tag is not found.');
        return $product;
    }

    public function existByBrand($id)
    {
        return Product::find()->andWhere(['brand_id' => $id])->exists();
    }

    public function save(Product $product)
    {
        if (!$product->save()) throw new \RuntimeException('Saving error.');
    }

    public function remove(Product $product)
    {
        $product->status = '0';
        if (!$product->save()) throw new \RuntimeException('Removing error.');
    }
}