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
            'created_at'=>$this->dateTime()->notNull()->comment('Время создания'),
        ]);


        //таблица много ко многим
        $this->createTable('calendar_to_day_period', [
            'id' => $this->primaryKey(),
            'calendar_id'=>$this->integer()->notNull()->comment('День (ид)'),
            'day_period_id'=>$this->integer()->notNull()->comment('ид периода'),
            'status'=>$this->integer()->defaultValue(0)->comment('статус, занят | не занят'),
        ]);

        $this->addForeignKey('FK_calendar_to_day_period', '{{%calendar_to_day_period}}', 'calendar_id', '{{%calendar}}', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('FK_day_period_to_calendar', '{{%calendar_to_day_period}}', 'day_period_id', '{{%day_period}}', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('FK_calendar_to_doctor', '{{%calendar}}', 'doctor_id', '{{%doctor}}', 'id', 'NO ACTION', 'CASCADE');





        //fill

        $faker = Faker\Factory::create();

  //$doc_list=Doctor::find()->where(1)->all();



//        $cal_list=[];


        foreach (range(5,12) as $j) {
            if ($j<10) {
                $tj='0'.$j;
            }else{
                $tj=strval($j);
            }



            foreach (range(1,10) as $i){ // часы работы
                //$dt=  $faker->dateTime()  ->format('Y-m-d');
                $dt=  '2018-02-'.$tj;
                $cal_list[]= [ $dt,$i,date('Y-m-d H:i:s')  ];
            }
            $this->batchInsert('{{%calendar}}', ['date','doctor_id','created_at'],
                $cal_list
            );
        }




    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->execute("SET foreign_key_checks = 0;");
        $this->truncateTable('calendar_to_day_period');
        $this->dropTable('calendar_to_day_period');
        $this->truncateTable('calendar');
        $this->dropTable('calendar');
        $this->execute("SET foreign_key_checks = 1;");
    }
}
