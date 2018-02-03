<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profession`.
 */
class m180203_113604_create_profession_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('profession', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);






    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->execute("SET foreign_key_checks = 0;");
        $this->truncateTable('profession');
        $this->execute("SET foreign_key_checks = 1;");
        $this->dropTable('profession');
    }
}

