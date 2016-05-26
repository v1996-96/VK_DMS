<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class DashboardController extends \BaseController
{
	const PAGE_TYPE = "department_dashboard";

	private $CompanyUrl = null;
	private $DepartmentId = null;

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
			$this->f3->set("department_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		if (isset($this->f3->get("PARAMS")["DepartmentId"])) {
			$this->DepartmentId = $this->f3->get("PARAMS")["DepartmentId"];
			$this->view->DepartmentId = $this->DepartmentId;
		} else {
			$this->f3->set("department_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'edit':
					$this->Edit();
					break;

				case 'remove':
					$this->Remove();
					break;
			}
		}

		$this->view->ShowPage( self::PAGE_TYPE );
	}


	private function Edit() {
		$department = new \DepartmentModel($this->f3);
		$company = new \CompanyModel($this->f3);

		try {
			$department->edit(array_merge($_POST, array("DepartmentId" => $this->DepartmentId)));
		} catch (\Exception $e) {
			$this->f3->set("department_error", $e->getMessage());
		}
	}


	private function Remove() {
		$department = new \DepartmentModel($this->f3);

		try {
			$success = $department->remove(array("DepartmentId" => $this->DepartmentId));
			if ($success) {
				$this->f3->reroute("/" . $this->CompanyUrl . "/departments");
			}
		} catch (\Exception $e) {
			$this->f3->set("department_error", $e->getMessage());
		}
	}
}