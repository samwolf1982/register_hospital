<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DayPeriod */

$this->title = 'Изменить Время приема';
$this->params['breadcrumbs'][] = ['label' => 'Day Periods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="day-period-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
