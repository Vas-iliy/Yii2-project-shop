<?php

namespace shop\entities\shop\product;

use yii\db\ActiveRecord;

class CategoryAssignment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%shop_category_assignments}}';
    }

    public static function create($categoryId)
    {
        $assignment = new static();
        $assignment->category_id = $categoryId;
        return $assignment;
    }

    public function isForCategory($id)
    {
        return $this->category_id == $id;
    }
}