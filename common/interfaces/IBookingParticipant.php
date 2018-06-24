<?php


namespace common\interfaces;


interface IBookingParticipant
{


	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBookings();
}
