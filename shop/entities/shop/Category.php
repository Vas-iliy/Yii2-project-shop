<?php


namespace entities\shop;


use entities\behaviors\MetaBehavior;
use entities\Meta;
use entities\shop\queries\CategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public $meta;

    public static function tableName()
    {
        return '{{%shop_categories}}';
    }

    public static function create($name, $alias, $title, $description, Meta $meta)
    {
        $category = new static();
        $category->name = $name;
        $category->alias = $alias;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;
        return $category;
    }

    public function edit($name, $alias, $title, $description, Meta $meta)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->title = $title;
        $this->description = $description;
        $this->meta = $meta;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class,
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new CategoryQuery(static::class);
    }

}