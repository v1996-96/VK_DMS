<?php

defined('_EXECUTED') or die('Restricted access');

class UserModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "User";
		$this->required = array("Name", "Surname", "Email", "Password", "Role", "VK");
		$this->optional = array();
	}


	/* Check email */
	private function IsEmailUnique($email) {
		$response = $this->db->exec("SELECT id FROM ".$this->entity." WHERE Email = ?", $email);
		return !(bool)$response;
	}


	/* Check vk id */
	private function IsVkIdUnique($vkId) {
		$response = $this->db->exec("SELECT id FROM ".$this->entity." WHERE VK = ?", $vkId);
		return !(bool)$response;
	}


	/* Read */
	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'isEmailUnique':
					if (isset($search["email"])) {
						return $this->IsEmailUnique($search["email"]);
					} else return null;

				case 'isVkIdUnique':
					if (isset($search["id"])) {
						return $this->IsVkIdUnique($search["id"]);
					} else return null;
				
				default: return null;
			}
		} else return null;
	}


	/* Create */
	public function add($data = array()) {
		// Start transaction
		$this->db->begin();

		$this->insert($data);
		$lastInsertId = $this->db->exec("SELECT LAST_INSERT_ID() as id;");

		// Finish transaction
		$this->db->commit();

		return $lastInsertId ? $lastInsertId[0]["id"] : null;
	}


	/* Update */
	public function edit($data = array()) {
		return null;
	}


	/* Delete */
	public function remove($find = null) {
		return null;
	}
}