<?php

use dosamigos\selectize\SelectizeTextInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\selectize\SelectizeDropDownList;

/* @var $this yii\web\View */
/* @var $model app\models\Calendar */

$this->title =$model->doctor->name.' '.$model->doctor->surname.' '.$model->doctor->patronymic ;
$this->params['breadcrumbs'][] = ['label' => 'Calendars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<style>
    .item{
        margin: 5px!important;
        padding: 5px!important;
        background-color: lightblue!important;
    }
    .item a{
        padding: 5px!important;
    }
</style>

<div class="calendar-update">

    <h1 class="hidden"><?= Html::encode($this->title) ?></h1>
    <p><?= Html::encode($model->date) ?></p>


    <?= Html::img( Yii::$app->params['frontendhost'].'/'. $model->doctor->photo,['width'=>'180px','height'=>'180px','class'=>'img-rounded']); ?>

    <?php // $this->render('_form', ['model' => $model,]) ?>





    <div class="calendar-form">

        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'timetable_work')->textInput() ?>

        <label for="">Отметьте время приема</label>
        <?php

        echo SelectizeTextInput::widget([
            'name' => 'tags2',
            'value' => $value_name,

            'clientOptions' => [
                'plugins'=> ['remove_button'],
                'delimiter'=> ',',
                'persist'=> 'false',
                'options'=> $options_list,
                'valueField'=>'id',
                'labelField'=>'name',
                'searchField'=>'name',
            ],
        ]);

        ?>



        <?= $form->field($model, 'date')->hiddenInput()->label("") ?>

        <?= $form->field($model, 'doctor_id')->hiddenInput()->label(""); ?>

        <?php // $form->field($model, 'timetable')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'created_at')->hiddenInput()->label("") ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>






        <?php ActiveForm::end(); ?>

    </div>








</div>
