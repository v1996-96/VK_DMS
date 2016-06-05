<?php

namespace Employee;

defined('_EXECUTED') or die('Restricted access');

class ProfileController extends \BaseController
{

	const PAGE_TYPE = "employee_profile";

	private $EmployeeId = null;
	private $CompanyUrl = null;
	private $UserRights = USER_UNKNOWN;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ProfileView($f3);

		$this->CheckAuthStatus();
	}


	private function GetUserRights() {
		// On the list level we use company-level rights
		$company = new \CompanyModel($this->f3);

		$companyData = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
		if (!$companyData) return;

		$userRights = $company->getData(array(
			"type" => "getUserRights", 
			"userId" => $this->GetUserInfo()["id"],
			"companyId" => $companyData["CompanyId"]));

		$this->UserRights = $userRights;
		$this->view->UserRights = $userRights;
	}


	public function Gateway() {

		// Company url
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$this->CompanyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$this->view->CompanyUrl = $this->CompanyUrl;
		} else {
			$this->f3->set("employee_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		// Employee id
		if (isset($this->f3->get("PARAMS")["EmployeeId"])) {
			$this->EmployeeId = $this->f3->get("PARAMS")["EmployeeId"];
			$this->view->EmployeeId = $this->EmployeeId;
		} else {
			$this->f3->set("employee_error", "Не задан id сотрудника");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		$this->GetUserRights();

		// Action switch
		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'setAdmin':
					$this->SetAdmin();
					break;

				case 'unsetAdmin':
					$this->UnsetAdmin();
					break;

				case 'delete':
					$this->Delete();
					break;
			}
		}

		// View initialization
		$this->view->ShowPage( self::PAGE_TYPE );
	}


	private function SetAdmin() {
		$companyEmployee = new \CompanyEmployeeModel($this->f3);
		$company = new \CompanyModel($this->f3);

		try {
			$companyData = $company->getData(array(
				"type" => "byUrl",
				"url" => $this->CompanyUrl
				));

			if (!$company) 
				throw new \Exception("Неверный идентификатор компании");

			$current = $companyEmployee->getData(array(
				"type" => "byId",
				"userId" => $this->EmployeeId,
				"companyId" => $companyData["CompanyId"]
				));

			if (!($current && count($current) == 1)) 
				throw new \Exception("Сотрудник не найден");
			
			$current[0]["IsAdmin"] = 1;

			$companyEmployee->edit($current[0]);

		} catch (\Exception $e) {
			$this->f3->set("employee_error", $e->getMessage());
		}
	}


	private function UnsetAdmin() {
		$companyEmployee = new \CompanyEmployeeModel($this->f3);
		$company = new \CompanyModel($this->f3);

		try {
			$companyData = $company->getData(array(
				"type" => "byUrl",
				"url" => $this->CompanyUrl
				));

			if (!$company) 
				throw new \Exception("Неверный идентификатор компании");

			$current = $companyEmployee->getData(array(
				"type" => "byId",
				"userId" => $this->EmployeeId,
				"companyId" => $companyData["CompanyId"]
				));

			if (!($current && count($current) == 1)) 
				throw new \Exception("Сотрудник не найден");
			
			$current[0]["IsAdmin"] = 0;

			$companyEmployee->edit($current[0]);

		} catch (\Exception $e) {
			$this->f3->set("employee_error", $e->getMessage());
		}
	}


	private function Delete() {
		$companyEmployee = new \CompanyEmployeeModel($this->f3);
		$company = new \CompanyModel($this->f3);

		try {
			$companyData = $company->getData(array(
				"type" => "byUrl",
				"url" => $this->CompanyUrl
				));

			if (!$company) 
				throw new \Exception("Неверный идентификатор компании");

			$current = $companyEmployee->getData(array(
				"type" => "byId",
				"userId" => $this->EmployeeId,
				"companyId" => $companyData["CompanyId"]
				));

			if (!($current && count($current) == 1)) 
				throw new \Exception("Сотрудник не найден");
			
			$companyEmployee->remove($current[0]);

			$this->f3->reroute("/" . $this->CompanyUrl . "/employee");

		} catch (\Exception $e) {
			$this->f3->set("employee_error", $e->getMessage());
		}
	}
}