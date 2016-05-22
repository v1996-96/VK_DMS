<?php

defined('_EXECUTED') or die('Restricted access');

class CompanyModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "Company";
		$this->required = array("CreatorId", "Title", "Url", "Slogan", "DateAdd");
		$this->optional = array("Logo");
	}


	private function ByUrl($url) {
		$resp = $this->db->exec("SELECT * FROM Company WHERE Url = ?", $url);
		return $resp ? $resp[0] : null;
	}


	private function ByUserId($id) {
		$query =   "SELECT * FROM ((SELECT 
						C.CompanyId, C.Title, C.Logo, C.Slogan, C.Url, C.DateAdd, 
						'Директор' as CompanyRole
					FROM User as U
					LEFT JOIN Company as C ON U.id = C.CreatorId
					WHERE U.id = :UserId) ";
		$query.=  " UNION ";
		$query.=  "(SELECT 
						C.CompanyId, C.Title, C.Logo, C.Slogan, C.Url, C.DateAdd,
						CASE CE.IsAdmin
							WHEN 1 THEN 'Администратор'
							WHEN 0 THEN 'Сотрудник'
						END as CompanyRole
					FROM User as U
					LEFT JOIN CompanyEmployee as CE ON U.id = CE.UserId
					LEFT JOIN Company as C ON CE.CompanyId = C.CompanyId
					WHERE U.id = :UserId)) AS t WHERE NOT t.CompanyId IS NULL";

		return $this->db->exec( $query, array("UserId" => (int)$id) );
	}


	private function IsUrlUnique($url) {
		$response = $this->db->exec("SELECT CompanyId FROM ".$this->entity." WHERE Url = ?", $url);
		return !(bool)$response;
	}


	private function CompanySummary($companyId) {
		// Set defaults
		$summary = array(
			"DepartmentsCount" => 0,
			"ProjectsCount" => 0,
			"Activity" => "0",
			"EmployeeCount" => 0
			);


		// Get data
		$departments = $this->db->exec("SELECT C.CompanyId, count(D.DepartmentId) as DepartmentsCount
										FROM Company as C
										LEFT JOIN Department as D ON D.CompanyId = C.CompanyId
										GROUP BY C.CompanyId
										HAVING C.CompanyId = :id",
										array("id" => $companyId));

		$projects = $this->db->exec("SELECT C.CompanyId, count(P.ProjectId) as ProjectsCount
									 FROM Company as C
									 LEFT JOIN Department as D ON D.CompanyId = C.CompanyId
									 LEFT JOIN Project as P ON P.DepartmentId = D.DepartmentId
									 GROUP BY C.CompanyId
									 HAVING C.CompanyId = :id",
									 array("id" => $companyId));

		$employee = $this->db->exec("SELECT C.CompanyId, count(CE.UserId) as EmployeeCount
									 FROM Company as C
									 LEFT JOIN CompanyEmployee as CE ON C.CompanyId = CE.CompanyId
									 GROUP BY C.CompanyId
									 HAVING C.CompanyId = :id",
									 array("id" => $companyId));

		$activityPrevMonth = $this->db->exec("SELECT C.CompanyId, count(T.TaskId) as CountCompleted
											  FROM Company as C
											  LEFT JOIN Department as D ON C.CompanyId = D.CompanyId
											  LEFT JOIN Project as P ON D.DepartmentId = P.DepartmentId
											  LEFT JOIN Task as T ON P.ProjectId = T.ProjectId
											  WHERE T.IsClosed = 1 AND
											  		T.DateClosed BETWEEN DATE_SUB(:today, INTERVAL 2 MONTH) AND DATE_SUB(:today, INTERVAL 1 MONTH)
											  GROUP BY C.CompanyId
											  HAVING C.CompanyId = :id",
									 		  array("id" => $companyId, "today" => date("Y-m-d H:i:s")));

		$activityCurrMonth = $this->db->exec("SELECT C.CompanyId, count(T.TaskId) as CountCompleted
											  FROM Company as C
											  LEFT JOIN Department as D ON C.CompanyId = D.CompanyId
											  LEFT JOIN Project as P ON D.DepartmentId = P.DepartmentId
											  LEFT JOIN Task as T ON P.ProjectId = T.ProjectId
											  WHERE T.IsClosed = 1 AND
											  		T.DateClosed BETWEEN DATE_SUB(:today, INTERVAL 1 MONTH) AND :today
											  GROUP BY C.CompanyId
											  HAVING C.CompanyId = :id",
									 		  array("id" => $companyId, "today" => date("Y-m-d H:i:s")));


		// Set data
		if ($departments) 
			$summary["DepartmentsCount"] = $departments[0]["DepartmentsCount"];

		if ($projects) 
			$summary["ProjectsCount"] = $projects[0]["ProjectsCount"];

		if ($employee) 
			$summary["EmployeeCount"] = $employee[0]["EmployeeCount"];

		$prevMonthCompleted = $activityPrevMonth ? $activityPrevMonth[0]["CountCompleted"] : 0;
		$currMonthCompleted = $activityCurrMonth ? $activityCurrMonth[0]["CountCompleted"] : 0;
		$activityIndex = "0";

		if ($prevMonthCompleted == 0){
			$activityIndex = $currMonthCompleted == 0 ? "0" : "+".$currMonthCompleted;
		} else {
			$activityIndex = $currMonthCompleted == 0 ? 
								"-".$prevMonthCompleted : 
								"+" . (($currMonthCompleted - $prevMonthCompleted)/$prevMonthCompleted) . "%"  ;
		}

		$summary["Activity"] = $activityIndex;

		return $summary;
	}


	private function GetUserRights($userId, $companyId) {
		$isCreator = $this->db->exec("SELECT CompanyId FROM Company 
									  WHERE CompanyId = :CompanyId AND CreatorId = :CreatorId",
									  array("CompanyId" => $companyId, "CreatorId" => $userId));
		if ($isCreator) 
			return USER_OWNER;

		$isAdmin = $this->db->exec("SELECT CompanyId FROM CompanyEmployee
									WHERE CompanyId = :CompanyId AND UserId = :UserId AND IsAdmin = 1",
									array("CompanyId" => $companyId, "UserId" => $userId));
		if ($isCreator) 
			return USER_ADMIN;

		$isEmployee = $this->db->exec("SELECT CompanyId FROM CompanyEmployee
									   WHERE CompanyId = :CompanyId AND UserId = :UserId AND IsAdmin = 0",
									   array("CompanyId" => $companyId, "UserId" => $userId));
		if ($isEmployee) 
			return USER_EMPLOYEE;

		return USER_UNKNOWN;
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'isUrlUnique':
					if (isset($search["url"])) {
						return $this->IsUrlUnique($search["url"]);
					} else return null;

				case 'getUserRights':
					if (isset($search["userId"]) && isset($search["companyId"])) {
						return $this->GetUserRights($search["userId"], $search["companyId"]);
					} else return null;

				case 'byUserId':
					if (isset($search["id"])) {
						return $this->ByUserId($search["id"]);
					} else return null;

				case 'byUrl':
					if (isset($search["url"])) {
						return $this->ByUrl($search["url"]);
					} else return null;

				case 'summary':
					if (isset($search["id"])) {
						return $this->CompanySummary($search["id"]);
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
		return null;
	}
}