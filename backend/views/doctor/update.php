<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doctor */

$this->title = 'Изменить значение';
$this->params['breadcrumbs'][] = ['label' => 'Врач', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="doctor-update">

    <h1 class="hidden"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'profession_list_drop'=>$profession_list_drop,'model_upload'=>$model_upload,

    ]) ?>

</div>
