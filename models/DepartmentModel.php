<?php

defined('_EXECUTED') or die('Restricted access');

class DepartmentModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "Department";
		$this->required = array("CompanyId", "Title", "DateAdd", "VKGroupId");
		$this->optional = array();
	}


	private function ById($id) {
		$response = $this->db->exec("SELECT * FROM Department WHERE DepartmentId = ?", $id);
		return $response ? $response[0] : null;
	}


	private function ByCompanyUrl($url) {
		return $this->db->exec("SELECT 
									d.*,
									COUNT(DISTINCT de.UserId) as EmployeeCount,
									COUNT(DISTINCT p.ProjectId) as ProjectCount,
									COUNT(DISTINCT t.TaskId) as TaskCount
								FROM Department as d
								LEFT JOIN Company as c ON d.CompanyId = c.CompanyId
								LEFT JOIN DepartmentEmployee as de ON de.DepartmentId = d.DepartmentID
								LEFT JOIN Project as p ON p.DepartmentId = d.DepartmentId
								LEFT JOIN Task as t ON t.ProjectId = p.ProjectId
								WHERE c.Url = ?
								GROUP BY d.DepartmentId
								ORDER BY d.DateAdd", $url);
	}


	private function ByCompanyUrlExcept($url, $id) {
		return $this->db->exec("SELECT d.* FROM Department as d
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								WHERE c.Url = :url AND d.DepartmentId <> :id
								GROUP BY d.DepartmentId",
								array("url" => $url, "id" => $id));
	}


	private function Summary($id, $url) {
		return $this->db->exec("SELECT 
									d.*,
									COUNT(p.ProjectId) as ProjectCount,
									COUNT(t.TaskId) as TaskCount,
									COUNT(CASE dp.PackageType
											WHEN 1 THEN 1
											ELSE NULL END) as IncomingPackageCount,
									COUNT(CASE dp.PackageType
											WHEN 2 THEN 1
											ELSE NULL END) as OutcomingPackageCount
								FROM Department as d
								LEFT JOIN Company as c ON c.CompanyId = d.CompanyId
								LEFT JOIN Project as p ON p.DepartmentId = d.DepartmentId
								LEFT JOIN Task as t ON t.TaskId = p.ProjectId
								LEFT JOIN DepartmentPackage as dp ON dp.DepartmentId = d.DepartmentId
								WHERE d.DepartmentId = :id AND c.Url = :url
								GROUP BY d.DepartmentId",
								array("id" => (int)$id, "url" => $url));
	}


	private function Activity($id) {
		$intervals = array();
		$startDate = strtotime("-1 month");
		$endDate = time();

		while ($startDate < $endDate) {
			$intervals[] = array(
				"from" => $startDate,
				"to" => strtotime("+1 day", $startDate)
				);
			$startDate = strtotime("+1 day", $startDate);
		}

		$activity = array();

		foreach ($intervals as $period) {
			$response = $this->db->exec("SELECT 
											d.DepartmentId,
											COUNT(CASE t.IsClosed
													WHEN 1 THEN 1 ELSE NULL END) as ClosedCount
										FROM Department as d
										LEFT JOIN Project as p ON d.DepartmentId = p.DepartmentId
										LEFT JOIN Task as t ON p.ProjectId = t.ProjectId
										WHERE 
											d.DepartmentId = :id AND
											t.DateClosed BETWEEN :startDate AND :endDate
										GROUP BY d.DepartmentId",
										array(
											"id" => (int)$id, 
											"startDate" => date("Y-m-d H:i:s", $period["from"]),
											"endDate" => date("Y-m-d H:i:s", $period["to"])
											));
			$activity[] = $response ? $response[0]["ClosedCount"] : 0;
		}

		return $activity;
	}


	private function GetUserRights($userId, $departmentId) {
		$response = $this->db->exec("SELECT IsManager FROM DepartmentEmployee
									 WHERE UserId = :userId AND DepartmentId = :departmentId",
									 array("userId" => (int)$userId, "departmentId" => (int)$departmentId));
		if ($response && count($response) == 1) {
			return $response[0]["IsManager"] ? USER_DEP_MANAGER : USER_EMPLOYEE ;
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

				case 'byCompanyUrl':
					if (isset($search["url"])) {
						return $this->ByCompanyUrl($search["url"]);
					} else return null;

				case 'byCompanyUrlExcept':
					if (isset($search["url"]) && isset($search["id"])) {
						return $this->ByCompanyUrlExcept($search["url"], $search["id"]);
					} else return null;

				case 'summary':
					if (isset($search["id"]) && isset($search["url"])) {
						return $this->Summary($search["id"], $search["url"]);
					} else return null;

				case 'activity':
					if (isset($search["id"])) {
						return $this->Activity($search["id"]);
					} else return null;

				case 'getUserRights':
					if (isset($search["userId"]) && isset($search["departmentId"])) {
						return $this->GetUserRights($search["userId"], $search["departmentId"]);
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