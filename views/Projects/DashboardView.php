<?php

namespace Projects;

defined('_EXECUTED') or die('Restricted access');

class DashboardView extends \BaseView
{

	public $CompanyUrl = null;
	public $ProjectId = null;

	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Проекты", $page);
		$this->SetVars();

		echo (new \Template)->render('projectDashboard.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$project = new \ProjectModel($this->f3);
		$projectEmployee = new \ProjectEmployeeModel($this->f3);
		$departmentEmployee = new \DepartmentEmployeeModel($this->f3);

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

		if ($projectInfo) {
			$departmentEmployeeList = $departmentEmployee->getData(array(
				"type" => "freeEmployeeForProject",
				"departmentId" => $projectInfo["DepartmentId"],
				"projectId" => $this->ProjectId
				));
			$this->f3->set("DepartmentEmployeeList", $departmentEmployeeList);
		}
	}
}