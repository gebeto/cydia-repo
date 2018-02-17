<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Response.php';

class Api
{
	private $QUERY;
	private $URI;
	
	function __construct()
	{
		$this->InitQuery();
		$this->InitAction();
	}

	private function InitQuery()
	{
		$this->QUERY = $_REQUEST;
		return $this;
	}

	private function HandleOKAction($exp_uri)
	{
		$scriptName = $exp_uri[0];
		$scriptAction = $exp_uri[1];
		$scriptFile = $scriptName . '.php';
		if (file_exists($scriptFile)) {
			require_once($scriptFile);
			$scriptObject = new $scriptName();
			if (method_exists($scriptObject, $scriptAction)) {
				$result = call_user_func_array(array($scriptObject, $scriptAction), array($this->QUERY));
				$resp = new Response('success', $result);
				$resp->send();
			} else {
				$resp = new Response('error', 'Method is not exists');
				$resp->send();
			}
		}
	}

	private function InitAction()
	{
		$SHIFT_COUNT = 3;
		$exp_uri = explode('/', $_SERVER['REDIRECT_URL']);
		for ($i=0; $i < $SHIFT_COUNT; $i++) { 
			array_shift( $exp_uri );
		}
		if (count($exp_uri) > 0) {
			if (count($exp_uri) > 1) {
				$this->HandleOKAction($exp_uri);
			} else {
				$resp = new Response('error', 'You dont call a method');
				$resp->send();
			}
		}
		return $this;
	}


}

$api = new Api();