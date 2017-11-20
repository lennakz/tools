<?php

use yii\db\Migration;

/**
 * Class m171120_063424_modify_job_sites_table
 */
class m171120_063424_modify_job_sites_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->alterColumn('job_sites', 'lat', 'float');
		$this->alterColumn('job_sites', 'lng', 'float');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->alterColumn('job_sites', 'lat', 'integer');
		$this->alterColumn('job_sites', 'lng', 'integer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171120_063424_modify_job_sites_table cannot be reverted.\n";

        return false;
    }
    */
}
