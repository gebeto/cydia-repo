<?php

include_once 'TableModelNew.php';

$TABLES = array(

	new TableModel('repo_users', array(
		'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
		'`name` VARCHAR(50) NOT NULL DEFAULT "unknown"',
		'`udid` VARCHAR(40) NOT NULL',
		'`active` TINYINT(1) NOT NULL DEFAULT 0',
		'`last_tweak` TINYINT(1) NOT NULL DEFAULT 0',
		'`last_tweak_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
		'UNIQUE (`udid`)'
	), array(
		'name' => 'Slavik Nychkalo',
		'udid' => '6e74d6351e6e38cfced813c9f0e38aa3d8174834'
	)),

	new TableModel('repo_purchases', array(
		'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
		'`user_id` INT NOT NULL',
		'`tweak_id` INT NOT NULL',
		'`purchase_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
		'UNIQUE `user_tweak_key` (`user_id`, `tweak_id`)'
	), array(
		'user_id' => 1,
		'tweak_id' => 1,
	)),
	
	// new TableModel('repo_tweaks', array(
	// 	'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
	// 	'`name` VARCHAR(64) NOT NULL',
	// 	'`filename` VARCHAR(64) NOT NULL',
	// 	'`downloads` INT NOT NULL DEFAULT 0',
	// 	'UNIQUE (`name`)',
	// 	'UNIQUE (`filename`)'
	// ), array(
	// 	'name' => 'Test Package',
	// 	'filename' => 'Package.deb',
	// )),

	new TableModel('repo_tweaks', array(
		'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
		'`Name` VARCHAR(64) NOT NULL',
		'`Package` VARCHAR(64) NOT NULL',
		'`Version` VARCHAR(12) NOT NULL DEFAULT \'1.0\'',
		'`Maintainer` VARCHAR(64) NOT NULL',
		'`Filename` VARCHAR(64) NOT NULL',
		'`Size` INT NOT NULL',
		'`MD5sum` VARCHAR(32) NOT NULL',
		'`Section` VARCHAR(32) NOT NULL',
		'`Description` VARCHAR(256) NOT NULL',
		'`Author` VARCHAR(64) NOT NULL',
		'UNIQUE (`Name`)',
		'UNIQUE (`Package`)',
		'UNIQUE (`Filename`)'

		// '`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
		// '`name` VARCHAR(64) NOT NULL',
		// '`filename` VARCHAR(64) NOT NULL',
		// '`downloads` INT NOT NULL DEFAULT 0',
		// 'UNIQUE (`name`)',
		// 'UNIQUE (`filename`)'
		
	), array(
		'Name' => 'Test Package',
		'Package' => 'com.slaviktest.package',
		'Version' => '1.0',
		'Maintainer' => 'Slavik Nychkalo',
		'Filename' => 'Package.deb',
		'Size' => 1370,
		'MD5sum' => 'e71f21bd3b20d299b406c77e9143a15e',
		'Section' => 'Test',
		'Description' => 'Some test package',
		'Author' => 'Slavik Nychkalo',
	)),

);