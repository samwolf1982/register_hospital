<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = $name;
?>


<div class="cn-modal-content">
    <div class="content col-margin-bottom"><div class="col col-4 ta-right"><b>Номер страхового полиса</b></div>
        <div class="col col-8"><?= Html::encode($cod) ?></div>
    </div>


    <div class="content col-margin-bottom"><div class="col col-4 ta-right"><b>Клиника</b></div>
<div class="col col-8"><?= Html::encode($clinic_name) ?></div>
    </div>
<div class="content col-margin-bottom">
    <div class="col col-4 ta-right"><b>Адрес</b></div>
<div class="col col-8"><?= Html::encode($adress) ?></div>
</div>
<div class="content col-margin-bottom"><div class="col col-4 ta-right"><b>Специальность</b></div>
<div class="col col-8">
    <?= Html::encode($doc_spec) ?></div>
</div>



<div class="content col-margin-bottom"><div class="col col-4 ta-right"><b>Услуга</b></div>
<div class="col col-8">
    <?= Html::encode($to_do) ?></div>
</div>
    <div class="content col-margin-bottom"><div class="col col-4 ta-right"><b>Врач</b></div>
        <div class="col col-8">
            <?= Html::encode($doc_name) ?></div>
    </div>

<div class="content col-margin-bottom"><div class="col col-4 ta-right"><b>Дата записи</b></div>
<div class="col col-8"> <?= Html::encode($date) ?>  <b> <?= Html::encode($time) ?></b></div>
</div>



<div class="ta-center">
<?php
                echo Html::a("Записаться",Url::to(['site/success', 'cod' => $cod,'calendar_id'=>$calendar_id,'day_id'=>$day_id]),['class' => 'btn btn-big'] );
              //  Html::button("Записаться", ['class' => 'btn btn-big', 'href'=> Url::to(['site/checkorder', 'cod' => $cod,'calendar_id'=>$calendar_id,'day_id'=>$day_id])]);
    ?>

</div>

</div>





