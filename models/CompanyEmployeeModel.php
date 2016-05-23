<?php

defined('_EXECUTED') or die('Restricted access');

class CompanyEmployeeModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "CompanyEmployee";
		$this->required = array("CompanyId", "UserId", "IsAdmin", "DateAdd", "RoleDescription");
		$this->optional = array();
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				// case 'byToken':
				// 	if (isset($search["token"])) {
				// 		return $this->ByToken($search["token"]);
				// 	} else return null;
				
				default: return null;
			}
		} else return null;
	}


	public function add($data = array()) {
		return $this->insert($data);
	}


	public function edit($data = array()) {
		return null;
	}


	public function remove($find = null) {
		return null;
	}
}