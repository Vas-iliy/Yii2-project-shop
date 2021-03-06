<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\Brand */

$this->title = 'Update Brand: ' . $brand->name;
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brand->name, 'url' => ['view', 'id' => $brand->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="brand-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>