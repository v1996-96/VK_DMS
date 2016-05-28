<?php

namespace Projects;

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
		$this->PreparePage("Проекты", $page);
		$this->SetVars();

		echo (new \Template)->render('projectList.php');
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$project = new \ProjectModel($this->f3);
		$projectList = $project->getData(array(
			"type" => "byCompanyUrl", 
			"url" => $this->CompanyUrl
			));
		$this->f3->set("ProjectList", $projectList);
	}
}