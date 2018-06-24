<?php


namespace common\models;

use yii\db\ActiveQuery;


class BookingQuery extends ActiveQuery
{


	public function nonAdvertiserCalendar($nonAdvId, $mainAdvId)
	{
		return $this->andWhere([
				'or',
				['user_id' => $nonAdvId],
				['advertiser_id' => $mainAdvId],
		]);
	}


	/**
	 * 
	 * @return BookingQuery
	 */
	public function future()
	{
		return $this->andWhere(['>', 'from_date', time()+\common\helpers\Calendar::eventExpirationLimit()*60*60]);
	}

	
	/**
	 * 
	 * @return BookingQuery
	 */
	public function past()
	{
		return $this->andWhere(['<=', 'from_date', time()+\common\helpers\Calendar::eventExpirationLimit()*60*60]);
	}
	

	/**
	 * 
	 * @return BookingQuery
	 */
	public function active()
	{
		return $this->future()->notStub()->andWhere(['status' => Booking::STATUS_APPROVED]);
	}


	/**
	 * 
	 * @return BookingQuery
	 */
	public function pending()
	{
		return $this->future()->notStub()->andWhere(['status' => Booking::STATUS_PENDING]);
	}

	
	/**
	 * 
	 * @return BookingQuery
	 */
	public function notStub()
	{
		return $this->andWhere(['<>', 'status', Booking::STATUS_STUB]);
	}

}
