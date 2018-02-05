<?php

/* @var $this yii\web\View */

use app\components\RegisterclientWidget;
use yii\helpers\Html;

$this->title = 'Med Clinic';
?>
<style>
    .jumbotron{
        border: solid 1px grey;
    }
</style>

<div class="site-index">

    <div class="jumbotron">

                SOME INFO BLOck
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-sm-12">

                <h1 class="text-center"><?= Html::encode("Место подачи заявки") ?></h1>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <?= $this->render('_form', [
                            'model' => $model,'stringHash'=>$stringHash,'stage'=>$stage,'profession_list'=>$profession_list,'profession_list'=>$profession_list,'doc_list'=>$doc_list,'selected_profesion'=>$selected_profesion
                        ]) ?>

                    </div>
                </div>




            </div>
        </div>


        <div class="jumbotron">

            SOME INFO BLOck 2



        </div>


        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
