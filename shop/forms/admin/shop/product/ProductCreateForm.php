<?php

namespace shop\forms\admin\shop\product;

use shop\forms\admin\shop\product\CategoriesForm;
use shop\forms\admin\shop\product\PhotosForm;
use shop\forms\admin\shop\product\PriceForm;
use shop\entities\shop\Characteristic;
use shop\entities\shop\product\Product;
use shop\forms\admin\MetaForm;
use shop\forms\admin\shop\product\TagsForm;
use shop\forms\admin\shop\product\ValueForm;
use shop\forms\CompositeForm;

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
            [['brandId', 'code', 'name', 'description'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['brandId'], 'integer'],
            [['description'], 'string'],
            [['code'], 'unique', 'targetClass' => Product::class],
        ];
    }

    protected function internalForms()
    {
        return ['price', 'meta', 'photos', 'categories', 'tags', 'values'];
    }
}