<?php


namespace shop\entities\shop\product\queries;


use shop\entities\shop\product\Product;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere([
           'status' => Product::STATUS_ACTIVE,
        ]);
    }
}