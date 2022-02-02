<?php

namespace entities\shop\product;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Photo extends ActiveRecord
{
    public static function create(UploadedFile $file)
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id)
    {
        return $this->id === $id;
    }

    public static function tableName()
    {
        return '{{%shop_photos}}';
    }
}