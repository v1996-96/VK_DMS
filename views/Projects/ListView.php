<?php

namespace Projects;

defined('_EXECUTED') or die('Restricted access');

class ListView extends \BaseView
{

	public $CompanyUrl = null;
	public $UserRights = USER_UNKNOWN;

	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Проекты", $page);
		$this->SetVars();

		echo (new \Template)->render('projectList.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$project = new \ProjectModel($this->f3);

		$projectList = array();

		if (in_array($this->UserRights, array(USER_OWNER, USER_ADMIN))) {
			$projectList = $project->getData(array(
				"type" => "byCompanyUrl", 
				"url" => $this->CompanyUrl
				));
		} else {
			$projectList = $project->getData(array(
				"type" => "byCompanyUrlForUser", 
				"url" => $this->CompanyUrl,
				"userId" => $this->GetUserInfo()["id"]
				));
		}

		$this->f3->set("ProjectList", $projectList);
	}
}