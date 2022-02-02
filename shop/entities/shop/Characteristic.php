<?php

namespace entities\shop;

use yii\db\ActiveRecord;
use yii\helpers\Json;

class Characteristic extends ActiveRecord
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_FLOAT = 'float';

    public $variants;

    public static function tableName()
    {
        return '{{%shop_characteristics}}';
    }

    public static function create($name, $type, $request, $default, $variants, $sort)
    {
        $category = new static();
        $category->name = $name;
        $category->type = $type;
        $category->request = $request;
        $category->default = $default;
        $category->variants = $variants;
        $category->sort = $sort;
        return $category;
    }

    public function edit($name, $type, $request, $default, $variants, $sort)
    {
        $this->name = $name;
        $this->type = $type;
        $this->request = $request;
        $this->default = $default;
        $this->variants = $variants;
        $this->sort = $sort;
    }

    public function isSelect()
    {
        return count($this->variants) > 0;
    }

    public function afterFind()
    {
        $this->variants = Json::decode($this->getAttribute('variants_json'));
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('variants_json', Json::encode($this->variants));
        return parent::beforeSave($insert);
    }
}