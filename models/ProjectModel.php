<?php

defined('_EXECUTED') or die('Restricted access');

class ProjectModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "Project";
		$this->required = array("DepartmentId", "Title", "DateAdd");
		$this->optional = array("Description", "Status");
	}


	private function ForEmployee($employeeId, $companyUrl) {
		return $this->db->exec("SELECT p.* FROM Project as p
								LEFT JOIN ProjectEmployee as pe ON p.ProjectId = pe.ProjectId
								LEFT JOIN Department as d ON d.DepartmentId = p.DepartmentId
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								WHERE pe.UserId = :id and c.Url = :url
								ORDER BY p.DateAdd DESC",
								array("id" => (int)$employeeId, "url" => $companyUrl));
	}


	private function ByDepartmentId($departmentId) {
		return $this->db->exec("SELECT 
									p.*, 
									COUNT(DISTINCT t.TaskId) as TaskCount, 
									COUNT(DISTINCT pe.UserId) as EmployeeCount
								FROM Project as p
								LEFT JOIN Task as t ON t.ProjectId = p.ProjectId
								LEFT JOIN ProjectEmployee as pe ON pe.ProjectId = p.ProjectId
								WHERE p.DepartmentId = ?
								GROUP BY p.ProjectId
								ORDER BY p.DateAdd DESC", (int) $departmentId);
	}


	private function ById($id) {
		$response = $this->db->exec("SELECT p.*, d.Title as DepartmentTitle FROM Project as p 
									 LEFT JOIN Department as d ON p.DepartmentId = d.DepartmentId
									 WHERE ProjectId = ?", (int)$id);
		return $response ? $response[0] : null;
	}


	private function ByCompanyUrl($url) {
		return $this->db->exec("SELECT 
									p.*,
									d.Title as DepartmentTitle,
									COUNT(DISTINCT t.TaskId) as TaskCount,
									COUNT(DISTINCT pe.UserId) as EmployeeCount
								FROM Project as p
								LEFT JOIN Task as t ON t.ProjectId = p.ProjectId
								LEFT JOIN ProjectEmployee as pe ON pe.ProjectId = p.ProjectId
								LEFT JOIN Department as d ON p.DepartmentId = d.DepartmentId
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								WHERE c.Url = ?
								GROUP BY p.ProjectId
								ORDER BY p.Status DESC, p.DateAdd DESC", $url);
	}


	private function ByCompanyUrlForUser($url, $userId) {
		return $this->db->exec("SELECT 
									p.*,
									d.Title as DepartmentTitle,
									COUNT(DISTINCT t.TaskId) as TaskCount,
									COUNT(DISTINCT pe.UserId) as EmployeeCount
								FROM Project as p
								LEFT JOIN Task as t ON t.ProjectId = p.ProjectId
								LEFT JOIN ProjectEmployee as pe ON pe.ProjectId = p.ProjectId
								LEFT JOIN Department as d ON p.DepartmentId = d.DepartmentId
								LEFT JOIN DepartmentEmployee as de ON de.DepartmentId = d.DepartmentId
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								WHERE c.Url = :url AND de.UserId = :userId
								GROUP BY p.ProjectId
								ORDER BY p.Status DESC, p.DateAdd DESC",
								array("url" => $url, "userId" => $userId));
	}


	private function GetUserRights($userId, $projectId) {
		$dep = $this->db->exec("SELECT de.IsManager FROM DepartmentEmployee as de
								LEFT JOIN Project as p ON de.DepartmentId = p.DepartmentId
								WHERE de.UserId = :userId AND p.ProjectId = :projectId",
								array("userId" => (int)$userId, "projectId" => (int)$projectId));

		if ($dep && count($dep) == 1 && $dep[0]["IsManager"]) 
			return USER_DEP_MANAGER;

		$response = $this->db->exec("SELECT IsManager FROM ProjectEmployee
									 WHERE UserId = :userId AND ProjectId = :projectId",
									 array("userId" => (int)$userId, "projectId" => (int)$projectId));
		if ($response && count($response) == 1) {
			return $response[0]["IsManager"] ? USER_PROJ_MANAGER : USER_EMPLOYEE ;
		} else 
			return USER_UNKNOWN;
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'byId':
					if (isset($search["id"])) {
						return $this->ById($search["id"]);
					} else return null;

				case 'forEmployee':
					if (isset($search["id"]) && isset($search["url"])) {
						return $this->ForEmployee($search["id"], $search["url"]);
					} else return null;

				case 'byDepartmentId':
					if (isset($search["id"])) {
						return $this->ByDepartmentId($search["id"]);
					} else return null;

				case 'byCompanyUrl':
					if (isset($search["url"])) {
						return $this->ByCompanyUrl($search["url"]);
					} else return null;

				case 'byCompanyUrlForUser':
					if (isset($search["url"]) && isset($search["userId"])) {
						return $this->ByCompanyUrlForUser($search["url"], $search["userId"]);
					} else return null;

				case 'getUserRights':
					if (isset($search["userId"]) && isset($search["projectId"])) {
						return $this->GetUserRights($search["userId"], $search["projectId"]);
					} else return null;
				
				default: return null;
			}
		} else return null;
	}


	public function add($data = array()) {
		$data["DateAdd"] = date("Y-m-d H:i:s");

		$this->db->begin();
		$this->insert($data);
		$id = $this->db->exec("SELECT LAST_INSERT_ID() as id");
		$this->db->commit();

		return $id ? $id[0]["id"] : null;
	}


	public function edit($data = array()) {
		return $this->update($data, array("ProjectId"));
	}


	public function remove($find = null) {
		return $this->delete($find, array("ProjectId"));
	}
}