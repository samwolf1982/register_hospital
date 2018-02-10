<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DayPeriod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="day-period-form">

    <div class="row">
        <div class="col-sm-12 col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'type')->dropDownList(['time'=>'время','text'=>'текст']) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>




</div>
