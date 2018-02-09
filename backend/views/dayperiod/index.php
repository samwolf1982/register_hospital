<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DayperiodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Время приема';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="day-period-index">


<div class="row">
    <div class="col-sm-12 col-md-6 col-md-offset-3">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Создать время приема', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                // 'id',
                'name:ntext',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>

</div>
