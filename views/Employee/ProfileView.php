<?php

namespace Employee;

defined('_EXECUTED') or die('Restricted access');

class ProfileView extends \BaseView
{
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
	}
}