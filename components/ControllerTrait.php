<?php

namespace app\components;

use yii\data\ActiveDataProvider;

trait ControllerTrait
{
	public function getInventoryDataProvider($query, $pagination = [])
	{
		return new ActiveDataProvider([
            'query' => $query,
			'pagination' => $pagination,
			'sort' => [
				'attributes' => [
					'formattedNumber' => [
						'asc' => ['inventory_number' => SORT_ASC],
						'desc' => ['inventory_number' => SORT_DESC],
					],
					'tool.name' => [
						'asc' => ['tools.name' => SORT_ASC],
						'desc' => ['tools.name' => SORT_DESC],
					],
					'jobSite.name' => [
						'asc' => ['job_sites.name' => SORT_ASC],
						'desc' => ['job_sites.name' => SORT_DESC],
					],
					'category.name' => [
						'asc' => ['tool_categories.name' => SORT_ASC],
						'desc' => ['tool_categories.name' => SORT_DESC],
					],
					'statusText' => [
						'asc' => ['status_id' => SORT_ASC],
						'desc' => ['status_id' => SORT_DESC],
					],
					'updated_date',
				],
				'defaultOrder' => [
					'updated_date' => SORT_DESC,
				],
			],
        ]);
	}
}
