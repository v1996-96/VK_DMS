<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class DashboardView extends \BaseView
{
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
	}
}