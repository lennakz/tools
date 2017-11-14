<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "inventories".
 *
 * @property integer $id
 * @property integer $tool_id
 * @property string $serial_number
 * @property integer $job_site_id
 * @property string $note
 * @property integer $status_id
 * @property string $created_date
 * @property string $updated_date
 */
class Inventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tool_id', 'job_site_id', 'status_id'], 'integer'],
			[['tool_id', 'job_site_id', 'status_id'], 'required'],
            [['note'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['serial_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tool_id' => 'Tool ID',
            'serial_number' => 'Serial Number',
            'job_site_id' => 'Job Site ID',
            'note' => 'Note',
            'status_id' => 'Status ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
	
	public function getTool()
	{
		return $this->hasOne(Tool::className(), ['id' => 'tool_id']);
	}
	
	public function getJobSite()
	{
		return $this->hasOne(JobSite::className(), ['id' => 'job_site_id']);
	}
	
	public function getStatus()
	{
		return $this->hasOne(InventoryStatus::className(), ['id' => 'status_id']);
	}
	
	public function getCategory()
	{
		return $this->hasOne(ToolCategory::className(), ['id' => 'category_id'])->via('tool');
	}
	
	public function getAllToolsArray()
	{
		return ArrayHelper::map(Tool::find()->all(), 'id', 'name');
	}
	
	public function getAllJobSitesArray()
	{
		return ArrayHelper::map(JobSite::find()->all(), 'id', 'street');
	}
	
	public function getAllStatusesArray()
	{
		return ArrayHelper::map(InventoryStatus::find()->all(), 'id', 'status');
	}
	
}
