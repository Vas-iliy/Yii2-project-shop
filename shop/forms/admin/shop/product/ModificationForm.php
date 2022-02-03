<?php

namespace forms\admin\shop\product;

use entities\shop\product\Modification;
use yii\base\Model;

class ModificationForm extends Model
{
    public $code;
    public $name;
    public $price;
    public $quantity;

    public function __construct(Modification $modification = null, $config = [])
    {
        if ($modification) {
            $this->code = $modification->code;
            $this->name = $modification->name;
            $this->price = $modification->price;
            $this->quantity = $modification->quantity;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['code', 'name', 'quantity'], 'required'],
            [['price'], 'integer'],
        ];
    }
}