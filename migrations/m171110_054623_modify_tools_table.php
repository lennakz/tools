<?php

use yii\db\Migration;

/**
 * Class m171110_054623_modify_tools_table
 */
class m171110_054623_modify_tools_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('tools', 'category_id', 'smallint');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
		$this->dropColumn('tools', 'category_id');
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171110_054623_modify_tools_table cannot be reverted.\n";

        return false;
    }
    */
}
