<?php use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>
<div class="box box-default">
    <div class="box-header with-border">Characteristics</div>
    <div class="box-body">
        <?php foreach ($model->values as $i => $value): ?>
            <?php if ($variants = $value->variantsList()): ?>
                <?= $form->field($value, '[' . $i . ']value')->dropDownList($variants, ['prompt' => '']) ?>
            <?php else: ?>
                <?= $form->field($value, '[' . $i . ']value')->textInput() ?>
            <?php endif ?>
        <?php endforeach; ?>
    </div>
</div>
<?ActiveForm::end()?>