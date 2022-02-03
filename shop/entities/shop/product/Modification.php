<?php

namespace shop\entities\shop\product;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $price
*/
class Modification extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%shop_modification}}';
    }

    public static function create($code, $name, $price)
    {
        $modification = new static();
        $modification->code = $code;
        $modification->name = $name;
        $modification->price = $price;
        return $modification;
    }

    public function edit($code, $name, $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    public function isIdEqualTo($id)
    {
        return $this->id === $id;
    }

    public function isCodeEqualTo($code)
    {
        return $this->code === $code;
    }
}