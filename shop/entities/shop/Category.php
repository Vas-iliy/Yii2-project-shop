<?php

namespace shop\entities\shop;

use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use shop\entities\shop\queries\CategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property \shop\entities\Meta $meta
 *
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 * @property Category $prev
 * @property Category $next
 * @mixin NestedSetsBehavior
 */
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
        $this->status = 1;
        $this->name = $name;
        $this->alias = $alias;
        $this->title = $title;
        $this->description = $description;
        $this->meta = $meta;
    }

    public function getSeoTitle()
    {
        return $this->meta->title ?: $this->getHeadingTile();
    }

    public function getHeadingTile()
    {
        return $this->title ?: $this->name;
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