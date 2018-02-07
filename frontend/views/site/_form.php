<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form ">
    <?php  Pjax::begin(['id' => 'step_order_form']); ?>

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <?php
          if ($stage==1){
            echo  $this->render('forms_stage/_form_stage1.php', [ 'model' => $model,'form'=>$form]);
          }elseif ($stage==2){
            echo  $this->render('forms_stage/_form_stage2.php', [ 'model' => $model,'form'=>$form,'profession_list'=>$profession_list,'model_profession'=>$model_profession,'profession_list'=>$profession_list,'profession_list_drop'=>$profession_list_drop,]);
          }elseif ($stage==3){
              echo  $this->render('forms_stage/_form_stage3.php', [ 'model' => $model,'form'=>$form,'profession_list'=>$profession_list,'model_profession'=>$model_profession,'doc_list'=>$doc_list,'selected_profesion'=>$selected_profesion,'next_week'=>$next_week,]);
          }


    ?>



    <?php // $form->field($model, 'cod')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'client_name')->textarea(['rows' => 6]) ?>

    <?php // $form->field($model, 'client_surname')->textarea(['rows' => 6]) ?>

    <?php // $form->field($model, 'client_patronymic')->textarea(['rows' => 6]) ?>

    <?php // $form->field($model, 'born')->textInput() ?>

    <?php // $form->field($model, 'doctor_id')->textInput() ?>

    <?php // $form->field($model, 'period_id')->textInput() ?>

    <?php // $form->field($model, 'statusorder_id')->textInput() ?>

    <?php // $form->field($model, 'date')->textInput() ?>

    <?php // $form->field($model, 'date_created')->textInput() ?>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>




<?php

Modal::begin([
    'header'=>'<h4>Подтверждение записи</h4>',
    'id'=>'time_modal',
    'size'=>'modal-lg',
    'clientEvents' => [
        'show.bs.modal' => new \yii\web\JsExpression("function(event){
         console.log(event.relatedTarget);
                             
            var rel_target =$(event.relatedTarget);
             $(this).attr('href');
            var target = $(this).data('target');
            console.log(target);
            console.log(this);
               $(this).find('#modalContent', $(target)).load(rel_target.attr('href'));
            
            //$('.modal-content', $(target)).load(rel_target.attr('href'));
        }"),
        ]
]);

echo "<div id='modalContent'>
me modal !!!!
</div>";
Modal::end();
?>