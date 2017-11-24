<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "inventory_logs".
 *
 * @property integer $id
 * @property integer $inventory_id
 * @property string $change_date
 * @property integer $inventory_number
 * @property integer $tool_id
 * @property string $serial_number
 * @property integer $job_site_id
 * @property string $note
 * @property integer $status_id
 * @property string $created_date
 * @property string $updated_date
 * @property integer $previous_id
 */
class InventoryLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inventory_id', 'inventory_number', 'tool_id', 'job_site_id', 'status_id', 'previous_id'], 'integer'],
            [['change_date', 'created_date', 'updated_date'], 'safe'],
            [['note'], 'string'],
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
            'inventory_id' => 'Inventory ID',
            'change_date' => 'Change Date',
            'inventory_number' => 'Inventory Number',
            'tool_id' => 'Tool ID',
            'serial_number' => 'Serial Number',
            'job_site_id' => 'Job Site ID',
            'note' => 'Note',
            'status_id' => 'Status ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'previous_id' => 'Previous ID',
        ];
    }
	
	public function beforeSave($insert)
	{
		if ($insert) 
			$this->created_date = date('Y-m-d H:i:s');
		
		$this->updated_date = date('Y-m-d H:i:s');
		
		return parent::beforeSave($insert);
	}
	
	public function getInventory()
	{
		return $this->hasOne(Inventory::className(), ['id' => 'inventory_id']);
	}
	
	public function isChanged($prev_log, $attr)
	{
		return $this->$attr !== $prev_log->$attr and !empty($prev_log->$attr);
	}
	
	public function getChangedModel($attr)
	{
		if (empty($this->previous_id))
			return '';
		
		$prev_log = self::findOne($this->previous_id);
		
		if ($this->isChanged($prev_log, $attr))
			return $prev_log;
		else
			return '';
	}
	
	public function getChangedTextHtml($old, $new)
	{
		$old_html = Html::tag('span', $old, ['class' => 'text-danger']);
		$new_html = Html::tag('span', $new, ['class' => 'text-success']);
		
		return $old_html . ' -> ' . $new_html;
	}
	
	public function getTool()
	{
		return $this->hasOne(Tool::className(), ['id' => 'tool_id']);
	}
	
	public function getJobSite()
	{
		return $this->hasOne(JobSite::className(), ['id' => 'job_site_id']);
	}
	
	public function getStatusText()
	{
		$status_array = Inventory::getStatusArray();
		
		return $status_array[$this->status_id];
	}
	
	public function getFormattedNumber()
	{
		return str_pad($this->inventory_number, 5, '0', STR_PAD_LEFT);
	}
}
