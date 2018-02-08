<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Profession */

$this->title = 'Обновить';
$this->params['breadcrumbs'][] = ['label' => 'Professions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profession-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
