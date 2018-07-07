<?php

include_once 'DB.php';


class TableModel {
	static public $table_names = array();
	static public $tables = null;

	static public function init_tables_data() {
		if (TableModel::$tables) {

		} else {
			TableModel::$tables = array();
			$query = implode(',', array_fill(0, count(TableModel::$table_names), '?'));
			$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME IN(" . $query . ")";
			$res = DB::select($sql, TableModel::$table_names);
			foreach ($res as $table) {
				// echo $table;
				TableModel::$tables[$table['TABLE_NAME']] = array();
			}
		}
	}

	public $name;
	public $columns;
	public $default_insert;

	function __construct($name, $columns, $default_insert = array()) {
		// Tables
		TableModel::$table_names[] = $name;

		$this->name = $name;
		$this->columns = $columns;
		$this->default_insert = $default_insert;
	}
	
	public function create() {
		DB::create_table($this->name, $this->columns);
		$this->default_insert();
	}
	
	public function remove() {
		DB::drop_table($this->name);
	}

	public function recreate() {
		$this->remove();
		$this->create();
	}

	public function default_insert() {
		DB::insert($this->name, $this->default_insert);
	}
	
	public function is_initialized() {
		if (!TableModel::$tables) {
			TableModel::init_tables_data();
		}
		return isset(TableModel::$tables[$this->name]);
	}
}