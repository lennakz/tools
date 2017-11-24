<?php

use yii\db\Migration;

/**
 * Handles the creation of table `inventory_logs`.
 */
class m171124_024143_create_inventory_logs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('inventory_logs', [
            'id' => $this->primaryKey(),
			'inventory_id' => $this->smallInteger(),
			'change_date' => $this->dateTime(),
			'inventory_number' => $this->integer(),
			'tool_id' => $this->smallInteger(),
			'serial_number' => $this->string(),
			'job_site_id' => $this->smallInteger(),
			'note' => $this->text(),
			'status_id' =>$this->smallInteger(),
			'created_date' => $this->dateTime(),
			'updated_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('inventory_logs');
    }
}
