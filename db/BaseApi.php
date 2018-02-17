<?php

/**
* BaseApi class
*/
class BaseApi
{
	static public function process()
	{
		// header('Content-Type: application/json');
		// print_r($_SERVER['REQUEST_URI']);
		$method = $_SERVER['REQUEST_METHOD'];
		$exploded_uri = explode('/', $_SERVER['REQUEST_URI']);
		$action = end($exploded_uri);
		$res = call_user_func_array(array('TablesApi', $method . '_' . $action), array());
		echo json_encode(array('response' => $res));
	}
}