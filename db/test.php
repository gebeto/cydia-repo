<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'TableModelNew.php';


$tms = array();
foreach (array(
	'apps',
	'test123123',
	'test1',
	'test1',
	'test1',
	'test1',
	'test1',
	'test1',
	'test1',
	'test1',
	'test1',
	'test1',
	'apps',
	'images',
) as $value) {
	$tms[] = new TableModel($value, array(
		'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
		'`test` INT NOT NULL',
	), array(
		'test' => 1,
	));
}

function isInit($tm)
{
	echo '<li>' . $tm->name . ' -- ' . ($tm->is_initialized() ? 'YE' : 'NO') . '</li>';
}

echo '<ul>';
foreach ($tms as $tm) {
	isInit($tm);
}
echo '</ul>';