<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Doctor */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="doctor-form row">


    <div class="col-sm-12 col-md-6 col-md-offset-3">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->textInput() ?>

    <?= $form->field($model, 'area_id')->textInput() ?>

    <?= $form->field($model, 'profession_id')->dropDownList($profession_list_drop); ?>
    <?php // $form->field($model, 'profession_id')->textInput() ?>



    <div class="row">
        <div class="col-sm-12 text-center">
            <?=   Html::img( Yii::$app->params['frontendhost'].'/'.  $model->photo,['width'=>'150px','height'=>'150px','class'=>'img-rounded']);  ?>
        </div>
    </div>




    <?php
    echo $form->field($model_upload, 'imageFiles[]')->widget(FileInput::classname(), [
        'language' => 'ru',
        'options' => ['accept' => 'image/*','multiple' => false],
        'pluginOptions' => ['previewFileType' => 'any']
    ])->label("Фотографии");
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
