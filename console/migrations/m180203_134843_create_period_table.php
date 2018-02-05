<?php

use yii\db\Migration;

/**
 * Handles the creation of table `period`.
 */
class m180203_134843_create_period_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('day_period', [
            'id' => $this->primaryKey(),
            'name'=>$this->text(),
        ]);

          $list_period=[];
        foreach (range(8,17) as $t) {
            $list_period[]=[ "{$t}:00"];
            $j=$t+1;
            $list_period[]=[ "{$t}:30"];
        }

        $this->batchInsert('{{%day_period}}', ['name'],
            $list_period
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->execute("SET foreign_key_checks = 0;");
        $this->truncateTable('day_period');
        $this->dropTable('day_period');
        $this->execute("SET foreign_key_checks = 1;");

    }
}
