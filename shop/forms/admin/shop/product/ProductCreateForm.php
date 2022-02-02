<?php

namespace forms\admin\shop\product;

use entities\shop\Characteristic;
use entities\shop\product\Product;
use forms\admin\MetaForm;
use forms\CompositeForm;

class ProductCreateForm extends CompositeForm
{
    public $brandId;
    public $code;
    public $name;

    public function __construct($config = [])
    {
        $this->price = new PriceForm();
        $this->meta = new MetaForm();
        $this->categories = new CategoriesForm();
        $this->photos = new PhotosForm();
        $this->tags = new TagsForm();
        $this->values = array_map(function (Characteristic $characteristic) {
           return new ValueForm($characteristic);
        }, Characteristic::find()->orderBy('sort')->all());
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['brandId', 'code', 'name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['brandId'], 'integer'],
            [['code'], 'unique', 'targetClass' => Product::class],
        ];
    }

    protected function internalForms()
    {
        return ['price', 'meta', 'photos', 'categories', 'tags', 'values'];
    }
}