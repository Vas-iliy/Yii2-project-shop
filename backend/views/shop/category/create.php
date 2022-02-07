<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\Category */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
    <div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
