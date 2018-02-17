<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'BaseApi.php';

class TablesApi extends BaseApi
{
	static public function GET_test()
	{
		return array('test');
	}
}


TablesApi::process();