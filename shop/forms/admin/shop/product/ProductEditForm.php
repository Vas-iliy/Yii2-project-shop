<?php

namespace shop\forms\admin\shop\product;

use shop\entities\shop\Characteristic;
use shop\entities\shop\product\Product;
use shop\forms\admin\MetaForm;
use shop\forms\admin\shop\product\TagsForm;
use shop\forms\admin\shop\product\ValueForm;
use shop\forms\CompositeForm;

class ProductEditForm extends CompositeForm
{
    public $brandId;
    public $code;
    public $name;

    private $_product;

    public function __construct(Product $product, $config = [])
    {
        $this->meta = new MetaForm($product->meta);
        $this->tags = new TagsForm($product);
        $this->values = array_map(function (Characteristic $characteristic) {
           return new ValueForm($characteristic, $this->_product->getValue($characteristic->id));
        }, Characteristic::find()->orderBy('sort')->all());
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['brandId', 'code', 'name', 'description'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['brandId'], 'integer'],
            [['description'], 'string'],
            [['code'], 'unique', 'targetClass' => Product::class, 'filter' => $this->_product ? ['<>', 'id', $this->_product->id] : null],
        ];
    }

    protected function internalForms()
    {
        return ['meta', 'tags', 'values'];
    }
}