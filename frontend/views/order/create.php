<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Create Order';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



?>


<div class="order-create">

    <h1><?= Html::encode($this->title). uniqid() ?></h1>

    <div class="panel panel-default">
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,'stringHash'=>$stringHash,'stage'=>$stage,'profession_list'=>$profession_list,'model_profession'=>$model_profession,'dataProvider'=>$dataProvider
    ]) ?>

        </div>
    </div>

</div>
