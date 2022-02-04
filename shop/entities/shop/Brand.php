<?php

namespace shop\entities\shop;

use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $status
 * @property Meta $meta
 */
class Brand extends ActiveRecord
{
    public $meta;

    public static function tableName(): string
    {
        return '{{%shop_brands}}';
    }

    public static function create($name, $slug, Meta $meta): self
    {
        $brand = new static();
        $brand->name = $name;
        $brand->alias = $slug;
        $brand->meta = $meta;
        return $brand;
    }

    public function edit($name, $slug, Meta $meta): void
    {
        $this->status = 1;
        $this->name = $name;
        $this->alias = $slug;
        $this->meta = $meta;
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
        ];
    }
}