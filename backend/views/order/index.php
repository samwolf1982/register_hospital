<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предварительная запись';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
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
            'time_value',
            //'statusorder_id',
            'date',
            //'date_created',
            //'hash',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
