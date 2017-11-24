<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
 * @property integer $inventory_number
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
            [['tool_id', 'job_site_id', 'status_id', 'inventory_number'], 'integer'],
			[['tool_id', 'job_site_id', 'status_id', 'inventory_number'], 'required'],
            [['note'], 'string'],
			[['inventory_number'], 'unique'],
            [['created_date', 'updated_date'], 'safe'],
            [['serial_number'], 'string', 'max' => 255],
        ];
    }
	
	public function beforeSave($insert)
	{
		$log = new InventoryLog;
		
		if ($insert)
		{
			$this->created_date = date('Y-m-d H:i:s');			
		}
		else
		{
			$this->updated_date = date('Y-m-d H:i:s');
			//$log->previous_id = $this->getOldAttribute('id');			
		}
				
		$log->attributes = $this->attributes;	
		$log->inventory_id = $this->id;
		$log->change_date = date('Y-m-d H:i:s');
				
		$log->save();
		
		return parent::beforeSave($insert);
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
            'inventory_number' => 'Inventory Number',
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
	
	public static function getStatusArray()
	{
		return [
			1 => 'Working',
			2 => 'Need Repair',
			3 => 'In Repair',
			4 => 'Retired',
			5 => 'Missing',
		];
	}
	
	public function getStatusText()
	{
		$status_array = self::getStatusArray();
		
		return $status_array[$this->status_id];
	}
	
	public function getFormattedNumber()
	{
		return str_pad($this->inventory_number, 5, '0', STR_PAD_LEFT);
	}
	
	public function getUrl()
	{
		return Url::to(['inventory/view', 'id' => $this->id]);
	}
	
}
