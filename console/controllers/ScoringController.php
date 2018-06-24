<?php


namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Score;
use common\helpers\Scoring;
use yii\helpers\Console;
use frontend\models\Advertiser;
use common\models\User;

class ScoringController extends Controller
{

	public function actionCleanup()
	{
		$amount = Score::deleteAll(['<', 'created_at', time()-Scoring::expirationLimit()]);
		self::out('Purged '.$amount.' expired score records.');
	}

	
	public function actionPaused()
	{
		$paused = Score::find()->withPausedProfiles()->active()->notUpdatedToday();
		$counter = 0;
		
		foreach ($paused->each() as $record) {
			$record->valid_until += Scoring::daysToTimestamp(1);
			$record->update(false, ['valid_until']);
			$counter++;
		}
		
		self::out('Updated '.$counter.' score records of paused profiles.');
	}


	public function actionTest($ok = null)
	{
		if ($ok != 'yes') {
			$this->stdout("Error! ", Console::FG_RED);
			self::out('This action will add a lot of test score records');
			self::out('Those scores can be incompatible with latest scoring logic. You should delete it after using.');
			self::out('Please use "yes" word as command parameter to be sure you know what you are doing.');
			return 1;
		}
		
		self::out('Start test data.');
		
		foreach (Advertiser::find()->with(['user'])->each() as $adv) {
			if (rand(0,1)) {
				self::out('Advertiser "'.$adv->user->username.'"', 1);
				self::out('Scoring Photos', 2);
				
				foreach ($adv->images as $photo) {
					$client = $this->testRandomClient();
					self::out(' Test non-advertiser: "'.$client->username.'" produces scores for image #'.$photo->id.' valid 40 days from now', 3);
					$params = Scoring::prepare($adv->id, 10, 40, $photo, $client->id);
					$params['is_test'] = 1;
					Scoring::addByAttributes($params);
					
					$client = $this->testRandomClient();
					self::out(' Test non-advertiser: "'.$client->username.'" produces scores for image #'.$photo->id.' not valid 1 day ago', 3);
					$params = Scoring::prepare($adv->id, 10, 40, $photo, $client->id);
					$params['valid_until'] = $params['valid_until'] - Scoring::daysToTimestamp(41);
					$params['is_test'] = 1;
					Scoring::addByAttributes($params);

					$client = $this->testRandomClient();
					self::out(' Test non-advertiser: "'.$client->username.'" produces scores for image #'.$photo->id.' expired 181 day ago', 3);
					$params = Scoring::prepare($adv->id, 10, 40, $photo, $client->id);
					$params['valid_until'] = $params['valid_until'] - Scoring::daysToTimestamp(41);
					$params['is_test'] = 1;
					$model = Scoring::addByAttributes($params);
					$model->created_at = time() - Scoring::daysToTimestamp(181);
					$model->save(false, ['created_at']);
				}
				
			}
		}
	}
	
	
	public function actionTestPurge()
	{
		Score::deleteAll(['is_test' => 1]);
	}
	
	protected function testRandomClient()
	{
		return User::find()
			->joinWith(['params'])
			->where(['{{%advertiser}}.id'=>null])
			->orderBy('RAND()')
			->one();
	}
	
	/**
	 * 
	 * @param string $string
	 * @param int $level
	 * @return void
	 */
	protected static function out($string, $level = 0)
	{
		$prefix = str_pad('', $level, "\t");
		echo $prefix . $string . "\r\n";
	}
}
