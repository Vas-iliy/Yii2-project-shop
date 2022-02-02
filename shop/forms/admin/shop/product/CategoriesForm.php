<?php

namespace forms\admin\shop\product;

use entities\shop\product\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;
    public $others = [];

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->main = $product->category_id;
            $this->others = ArrayHelper::getColumn($product->categoryAssigments, 'category_id');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['main'], 'required'],
            [['main'], 'integer'],
            ['others', 'each', 'rule' => ['integer']],
        ];
    }
}