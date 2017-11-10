<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tool_categories`.
 */
class m171110_054348_create_tool_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('tool_categories', [
            'id' => $this->primaryKey(),
			'name' => $this->string(),
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
        $this->dropTable('tool_categories');
    }
}
