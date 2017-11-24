<?php

use yii\db\Migration;

/**
 * Class m171124_020927_modify_job_sites_table
 */
class m171124_020927_modify_job_sites_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->renameColumn('job_sites', 'type', 'type_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameColumn('job_sites', 'type_id', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171124_020927_modify_job_sites_table cannot be reverted.\n";

        return false;
    }
    */
}
