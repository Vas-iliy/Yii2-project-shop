<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $product shop\entities\shop\product\Product */

$this->title = 'Create Modification';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['shop/product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['shop/product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modification-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
