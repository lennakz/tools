<?php

use yii\db\Migration;

/**
 * Handles the creation of table `job_sites`.
 */
class m171107_200625_create_job_sites_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('job_sites', [
            'id' => $this->primaryKey(),
			'street' => $this->string(),
			'city' => $this->string(),
			'province' => $this->char(2),
			'postal_code' => $this->string(),
			'complete' =>$this->boolean(),
			'created_date' => $this->dateTime(),
			'updated_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('job_sites');
    }
}
