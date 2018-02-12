<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use yii\jui\DatePicker;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предварительная запись';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    @media print
    {
        .no-print, .no-print *,.pagination, thead
        {
            display: none !important;
        }
    }
</style>

<div class="order-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="no-print">
        <button class="pull-right" onclick="window.print();">Печать</button>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'cod',
           // 'client_name:ntext',
            //'client_surname:ntext',
            //'client_patronymic:ntext',
            //'born',
            //'doctor_id',
            'doctor_name:ntext',
            //'profession_id',
            //'period_id',

            //'statusorder_id',

            [
                'attribute' => 'date',
                'value' => 'date',
              //  'filter' => DatePicker::widget(['model' => $searchModel,'attribute' => 'date', 'language' => 'ru', 'dateFormat' => 'yyyy-MM-dd','type'=>"input-daterange"]),
                'filter' =>

                  //  DatePicker::widget(['model' => $searchModel,'attribute' => 'date', 'language' => 'ru', 'dateFormat' => 'yyyy-MM-dd','type'=>"input-daterange"]),
                 DateRangePicker::widget([
 'model' => $searchModel,
    'attribute'=>'date',
    'convertFormat'=>true,

    'pluginOptions'=>[
        //'timePicker'=>true,
        //'timePickerIncrement'=>30,

        'locale'=>[
            'format'=>'Y-m-d',
            'separator' => ':',
        ]
    ]
])
            ],
            'time_value',
           // 'date',
            //'date_created',
            //'hash',

            ['class' => 'yii\grid\ActionColumn','template' => '<div class="no-print"> {delete} </div>'],
        ],
    ]); ?>
</div>
