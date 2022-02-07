<?php

use shop\entities\shop\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\shop\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function(Category $model) {
                    $indent = ($model->depth > 1 ? str_repeat('--', $model['depth'] -1) . ' ' : '');
                    return $indent . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
            [
                'value' => function(Category $model) {
                    return
                        Html::a('<i class="fa fa-angle-up"></i>', ['move-up', 'id' => $model->id]) .
                        Html::a('<i class="fa fa-angle-down"></i>', ['move-down', 'id' => $model->id]);
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'text-align: center']
            ],
            'alias',
            'title',
            [
                'attribute' => 'status',
                'filter' => [
                    false => 'Deleted',
                    true => 'Published',
                ],
                'value' => function(Category $model) {
                    return $model->status ? '<span class="text-green">Published</span>' : '<span class="text-red">Deleted</span>';
                },
                'format' => 'raw',
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
