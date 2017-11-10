<?php

use yii\db\Migration;

/**
 * Handles the creation of table `status`.
 */
class m171110_050922_create_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('status', [
            'id' => $this->primaryKey(),
			'status' => $this->string(),
			'description' => $this->text(),
			'created_date' => $this->dateTime(),
			'updated_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('status');
    }
}
