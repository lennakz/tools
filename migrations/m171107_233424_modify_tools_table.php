<?php

use yii\db\Migration;

/**
 * Class m171107_233424_modify_tools_table
 */
class m171107_233424_modify_tools_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->renameColumn('tools', 'make', 'make_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameColumn('tools', 'make_id', 'make');
    }
}
