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
									COUNT(t.TaskId) as TaskCount, 
									COUNT(pe.UserId) as EmployeeCount
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
									COUNT(t.TaskId) as TaskCount,
									COUNT(pe.UserId) as EmployeeCount
								FROM Project as p
								LEFT JOIN Task as t ON t.ProjectId = p.ProjectId
								LEFT JOIN ProjectEmployee as pe ON pe.ProjectId = p.ProjectId
								LEFT JOIN Department as d ON p.DepartmentId = d.DepartmentId
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								WHERE c.Url = ?
								GROUP BY p.ProjectId
								ORDER BY p.Status DESC, p.DateAdd DESC", $url);
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
		return null;
	}


	public function remove($find = null) {
		return null;
	}
}