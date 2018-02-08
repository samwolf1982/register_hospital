<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Doctor */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Doctors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
//            'id',
            'name',
            'surname',
            'patronymic',
            'phone',
//            'status_id',
            'area_id',

            [
                'attribute'=>'profession_id',
                'value'=>  $model->profession->name
            ],

            [
                'attribute'=>'photo',
                'format'=>'raw',
                'value'=> Html::img( Yii::$app->params['frontendhost'].'/'. $model->photo,['width'=>'50px','height'=>'50px','class'=>'img-rounded'])
            ],

//            'photo:ntext',
        ],
    ]) ?>

</div>
