<?php

namespace shop\entities\shop;

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

    public static function create($name, $type, $required, $default, $variants, $sort)
    {
        $category = new static();
        $category->name = $name;
        $category->type = $type;
        $category->required = $required;
        $category->default = $default;
        $category->variants = $variants;
        $category->sort = $sort;
        return $category;
    }

    public function edit($name, $type, $required, $default, $variants, $sort)
    {
        $this->status = 1;
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
        $this->default = $default;
        $this->variants = $variants;
        $this->sort = $sort;
    }

    public function isString(): bool
    {
        return $this->type === self::TYPE_STRING;
    }

    public function isInteger(): bool
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat(): bool
    {
        return $this->type === self::TYPE_FLOAT;
    }

    public function isSelect(): bool
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