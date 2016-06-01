<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class ListController extends \BaseController
{

	const PAGE_TYPE = "department_list";

	private $CompanyUrl = null;
	private $UserRights = USER_UNKNOWN;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ListView($f3);

		$this->CheckAuthStatus();
	}


	private function GetUserRights() {
		// On the list level we use company-level rights
		$company = new \CompanyModel($this->f3);

		$companyData = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
		if (!$companyData) return;

		$userCompanyRights = $company->getData(array(
			"type" => "getUserRights", 
			"userId" => $this->GetUserInfo()["id"],
			"companyId" => $companyData["CompanyId"]));

		$this->UserRights = $userCompanyRights;
		$this->view->UserRights = $userCompanyRights;
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

		// Get user rights
		$this->GetUserRights();

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'create':
					$this->Create();
					break;
			}
		}

		$this->view->ShowPage( self::PAGE_TYPE );
	}


	private function Create() {
		$department = new \DepartmentModel($this->f3);
		$company = new \CompanyModel($this->f3);

		try {
			if (!isset($_POST['Title'])) 
				throw new \Exception("Не указано название отдела");

			if (!in_array($this->UserRights, array(USER_OWNER, USER_ADMIN))) 
				throw new \Exception("Вы не имеете прав для создания отдела");

			$companyData = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
			if (!$companyData) 
				throw new \Exception("Неверный id компании");
				
			$data = array_merge($_POST, array(
				"CompanyId" => $companyData["CompanyId"]
				));
			$department->add($data);

		} catch (\Exception $e) {
			$this->f3->set("department_error", $e->getMessage());
		}
	}
}