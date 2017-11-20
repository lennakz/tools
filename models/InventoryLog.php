<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_logs".
 *
 * @property integer $id
 * @property integer $inventory_id
 * @property integer $inventory_number
 * @property integer $tool_id
 * @property string $serial_number
 * @property integer $job_site_id
 * @property string $note
 * @property integer $status_id
 * @property string $created_date
 * @property string $updated_date
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
            [['inventory_id', 'inventory_number', 'tool_id', 'job_site_id', 'status_id'], 'integer'],
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
            'inventory_id' => 'Inventory ID',
            'inventory_number' => 'Inventory Number',
            'tool_id' => 'Tool ID',
            'serial_number' => 'Serial Number',
            'job_site_id' => 'Job Site ID',
            'note' => 'Note',
            'status_id' => 'Status ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
}
