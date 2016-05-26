<?php

defined('_EXECUTED') or die('Restricted access');

class DepartmentModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "Department";
		$this->required = array("CompanyId", "Title", "DateAdd");
		$this->optional = array();
	}


	private function ById($id) {
		$response = $this->db->exec("SELECT * FROM Department WHERE DepartmentId = ?", $id);
		return $response ? $response[0] : null;
	}


	private function ByCompanyUrl($url) {
		return $this->db->exec("SELECT 
									d.*,
									COUNT(de.UserId) as EmployeeCount,
									COUNT(p.ProjectId) as ProjectCount,
									COUNT(t.TaskId) as TaskCount
								FROM Department as d
								LEFT JOIN Company as c ON d.CompanyId = c.CompanyId
								LEFT JOIN DepartmentEmployee as de ON de.DepartmentId = d.DepartmentID
								LEFT JOIN Project as p ON p.DepartmentId = d.DepartmentId
								LEFT JOIN Task as t ON t.ProjectId = p.ProjectId
								WHERE c.Url = ?
								GROUP BY d.DepartmentId
								ORDER BY d.DateAdd", $url);
	}


	private function Summary($id, $url) {
		return $this->db->exec("SELECT 
									d.*,
									COUNT(p.ProjectId) as ProjectCount,
									COUNT(t.TaskId) as TaskCount,
									COUNT(dp.PackageType = 1) as IncomingPackageCount,
									COUNT(dp.PackageType = 2) as OutcomingPackageCount
								FROM Department as d
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								LEFT JOIN Project as p ON p.DepartmentId = d.DepartmentId
								LEFT JOIN Task as t ON t.TaskId = p.ProjectId
								LEFT JOIN DepartmentPackage as dp ON dp.DepartmentId = d.DepartmentId
								WHERE d.DepartmentId = :id AND c.Url = :url
								GROUP BY d.DepartmentId",
								array("id" => (int)$id, "url" => $url));
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'byId':
					if (isset($search["id"])) {
						return $this->ById($search["id"]);
					} else return null;

				case 'byCompanyUrl':
					if (isset($search["url"])) {
						return $this->ByCompanyUrl($search["url"]);
					} else return null;

				case 'summary':
					if (isset($search["id"]) && isset($search["url"])) {
						return $this->Summary($search["id"], $search["url"]);
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
		return $this->update($data, array("DepartmentId"));
	}


	public function remove($find = null) {
		return $this->delete($find, array("DepartmentId"));
	}

}