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

		$department = new \DepartmentModel($this->f3);
		$summary = $department->getData(array(
			"type" => "summary", 
			"id" => $this->DepartmentId, 
			"url" => $this->CompanyUrl
			));

		$this->f3->set("DepartmentSummary", $summary ? $summary[0] : null);
	}
}