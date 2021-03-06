<?php


use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;


echo $form->field($model, 'cod')->textInput(['maxlength' => true,'class'=>'hidden'])->label('');
?>

<style>
    .wrap_time_list{
        display: flex;flex-wrap: wrap;
        padding-bottom: 1em;
    }
    .time_list_1{
       /*background-color: red;*/
        flex-basis: 30%;
    }
    .time_list_2{
        /*background-color: gold;*/
        flex-basis: 70%;
    }

    .wrap_doc img  {
        width: 116px;
        height: 116px;
    }


    .wrap_doc{
        display: flex;
    }
    .doc_info{
        flex-direction: column;
        display: flex;
        padding: 0.5em;
    }
    .week{
        display: flex;
        justify-content: space-around;

    }
    .week_header{
        padding: 0.5em;    font-size: 110%;
        font-weight: bold;

    }
    .week_day.talon{
 width: 93px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .week_day{
        /*height: 100%;*/
        align-items: baseline;
    }
    .day_time.hour{
text-align: center;
        padding-bottom: 0.2em;
    }
    .day_time.hour.live{
        position: relative;
        top: 50%;
        /*background-color: lightpink;*/
        border-radius: 4px;
        color: #E2307D;
    }
    .dok_nav{
        display: flex;
        justify-content: space-between;
    }
    .clear_btn{
        border: none!important;
    }
    .clear_btn:hover ,.btn-clear_btn:active, .clear_btn.btn-schedule.disabled:hover, .clear_btn.btn-schedule.disabled:active
    .clear_btn:hover, .clear_btn:active,.clear_btn.btn-schedule.disabled:hover, .clear_btn.btn-schedule.disabled:focus
    {
          background: transparent!important; /* Цвет фона под ссылкой */
          color: #e82654!important; /* Цвет ссылки */
        cursor: default!important;
        text-decoration: none;
        border-color: transparent;

      }


    .clear_btn.btn-schedule.disabled:focus,.clear_btn.btn-schedule.disabled:active {
        outline: none !important;
        box-shadow: none;
    }

    .btn-close-time{
        background-color: lightgrey;
        cursor: initial;
    }
    .btn-close-time:hover{
        background-color: lightgrey;
        border-color: lightgrey;
        color: #e82654!important;
    }


</style>


<div class="dok_nav">
    <div class="link_nav">
      <?php   echo Html::submitButton("Сменить специализацию", ['class' => 'btn btn-schedule', 'name' => 'change', 'value' => '7']); ?>
    </div>
    <div class="link_nav">

        <?php
        if ($next_week){
            echo Html::submitButton("Следущая неделя", ['class' => 'btn btn-schedule', 'name' => 'next_week', 'value' => '7']);
        }else{
            echo Html::submitButton("Предыдущая неделя", ['class' => 'btn btn-schedule', 'name' => 'prev_week', 'value' => '7']);
        }

        ?>
<?php
        echo $form->field($model, 'profession_id')->hiddenInput()->label('');
?>
    </div>
</div>



<?php

foreach ($doc_list as $item) {  ?>
    <div class="wrap_time_list">
        <div class="time_list_1">
            <div class="wrap_doc">
                <img src="<?=$item['doctor']->photo?>" alt="foto" class="img-circle">
                <div class="doc_info">
                 <span>  <?=$item['doctor']->name." ".$item['doctor']->surname.' '.$item['doctor']->patronymic;?> </span>
                 <span>  <?=$selected_profesion->name;?> </span>

                    <div class="schedule-doctor-schedule">
                    <?php   // generate work list

                    foreach ($item['calendar_list'] as $work_list) {  ?>
                        <div class="day-wrapper">
                            <span class="day"><?=$work_list['day_name'];?></span>
                            <?php  yii::error($work_list);  ?>
                            <?=$work_list['timetable_work'];?>


                        </div>

                    <?php   } ?>
                    </div>









                </div>
            </div>

        </div>
        <div class="time_list_2">
            <div class="week">


                <?php foreach ($item['calendar_list'] as $info) { ?>
                    <div class="week_day talon">
                        <div class="week_header">
                            <span><?=$info['day_name'];?></span>
                        </div>
                        <div class="week_day">


                            <?php
                                       if (!is_null($info['doclist']['timetable'])) {   ?>

                                         <?php  foreach ($info['doclist']['timetable'] as $json) { ?>

                                               <?php
                                               // yii::error(['state'=>$json->status]);
                                               if ($json->type=='time'){?>
                                               <div class="day_time hour">
                                                   <?php
                                                   if ($info['active_day']){
                                                       if (!is_null($json->status)){   // уже есть ставка
                                                        //   echo Html::button($json->val, ['class' => 'btn btn-schedule btn-close-time', 'data-target'=>'#time_modal','data-toggle'=>'modal', 'name' => 'dok_order',
                                                          //     'href'=> Url::to(['site/checkorder', 'cod' => $model->cod,'doc_id'=>$item['doctor']->id,'calendar_id'=>$info['calendar_id'],'day_id'=>$json->id]), 'value' => $info['doclist']['doc_id'] . '_' . $json->id]);
                                                           echo Html::button($json->val, ['class' => 'btn btn-schedule btn-close-time', "data-toggle"=>"tooltip","data-placement"=>"top","title"=>"Уже занято",
                                                               'href'=> Url::to(['site/checkorder', 'cod' => $model->cod,'doc_id'=>$item['doctor']->id,'calendar_id'=>$info['calendar_id'],'day_id'=>$json->id]), 'value' => $info['doclist']['doc_id'] . '_' . $json->id]);



                                                       }else{
                                                           echo Html::button($json->val, ['class' => 'btn btn-schedule', 'data-target'=>'#time_modal','data-toggle'=>'modal', 'name' => 'dok_order',
                                                               'href'=> Url::to(['site/checkorder', 'cod' => $model->cod,'doc_id'=>$item['doctor']->id,'calendar_id'=>$info['calendar_id'],'day_id'=>$json->id]), 'value' => $info['doclist']['doc_id'] . '_' . $json->id]);
                                                       }

                                                   }else{
//                                                       echo Html::tag('span',$json->val,['class'=>'in_active_day']);
                                                       echo Html::button($json->val, ['class' => 'clear_btn btn-schedule disabled']);
                                                   }

                                                   ?>
                                               </div>
                                                   <?php } ?>

                                               <?php if ($json->type=='text'){?>
                                                   <div class="day_time hour live">
                                                    <span>
                                                         <?php echo $json->val; ?>
                                                    </span>
                                                   </div>
                                               <?php } ?>
                                               <?php if ($json->type=='empty_day'){?>
                                                   <div class="day_time hour live empty_day">
                                                    <span>
                                                         <?php echo $json->val; ?>
                                                    </span>
                                                   </div>
                                               <?php } ?>




                                           <?php }
                                       }
                            ?>


                        </div>



                    </div>
               <?php } ?>



            </div>

        </div>

    </div>

    <hr>
<?php }  ?>

<?php
//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>






