<?php

use yii\bootstrap\Html;

echo $form->field($model, 'cod')->textInput(['maxlength' => true,'class'=>'hidden']);
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

<ul>
    <?php

    //echo Html::ul($profession_list);

    echo Html::ul($profession_list, ['item' => function($item, $index) {
        return Html::tag(
            'li',
            Html::a($item, [''], ['class' => 'btn btn-lg btn-primary']),
//            Html::submitButton('Save', ['class' => 'btn btn-success','value'=>uniqid()]),
            ['class' => 'doctor_li']
        );
    }, 'class' => 'flex_wrap']);

    ?>
</ul>
<?php

   // echo $form->field($model_profession, 'id')->dropDownList($profession_list,['class'=>'form-control','reqired'=>true]);


