<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tool_categories".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created_date
 * @property string $updated_date
 */
class ToolCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tool_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
	
	public function beforeSave($insert)
	{
		if ($insert) 
			$this->created_date = date('Y-m-d H:i:s');
		
		$this->updated_date = date('Y-m-d H:i:s');
		
		return parent::beforeSave($insert);
	}
}
