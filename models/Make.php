<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "make".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_date
 * @property string $updated_date
 */
class Make extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'make';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['name'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
			[['name'], 'required'],
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
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
}
