<?php

use shop\entities\shop\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'alias',
            'title',
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => function(Category $model) {
                    return $model->status ? '<span class="text-green">Published</span>' : '<span class="text-red">Deleted</span>';
                },
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
