<?php

namespace forms\admin\shop\product;

use entities\shop\product\Product;
use yii\base\Model;

class PriceForm extends Model
{
    public $old;
    public $new;

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->new = $product->price_new;
            $this->old = $product->price_old;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['new'], 'required'],
            [['new', 'old'], 'integer', 'min' => 0],
        ];
    }

}