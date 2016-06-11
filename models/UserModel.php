<?php

defined('_EXECUTED') or die('Restricted access');

class UserModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "User";
		$this->required = array("Name", "Surname", "Email", "Password", 
			"Role", "VK", "VK_Avatar", "DateRegistered");
		$this->optional = array();
	}


	private function IsEmailUnique($email) {
		$response = $this->db->exec("SELECT id FROM ".$this->entity." WHERE Email = ?", $email);
		return !(bool)$response;
	}


	private function ByVkId($vkId) {
		return $this->db->exec("SELECT id FROM ".$this->entity." WHERE VK = ?", $vkId);
	}


	private function ById($vkId) {
		return $this->db->exec("SELECT * FROM ".$this->entity." WHERE id = ?", $vkId);
	}


	private function IsVkIdUnique($vkId) {
		$response = $this->db->exec("SELECT id FROM ".$this->entity." WHERE VK = ?", $vkId);
		return !(bool)$response;
	}


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
						WHEN 1 THEN 'Администратор'
						ELSE 
							CASE
								WHEN EXISTS(SELECT * FROM DepartmentEmployee as DE
											LEFT JOIN Department as D ON DE.DepartmentId = D.DepartmentId
											WHERE D.CompanyId = CE.CompanyId AND DE.IsManager = 1) THEN 'Руководитель'
								WHEN EXISTS(SELECT * FROM ProjectEmployee as PE
											LEFT JOIN Project as P ON PE.ProjectId = P.ProjectId
											LEFT JOIN Department as Dep ON P.DepartmentId = Dep.DepartmentId
											WHERE Dep.CompanyId = CE.CompanyId AND PE.IsManager = 1) THEN 'Менеджер'
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


	private function Summary($id, $url) {
		$query =   "SELECT 
					u.*,
					case 
						when 
							c.CompanyId is not null
							and c.Url = :CompanyUrl
							then 'Генеральный директор'
						else 
							case
								when ce.CompanyId is not null and ce.IsAdmin = 1 then 'Администратор'
								else
									case 
										when de.DepartmentId is not null and de.IsManager = 1 then 'Руководитель'
										when pe.ProjectId is not null and pe.IsManager = 1 then 'Менеджер'
										else 'Сотрудник'
									end
							end
					end as EmployeeType,
					ifnull(d.Title, '-') as DepartmentTitle,
					ifnull(de.RoleDescription, '-') as DepartmentRole

					FROM User as u
					LEFT JOIN Company as c ON c.CreatorId = u.id
					LEFT JOIN CompanyEmployee as ce ON u.id = ce.UserId
					LEFT JOIN Company as cc on cc.CompanyId = ce.CompanyId
					LEFT JOIN DepartmentEmployee as de ON ((u.id = de.UserId) and (de.CompanyId = ce.CompanyId))
					LEFT JOIN Department as d ON d.DepartmentId = de.DepartmentId
					LEFT JOIN Project as p ON p.DepartmentId = d.DepartmentId
					LEFT JOIN ProjectEmployee as pe ON ((pe.UserId = u.id) and (pe.ProjectId = p.ProjectId))
					WHERE u.id = :EmployeeId AND (cc.Url = :CompanyUrl or c.Url = :CompanyUrl)
					GROUP BY u.id";
		return $this->db->exec($query, array("EmployeeId" => (int)$id, "CompanyUrl" => $url));
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

				case 'byVkId':
					if (isset($search["id"])) {
						return $this->ByVkId($search["id"]);
					} else return null;

				case 'byId':
					if (isset($search["id"])) {
						return $this->ById($search["id"]);
					} else return null;

				case 'summary':
					if (isset($search["id"]) && isset($search["url"])) {
						return $this->Summary($search["id"], $search["url"]);
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