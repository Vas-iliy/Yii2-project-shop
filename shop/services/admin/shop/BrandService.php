<?php

namespace shop\services\admin\shop;

use shop\entities\Meta;
use shop\entities\shop\Brand;
use shop\forms\admin\shop\BrandForm;
use shop\repositories\shop\BrandRepository;
use shop\repositories\shop\ProductRepository;
use yii\helpers\Inflector;

class BrandService
{
    private $brands;
    private $products;

    public function __construct()
    {
        $this->brands = new BrandRepository();
        $this->products = new ProductRepository();
    }

    public function create(BrandForm $form): Brand
    {
        $brand = Brand::create(
            $form->name,
            Inflector::slug($form->name),
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brands->save($brand);
        return $brand;
    }


    public function edit($id, BrandForm $form)
    {
        $brand = $this->brands->get($id);
        $brand->edit(
            $form->name,
            Inflector::slug($form->name),
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brands->save($brand);
    }

    public function remove($id)
    {
        $brand = $this->brands->get($id);
        if ($this->products->existByBrand($brand->id)) {
            throw new \DomainException('Unable to remove brand with products.');
        }
        $brand->status = '0';
        $this->brands->save($brand);
    }
}