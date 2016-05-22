<?php

defined('_EXECUTED') or die('Restricted access');

class UserModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "User";
		$this->required = array("Name", "Surname", "Email", "Password", "Role", "VK", "VK_Avatar", "DateRegistered");
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


	/* Get user list by company url */
	private function ByCompanyUrl($url) {
		$query = "SELECT
					U.id, U.Name, U.Surname, U.VK_Avatar, U.VK, U.DateRegistered,
					'Генеральный директор' as Position,
					'-' as DepartmentTitle,
					'-' as DepartmentRole
				FROM User as U
				LEFT JOIN Company as C ON U.id = C.CreatorId
				WHERE C.Url = :url";
		$query.=" union ";
		$query.="SELECT 
					U.id, U.Name, U.Surname, U.VK_Avatar, U.VK, U.DateRegistered,
					CASE CE.IsAdmin
						WHEN CE.IsAdmin THEN 'Администратор'
						ELSE 
							CASE
								WHEN EXISTS(SELECT * FROM DepartmentEmployee as DE
												LEFT JOIN Department as D ON DE.DepartmentId = D.DepartmentId
												WHERE D.CompanyId = CE.CompanyId) THEN 'Руководитель'
								WHEN EXISTS(SELECT * FROM ProjectEmployee as PE
												LEFT JOIN Project as P ON PE.ProjectId = P.ProjectId
												LEFT JOIN Department as Dep ON P.DepartmentId = Dep.DepartmentId
												WHERE Dep.CompanyId = CE.CompanyId) THEN 'Менеджер'
								ELSE 'Сотрудник'
				 			END
					END as Position,
					ifnull((SELECT De.Title FROM DepartmentEmployee as DEm
					LEFT JOIN Department as De on DEm.DepartmentID = De.DepartmentId
					WHERE DEm.UserId = U.id GROUP BY UserId), '-') as DepartmentTitle,
					
					ifnull((SELECT DEm.RoleDescription FROM DepartmentEmployee as DEm
					WHERE DEm.UserId = U.id GROUP BY UserId), '-') as DepartmentRole
					
				FROM User as U
				LEFT JOIN CompanyEmployee as CE ON U.id = CE.UserId
				LEFT JOIN Company as C ON C.CompanyId = CE.CompanyId
				WHERE C.Url = :url";

		return $this->db->exec( $query, array("url" => $url) );
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

				case 'byCompanyUrl':
					if (isset($search["url"])) {
						return $this->ByCompanyUrl($search["url"]);
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