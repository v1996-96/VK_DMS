<?php

defined('_EXECUTED') or die('Restricted access');

class ProjectEmployeeModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "ProjectEmployee";
		$this->required = array("UserId", "ProjectId", "IsManager");
		$this->optional = array();
	}


	private function GetProjects($employeeId, $departmentId) {
		return $this->db->exec("SELECT p.*, pe.IsManager FROM Project as p
								LEFT JOIN ProjectEmployee as pe ON pe.ProjectId = p.ProjectId
								WHERE pe.UserId = :id AND p.DepartmentId = :departmentId",
								array("id" => $employeeId, "departmentId" => $departmentId));
	}


	private function GetEmployee($projectId, $isManager = false) {
		return $this->db->exec("SELECT pe.*, u.Name, u.Surname, u.VK_Avatar FROM ProjectEmployee as pe
								LEFT JOIN User as u ON pe.UserId = u.id
								WHERE pe.ProjectId = :id AND pe.IsManager = :isManager", 
								array("id" =>(int)$projectId, "isManager" => $isManager));
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'getManagers':
					if (isset($search["id"])) {
						return $this->GetEmployee($search["id"], true);
					} else return null;

				case 'getEmployee':
					if (isset($search["id"])) {
						return $this->GetEmployee($search["id"], false);
					} else return null;

				case 'getProjects':
					if (isset($search["employeeId"]) && isset($search["departmentId"])) {
						return $this->GetProjects($search["employeeId"], $search["departmentId"]);
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
		return $this->delete($find, array("UserId", "ProjectId"));
	}
}