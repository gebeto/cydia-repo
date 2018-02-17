<?php
require_once 'db/DB.php';
require_once 'methods/compression.php';

/**
* Repo redirection class
*/
class Repo
{
	private $currentUDID;
	private $isTrusted = false;
	// private $repoPath = 'http://jailgeek.ru/repo/repofiles';
	private $repoPath = 'repofiles';

	function __construct()
	{
		$this->isTrusted = $this->checkUDID();
		$this->isTrusted = true;
	}

	public function checkUDID() {
		if (isset($_SERVER['HTTP_X_UNIQUE_ID'])) {
			// DB::insert('repo_users', array('name' => 'slavik', 'udid' => $_SERVER['HTTP_X_UNIQUE_ID']));
			$res = DB::select('SELECT * FROM repo_users WHERE udid=:udid', array(
				'udid' => $_SERVER['HTTP_X_UNIQUE_ID']
			));
			if (count($res) > 0) return true;
		}
		return false;
	}

	public function init()
	{
		$ex_path = explode('/', $_SERVER['REQUEST_URI']);
		$method = end($ex_path);

		if ($this->isTrusted == false && $method == 'Release') {
			$this->Release(true);
			exit();
		}

		switch ($method) {
			case 'Release':
				$this->Release();
				break;

			case 'Packages.bz2':
				$this->PackagesBZ2();
				break;

			case 'Packages.gz':
				$this->PackagesGZ();
				break;

			default:
				// call_user_func_array(array($this, $method), array());
				break;
		}
	}

	public function Release($error = false) {
		header('Content-Type: text/plain');
		if ($error) {
			$title = 'Купи доступ';
			$description = 'Купи доступ';
		} else {
			$res = DB::select('SELECT * from repo_info ORDER BY id DESC;', array());
			$title = $res[0]['title'];
			$description = $res[0]['description'];
		}
		echo trim("
Origin: $title
Label: $title
Suite: stable
Version: 1.0
Codename: ios
Architectures: iphoneos-arm
Components: main
Description: $description
		");
	}

	public function PackagesBZ2() {
		header('Content-Type: application/x-bzip2');
		// bzCompressTweaks('repofiles/Packages');
		include_once $this->repoPath . '/Packages.bz2';
	}

	public function PackagesGZ() {
		header('Content-Type: application/x-gzip');
		// gzCompressTweaks('repofiles/Packages');
		include_once $this->repoPath . '/Packages.gz';
	}

}


$repo = new Repo();
$repo->init();