<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../db/DB.php';

function UDID()
{
	$SRC = $_SERVER;
	// $SRC = $_GET;
	if (isset($SRC['HTTP_X_UNIQUE_ID'])) {
		return $SRC['HTTP_X_UNIQUE_ID'];
	} else {
		return false;
	}
}

function GetDebFile($fileName)
{
    header('Content-Type: application/vnd.debian.binary-package');
    include $fileName;
    exit(0);
}

function CheckPurchase($fileName) {
	$udid = UDID();

	DB::exec("
		INSERT INTO repo_users (udid)
		VALUES (:udid)
  		ON DUPLICATE KEY
  		UPDATE last_tweak_time=CURRENT_TIMESTAMP;
	", array(
		'udid' => $udid
	));

	$res = DB::select("
		SELECT
			rt.id as tweak_id,
			ru.id as user_id,
			rt.Name as name,
			rt.Filename as filename,
			rp.purchase_time
		FROM repo_tweaks rt
		INNER JOIN repo_users ru ON ru.udid=:udid
		INNER JOIN repo_purchases rp ON rp.user_id=ru.id AND rp.tweak_id=rt.id
		WHERE rt.Filename=:filename AND ru.active=1;
	", array(
		'filename' => $fileName,
		'udid' => $udid
	));
	return $res;
}

function UpdateLastTweak($user_id, $tweak_id)
{
	
}

// print_r($_SERVER);

$exploded_path = explode('/', $_SERVER['REDIRECT_URL']);
$fileName = end($exploded_path);

if (!UDID()) {
	http_response_code(403);
	echo 'You are not authorized user';
	exit(0);
}

$res = CheckPurchase($fileName);

if (count($res) == 0) {
	http_response_code(403);
	echo '"' . $fileName . '" is not purchased or file not found';
	exit(0);
}

if (!file_exists($fileName)) {
	http_response_code(403);
	echo '"' . $fileName . '" is not found on server';
	exit(0);
}

// echo json_encode($res);
GetDebFile($fileName);

