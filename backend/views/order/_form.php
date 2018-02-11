<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_name')->hiddenInput()->label("") ?>

    <?= $form->field($model, 'client_surname')->hiddenInput()->label("") ?>

    <?= $form->field($model, 'client_patronymic')->hiddenInput()->label("") ?>

    <?= $form->field($model, 'born')->hiddenInput()->label("") ?>

    <?= $form->field($model, 'doctor_id')->textInput() ?>

    <?= $form->field($model, 'doctor_name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'profession_id')->textInput() ?>

    <?= $form->field($model, 'period_id')->textInput() ?>

    <?= $form->field($model, 'time_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'statusorder_id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'hash')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
