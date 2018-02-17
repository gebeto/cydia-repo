<?php

include_once 'DB.php';


class TableModel {
	public $name;
	public $columns;
	public $default_insert;

	function __construct($name, $columns, $default_insert = array()) {
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
		$res = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_NAME=:table_name", array(
				'table_name' => $this->name
			)
		);
		return count($res) > 0;
	}
}