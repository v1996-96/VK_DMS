<?php

defined('_EXECUTED') or die('Restricted access');

class CompanyEmployeeModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "CompanyEmployee";
		$this->required = array("CompanyId", "UserId", "IsAdmin", "DateAdd");
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


	private function ById($userId, $companyId) {
		return $this->db->exec("SELECT * FROM CompanyEmployee
								WHERE UserId = :userId AND CompanyId = :companyId",
								array("userId" => $userId, "companyId" => $companyId));
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'isVkNew':
					if (isset($search["vk"]) && isset($search["id"])) {
						return $this->IsVkNew($search["vk"], $search["id"]);
					} else return null;

				case 'byId':
					if (isset($search["userId"]) && isset($search["companyId"])) {
						return $this->ById($search["userId"], $search["companyId"]);
					} else return null;
				
				default: return null;
			}
		} else return null;
	}


	public function add($data = array()) {
		$data["DateAdd"] = date("Y-m-d H:i:s");
		return $this->insert($data);
	}


	public function edit($data = array()) {
		return $this->update($data, array("UserId", "CompanyId"));
	}


	public function remove($find = null) {
		return $this->delete($find, array("UserId", "CompanyId"));;
	}
}