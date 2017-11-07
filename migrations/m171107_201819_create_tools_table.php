<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tools`.
 */
class m171107_201819_create_tools_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('tools', [
            'id' => $this->primaryKey(),
			'name' => $this->string(),
			'make' => $this->smallInteger(),
			'model' => $this->string(),
			'created_date' => $this->dateTime(),
			'updated_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('tools');
    }
}
