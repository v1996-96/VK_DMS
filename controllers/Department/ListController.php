<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class ListController extends \BaseController
{

	const PAGE_TYPE = "department_list";

	private $CompanyUrl = null;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ListView($f3);

		$this->CheckAuthStatus();
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