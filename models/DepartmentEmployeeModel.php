<?php

defined('_EXECUTED') or die('Restricted access');

class DepartmentEmployeeModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "DepartmentEmployee";
		$this->required = array("UserId", "CompanyId", "DepartmentId", "DateAdd", "IsManager");
		$this->optional = array("RoleDescription");
	}


	private function ManagerList($departmentId) {
		return $this->db->exec("SELECT de.*, u.Name, u.Surname, u.VK FROM DepartmentEmployee as de
								LEFT JOIN User as u ON u.id = de.UserId
								WHERE IsManager = 1 AND DepartmentId = ?", (int)$departmentId);
	}


	private function EmployeeList($departmentId) {
		return $this->db->exec("SELECT de.*, u.Name, u.Surname, u.VK FROM DepartmentEmployee as de
								LEFT JOIN User as u ON u.id = de.UserId
								WHERE IsManager = 0 AND DepartmentId = ?", (int)$departmentId);
	}


	private function EmployeeFullList($departmentId) {
		return $this->db->exec("SELECT de.*, u.Name, u.Surname, u.VK FROM DepartmentEmployee as de
								LEFT JOIN User as u ON u.id = de.UserId
								WHERE DepartmentId = ?", (int)$departmentId);
	}


	private function FreeEmployeeForProject($departmentId, $projectId) {
		return $this->db->exec("SELECT * FROM DepartmentEmployee as de
								LEFT JOIN User as u ON u.id = de.UserId
								WHERE de.DepartmentId = :departmentId AND 
									de.UserId NOT IN (SELECT pe.UserId FROM ProjectEmployee as pe
													  WHERE pe.ProjectId = :projectId)",
								array("departmentId" => $departmentId, "projectId" => $projectId));
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'managerList':
					if (isset($search["id"])) {
						return $this->ManagerList($search["id"]);
					} else return null;

				case 'employeeList':
					if (isset($search["id"])) {
						return $this->EmployeeList($search["id"]);
					} else return null;

				case 'employeeFullList':
					if (isset($search["id"])) {
						return $this->EmployeeFullList($search["id"]);
					} else return null;

				case 'freeEmployeeForProject':
					if (isset($search["departmentId"]) && isset($search["projectId"])) {
						return $this->FreeEmployeeForProject($search["departmentId"], $search["projectId"]);
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
		return null;
	}


	public function remove($find = null) {
		return $this->delete($find, array("UserId", "CompanyId"));
	}
}