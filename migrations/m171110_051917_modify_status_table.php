<?php

use yii\db\Migration;

/**
 * Class m171110_051917_modify_status_table
 */
class m171110_051917_modify_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->renameTable('status', 'inventory_status');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameTable('inventory_status', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171110_051917_modify_status_table cannot be reverted.\n";

        return false;
    }
    */
}
