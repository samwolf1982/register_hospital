<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Calendar */

$this->title = 'Добавить график';
$this->params['breadcrumbs'][] = ['label' => 'Calendars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-create">



    <?= $this->render('_form', [
        'model' => $model,'doctor_list_drop'=>$doctor_list_drop,'options_list'=>$options_list,'value_name'=>$value_name,
    ]) ?>

</div>
