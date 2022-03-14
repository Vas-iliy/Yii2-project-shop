<?php


namespace frontend\controllers\shop;


use shop\entities\shop\product\Product;
use yii\web\Controller;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    public function actionIndex()
    {
        Product::find()->active()->all();
        return $this->render('index');
    }
}