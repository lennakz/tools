<?php

use yii\db\Migration;

/**
 * Class m171110_050736_modify_inventory_table
 */
class m171110_050736_modify_inventory_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->renameColumn('inventories', 'working', 'status_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameColumn('inventories', 'status_id', 'working');
    }
}
