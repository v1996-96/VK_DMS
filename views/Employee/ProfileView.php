<?php

namespace Employee;

defined('_EXECUTED') or die('Restricted access');

class ProfileView extends \BaseView
{

	public $EmployeeId = null;
	public $CompanyUrl = null;

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

		$employeeData = $employee->getData(array(
			"type" => "summary", 
			"id" => $this->EmployeeId,
			"url" => $this->CompanyUrl
			));
		$this->f3->set("EmployeeData", $employeeData ? $employeeData[0] : null);
	}
}