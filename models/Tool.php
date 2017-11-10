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
 * @property integer $category_id
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
            [['make_id', 'category_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['name', 'model'], 'string', 'max' => 255],
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
            'make_id' => 'Make ID',
            'model' => 'Model',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'category_id' => 'Category ID',
        ];
    }
	
	public function getMake()
	{
		return $this->hasOne(Make::className(), ['id' => 'make_id']);
	}
	
	public function getCategory()
	{
		return $this->hasOne(ToolCategory::className(), ['id' => 'category_id']);
	}
	
	public function getAllMakesArray()
	{
		return ArrayHelper::map(Make::find()->all(), 'id', 'name');
	}
	
	public function getAllCategoriesArray()
	{
		return ArrayHelper::map(ToolCategory::find()->all(), 'id', 'name');
	}
	
}
