<?php
/**
 *  http://fixer.io/
 */


namespace common\components;

use yii\base\Component;

/**
 * @property string $base 
 * @property boolean $https 
 * @property boolean $ratesOnly Return array of rates only (otherwise full responce array)
 * @property array $rates Fixer response array
 */
class Fixer extends Component
{

	const GATEWAY = '//api.fixer.io/';

	// Base currency (calculation basis, eq 1)
	public $base = null;
	// Use HTTPS requests
	public $https = false;
	//Return array of rates only (otherwise full responce array)
	public $ratesOnly = true;
	protected $_loaded = [];

	
	public function init()
	{
		parent::init();
		
		if (!$this->base) {
			$this->base = 'EUR';
		}
	}

	public function getRates($date = null, $refresh = false)
	{
		if (null == $date) {
			$dateStr = 'latest';
		} else {
			if (!filter_var($date, FILTER_VALIDATE_INT)) {
				$date = strtotime($date);
			}

			$dateStr = date('Y-m-d', $date);
		}

		$key = md5($dateStr . $this->base);

		if (!isset($this->_loaded[$key]) || $refresh) {
			$response = $this->_loaded[$key] = $this->request($this->getRequestUrl($dateStr));
		}

		$result = $this->_loaded[$key];

		if ($result && $this->ratesOnly) {
			$result = $result['rates'];
		}

		return $result;
	}


	protected function getRequestUrl($dateStr)
	{
		$url = self::GATEWAY . $dateStr;

		if ($this->base) {
			$url.= '?base=' . urlencode($this->base);
		}

		return ($this->https ? 'https:' : 'http:') . $url;
	}


	protected function request($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$result = curl_exec($ch);
		curl_close($ch);

		if ($result) {
			$result = json_decode($result, true);
			return isset($result['rates']) ? $result : false;
		} else {
			return false;
		}
	}


}
