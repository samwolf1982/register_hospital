<?php

use yii\bootstrap\Html;

echo $form->field($model, 'cod')->textInput(['maxlength' => true]);
    ?>

        <div class="form-group">
        <?= Html::submitButton('Далее', ['class' => 'btn btn-success', 'id'=>'doc_submit']) ?>
    </div>

