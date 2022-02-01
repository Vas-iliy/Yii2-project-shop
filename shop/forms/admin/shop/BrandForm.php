<?php

namespace forms\admin\shop;

use entities\shop\Brand;

class BrandForm
{
    public $name;
    private $_brand;

    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->_brand = $brand;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass' => Tag::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_tag->id] : null],
        ];
    }
}