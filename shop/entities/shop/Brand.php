<?php

namespace shop\entities\shop;

use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use yii\db\ActiveRecord;

class Brand extends ActiveRecord
{
    public $meta;

    public static function tableName()
    {
        return '{{%shop_brand}}';
    }

    public static function create($name, $alias, Meta $meta)
    {
        $brand = new static();
        $brand->name = $name;
        $brand->alias = $alias;
        $brand->meta = $meta;
        return $brand;
    }

    public function edit($name, $alias, Meta $meta)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->meta = $meta;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
        ];
    }
}