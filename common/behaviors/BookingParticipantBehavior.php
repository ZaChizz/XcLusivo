<?php


namespace common\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveQuery;
use yii\base\Exception;
use common\helpers\Toolbox;


class BookingParticipantBehavior extends Behavior
{


	public function attach($owner)
	{
		if (!($owner instanceof \common\interfaces\IBookingParticipant)) {
			throw new Exception('Behavior owner must be an instance of common\interfaces\IBookingParticipant.');
		}

		$q = $owner->getBookings();

		if (!($q instanceof ActiveQuery)) {
			throw new Exception('Method getBooking must return an yii\db\ActiveQuery instance (to be relation).');
		}


		parent::attach($owner);
	}



	public function getBookingCount()
	{
		$model = $this->owner;
		$key = 'bookingCount'.-get_class($model).'-'.$model->id;

		return Toolbox::singleton($key, function() use ($model, $conditions) {
			$query = $model->getBookings();
			return $q->count();
		});
	}

	public function getBookingActiveCount()
	{
		$model = $this->owner;
		$key = 'bookingActiveCount'.-get_class($model).'-'.$model->id;
		$self = $this;

		return Toolbox::singleton($key, function() use ($model, $self) {
			$query = $self->getBookingActiveQuery();
			return $query->count();
		});
	}

	public function getBookingActiveQuery()
	{
		return $this->owner->getBookings()
			->andWhere(['>', 'to_date', time()])
			->andWhere(['status' => \common\models\Booking::STATUS_APPROVED])
			->orderBy('from_date ASC');
	}

	public function getBookingPendingCount()
	{
		$model = $this->owner;
		$key = 'bookingPendingCount'.-get_class($model).'-'.$model->id;
		$self = $this;

		return Toolbox::singleton($key, function() use ($model, $self) {
			$query = $self->getBookingPendingQuery();
			return $query->count();
		});
	}

	public function getBookingPendingQuery()
	{
		return $this->owner->getBookings()
			->andWhere(['>', 'to_date', time()])
			->andWhere(['status' => \common\models\Booking::STATUS_PENDING])
			->orderBy('from_date ASC');
	}

	public function getBookingPastCount()
	{
		$model = $this->owner;
		$key = 'bookingPastCount'.-get_class($model).'-'.$model->id;
		$self = $this;

		return Toolbox::singleton($key, function() use ($model, $self) {
			$query = $self->getBookingPastQuery();
			return $query->count();
		});
	}

	public function getBookingPastQuery()
	{
		return $this->owner->getBookings()->andWhere(['<=', 'to_date', time()])->orderBy('from_date DESC');
	}


}
