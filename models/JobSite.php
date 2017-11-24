<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;

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
 * @property integer $type_id
 * @property double $lat
 * @property double $lng
 * @property string $name
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
            [['complete', 'type_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['lat', 'lng'], 'number'],
            [['street', 'city', 'postal_code', 'name'], 'string', 'max' => 255],
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
            'type_id' => 'Type ID',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'name' => 'Name',
        ];
    }
	
	public function beforeSave($insert)
	{
		if ($insert) 
			$this->created_date = date('Y-m-d H:i:s');
		else
			$this->updated_date = date('Y-m-d H:i:s');
		
		if (empty($this->name))
			$this->name = $this->street;
		
		$location_info = $this->getLocationInfo();
		
		foreach (['lat', 'lng', 'postal_code'] as $attr)
		{
			if (empty($this->$attr))
				$this->$attr = $location_info[$attr];
		}
				
		return parent::beforeSave($insert);
	}
	
	public static function getProvincesArray()
	{
		$provinces = [
			'AB' => 'Alberta',
			'BC' => 'British Columbia',
			'MB' => 'Manitoba',
			'NB' => 'New Brunswick',
			'NL' => 'Newfoundland and Labrador',
			'NT' => 'Northwest Territories',
			'NS' => 'Nova Scotia',
			'NU' => 'Nunavut',
			'ON' => 'Ontario',
			'PE' => 'Prince Edward Island',
			'QC' => 'Quebec',
			'SK' => 'Saskatchewan',
			'YT' => 'Yukon',
		];

		return $provinces;
	}
	
	public static function getLookupMarkersArray()
	{
		return [
			1 => 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
			2 => 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
			3 => 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
		];
	}


	public function getLocationInfo()
	{
		$location_info = [
			'lat' => '',
			'lng' => '',
			'postal_code' => '',
		];
		$address = urlencode($this->getFullAddress(false));

		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";

		$data = @file_get_contents($url);
		$jsondata = Json::decode($data, true);

		if ($jsondata['status'] !== 'OK')
			return $location_info;

		$location_info = [
			'lat' => $jsondata["results"][0]["geometry"]["location"]["lat"],
			'lng' => $jsondata["results"][0]["geometry"]["location"]["lng"],
			'postal_code' => $jsondata["results"][0]["address_components"][7]["long_name"],
		];

		return $location_info;
	}
	
	public function getCompleteText()
	{
		return empty($this->complete) ? 'Active' : 'Completed';
	}
	
	public static function getTypeArray()
	{
		return [
			1 => 'Job Site',
			2 => 'Shop',
			3 => 'Storage',
		];
	}
	
	public function getTypeText()
	{
		$type_array = self::getTypeArray();
		
		return $type_array[$this->type_id];
	}
	
	public function getNameText()
	{
		return empty($this->name) ? $this->street : $this->name;
	}
	
	public function getFullAddress($add_postal_code = true)
	{
		$address = [];
		$postal_code = '';
		
		if (!empty($add_postal_code))
			$postal_code = $this->postal_code;
		
		foreach ([$this->street, $this->city, $this->province, $postal_code] as $v)
		{
			if (!empty($v))
				$address[] = $v;
		}
		
		return implode(', ', $address);
	}
	
	public function getTotalInventories()
	{
		return Inventory::find()->where(['job_site_id' => $this->id])->count();
	}
	
	public function getUrl()
	{
		return Url::to(['job-site/view', 'id' => $this->id]);
	}
}
