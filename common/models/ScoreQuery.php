<?php


namespace common\models;

use yii\db\ActiveQuery;
use common\helpers\Scoring;
use common\models\User;

class ScoreQuery extends ActiveQuery
{

	/**
	 * 
	 * @return \common\models\ScoreQuery
	 */
	public function expired()
	{
		$this->andWhere(['<', 'created_at', time()-Scoring::expirationLimit()]);
		return $this;
	}
	
	
	/**
	 * 
	 * @return \common\models\ScoreQuery
	 */
	public function active()
	{
		$this->andWhere(['>', 'valid_until', time()]);
		return $this;
	}
	
	/**
	 * 
	 * @return \common\models\ScoreQuery
	 */
	public function notUpdatedToday()
	{
		$dayStart = strtotime("midnight", time());
		$this->andWhere(['<', '{{%scores}}.updated_at', $dayStart]);
		return $this;
	}
	
	
	public function withPausedProfiles()
	{
		$this->joinWith(['advertiser.user'])->andWhere(['user.status' => User::STATUS_PAUSE]);
		return $this;
	}
}
