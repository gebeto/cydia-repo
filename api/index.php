<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// print_r($_SERVER);
// exit(0);

$euri = explode('/', $_SERVER['REDIRECT_URL']);
$request = end($euri);
// echo $request;

$segments = explode('.', $request);
$controllerName = ucfirst(array_shift($segments)) . 'Api';

$actionName = ucfirst(array_shift($segments));
// echo $controllerName . ' -- ' . $actionName;
$controllerFile = $controllerName . '.php';
$controllerName = $_SERVER['REQUEST_METHOD'] . '_' . $controllerName;
if (file_exists($controllerFile)) {
    include_once $controllerFile;
}
$controllerObject = new $controllerName();
if (method_exists($controllerObject, $actionName)) {
	call_user_func_array(array($controllerObject, $actionName), array());
}
// echo $result;
// $result = $controllerObject->$actionName($segments);
echo json_encode(array(
	'response' => 'Method not found'
));

?>