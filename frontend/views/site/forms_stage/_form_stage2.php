<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;

echo $form->field($model, 'cod')->textInput(['maxlength' => true,'class'=>'hidden'])->label('');
//    echo $form->field($model, 'client_name')->textInput(['maxlength' => true]);
//    echo $form->field($model, 'client_surname')->textInput(['maxlength' => true]);
//    echo $form->field($model, 'client_patronymic')->textInput(['maxlength' => true]);
//    echo $form->field($model, 'born')->textInput(['maxlength' => true]);


?>
    <style>
        .flex_wrap{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .flex_wrap li{
            list-style: none;
            padding-bottom: 1em;
        }
    </style>


    <?php

echo $form->field($model, 'profession_id')->dropDownList($profession_list_drop, ['onchange'=>'
    $("#doc_submit").click();
']);


if (false){
    echo Html::ul($profession_list, ['item' => function($item, $index) {
        return Html::tag(
            'li',
            Html::submitButton($item->name, ['class' => 'btn btn-success' ,'name'=>'dokid' ,'value'=>$item->id]),
            ['class' => 'doctor_li']
        );
    }, 'class' => 'flex_wrap']);
}


    ?>


    <div class="form-group hidden">
        <?= Html::submitButton('hidden click', ['class' => 'btn btn-success', 'id'=>'doc_submit']) ?>
    </div>




<?php

   // echo $form->field($model_profession, 'id')->dropDownList($profession_list,['class'=>'form-control','reqired'=>true]);


