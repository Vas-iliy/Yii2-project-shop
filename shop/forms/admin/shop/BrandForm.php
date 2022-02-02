<?php

namespace forms\admin\shop;

use entities\shop\Brand;
use forms\CompositeForm;
use forms\admin\MetaForm;

class BrandForm extends CompositeForm
{
    public $name;
    private $_brand;

    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null],
        ];
    }

    protected function internalForms()
    {
        return ['meta'];
    }
}