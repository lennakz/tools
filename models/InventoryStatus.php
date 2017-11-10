<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_status".
 *
 * @property integer $id
 * @property string $status
 * @property string $description
 * @property string $created_date
 * @property string $updated_date
 */
class InventoryStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'description' => 'Description',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
}
