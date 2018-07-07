<?php
include_once '../db/DB.php';
include_once 'Api.php';

class GET_UsersApi extends GET_Api {
	public function Get()
	{
		$this->CheckParams(array('id'));
		$res = DB::select('SELECT * FROM repo_users WHERE id=:id', array(
			'id' => $this->params['id']
		));
		$this->SendResponse(array(
			'count' => count($res),
			'items' => $res
		));
	}

	public function GetAll()
	{
		$sql = 'SELECT * FROM repo_users';
		if ($this->CheckParamExists('count')) {
			
		}
		$res = DB::select($sql);
		$this->SendResponse(array(
			'count' => count($res),
			'items' => $res
		));
	}
}