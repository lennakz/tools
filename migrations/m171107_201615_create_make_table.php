<?php

use yii\db\Migration;

/**
 * Handles the creation of table `make`.
 */
class m171107_201615_create_make_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('make', [
            'id' => $this->primaryKey(),
			'name' => $this->string(),
			'created_date' => $this->dateTime(),
			'updated_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('make');
    }
}
