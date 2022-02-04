<?php

namespace shop\repositories\shop;

use shop\entities\shop\Brand;
use yii\web\NotFoundHttpException;

class BrandRepository
{
    public function get($id)
    {
        if (!$brand = Brand::findOne($id)) throw new NotFoundHttpException('Tag is not found.');
        return $brand;
    }

    public function save(Brand $brand)
    {
        if (!$brand->save()) throw new \RuntimeException('Saving error.');
    }

    public function remove(Brand $brand)
    {
        $brand->status = 0;
        if (!$brand->save()) throw new \RuntimeException('Removing error.');
    }
}