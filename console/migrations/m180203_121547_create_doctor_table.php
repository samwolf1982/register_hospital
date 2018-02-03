<?php

use yii\db\Migration;

/**
 * Handles the creation of table `doctor`.
 */
class m180203_121547_create_doctor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->createTable('doctor', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Имя'),
            'surname' => $this->string()->notNull()->comment("Фамилия"),
            'patronymic' => $this->string()->notNull()->comment('Отчество'),
            'phone' => $this->string()->notNull()->comment('Телефон'),
            'status_id'=>$this->integer()->notNull()->comment("Статус врача"),// работает, отпуск, командировка, уволился
            'area_id' => $this->integer()->notNull()->comment('Отделение'),
            'profession_id' => $this->integer()->notNull()->comment('Специализация'),
        ]);

        $this->createTable('area', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->comment('Название отделения'),
        ]);

        $this->createTable('doctor_status', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->comment('Cтатус врача'),
        ]);

        //       many to many
//        $this->createTable('doctor_profession', [
//            'doctor_id' => $this->integer()->notNull(),
//            'profession_id' => $this->integer()->notNull(),
//        ]);
      //  $this->addPrimaryKey('PK_doctor_to_profession','doctor_profession',['doctor_id','profession_id']);

      //  $this->addForeignKey('FK_doctor_to_profession', '{{%doctor_profession}}', 'doctor_id', '{{%doctor}}', 'id', 'NO ACTION', 'CASCADE');
       // $this->addForeignKey('FK_profession_to_doctor', '{{%doctor_profession}}', 'profession_id', '{{%profession}}', 'id', 'NO ACTION', 'CASCADE');


