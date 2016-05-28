<?php

defined('_EXECUTED') or die('Restricted access');

class TaskModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "Task";
		$this->required = array("ProjectId", "Title", "DateAdd");
		$this->optional = array("Description", "Deadline", "DateClosed", "IsClosed");
	}


	private function ForEmployee($employeeId, $companyUrl) {
		return $this->db->exec("SELECT t.*, p.Title as ProjectTitle FROM Task as t
								LEFT JOIN TaskEmployee as te ON t.TaskId = te.TaskId
								LEFT JOIN Project as p ON p.ProjectId = t.ProjectId
								LEFT JOIN Department as d ON d.DepartmentId = p.DepartmentId
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								WHERE te.UserId = :id and c.Url = :url
								ORDER BY t.Deadline DESC",
								array("id" => (int)$employeeId, "url" => $companyUrl));
	}


	private function ById($id) {
		$response = $this->db->exec("SELECT * FROM Task WHERE TaskId = ?", (int)$id);
		return $response ? $response[0] : null;
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
				
				default: return null;
			}
		} else return null;
	}


	public function add($data = array()) {
		return null;
	}


	public function edit($data = array()) {
		return null;
	}


	public function remove($find = null) {
		return null;
	}
}