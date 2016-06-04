<?php

defined('_EXECUTED') or die('Restricted access');

class TaskPackageModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "TaskPackage";
		$this->required = array("ProjectId", "TaskId", "DateAdd");
		$this->optional = array();
	}


	private function ById($id) {
		$response = $this->db->exec("SELECT * FROM TaskPackage WHERE PackageId = ?", (int)$id);
		return $response ? $response[0] : null;
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'byId':
					if (isset($search["id"])) {
						return $this->ById($search["id"]);
					} else return null;
				
				default: return null;
			}
		} else return null;
	}


	public function add($data = array()) {
		return null;
	}


	public function edit($data = array()) {
		return null;
	}


	public function remove($find = null) {
		return null;
	}
}