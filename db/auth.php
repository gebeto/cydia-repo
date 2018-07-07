<?php

$accounts = array(
	'admin' => 'pw',
);

function authErr()
{
	header('WWW-Authenticate: Basic realm="Need auth"');
	header('HTTP\ 1.0 401 Unauthorized');
	// echo 'Need auth!';
	exit();
}

if (!isset($accounts[$_SERVER['PHP_AUTH_USER']])) {
	authErr();
}

if ($accounts[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) {
	authErr();
}