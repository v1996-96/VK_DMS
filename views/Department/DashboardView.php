<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class DashboardView extends \BaseView
{

	public $CompanyUrl = null;
	public $DepartmentId = null;
	public $UserRights = USER_UNKNOWN;

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
		$document = new \DocumentModel($this->f3);


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


		// Deleted documents
		$deleted = $document->getData(array(
			"type" => "byDepartmentDeleted",
			"id" => $this->DepartmentId
			));
		$this->f3->set("DeletedDoucumentsCount", count($deleted));


		try {
			$userInfo = $this->GetUserInfo();
			if (!$userInfo["VK_Authorized"]) 
				throw new \Exception("Для редактирования группы отдела необходимо авторизиваться во Вконтакте");
				
			$vk = new \VkPhpSdk();
			$vk->setAccessToken( $userInfo["VK_AccessToken"] );
			$vk->setUserId( $userInfo["VK"] );

			$result = $vk->api("groups.get", array(
				"user_id" => $userInfo["VK"],
				"extended" => 1,
				"filter" => "moder"
				));

			if (isset($result["response"]) && is_array($result["response"])) {
				foreach ($result["response"] as $key => $value) {
					if (!isset($value["gid"])) {
						unset($result["response"][$key]);
					}
				}

				$this->f3->set("GroupList", $result["response"]);
			}
		} catch (\Exception $e) {
			$this->f3->set("department_add_error", $e->getMessage());
		}


		$this->f3->mset(array(
			"DepartmentRight_Delete" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN)),
			"DepartmentRight_Edit" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN)),
			"DepartmentRight_AddManager" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN)),
			"DepartmentRight_AddEmployee" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER)),
			"DepartmentRight_DeleteManager" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN)),
			"DepartmentRight_DeleteEmployee" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER)),
			"DepartmentRight_AddProject" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER))
			));
	}
}