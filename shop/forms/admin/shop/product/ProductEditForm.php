<?php

namespace shop\forms\admin\shop\product;

use shop\entities\shop\Brand;
use shop\entities\shop\Characteristic;
use shop\entities\shop\product\Product;
use shop\forms\admin\MetaForm;
use shop\forms\CompositeForm;
use yii\helpers\ArrayHelper;

class ProductEditForm extends CompositeForm
{
    public $brandId;
    public $code;
    public $name;
    public $description;

    private $_product;

    public function __construct(Product $product, $config = [])
    {
        $this->brandId = $product->brand_id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->meta = new MetaForm($product->meta);
        $this->tags = new TagsForm($product);
        $this->values = array_map(function (Characteristic $characteristic) use ($product) {
           return new ValueForm($characteristic, $product->getValue($characteristic->id));
        }, Characteristic::find()->orderBy('sort')->all());
        $this->_product = $product;
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

    public function brandsList(): array
    {
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms()
    {
        return ['meta', 'tags', 'values'];
    }
}