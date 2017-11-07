<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tools".
 *
 * @property integer $id
 * @property string $name
 * @property integer $make_id
 * @property string $model
 * @property string $created_date
 * @property string $updated_date
 */
class Tool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tools';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['make_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['name', 'model'], 'string', 'max' => 255],
			[['name'], 'unique'],
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
            'make_id' => 'Make',
            'model' => 'Model',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
	
	public function getMake()
	{
		return $this->hasOne(Make::className(), ['id' => 'make_id']);
	}
	
	public function getAllMakesArray()
	{
		return ArrayHelper::map(Make::find()->all(), 'id', 'name');
	}
	
}
