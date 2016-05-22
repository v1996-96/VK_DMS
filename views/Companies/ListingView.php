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
		$company = new \CompanyModel($this->f3);

		$userInfo = $this->f3->get("UserInfo");
		if (is_null($userInfo["id"])) 
			throw new \Exception("Ошибка отображения компаний. Неверный id пользователя.");

		$list = $company->getData(array("type" => "byUserId", "id" => $userInfo["id"]));
		$this->f3->set("CompanyList", $list);
	}
}