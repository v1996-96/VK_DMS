<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class ListView extends \BaseView
{

	public $CompanyUrl = null;

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
	}
}