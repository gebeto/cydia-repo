<?php

/**
* Api Base class
*/
class Api
{
	public $params;
	function __construct() {
		$this->params = $_GET;
	}

	public function SendResponse($params)
	{
		echo json_encode(array(
			'response' => $params,
		));
		exit(0);
	}

	public function SendSuccessResponse($data)
	{
		$this->SendResponse($data);
	}

	public function SendErrorResponse($message)
	{
		$this->SendResponse(array(
			'message' => $message,
			'error' => true
		));
	}

	public function CheckParams($params = array()) {
		foreach ($params as $key => $value) {
			if (!isset($this->params[$value])) {
				$this->SendErrorResponse('Need param: ' . $value);
			}
		}
		return false;
	}

	public function CheckParamExists($param) {
		if (isset($this->params[$param])) {
			return true;
		}
		return false;
	}
}

/**
* POSTApi
*/
class POST_Api extends Api
{
	function __construct() {
		$this->params = $_POST;
	}
}

/**
* GETApi
*/
class GET_Api extends Api
{
	function __construct() {
		$this->params = $_GET;
	}
}

