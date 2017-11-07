<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventories".
 *
 * @property integer $id
 * @property integer $tool_id
 * @property string $serial_number
 * @property integer $job_site_id
 * @property string $note
 * @property integer $working
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
            [['tool_id', 'job_site_id', 'working'], 'integer'],
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
            'working' => 'Working',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
}
