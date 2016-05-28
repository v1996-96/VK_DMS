<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class DashboardView extends \BaseView
{

	public $CompanyUrl = null;
	public $DepartmentId = null;

	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Отделы", $page);
		$this->SetVars();

		echo (new \Template)->render('departmentDashboard.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		// Models
		$company = new \CompanyModel($this->f3);
		$department = new \DepartmentModel($this->f3);
		$project = new \ProjectModel($this->f3);
		$departmentEmployee = new \DepartmentEmployeeModel($this->f3);


		// Summary
		$summary = $department->getData(array(
			"type" => "summary", 
			"id" => $this->DepartmentId, 
			"url" => $this->CompanyUrl
			));
		$this->f3->set("DepartmentSummary", $summary ? $summary[0] : null);


		// Activity
		$activity = $department->getData(array(
			"type" => "activity", 
			"id" => $this->DepartmentId
			));
		$this->f3->set("DepartmentActivity", $activity);


		// Projects
		$projectList = $project->getData(array(
			"type" => "byDepartmentId", 
			"id" => $this->DepartmentId
			));
		$this->f3->set("ProjectList", $projectList);


		// Employees
		$freeEmployeeList = $company->getData(array(
			"type" => "freeEmployee",
			"url" => $this->CompanyUrl
			));
		$managerList = $departmentEmployee->getData(array(
			"type" => "managerList", 
			"id" => $this->DepartmentId
			));
		$employeeList = $departmentEmployee->getData(array(
			"type" => "employeeList", 
			"id" => $this->DepartmentId
			));
		$employeeFullList = $departmentEmployee->getData(array(
			"type" => "employeeFullList", 
			"id" => $this->DepartmentId
			));
		$this->f3->mset(array(
			"ManagerList" => $managerList,
			"EmployeeList" => $employeeList,
			"EmployeeFullList" => $employeeFullList,
			"FreeCompanyEmployeeList" => $freeEmployeeList
			));

	}
}