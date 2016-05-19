<?php

namespace Companies;

defined('_EXECUTED') or die('Restricted access');

class ListingView extends \BaseView
{
	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Компании", $page);
		$this->SetVars();

		echo (new \Template)->render('companyList.php');
	}



	private function SetVars() {

	}
}