<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cod') ?>

    <?= $form->field($model, 'client_name') ?>

    <?= $form->field($model, 'client_surname') ?>

    <?= $form->field($model, 'client_patronymic') ?>

    <?php // echo $form->field($model, 'born') ?>

    <?php // echo $form->field($model, 'doctor_id') ?>

    <?php // echo $form->field($model, 'doctor_name') ?>

    <?php // echo $form->field($model, 'profession_id') ?>

    <?php // echo $form->field($model, 'period_id') ?>

    <?php // echo $form->field($model, 'time_value') ?>

    <?php // echo $form->field($model, 'statusorder_id') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'hash') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
