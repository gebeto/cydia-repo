<?php
include_once 'TABLES.php';

// print_r($_POST);
if (isset($_POST['create'], $_POST['index'])) {
	// echo 'CREATE: ' . $_POST['index'];
	$TABLES[$_POST['index']]->create();
} elseif (isset($_POST['remove'], $_POST['index'])) {
	// echo 'REMOVE: ' . $_POST['index'];
	$TABLES[$_POST['index']]->remove();
} elseif (isset($_POST['recreate'], $_POST['index'])) {
	// echo 'RECREATE: ' . $_POST['index'];
	$TABLES[$_POST['index']]->recreate();
}


header("Location: ./");