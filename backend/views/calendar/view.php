<?php

use yii\helpers\Html;
use yii\helpers\Url;
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

</style>

<div class="calendar-view">



    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
                'attribute' => 'timetable',
                'label'=>'График работы на текущий день',
                'filter' =>false,
                'format' => 'raw',
                'value' => function ($model) {
                    $json=    json_decode($model->timetable);

                    $fin='';
                    // yii::error($json);
                    foreach ($json as $item) {
                        if ($item->type="time"){
                            $fin.=Html::tag('button',$item->val,['class'=>'btn btn-xs  btn-info time_btn']);
                        }else{
                            $fin.=Html::tag('button',$item->val,['class'=>'btn btn-xs  btn-warning time_btn']);
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


    <div class="row">

<?php foreach ($calendar_list_model as $item) { ?>
    <div class="col-md-4">
        <span class="lead pull-left"><?=$item['name']?></span>
        <?= Html::a('Редактировать',Url::toRoute(['calendar/update','id'=>$item['model']->id]),['class'=>'btn btn-xs btn-warning pull-right']);  ?>


        <div class="clearfix"></div>
    <div class="checboxarea panel">
        <div class="panel-body">
                <?php foreach (json_decode($item['model']->timetable) as $item) {
                    if ($item->type="time"){
                   echo Html::tag('button',$item->val,['class'=>'btn btn-xs  btn-info time_btn']);
                    }else{
                  echo Html::tag('button',$item->val,['class'=>'btn btn-xs  btn-warning time_btn']);
                    }
                } ?>
    </div>
    </div>

    </div>
<?php }  ?>





    </div>



</div>
