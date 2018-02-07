<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Завка успешно создана';
?>
<style>
    .jumbotron{
        border: solid 1px grey;
    }
</style>

<style type="text/css" media="print">
    button,.hideprint, .footer, .header {display: none; }
</style>

<div class="site-index">

    <div class="jumbotron hideprint">

                SOME INFO BLOck
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-sm-12">

                <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

                <div class="panel panel-default">

                    <button class="pull-right" onclick="window.print();">Печать</button>
                    <div class="panel-body">

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


                            </div>

                        </div>


                    </div>
                </div>




            </div>
        </div>


        <div class="jumbotron hideprint">

            SOME INFO BLOck 2



        </div>


        <div class="row hideprint">
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




