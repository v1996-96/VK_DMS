<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class ListView extends \BaseView
{

	public $CompanyUrl = null;
	public $UserRights = USER_UNKNOWN;

	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Отделы", $page);
		$this->SetVars();

		echo (new \Template)->render('departmentList.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$department = new \DepartmentModel($this->f3);

		$departmentList = $department->getData(array("type" => "byCompanyUrl", "url" => $this->CompanyUrl));
		$this->f3->set("DepartmentList", $departmentList);

		try {
			$userInfo = $this->GetUserInfo();
			if (!$userInfo["VK_Authorized"]) 
				throw new \Exception("Для создания отдела необходимо авторизиваться во Вконтакте");
				
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
			"DepartmentRight_Add" => in_array($this->UserRights, array(USER_OWNER, USER_ADMIN))
			));
	}
}