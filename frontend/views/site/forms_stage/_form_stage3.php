<?php


use yii\bootstrap\Html;
use yii\grid\GridView;



echo $form->field($model, 'cod')->textInput(['maxlength' => true,'class'=>'hidden'])->label('');
?>

<style>
    .wrap_time_list{
        display: flex;flex-wrap: wrap;
        padding-bottom: 1em;
    }
    .time_list_1{
       background-color: red;
        flex-basis: 30%;
    }
    .time_list_2{
        background-color: gold;
        flex-basis: 70%;
    }

    .wrap_doc img  {
        width: 140px;
        height: 140px;
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
        padding: 0.5em;
    }

</style>



<?php

foreach ($doc_list as $item) {  ?>
    <div class="wrap_time_list">
        <div class="time_list_1">
            <div class="wrap_doc">
                <img src="<?=$item->photo?>" alt="foto" class="img-circle">
                <div class="doc_info">
                 <span>  <?=$item->name." ".$item->surname.' '.$item->patronymic;?> </span>
                 <span>  <?=$selected_profesion->name;?> </span>

                    <div class="schedule-doctor-schedule">
                        <div class="day-wrapper">
                            <span class="day">Пн, 05</span>
                                   8:00-12:00			</div>
                        <div class="day-wrapper">
                            <span class="day">Ср, 07</span>
                            13:00-17:00			</div>
                        <div class="day-wrapper">
                            <span class="day">Пт, 09</span>
                            8:00-12:00			</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="time_list_2">
            <div class="week">
                <div class="week_day">
                    <div class="week_header">
                       <span>Понедельник</span>
                    </div>
                    <div class="week_day">
<?php foreach (range(1,16) as $item) { ?>
    <div class="day_time">
      <?php echo    Html::submitButton('10:00', ['class' => 'btn btn-success okibtn' ,'name'=>'dok_order' ,'value'=>$item.'_'.uniqid()]);

 ?>
    </div>
<?php } ?>


                    </div>
                </div>
                <div class="week_day">
                    <div class="week_header">
                        <span>Вторник</span>
                    </div>
                    <div class="week_day">
                        <div class="day_time">10:00</div>
                        <div class="day_time">10:30</div>
                    </div>
                </div>
                <div class="week_day">
                    <div class="week_header">
                        <span>Понедельник</span>
                    </div>
                    <div class="week_day">
                        <div class="day_time">10:00</div>
                        <div class="day_time">10:30</div>
                    </div>
                </div>
                <div class="week_day">
                    <div class="week_header">
                        <span>Понедельник</span>
                    </div>
                    <div class="week_day">
                        <div class="day_time">10:00</div>
                        <div class="day_time">10:30</div>
                    </div>
                </div>
                <div class="week_day">
                    <div class="week_header">
                        <span>Понедельник</span>
                    </div>
                    <div class="week_day">
                        <div class="day_time">10:00</div>
                        <div class="day_time">10:30</div>
                    </div>
                </div>
                <div class="week_day">
                    <div class="week_header">
                        <span>Понедельник</span>
                    </div>
                    <div class="week_day">
                        <div class="day_time">10:00</div>
                        <div class="day_time">10:30</div>
                    </div>
                </div>
                <div class="week_day">
                    <div class="week_header">
                        <span>Понедельник</span>
                    </div>
                    <div class="week_day">
                        <div class="day_time">10:00</div>
                        <div class="day_time">10:30</div>
                    </div>
                </div>
            </div>

        </div>

    </div>
<?php }  ?>




