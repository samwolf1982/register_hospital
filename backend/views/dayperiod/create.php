<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DayPeriod */

$this->title = 'Create Day Period';
$this->params['breadcrumbs'][] = ['label' => 'Day Periods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="day-period-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
