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


	private function IsVkNew($vk, $id) {
		$companyEmployee = $this->db->exec("SELECT * FROM User as U
											LEFT JOIN CompanyEmployee as CE ON CE.UserId = U.id
											WHERE CE.CompanyId = :id AND U.VK = :vk",
											array("id" => $id, "vk" => $vk));
		$companyOwner = $this->db->exec("SELECT * FROM User as U
											LEFT JOIN Company as C ON C.CreatorId = U.id
											WHERE C.CompanyId = :id AND U.VK = :vk",
											array("id" => $id, "vk" => $vk));
		return !(bool)$companyOwner && !(bool)$companyEmployee;
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'isVkNew':
					if (isset($search["vk"]) && isset($search["id"])) {
						return $this->IsVkNew($search["vk"], $search["id"]);
					} else return null;
				
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