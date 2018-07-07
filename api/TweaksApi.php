<?php
include_once '../db/DB.php';
include_once 'Api.php';
include_once 'packager.php';

class GET_TweaksApi extends GET_Api {
	public function Get()
	{
		$this->CheckParams(array('id'));
		$res = DB::select('SELECT * FROM repo_tweaks WHERE id=:id', array(
			'id' => $this->params['id']
		));
		$this->SendResponse(array(
			'count' => count($res),
			'items' => $res
		));
	}

	public function GetAll()
	{
		$sql = 'SELECT * FROM repo_tweaks';
		if ($this->CheckParamExists('count')) {
			
		}
		$res = DB::select($sql);
		$this->SendResponse(array(
			'count' => count($res),
			'items' => $res
		));
	}

	public function GetFiles()
	{
		$res = glob('../debs/*.deb');
		$files = array();
		foreach ($res as $file_path) {
			$exploded_path = explode('/', $file_path);
			$files[] = array(
				'hash' => md5_file($file_path),
				'size' => filesize($file_path),
				'file' => end($exploded_path),
			);
		}
		$this->SendResponse(array(
			'count' => count($files),
			'items' => $files
		));
	}

	public function UpdatePackagesList()
	{
		gzCompression();
		bzCompression();
		$this->SendResponse(array(
			'message' => 'List of packages is updated'
		));
	}
}

class POST_TweaksApi extends POST_Api {
	public function RegisterTweak()
	{
		$this->CheckParams(array('name', 'filename', 'hash', 'size'));
		
		$file_path = '../debs/' . $this->params['filename'];
		$res = glob($file_path);
		if (count($res) > 0) {
			if ($this->params['size'] != $fs = filesize($file_path)) {
				$this->SendErrorResponse('Bad file size, size of file is ' . $fs . ' bytes.');
			}
			if ($this->params['hash'] != $fh = md5_file($file_path)) {
				$this->SendErrorResponse('Bad hash, hash of this file is ' . $fh);
			}
		} else {
			$this->SendErrorResponse('File is not found');
		}
		
		$res = DB::exec('INSERT INTO `repo_tweaks` (id, name, filename) SELECT id + 1, :name, :filename FROM `repo_tweaks` ORDER BY id DESC LIMIT 1;', array(
			'name' => $this->params['name'],
			'filename' => $this->params['filename']
		));
		
		if ($res) {
			$data = DB::select('SELECT * FROM repo_tweaks ORDER BY id DESC LIMIT 1;');
			$this->SendSuccessResponse(array(
				'count' => count($data),
				'items' => $data
			));
		}

		$this->SendErrorResponse('Registration error, this file is registered or something went wrong!');
	}
}