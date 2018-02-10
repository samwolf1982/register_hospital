<?php

use app\models\Doctor;
use yii\db\Migration;

/**
 * Handles the creation of table `calendar`.
 */
class m180205_000640_create_calendar_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('calendar', [
            'id' => $this->primaryKey(),
            'date'=>$this->date()->notNull()->comment('Дата (год-мес-день)'),
            'doctor_id'=>$this->integer()->notNull()->comment('Врач'),
            'timetable'=>$this->text()->null()->comment('График работы'),     // json

            'created_at'=>$this->dateTime()->notNull()->comment('Время создания'),
        ]);


//        //таблица много ко многим
//        $this->createTable('calendar_to_day_period', [
//            'id' => $this->primaryKey(),
//            'calendar_id'=>$this->integer()->notNull()->comment('День (ид)'),
//            'day_period_id'=>$this->integer()->notNull()->comment('ид периода'),
//            'status'=>$this->integer()->defaultValue(0)->comment('статус, занят | не занят'),
//        ]);
//
//        $this->addForeignKey('FK_calendar_to_day_period', '{{%calendar_to_day_period}}', 'calendar_id', '{{%calendar}}', 'id', 'NO ACTION', 'CASCADE');
//        $this->addForeignKey('FK_day_period_to_calendar', '{{%calendar_to_day_period}}', 'day_period_id', '{{%day_period}}', 'id', 'NO ACTION', 'CASCADE');


        $this->addForeignKey('FK_calendar_to_doctor', '{{%calendar}}', 'doctor_id', '{{%doctor}}', 'id', 'CASCADE', 'CASCADE');





        //fill

        $faker = Faker\Factory::create();

  //$doc_list=Doctor::find()->where(1)->all();



//        $cal_list=[];


        //$list_period[]=['id'=>$i++, 'val'=> "Живая очередь",'type'=>'live'];






        $date = new DateTime('2018-01-01');
        foreach (range(1,60) as $j) {
            // grafic dreate

            // generate  time in json
            $list_period=[];
            $f=1;
            foreach (range(8,17) as $t) {
                $list_period[]=['id'=>$f++,'type'=>'time','val'=> "{$t}:00",];
                $j=$t+1;
                $list_period[]=['id'=>$f++,'type'=>'time','val'=> "{$t}:30"];
            }


            $rn=rand(1,5);
            echo $rn.PHP_EOL;
            if ($rn == 3 ){
                $list_period=[];
                $list_period[]=['id'=>$f++,'type'=>'text', 'val'=> "Живая очередь",];
            }
            if ($rn == 2 ){
                $list_period=[];
                $list_period[]=['id'=>$f++,'type'=>'text', 'val'=> "В этот день приёма нет.",];
            }


            //-------------









            $date->modify('+1 day');
            $tj=$date->format('Y-m-d');
            $cal_list=[];
            foreach (range(1,500) as $i){ // часы работы
                //$dt=  $faker->dateTime()  ->format('Y-m-d');
                $dt= $tj;
                $cal_list[]= [ $dt,$i, json_encode($list_period),  date('Y-m-d H:i:s')  ];
            }
            echo $j.PHP_EOL;
            $this->batchInsert('{{%calendar}}', ['date','doctor_id','timetable','created_at'],
                $cal_list
            );
            unset($cal_list);
        }




    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->execute("SET foreign_key_checks = 0;");
//        $this->truncateTable('calendar_to_day_period');
//        $this->dropTable('calendar_to_day_period');
        $this->truncateTable('calendar');
        $this->dropTable('calendar');
        $this->execute("SET foreign_key_checks = 1;");
    }
}
