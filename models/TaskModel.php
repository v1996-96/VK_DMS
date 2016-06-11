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
		$this->optional = array("Description", "Deadline", "DateClosed", "IsClosed", "Position");
	}


	private function ForEmployee($employeeId, $companyUrl) {
		return $this->db->exec("SELECT t.*, p.Title as ProjectTitle FROM Task as t
								LEFT JOIN Project as p ON p.ProjectId = t.ProjectId
								LEFT JOIN ProjectEmployee as pe ON pe.ProjectId = p.ProjectId
								LEFT JOIN Department as d ON d.DepartmentId = p.DepartmentId
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								WHERE pe.UserId = :id and c.Url = :url
								ORDER BY t.Deadline DESC",
								array("id" => (int)$employeeId, "url" => $companyUrl));
	}


	private function ForProjectOpen($projectId) {
		return $this->db->exec("SELECT * FROM Task 
								WHERE ProjectId = ? AND IsClosed = 0
								ORDER BY Position", (int)$projectId);
	} 


	private function ForProjectClosed($projectId) {
		return $this->db->exec("SELECT * FROM Task 
								WHERE ProjectId = ? AND IsClosed = 1
								ORDER BY Position", (int)$projectId);
	}


	private function ForCompanySummary($url) {
		$response = $this->db->exec("SELECT 
										c.CompanyId,
										COUNT(CASE t.IsClosed 
												WHEN 0 THEN 0 ELSE NULL END) as CountOpened,
										COUNT(CASE t.IsClosed 
												WHEN 1 THEN 1 ELSE NULL END) as CountClosed
									FROM Task as t
									LEFT JOIN Project as p ON p.ProjectId = t.ProjectId
									LEFT JOIN Department as d ON d.DepartmentId = p.DepartmentId
									LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
									WHERE c.Url = ?
									GROUP BY c.CompanyId", (int)$url);
		return $response ? $response[0] : array(
			"CompanyId" => null,
			"CountOpened" => 0,
			"CountClosed" => 0
			);
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

				case 'forCompanySummary':
					if (isset($search["url"])) {
						return $this->ForCompanySummary($search["url"]);
					} else return null;

				case 'forProjectOpen':
					if (isset($search["projectId"])) {
						return $this->ForProjectOpen($search["projectId"]);
					} else return null;

				case 'forProjectClosed':
					if (isset($search["projectId"])) {
						return $this->ForProjectClosed($search["projectId"]);
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
		$data["DateAdd"] = date("Y-m-d H:i:s");
		return $this->insert($data);
	}


	public function edit($data = array()) {
		return $this->update($data, array("TaskId"));
	}


	public function remove($find = null) {
		return $this->delete($find, array("TaskId"));
	}
}