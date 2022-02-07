<?php use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>

<div class="box box-default">
    <div class="box-header with-border">Price</div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model->price, 'new')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model->price, 'old')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
</div>
<?ActiveForm::end()?>