<?php

namespace backend\controllers\shop;

use shop\entities\shop\Tag;
use backend\forms\shop\TagSearch;
use shop\forms\admin\shop\TagForm;
use shop\services\admin\shop\TagService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
{
    private $service;

    public function __construct($id, $module, TagService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new TagForm();
        if ($this->request->isPost) {
            if ($form->load($this->request->post()) && $form->validate()) {
                try {
                    $tag = $this->service->create($form);
                    return $this->redirect(['view', 'id' => $tag->id]);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $tag = $this->findModel($id);
        $form = new TagForm($tag);

        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->edit($tag->id, $form);
                return $this->redirect(['view', 'id' => $tag->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'tag' => $tag,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        }  catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Tag::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
