<?php

namespace Employee;

defined('_EXECUTED') or die('Restricted access');

class ProfileView extends \BaseView
{

	public $EmployeeId = null;
	public $CompanyUrl = null;
	public $UserRights = USER_UNKNOWN;

	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Сотрудники", $page);
		$this->SetVars();

		echo (new \Template)->render('employeeProfile.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$employee = new \UserModel($this->f3);
		$project = new \ProjectModel($this->f3);
		$task = new \TaskModel($this->f3);

		$employeeData = $employee->getData(array(
			"type" => "summary", 
			"id" => $this->EmployeeId,
			"url" => $this->CompanyUrl
			));
		$this->f3->set("EmployeeData", $employeeData ? $employeeData[0] : null);

		$projectList = $project->getData(array(
			"type" => "forEmployee", 
			"id" => $this->EmployeeId, 
			"url" => $this->CompanyUrl));
		$taskList = $task->getData(array(
			"type" => "forEmployee", 
			"id" => $this->EmployeeId, 
			"url" => $this->CompanyUrl));

		$this->f3->mset(array(
			"ProjectList" => $projectList,
			"TaskList" => $taskList
			));

		$this->f3->mset(array(
			"EmployeeRights_Edit" => 
				$employeeData && 
				(($employeeData[0]["EmployeeType"] !== "Генеральный директор" &&
				$this->UserRights == USER_OWNER) ||
				($employeeData[0]["EmployeeType"] !== "Генеральный директор" &&
				$employeeData[0]["EmployeeType"] !== "Администратор" &&
				$this->UserRights == USER_ADMIN)),
			"EmployeeRights_SetAdmin" => $this->UserRights == USER_OWNER	
			));
	}
}