<?php

use yii\db\Migration;

/**
 * Class m171120_020225_modify_job_sites_table
 */
class m171120_020225_modify_job_sites_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('job_sites', 'type', 'smallint');
		$this->addColumn('job_sites', 'lat', 'integer');
		$this->addColumn('job_sites', 'lng', 'integer');
		$this->addColumn('job_sites', 'name', 'string');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('type', 'smallint');
		$this->dropColumn('lat', 'integer');
		$this->dropColumn('lng', 'integer');
		$this->dropColumn('name', 'string');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171120_020225_modify_job_sites_table cannot be reverted.\n";

        return false;
    }
    */
}
