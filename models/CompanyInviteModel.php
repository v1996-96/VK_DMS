<?php

defined('_EXECUTED') or die('Restricted access');

class CompanyInviteModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "CompanyInvite";
		$this->required = array("CompanyId", "RegistrationToken", "VK", "DateAdd");
		$this->optional = array();
	}


	private function ByToken($token) {
		return $this->db->exec("SELECT * FROM CompanyInvite WHERE RegistrationToken = ?", $token);
	}


	private function ByCompanyUrl($url) {
		return $this->db->exec("SELECT CI.* FROM CompanyInvite as CI
								LEFT JOIN Company as C ON CI.CompanyId = C.CompanyId
								WHERE C.Url = :url",
								array("url" => $url));
	}


	private function IsTokenUnique($token) {
		return !(bool)$this->db->exec("SELECT * FROM CompanyInvite WHERE RegistrationToken = ?", $token);
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'byToken':
					if (isset($search["token"])) {
						return $this->ByToken($search["token"]);
					} else return null;

				case 'byCompanyUrl':
					if (isset($search["url"])) {
						return $this->ByCompanyUrl($search["url"]);
					} else return null;

				case 'isTokenUnique':
					if (isset($search["token"])) {
						return $this->IsTokenUnique($search["token"]);
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
		return $this->delete($find, array("id"));
	}
}