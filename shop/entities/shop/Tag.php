<?php

namespace entities\shop;

use yii\db\ActiveRecord;

class Tag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%shop_tags}}';
    }

    public static function create($name, $alias)
    {
        $tag = new static();
        $tag->name = $name;
        $tag->alias = $alias;
        return $tag;
    }

    public function edit($name, $alias)
    {
        $this->name = $name;
        $this->alias = $alias;
    }
}