<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[BookingRequests]].
 *
 * @see BookingRequests
 */
class BookingRequestsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BookingRequests[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BookingRequests|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
