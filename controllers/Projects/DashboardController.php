<?php

namespace Projects;

defined('_EXECUTED') or die('Restricted access');

class DashboardController extends \BaseController
{

	const PAGE_TYPE = "project_dashboard";

	private $CompanyUrl = null;
	private $ProjectId = null;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new DashboardView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		// Company url
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$this->CompanyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$this->view->CompanyUrl = $this->CompanyUrl;
		} else {
			$this->f3->set("project_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		if (isset($this->f3->get("PARAMS")["ProjectId"])) {
			$this->ProjectId = $this->f3->get("PARAMS")["ProjectId"];
			$this->view->ProjectId = $this->ProjectId;
		} else {
			$this->f3->set("project_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}


		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'editProject':
					$this->EditProject();
					break;

				case 'deleteProject':
					$this->DeleteProject();
					break;

				case 'addManagers':
					$this->AddEmployees(true);
					break;

				case 'addEmployees':
					$this->AddEmployees(false);
					break;

				case 'deleteManager':
					$this->DeleteEmployee(true);
					break;

				case 'deleteEmployee':
					$this->DeleteEmployee(false);
					break;
			}
		}

		$this->view->ShowPage( self::PAGE_TYPE );
	}


	private function DeleteEmployee($isManager) {
		$projectEmployee = new \ProjectEmployeeModel($this->f3);

		try {
			if (!isset($_POST["UserId"])) 
				throw new \Exception("Не указан id сотрудника");
				
			if ($isManager) {
				$managers = $projectEmployee->getData(array(
					"type" => "getManagers",
					"id" => (int)$this->ProjectId
					));
				if ($managers && count($managers) <= 1) {
					throw new \Exception("У проекта должен быть как минимум один менеджер");
				}
			}

			$projectEmployee->remove(array(
				"UserId" => (int)$_POST["UserId"],
				"ProjectId" => (int)$this->ProjectId
				));
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}


	private function AddEmployees($isManager) {
		$projectEmployee = new \ProjectEmployeeModel($this->f3);

		try {
			if (isset($_POST["employeeList"]) &&
				count($_POST["employeeList"]) > 0) {
				foreach ($_POST["employeeList"] as $employee) {
					$projectEmployee->add(array(
						"UserId" => (int)$employee,
						"ProjectId" => (int)$this->ProjectId,
						"IsManager" => (int)$isManager
						));
				}
			}
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}


	private function EditProject() {
		$project = new \ProjectModel($this->f3);

		try {
			$project->edit(array_merge($_POST, array("ProjectId" => $this->ProjectId)));
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}


	private function DeleteProject() {
		$project = new \ProjectModel($this->f3);

		try {
			$success = $project->remove(array("ProjectId" => $this->ProjectId));
			if ($success) 
				$this->f3->reroute("/" . $this->CompanyUrl . "/projects/");
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}
}