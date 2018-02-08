<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DoctorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список врачей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctor-index">

    <h1 class="hidden"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить врача', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'surname',
                'label'=>'ФИО врача',
                'filter' =>true,
                'format' => 'raw',
                'value' => function ($model) {
                    return  $model->name.' '.$model->surname.' '.$model->patronymic;
                },
            ],
            [
                'attribute' => 'profession_id',
                'label'=>'Специализация',
                'filter' =>true,
                'format' => 'raw',
                'value' => function ($model) {
                    return  $model->profession->name;
                },
            ],


//            'name',
//            'surname',
//            'patronymic',
            'phone',
            [
                'attribute' => 'photo',
                'label'=>'Фотография',
                'filter' =>false,
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img( Yii::$app->params['frontendhost'].'/'. $model->photo,['width'=>'50px','height'=>'50px','class'=>'img-rounded']);
                },
            ],


            //'status_id',
            //'area_id',
            //'profession_id',
            //'photo:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
