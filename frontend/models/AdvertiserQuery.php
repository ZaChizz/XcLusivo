<?php

namespace frontend\models;

use common\helpers\Toolbox;
use common\helpers\Calendar;
use common\models\AdvertiserScore;

/**
 * This is the ActiveQuery class for [[Advetiser]].
 *
 * @see Advetiser
 */
class AdvertiserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Advetiser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Advetiser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
	
	
    public function availableInDateRange($start, $end)
    {
            $start = Toolbox::ensureTimestamp($start);
            $end = Toolbox::ensureTimestamp($end);
            $realStart = $start-Calendar::eventBorderPeriod()*60*60;
            $realEnd = $end+Calendar::eventBorderPeriod()*60*60;
            $this->bookingDateRange($start, $end);
            $this->andWhere(['{{%bookings}}.id' => null]);
            $this->groupBy('id');
            return $this;
    }


    public function orderByScores($desc = true)
    {
            $this->joinWith(['advertiserScores']);
            $this->orderBy(AdvertiserScore::tableName().'.amount_sum '.($desc ? 'DESC' : 'ASC'));
            return $this;
    }


    protected function bookingDateRange($start, $end)
    {
            $this->leftJoin('{{%bookings}}', '{{%bookings}}.advertiser_id={{%advertiser}}.id AND '
                    . '({{%bookings}}.from_date>:bookingStart OR {{%bookings}}.to_date>:bookingStart OR {{%bookings}}.from_date<:bookingEnd OR {{%bookings}}.to_date<:bookingEnd)', [
                            ':bookingStart' => $start,
                            ':bookingEnd' => $end,
                    ]);
            return $this;
    }
}