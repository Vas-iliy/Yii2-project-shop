<?php

use shop\entities\shop\Tag;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\shop\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">
    <p>
        <?= Html::a('Create Tag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box box-default">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'attribute' => 'name',
                    'value' => function(Tag $model) {
                        return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                ],
                'alias',
                [
                    'attribute' => 'status',
                    'filter' => [
                            false => 'Deleted',
                            true => 'Published',
                    ],
                    'value' => function(Tag $model) {
                        return $model->status ? '<span class="text-green">Published</span>' : '<span class="text-red">Deleted</span>';
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, Tag $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
    </div>
</div>
