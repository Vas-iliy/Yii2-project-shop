<?php

namespace frontend\controllers\shop;

use shop\forms\shop\AddToCartForm;
use shop\forms\shop\ReviewForm;
use shop\forms\shop\search\SearchForm;
use shop\readModels\Shop\BrandReadRepository;
use shop\readModels\Shop\CategoryReadRepository;
use shop\readModels\Shop\ProductReadRepository;
use shop\readModels\Shop\TagReadRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    private $products;
    private $categories;
    private $brands;
    private $tags;

    public function __construct($id, $module,
                                ProductReadRepository $products,
                                CategoryReadRepository $categories,
                                BrandReadRepository $brands,
                                TagReadRepository $tags, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->products = $products;
        $this->categories = $categories;
        $this->brands = $brands;
        $this->tags = $tags;
    }

    public function actionIndex()
    {
        $dataProvider = $this->products->getAll();
        $category = $this->categories->getRoot();
        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCategory($id)
    {
        if (!$category = $this->categories->find($id)) {
            throw new NotFoundHttpException('No categories');
        }
        $dataProvider = $this->products->getAllByCategory($category);
        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionBrand($id)
    {
        if (!$brand = $this->brands->find($id)) {
            throw new NotFoundHttpException('No brand');
        }
        $dataProvider = $this->products->getAllByBrand($brand);
        return $this->render('brand', [
            'brand' => $brand,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionTag($id)
    {
        if (!$tag = $this->tags->find($id)) {
            throw new NotFoundHttpException('No tag');
        }
        $dataProvider = $this->products->getAllByTag($tag);
        return $this->render('tag', [
            'tag' => $tag,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionProduct($id)
    {
        if (!$product = $this->products->find($id)) {
            throw new NotFoundHttpException('No product');
        }
        $this->layout = 'blank';
        $cartForm = new AddToCartForm($product);
        $reviewForm = new ReviewForm();

        return $this->render('product', compact('product', 'cartForm', 'reviewForm'));
    }

    public function actionSearch()
    {
        $form = new SearchForm();
        $form->load(\Yii::$app->request->queryParams);
        $form->validate();

        $dataProvider = $this->products->search($form);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchForm' => $form,
        ]);
    }
}