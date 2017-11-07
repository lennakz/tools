<?php

use yii\db\Migration;

/**
 * Handles the creation of table `inventories`.
 */
class m171107_202023_create_inventories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('inventories', [
            'id' => $this->primaryKey(),
			'tool_id' => $this->smallInteger(),
			'serial_number' => $this->string(),
			'job_site_id' => $this->smallInteger(),
			'note' => $this->text(),
			'working' =>$this->boolean(),
			'created_date' => $this->dateTime(),
			'updated_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('inventories');
    }
}
