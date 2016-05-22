<?php

namespace Employee;

defined('_EXECUTED') or die('Restricted access');

class ListView extends \BaseView
{
	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Сотрудники", $page);
		$this->SetVars();

		echo (new \Template)->render('employeeList.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$users = new \UserModel($this->f3);
		$invites = new \CompanyInviteModel($this->f3);

		$url = $this->f3->get("PARAMS")["CompanyUrl"];
		$userList = is_null($url) ? array() : $users->getData(array("type" => "byCompanyUrl", "url" => $url));
		$this->f3->set("UserList", $userList);

		$inviteList = is_null($url) ? array() : $invites->getData(array("type" => "byCompanyUrl", "url" => $url));
		$this->f3->set("InviteList", $inviteList);
	}
}