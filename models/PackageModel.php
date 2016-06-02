<?php

defined('_EXECUTED') or die('Restricted access');

class PackageModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "Package";
		$this->required = array("Title", "DateAdd");
		$this->optional = array("DateModified");
	}


	private function ById($id) {
		$response = $this->db->exec("SELECT * FROM Package WHERE PackageId = ?", (int)$id);
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
		$this->db->begin();

		$data["DateAdd"] = date("Y-m-d H:i:s");
		$this->insert($data);
		$id = $this->db->exec("SELECT LAST_INSERT_ID() as id");

		$this->db->commit();

		return $id ? $id[0]["id"] : null;
	}


	public function edit($data = array()) {
		$data["DateModified"] = date("Y-m-d H:i:s");
		return $this->update($data, array("PackageId"));
	}


	public function remove($find = null) {
		return $this->delete($find, array("PackageId"));
	}
}