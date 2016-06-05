<?php

namespace Projects;

defined('_EXECUTED') or die('Restricted access');

class DashboardView extends \BaseView
{

	public $CompanyUrl = null;
	public $ProjectId = null;
	public $UserRights = USER_UNKNOWN;

	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Проекты", $page);
		$this->SetVars();

		if (in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER, USER_PROJ_MANAGER, USER_EMPLOYEE))) {
			echo (new \Template)->render('projectDashboardManagement.php');
		} else {
			echo (new \Template)->render('projectDashboardView.php');
		}
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$project = new \ProjectModel($this->f3);
		$projectEmployee = new \ProjectEmployeeModel($this->f3);
		$departmentEmployee = new \DepartmentEmployeeModel($this->f3);
		$task = new \TaskModel($this->f3);

		$projectInfo = $project->getData(array(
			"type" => "byId",
			"id" => $this->ProjectId
			));
		$this->f3->set("ProjectInfo", $projectInfo);

		$managerList = $projectEmployee->getData(array(
			"type" => "getManagers",
			"id" => $this->ProjectId
			));
		$employeeList = $projectEmployee->getData(array(
			"type" => "getEmployee",
			"id" => $this->ProjectId
			));
		$this->f3->mset(array(
			"ManagerList" => $managerList,
			"EmployeeList" => $employeeList
			));


		$taskListOpen = $task->getData(array(
			"type" => "forProjectOpen",
			"projectId" => (int)$this->ProjectId
			));
		$taskListClosed = $task->getData(array(
			"type" => "forProjectClosed",
			"projectId" => (int)$this->ProjectId
			));
		$this->f3->mset(array(
			"TaskListOpen" => $taskListOpen,
			"TaskListClosed" => $taskListClosed
			));


		if ($projectInfo) {
			$departmentEmployeeList = $departmentEmployee->getData(array(
				"type" => "freeEmployeeForProject",
				"departmentId" => $projectInfo["DepartmentId"],
				"projectId" => $this->ProjectId
				));
			$this->f3->set("DepartmentEmployeeList", $departmentEmployeeList);
		}


		$this->f3->mset(array(
			"ProjectRight_Delete" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER)),
			"ProjectRight_Edit" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER, USER_PROJ_MANAGER)),
			"ProjectRight_ManageEmployees" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER)),
			"ProjectRight_AddTask" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER, USER_PROJ_MANAGER)),
			"ProjectRight_CompleteTask" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER, USER_PROJ_MANAGER, USER_EMPLOYEE)),
			"ProjectRight_EditTask" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER, USER_PROJ_MANAGER)),
			"ProjectRight_DeleteTask" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER, USER_PROJ_MANAGER)),
			));
	}
}