<?php

use dosamigos\selectize\SelectizeTextInput;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Calendar */
/* @var $form yii\widgets\ActiveForm */
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

<div class="calendar-form">

    <?php $form = ActiveForm::begin(); ?>
    <p for="">Виберите дату</p  >
    <?php echo DatePicker::widget(['model' => $model,'attribute' => 'date', 'language' => 'ru', 'dateFormat' => 'yyyy-MM-dd']); ?>
    <?php // $form->field($model, 'date')->textInput() ?>

    <?php //$form->field($model, 'doctor_id')->textInput() ?>
    <?= $form->field($model, 'doctor_id')->dropDownList($doctor_list_drop,[
        'prompt' => 'Выберите врача...'
    ]); ?>


    <?= $form->field($model, 'timetable_work')->textInput() ?>



    <label for="">Отметьте время приема</label>
    <?php

    echo SelectizeTextInput::widget([
        'name' => 'tags2',
        'value' => $value_name,

        'clientOptions' => [
            'plugins'=> ['drag_drop','remove_button'],
            'delimiter'=> ',',
            'persist'=> 'false',
            'options'=> $options_list,
            'valueField'=>'id',
            'labelField'=>'name',
            'searchField'=>'name',
        ],
    ]);

    ?>

    <?php // $form->field($model, 'timetable')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->hiddenInput()->label("") ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
