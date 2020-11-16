<?php

use kerneldos\extmodule\models\Module;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Module */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>
    <?= $form->field($model, 'is_bootstrap')->checkbox() ?>
    <?= $form->field($model, 'is_main')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
