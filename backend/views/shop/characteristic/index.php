<?php

use shop\entities\shop\Characteristic;
use shop\helpers\CharacteristicHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\shop\CharacteristicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Characteristics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-index">
    <p>
        <?= Html::a('Create Characteristic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'value' => function(Characteristic $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' =>'type',
                        'filter' => CharacteristicHelper::typeList(),
                        'value' => function(Characteristic $characteristic) {
                            return CharacteristicHelper::typeName($characteristic->type);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'required',
                        'filter' => $searchModel->requiredList(),
                        'format' => 'boolean',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => [
                            false => 'Deleted',
                            true => 'Published',
                        ],
                        'value' => function(Characteristic $model) {
                            return $model->status ? '<span class="text-green">Published</span>' : '<span class="text-red">Deleted</span>';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => ActionColumn::class,
                        'urlCreator' => function ($action, Characteristic $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                         }
                    ],
                ],
            ]); ?>
        </div>
    </div>


</div>
