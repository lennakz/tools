<?php

use yii\db\Migration;

/**
 * Class m171119_233346_modify_inventories_table
 */
class m171119_233346_modify_inventories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('inventories', 'inventory_number', 'integer');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('inventory_number', 'integer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171119_233346_modify_inventories_table cannot be reverted.\n";

        return false;
    }
    */
}
