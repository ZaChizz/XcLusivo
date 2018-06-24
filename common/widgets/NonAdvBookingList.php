<?php


namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\assets\ProjectAsset;


class NonAdvBookingList extends Widget
{

	public $query;
	public $limit = 3;
	public $showMoreLink = false;
	public $showMoreTitle = 'Show More';
        public $writeReview = false;


	public function init()
	{
		parent::init();

		if (!($this->query instanceof ActiveQuery)) {
			throw new \yii\base\Exception('ActiveQuery instance required.');
		}

		$this->query = clone $this->query;
	}


	public function run()
	{
		$params = [
			'limit'			 => $this->limit,
			'needShowMore'	 => false,
			'showMoreLink'	 => $this->showMoreLink,
                        'writeReview'    => $this->writeReview
		];


		if ($this->limit) {
			if ($this->showMoreLink) {
				$totalCount = $this->query->count();
				$params['needShowMore'] = $needShowMore = $totalCount > $this->limit;
			}

			$this->query->limit = $this->limit;
		} else {
			$params['needShowMore'] = false;
		}

		$this->query->with(['advertiser.user', 'user']);
		$params['provider'] = ($this->limit) ? new \yii\data\ArrayDataProvider(['allModels' => $this->query->all()]) : new ActiveDataProvider(['query' => $this->query]);

		return $this->render('na_booking_list', $params);
	}


}

/*
			[
				'class'	 => 'yii\grid\DataColumn', // can be omitted, as it is the default
				'value'	 => function ($data) {
					return 'alala'; // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
 */