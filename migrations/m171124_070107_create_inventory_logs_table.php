<?php

use yii\db\Migration;

/**
 * Handles the creation of table `inventory_logs`.
 */
class m171124_070107_create_inventory_logs_table extends Migration
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
			'previous_id' => $this->integer(),
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
