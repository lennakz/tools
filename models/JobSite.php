<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_sites".
 *
 * @property integer $id
 * @property string $street
 * @property string $city
 * @property string $province
 * @property string $postal_code
 * @property integer $complete
 * @property string $created_date
 * @property string $updated_date
 */
class JobSite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_sites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complete'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['street', 'city', 'postal_code'], 'string', 'max' => 255],
            [['province'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'street' => 'Street',
            'city' => 'City',
            'province' => 'Province',
            'postal_code' => 'Postal Code',
            'complete' => 'Complete',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
	
	public function beforeSave($insert)
	{
		if ($insert) 
			$this->created_date = date('Y-m-d H:i:s');
		else
			$this->updated_date = date('Y-m-d H:i:s');
		
		return parent::beforeSave($insert);
	}
}
