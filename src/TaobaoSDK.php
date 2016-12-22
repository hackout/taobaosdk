<?php namespace DennisLui\TaobaoSDK;

/**
*  Taobao SDK
*/
class TaobaoSDK
{
	public $appkey;
	public $secret;
	public $client;

	function __construct( $appkey = null, $secret = null)
	{
		$this->appkey = $appkey;
		$this->secret = $secret;
		$this->client = new TopClient;
		$this->client->appkey = $this->appkey;
		$this->client->secretKey = $this->secret;
	}

	public function api($api,$options = [])
	{
		$class = $this->convertApi($api);
		$path = 'DennisLui\\TaobaoSDK\\Request\\'.$class;
		$req = new $path;
		foreach($options as $key=>$rs)
		{
			$function = $this->convertSet($key);
			$req->$function($rs);
		}
		$resq = $this->client->execute($req);
		return $resq;

	}

	private function convertApi($api)
	{
		$apis = explode('.',$api);
		$return = '';
		foreach($apis as $rs)
			$return .= ucfirst(strtolower($rs));
		return $return;
	}

	private function convertSet($api)
	{
		$apis = explode('_',$api);
		$return = 'set';
		foreach($apis as $rs)
			$return .= ucfirst(strtolower($rs));
		return $return;
	}
}