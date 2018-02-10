<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CalendarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'График работы';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .time_btn{
        margin: 2px;
    }
</style>

<div class="calendar-index">

    <div class="row">
        <div class="col-sm-12 col-md-8 col-md-offset-2">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый график', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
           // 'date',
            [
                'attribute' => 'date',
                'value' => 'date',
                'filter' => DatePicker::widget(['model' => $searchModel,'attribute' => 'date', 'language' => 'ru', 'dateFormat' => 'yyyy-MM-dd']),
            ],

            [
                'attribute' => 'doctor_id',
                'label'=>'ФИО врача',
                'filter' =>true,
                'format' => 'raw',
                'value' => function ($model) {
                    return    Html::tag('span',$model->doctor->surname.' '.$model->doctor->name.' '.$model->doctor->patronymic )."<br/>".
                        Html::tag('span',$model->doctor->profession->name);  ;
                },
            ],

           // 'doctor_id',

            [
                'attribute' => 'timetable',
                'label'=>'График работы',
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


        //    'timetable:ntext',
          //  'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    </div>
</div>

