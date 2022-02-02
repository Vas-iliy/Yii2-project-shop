<?php


namespace services\admin\shop;


use entities\Meta;
use entities\shop\Brand;
use forms\admin\shop\BrandForm;
use repositories\shop\BrandRepository;
use yii\helpers\Inflector;

class BrandService
{
    private $brands;

    public function __construct()
    {
        $this->brands = new BrandRepository();
    }

    public function create(BrandForm $form)
    {
        $brand = Brand::create(
            $form->name,
            Inflector::slug($form->name),
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords),
        );
        $this->brands->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form)
    {
        $brand = $this->brands->get($id);
        $brand->create(
            $form->name,
            Inflector::slug($form->name),
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords),
        );
        $this->brands->save($brand);
        return $brand;
    }
}