<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180203_145751_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'cod'=>$this->string(255)->notNull()->comment('Номер страхового полиса'),
            'client_name'=>$this->text()->null()->comment('Имя'),
            'client_surname'=>$this->text()->null()->comment('Фамилия'),
            'client_patronymic'=>$this->text()->null()->comment('Отчество'),
            'born'=>$this->date()->null()->comment('Год рождения'),

            'doctor_id'=>$this->integer()->notNull()->comment('Доктор'),

            'profession_id'=>$this->integer()->null()->comment('Выберите специализацию врача') , // удобство для пост запроса используется только для определения етапа в отправке форм

            'period_id'=>$this->integer()->notNull()->comment('Период'),
            'statusorder_id'=>$this->integer()->notNull()->defaultValue(0)->comment('Состояние заявки'),// 0 новая  1 закрытая
            'date'=>$this->date()->notNull()->comment('Дата'),// число на когда записался человек
            'date_created'=>$this->dateTime()->notNull()->comment('Дата создания'),
            'hash'=>$this->string()->null()->comment('хеш урла для предотврашениея повторных заявок'),

        ]);

//        $this->addForeignKey('order_to_doctor', '{{%order}}', 'doctor_id', '{{%doctor}}', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('period_to_doctor', '{{%order}}', 'period_id', '{{%day_period}}', 'id', 'NO ACTION', 'CASCADE');


        $faker = Faker\Factory::create();



        $doc_list=[];



        foreach (range(1,500) as $i){

          $dt=  $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)->format('Y-m-d');
          $dt_born=  $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)->format('Y-m-d');
//            $dt=  date_format( $dt,'Y-m-d');
            $doc_list[]= [ $faker->iban("UA"), $faker->firstName(),$faker->lastName(),$faker->lastName(),$dt_born,  $faker->numberBetween(1,500),$faker->numberBetween(1,20),$faker->numberBetween(0,1),$dt,date('Y-m-d H:i:s')  ];
        }
        $this->batchInsert('{{%order}}', ['cod','client_name','client_surname','client_patronymic','born', 'doctor_id','period_id','statusorder_id','date','date_created'],
            $doc_list
        );



    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->execute("SET foreign_key_checks = 0;");
        $this->truncateTable('order');
        $this->dropTable('order');
        $this->execute("SET foreign_key_checks = 1;");

    }
}
