<?php

namespace Documents;

defined('_EXECUTED') or die('Restricted access');

class MainView extends \BaseView
{

	public $CompanyUrl = null;
	public $UserRights = USER_UNKNOWN;


	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Отделы", $page);
		$this->SetVars();

		echo (new \Template)->render('documents.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");
	}
}