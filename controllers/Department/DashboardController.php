<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

// For PDO errors
set_error_handler(function ($errno, $errstr, $errfile, $errline ) {
    if (!(error_reporting() & $errno)) {
        return;
    }
    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
});

class DashboardController extends \BaseController
{
	const PAGE_TYPE = "department_dashboard";

	private $CompanyUrl = null;
	private $DepartmentId = null;
	private $UserRights = USER_UNKNOWN;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new DashboardView($f3);

		$this->CheckAuthStatus();
	}


	private function GetUserRights() {
		// On the list level we use company-level rights
		$company = new \CompanyModel($this->f3);
		$department = new \DepartmentModel($this->f3);

		$companyData = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
		if (!$companyData) return;

		$userRights = $company->getData(array(
			"type" => "getUserRights", 
			"userId" => $this->GetUserInfo()["id"],
			"companyId" => $companyData["CompanyId"]));

		if ($userRights == USER_EMPLOYEE) {
			$userRights = $department->getData(array(
				"type" => "getUserRights",
				"userId" => $this->GetUserInfo()["id"],
				"departmentId" => (int)$this->DepartmentId
				));
		}

		$this->UserRights = $userRights;
		$this->view->UserRights = $userRights;
	}


	public function Gateway() {
		// Company url
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$this->CompanyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$this->view->CompanyUrl = $this->CompanyUrl;
		} else {
			$this->f3->set("department_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		if (isset($this->f3->get("PARAMS")["DepartmentId"])) {
			$this->DepartmentId = $this->f3->get("PARAMS")["DepartmentId"];
			$this->view->DepartmentId = $this->DepartmentId;
		} else {
			$this->f3->set("department_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		// Get user rights
		$this->GetUserRights();

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'addManagers':
					$this->AddEmployees(true);
					break;

				case 'addEmployees':
					$this->AddEmployees(false);
					break;

				case 'deleteEmployee':
					$this->DeleteEmployee();
					break;

				case 'createProject':
					$this->CreateProject();
					break;

				case 'edit':
					$this->Edit();
					break;

				case 'remove':
					$this->Remove();
					break;
			}
		}

		$this->view->ShowPage( self::PAGE_TYPE );
	}


	private function AddEmployees($isManager = false) {
		$departmentEmployee = new \DepartmentEmployeeModel($this->f3);
		$company = new \CompanyModel($this->f3);

		try {

			if ($isManager) {
				if (!in_array($this->UserRights, array(USER_OWNER, USER_ADMIN))) 
					throw new \Exception("Вы не имеете прав для добавления руководителей отдела");
			} else {
				if (!in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER))) 
					throw new \Exception("Вы не имеете прав для добавления сотрудников отдела");
			}

			if (!isset($_POST["employeeList"])) 
				throw new \Exception("Не был передан список сотрудников для добавления в отдел");

			$companyData = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
			if (!$companyData) return;
			
			if (count($_POST["employeeList"]) > 0) {
				foreach ($_POST["employeeList"] as $index => $UserId) {
					$departmentEmployee->add(array(
						"UserId" => (int)$UserId,
						"CompanyId" => (int)$companyData["CompanyId"],
						"DepartmentId" => (int)$this->DepartmentId,
						"IsManager" => (int)$isManager,
						"RoleDescription" => 
							isset($_POST["roleDescription"][$index]) ? 
								$_POST["roleDescription"][$index] : 
								null
						));
				}
			}
		} catch(\ErrorException $e) {
			$this->f3->set("department_error", "Произошла непредвиденная ошибка");
		} catch (\Exception $e) {
			$this->f3->set("department_error", $e->getMessage());
		}
	}


	private function DeleteEmployee() {
		$departmentEmployee = new \DepartmentEmployeeModel($this->f3);
		$projectEmployee = new \ProjectEmployeeModel($this->f3);
		$company = new \CompanyModel($this->f3);

		// TODO: Restrict deletion when there are open tasks or give supporting information

		try {

			if (!isset($_POST["EmployeeId"])) 
				throw new \Exception("Не был передан id сотрудника");

			$companyData = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
			if (!$companyData) return;

			$current = $departmentEmployee->getData(array(
				"type" => "byId", 
				"userId" => (int)$_POST["EmployeeId"],
				"companyId" => (int)$companyData["CompanyId"]
				));
			if (!$current)
				throw new \Exception("Указанный сотрудник не привязан к выбранной компании");

			if ($current[0]["IsManager"]) {
				if (!in_array($this->UserRights, array(USER_OWNER, USER_ADMIN))) 
					throw new \Exception("Вы не имеете прав для удаления руководителя отдела");
					
			} else {
				if (!in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER))) 
					throw new \Exception("Вы не иммеете прав для удаления сотрудника");
			}
				

			$emplyeesProject = $projectEmployee->getData(array(
				"type" => "getProjects", 
				"employeeId" => (int)$_POST["EmployeeId"],
				"departmentId" => (int)$this->DepartmentId
				));
			if ($emplyeesProject) {
				foreach ($emplyeesProject as $project) {
					if ($project["IsManager"]) {
						$managerList = $projectEmployee->getData(array(
							"type" => "getManagers", "id" => $project["ProjectId"]
							));

						if ($managerList && count($managerList) <= 1) 
							throw new \Exception("Вы не можете удалить сотрудника, 
								поскольку он является единственным менеджером на проекте: " . $project["Title"]);
					}
				}
			}

			// There are triggers deleting records from 
			// ProjectEmployee and TaskEmployee
			$departmentEmployee->remove(array(
				"UserId" => (int)$_POST["EmployeeId"],
				"CompanyId" => (int)$companyData["CompanyId"]
				));
			
		} catch (\Exception $e) {
			$this->f3->set("department_error", $e->getMessage());
		}
	}


	private function CreateProject() {
		$project = new \ProjectModel($this->f3);
		$projectEmployee = new \ProjectEmployeeModel($this->f3);

		try {
			if (!in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER))) 
				throw new \Exception("Вы не имеете прав для добавления проекта");

			if (!isset($_POST["Title"])) 
				throw new \Exception("Не указано название проекта");

			if (!(isset($_POST["managerList"]) && count($_POST["managerList"]) > 0)) 
				throw new \Exception("Не выбран менеджер проекта");

			$insertId = $project->add(array(
				"DepartmentId" => $this->DepartmentId,
				"Title" => $_POST["Title"],
				"Description" => isset($_POST["Description"]) ? $_POST["Description"] : null
				));

			if (!$insertId)
				throw new \Exception("Произошла непредвиденная ошибка");

			if (isset($_POST["managerList"]) && 
				count($_POST["managerList"]) > 0) {
				foreach ($_POST["managerList"] as $managerId) {
					$projectEmployee->add(array(
						"UserId" => (int)$managerId,
						"ProjectId" => (int)$insertId,
						"IsManager" => 1
						));
				}
			}

			if (isset($_POST["employeeList"]) && 
				count($_POST["employeeList"]) > 0) {
				foreach ($_POST["employeeList"] as $managerId) {
					$projectEmployee->add(array(
						"UserId" => (int)$managerId,
						"ProjectId" => (int)$insertId,
						"IsManager" => 0
						));
				}
			}
				
		} catch (\Exception $e) {
			$this->f3->set("department_error", $e->getMessage());
		}
	}


	private function Edit() {
		$department = new \DepartmentModel($this->f3);
		$company = new \CompanyModel($this->f3);

		try {
			if (!in_array($this->UserRights, array(USER_OWNER, USER_ADMIN))) 
				throw new \Exception("Вы не имеете прав для изменения данных компании");

			$department->edit(array_merge($_POST, array("DepartmentId" => $this->DepartmentId)));
		} catch (\Exception $e) {
			$this->f3->set("department_error", $e->getMessage());
		}
	}


	private function Remove() {
		$department = new \DepartmentModel($this->f3);

		try {
			if (!in_array($this->UserRights, array(USER_OWNER, USER_ADMIN))) 
				throw new \Exception("Вы не имеете прав для удаления отдела");

			$success = $department->remove(array("DepartmentId" => $this->DepartmentId));
			if ($success)
				$this->f3->reroute("/" . $this->CompanyUrl . "/departments");
		} catch (\Exception $e) {
			$this->f3->set("department_error", $e->getMessage());
		}
	}
}