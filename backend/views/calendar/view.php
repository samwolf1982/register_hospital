<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Calendar */

$this->title = $model->doctor->name.' '.$model->doctor->surname.' '.$model->doctor->patronymic ;
$this->params['breadcrumbs'][] = ['label' => 'Calendars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .time_btn{
        margin: 2px;
    }
    .panel{
        min-height: 140px;
    }

    .marleft10{
        margin-left: 10px;
    }
</style>


<div class="calendar-view">

    <?php

    ?>

    <p>
        <?= Html::a('Изменить график на текущий день', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
           // 'doctor_id',
            [
                'attribute'=>'profession_id',
                'label'=>'Врач',
                'value'=> $model->doctor->name.' '.$model->doctor->surname.' '.$model->doctor->patronymic
            ],


                    [
                'attribute'=>'timetable_work',
                'label'=>'График работы (9:00-18:00)',
                'value'=> $model->timetable_work
            ],



            [
                'attribute' => 'timetable',
                'label'=>'График приема на текущий день',
                'filter' =>false,
                'format' => 'raw',
                'value' => function ($model) {
                    $json=    json_decode($model->timetable);

                    $fin='';
                    // yii::error($json);
                    if (!empty($json)){
                        foreach ($json as $item) {
                            if ($item->type="time"){
                                $fin.=Html::tag('button',$item->val,['class'=>'btn btn-xs  btn-info time_btn']);
                            }else{
                                $fin.=Html::tag('button',$item->val,['class'=>'btn btn-xs  btn-warning time_btn']);
                            }

                        }
                    }

                    return $fin;
                },
            ],

           // 'timetable:ntext',
           // 'created_at',
        ],
    ]) ?>

<div class="clearfix"></div>
    <br>

    <div class="clone_week">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model_monday, 'id_first_week_day')->hiddenInput()->label(""); ?>


        <div class="form-group">
            <?= Html::submitButton('Клонировать в следущую неделю', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Добавить график',Url::toRoute(['calendar/create','id'=>$model->doctor->id]), ['class' => 'btn btn-success']) ?>
        </div>

        <div class="form-group">
        <?php
        if ($prew_week_date_model->id){ ?>

                <?= Html::a('Перейти к предыдущей недели',Url::toRoute(['calendar/view','id'=>$prew_week_date_model->id]), ['class' => 'btn btn-success']) ?>
        <?php  }  ?>

        <?php
             if ($next_week_date_model->id){ ?>

                     <?= Html::a('Перейти к следущей недели',Url::toRoute(['calendar/view','id'=>$next_week_date_model->id]), ['class' => 'btn btn-success']) ?>

         <?php  }  ?>
                 </div>


        <?php ActiveForm::end(); ?>
    </div>

    <div class="row">

<?php foreach ($calendar_list_model as $item) { ?>
    <div class="col-md-4">
        <span class="lead pull-left"><?=$item['name']?></span>

        <?= Html::a('Редактировать',Url::toRoute(['calendar/update','id'=>$item['model']->id]),['class'=>'btn btn-xs btn-warning pull-right marleft10']);  ?>
        <?= Html::a('Перейти',Url::toRoute(['calendar/view','id'=>$item['model']->id]),['class'=>'btn btn-xs btn-success pull-right marleft10']);  ?>



        <?= Html::a('Удалить',Url::toRoute(['calendar/delete','id'=>$item['model']->id]),['class'=>'btn btn-xs btn-danger pull-right marleft10', 'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],]);  ?>








        <div class="clearfix"></div>
    <div class="checboxarea panel">
        <div class="panel-body">

                <?php  $json=json_decode($item['model']->timetable);

               // yii::error($json);
                if (!empty($json)){
                    foreach ($json as $item) {
                        if ($item->type="time"){
                            echo Html::tag('button',$item->val,['class'=>'btn btn-xs  btn-info time_btn']);
                        }else{
                            echo Html::tag('button',$item->val,['class'=>'btn btn-xs  btn-warning time_btn']);
                        }
                    }
                }

                ?>
    </div>
    </div>

    </div>
<?php }  ?>

    </div>




</div>

<?php

$this->registerJs(
    "$(function() {
       setTimeout(function() { $( \"#w2-warning\" ).fadeOut( \"slow\");$( \"#w2-success\" ).fadeOut( \"slow\") }, 2500);   ;
    });",
    View::POS_READY,
    'my-button-handler'.uniqid()
);

?>