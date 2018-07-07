<?php
include_once '../db/DB.php';
include_once 'Api.php';

class GET_PurchasesApi extends GET_Api {
	public function Get()
	{
		$this->CheckParams(array('id'));
		$res = DB::select('SELECT * FROM repo_purchases WHERE id=:id', array(
			'id' => $this->params['id']
		));
		$this->SendResponse(array(
			'count' => count($res),
			'items' => $res
		));
	}

	public function GetByUser()
	{
		$this->CheckParams(array('id'));
		$sql = "
			SELECT
				ru.id,
				ru.name,
				ru.udid,
				GROUP_CONCAT(rp.tweak_id) as tweaks
			FROM repo_users ru
			LEFT JOIN repo_purchases rp on rp.user_id=ru.id
			GROUP BY rp.user_id
		";
		if ($this->CheckParamExists('count')) {
			
		}
		$res = DB::select($sql);
		$this->SendResponse(array(
			'count' => count($res),
			'items' => $res
		));
	}

	public function GetAll()
	{
		$sql = "
			SELECT
				rp.id,
				rp.user_id,
				rp.tweak_id,
				ru.name as user_name,
				rt.name as tweak_name,
				rp.purchase_time
			FROM repo_purchases rp
			INNER JOIN repo_users ru ON ru.id=rp.user_id
			INNER JOIN repo_tweaks rt ON rt.id=rp.tweak_id
			ORDER BY rp.user_id, rp.purchase_time DESC
		";
		if ($this->CheckParamExists('count')) {
			
		}
		$res = DB::select($sql);
		$this->SendResponse(array(
			'count' => count($res),
			'items' => $res
		));
	}
}