<?php

namespace Companies;

defined('_EXECUTED') or die('Restricted access');

class EditView extends \BaseView
{

	public $CompanyUrl = null;

	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Компании", $page);
		$this->SetVars();

		echo (new \Template)->render('companyEdit.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$company = new \CompanyModel($this->f3);
		$companyInfo = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
		$this->RestoreFieldValues($companyInfo);
	}


	private function RestoreFieldValues($info) {
		$fieldList = array("Title", "Logo", "Url", "Slogan");

		foreach ($fieldList as $field) {
			if (isset($info[ $field ])) {
				$this->f3->set( "Field" . $field, $info[ $field ] );
			}
		}
	}
}