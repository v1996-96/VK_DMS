<?php

namespace Employee;

defined('_EXECUTED') or die('Restricted access');

class ProfileController extends \BaseController
{

	const PAGE_TYPE = "employee_profile";

	private $EmployeeId = null;
	private $CompanyUrl = null;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ProfileView($f3);

		$this->CheckAuthStatus();
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

		// Action switch
		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'value':
					# code...
					break;
				
				default:
					# code...
					break;
			}
		}

		// View initialization
		$this->view->ShowPage( self::PAGE_TYPE );
	}
}