<?php

defined('_EXECUTED') or die('Restricted access');

class TaskPackageModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "TaskPackage";
		$this->required = array("PackageId", "TaskId", "DateAdd");
		$this->optional = array();
	}


	private function ById($id) {
		$response = $this->db->exec("SELECT * FROM TaskPackage WHERE PackageId = ?", (int)$id);
		return $response ? $response[0] : null;
	}


	private function ByTask($taskId) {
		return $this->db->exec("SELECT * FROM Package as p
								LEFT JOIN TaskPackage as tp ON p.PackageId = tp.PackageId
								WHERE tp.TaskId = ?", (int)$taskId);
	}


	private function GetAvailable($taskId) {
		return $this->db->exec("SELECT 
									pack.*,
									CASE
										WHEN pack.PackageId IN (SELECT PackageId FROM TaskPackage
																WHERE TaskId = t.TaskId) THEN 1
										ELSE 0
									END as IsLinked
								FROM Package as pack
								LEFT JOIN DepartmentPackage as dp ON dp.PackageId = pack.PackageId
								LEFT JOIN Project as p ON p.DepartmentId = dp.DepartmentId
								LEFT JOIN Task as t ON t.ProjectId = p.ProjectId
								WHERE t.TaskId = ? AND pack.PackageId NOT IN 
									(SELECT PackageId FROM TaskPackage
									 WHERE TaskId <> t.TaskId) AND
									 (dp.PackageType = ".(int)PACKAGE_MANAGING." 
									  OR dp.PackageType = ".(int)PACKAGE_INCOMING.")", (int)$taskId);
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'byId':
					if (isset($search["id"])) {
						return $this->ById($search["id"]);
					} else return null;

				case 'byTask':
					if (isset($search["taskId"])) {
						return $this->ByTask($search["taskId"]);
					} else return null;

				case 'getAvailable':
					if (isset($search["taskId"])) {
						return $this->GetAvailable($search["taskId"]);
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
		return $this->update($data, array("PackageId"));
	}


	public function remove($find = null) {
		return $this->delete($find, array("PackageId"));
	}
}