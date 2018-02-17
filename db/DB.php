<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


class DB {
	
	public static $connection;

	public static function connect() {
		$host = 'localhost';
		$user = 'c97006xu_1';
		$pass = 'password';
		$dbname = 'c97006xu_1';

		try {
			DB::$connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);	
		}	
		catch(PDOException $e) {	
			echo $e->getMessage();
			exit();
		}
	}

	public static function select($query, $data = array()) {
		$STH = DB::$connection->prepare($query);
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		$STH->execute($data);
		$res = $STH->fetchAll();
		return $res;
	}
	
	public static function exec($query, $data = array()) {
		$STH = DB::$connection->prepare($query);
		$res = $STH->execute($data);
		return $res;
	}
	
	public static function insert($table_name, $data = array()) {
		$table_keys = array();
		$prepare_keys = array();
		$sql = 'INSERT INTO `';
		$sql .= $table_name . '` (';
		foreach ($data as $key => $value) {
			$table_keys[] = '`' . $key . '`';
			$prepare_keys[] = ':' . $key;
		}
		$sql .= implode(', ', $table_keys);
		$sql .= ') VALUES (';
		$sql .= implode(', ', $prepare_keys);
		$sql .= ');';
		
		DB::exec($sql, $data);
		return '';
	}

	public static function create_table($table_name, $cols=array()) {
		$sql = 'CREATE TABLE `';
		$sql .= $table_name;
		$sql .= '` (';
		$sql .= implode(', ', $cols);
		$sql .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';

		DB::exec($sql);
	}

	public static function alter_table($table_name, $action) {
		$sql = 'ALTER TABLE `' . $table_name . '` ' . $action . ';';
		DB::exec($res);
	}

	public static function drop_table($table_name) {
		$sql = 'DROP TABLE `' . $table_name . '`;';
		DB::exec($sql);
	}

	// public static function init() {
	// 	DB::create_table('repo_info', array(
	// 		'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
	// 		'`title` varchar(64) NOT NULL',
	// 		'`description` varchar(256) NOT NULL',
	// 		'`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
	// 	));
	// 	DB::insert('repo_info', array(
	// 		'id' => 1,
	// 		'title' => 'Danik repo',
	// 		'description' => 'Daniel repository'
	// 	));

	// 	DB::create_table('repo_users', array(
	// 		'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
	// 		'`name` varchar(50) NOT NULL',
	// 		'`udid` varchar(40) NOT NULL',
	// 		'`is_active` tinyint(1) NOT NULL DEFAULT 1'
	// 	));
		
	// 	DB::create_table('repo_tweaks', array(
	// 		'`id` INT NOT NULL AUTO_INCREMENT',
	// 		'`name` VARCHAR(32) NOT NULL',
	// 		'`description` VARCHAR(256) NOT NULL',
	// 		'`version` VARCHAR(11) NOT NULL',
	// 		'PRIMARY KEY (`id`)',
	// 		'UNIQUE `tweak_unique` (`name`)'
	// 	));
		
	// 	DB::create_table('repo_purchases', array(
	// 		'`id` INT NOT NULL AUTO_INCREMENT',
	// 		'`user_id` INT NOT NULL AUTO_INCREMENT',
	// 		'`tweak_id` INT NOT NULL AUTO_INCREMENT',
	// 		'`purchase_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
	// 		'PRIMARY KEY (`id`)'
	// 	));
	// }

	// public static function uninit() {
	// 	DB::drop_table('repo_info');
	// 	DB::drop_table('repo_users');
	// 	DB::drop_table('repo_tweaks');
	// 	DB::drop_table('repo_purchases');
	// }
	
	// public static function action() {
	// 	if (isset($_GET['act'])) {
	// 		call_user_func_array(array('DB', $_GET['act']), array());
	// 	}
	// }

}

DB::connect();
// print_r(
// 	DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=:table_name", array(
// 			'table_name' => 'repo_info'
// 		)
// 	)
// );
// DB::action();