//        PRIMARY KEY (doctor_id , profession_id ),
//      FOREIGN KEY (doctor_id) REFERENCES doctor(id),
//          FOREIGN KEY (profession_id) REFERENCES profession(id)


        $this->addForeignKey('doctor_to_area', '{{%doctor}}', 'area_id', '{{%area}}', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('doctor_to_profession', '{{%doctor}}', 'profession_id', '{{%profession}}', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('doctor_to_doctor_status', '{{%doctor}}', 'status_id', '{{%doctor_status}}', 'id', 'NO ACTION', 'CASCADE');



        // demo fill
        $this->batchInsert('{{%area}}', ['name', ], [
            ["Стоматологическое отделение"], ["Отделение неотложной помощи"],['Корпус 1'],['Корпус 2'], ["Психиатрическое 1"], ["Психиатрическое 2"],
        ]);

//        работает, отпуск, командировка, уволился
        $this->batchInsert('{{%doctor_status}}', ['name', ], [
            ["Работает"], ["Отпуск"],['Командировка'],['Уволился'],
        ]);


        $prof_list=['Акушер-гинеколог', 'Акушерка', 'Аллерголог', 'Аллерголог-иммунолог', 'Ангиохирург (см. также Сосудистый хирург)', 'Андролог', 'Андролог-эндокринолог', 'Анестезиолог', 'Анестезиолог-реаниматолог', 'Аритмолог', 'Ароматерапевт', 'Артролог', 'Бактериолог', 'Бальнеолог', 'Валеолог', 'Венеролог', 'Вертебролог', 'Вирусолог', 'Врач общей практики (см. также Семейный врач)', 'Врач по лечебной физкультуре и спорту', 'Врач по лечению бесплодия', 'Врач по спортивной медицине', 'Врач скорой помощи', 'Врач УЗИ', 'Врач функциональной диагностики', 'Гастроэнтеролог', 'Гематолог', 'Генетик', 'Гепатолог', 'Гериатр', 'Гинеколог', 'Гинеколог-перинатолог', 'Гинеколог-эндокринолог', 'Гирудотерапевт', 'Гомеопат', 'Дерматовенеролог', 'Дерматолог (см. также Миколог, Трихолог)', 'Диагност', 'Диетолог', 'Зубной врач', 'Иглорефлексотерапевт', 'Иммунолог', 'Имплантолог', 'Инфекционист', 'Кардиолог', 'Кардиоревматолог', 'Кардиохирург', 'Кинезиолог', 'Колопроктолог', 'Косметолог', 'Курортолог', 'Лаборант', 'Логопед', 'ЛОР (см. также Отоларинголог)', 'Маммолог', 'Мануальный терапевт', 'Массажист', 'Миколог (см. также Трихолог, Дерматолог)', 'Нарколог', 'Невролог (см. также Паркинсонолог)', 'Невропатолог', 'Нейротравматолог (см. также Нейрохирург)', 'Нейрохирург (см. также Нейротравматолог)', 'Неонатолог', 'Нефролог', 'Окулист (см. также Офтальмолог)', 'Онкогинеколог (см. также Онколог-гинеколог)', 'Онколог', 'Онколог-гинеколог (см. также Онкогинеколог)', 'Онколог-хирург', 'Онкоуролог', 'Ортодонт', 'Ортопед', 'Ортопед-травматолог', 'Остеопат', 'Отоларинголог (см. также ЛОР)', 'Отоневролог', 'Офтальмолог (см. также Окулист)', 'Офтальмолог-хирург', 'Паразитолог', 'Паркинсонолог (см. также Невролог)', 'Пародонтолог', 'Педиатр', 'Педиатр-неонатолог', 'Перинатолог', 'Пластический хирург', 'Подолог', 'Проктолог', 'Профпатолог', 'Психиатр', 'Психиатр-нарколог', 'Психолог (см. также Психотерапевт)', 'Психоневролог', 'Психотерапевт (см. также Психолог)', 'Пульмонолог', 'Радиолог', 'Реабилитолог', 'Реаниматолог', 'Ревматолог', 'Рентгенолог', 'Репродуктолог', 'Рефлексотерапевт', 'Санитарный врач по гигиене детей и подростков', 'Санитарный врач по гигиене питания', 'Санитарный врач по гигиене труда', 'Сексолог (см. также Сексопатолог)', 'Сексопатолог (см. также Сексолог)', 'Семейный врач (см. также Врач общей практики)', 'Семейный доктор', 'Сомнолог', 'Сосудистый хирург', 'Специалист восстановительного лечения', 'Стоматолог', 'Стоматолог-ортодонт', 'Стоматолог-ортопед', 'Стоматолог-протезист', 'Стоматолог-терапевт', 'Стоматолог-хирург', 'Суггестолог', 'Судебно-медицинский эксперт', 'Сурдолог', 'Сурдопедагог', 'Терапевт', 'Терапевт мануальный', 'Токсиколог', 'Торакальный хирург', 'Травматолог', 'Трансфузиолог', 'Трихолог (см. также Миколог, Дерматолог)', 'УЗИ врач', 'Урогинеколог', 'Уролог', 'Фармаколог клинический', 'Физиотерапевт', 'Флеболог', 'Фониатр', 'Фтизиатр', 'Фтизиопедиатр', 'Хирург', 'Хирург детский', 'Хирург пластический', 'Хирург сосудистый (см. также Ангиохирург)', 'Хирург торакальный', 'Хирург челюстно-лицевой', 'Хирург-флеболог', 'Челюстно-лицевой хирург', 'Эмбриолог', 'Эндодонт', 'Эндокринолог', 'Эндоскопист', 'Эпидемиолог', 'Эпилептолог'];
        $count_prof=count($prof_list);
        $prof_list_prepare=[];
        foreach ($prof_list as $item) {
            $prof_list_prepare[]=[$item];
         }

        $this->batchInsert('{{%profession}}', ['name', ], $prof_list_prepare);


//        $this->createTable('doctor', [
//            'id' => $this->primaryKey(),
//            'name' => $this->string()->notNull()->comment('Имя'),
//            'surname' => $this->string()->notNull()->comment("Фамилия"),
//            'patronymic' => $this->string()->notNull()->comment('Отчество'),
//            'area' => $this->integer()->notNull()->comment('Отделение'),
//        ]);

        $faker = Faker\Factory::create();

        $doc_list=[];
        foreach (range(1,500) as $i){
            $doc_list[]= [ $faker->firstName,$faker->firstName,$faker->lastName,$faker->numberBetween(1,4),$faker->numberBetween(1,6),$faker->numberBetween(1,$count_prof)];
        }
        $this->batchInsert('{{%doctor}}', ['name', 'surname','patronymic','status_id','area_id','profession_id'],
            $doc_list
        );


//        $this->batchInsert('{{%doctor}}', ['name', ], [
//            ["Хирург"], ["Терапевт"], ["Стоматолог"], ["Окулист"],
//        ]);
    }


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->execute("SET foreign_key_checks = 0;");
        $this->truncateTable('doctor');
        $this->truncateTable('area');
        $this->truncateTable('doctor_status');
//        $this->truncateTable('doctor_profession');


        $this->dropTable('doctor');
        $this->dropTable('area');
        $this->dropTable('doctor_status');

//        $this->dropTable('doctor_profession');

        $this->execute("SET foreign_key_checks = 1;");
    }
}
