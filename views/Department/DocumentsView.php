<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class DocumentsView extends \BaseView
{

	public $CompanyUrl = null;
	public $DepartmentId = null;
	public $UserRights = USER_UNKNOWN;

	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Отделы", $page);
		$this->SetVars();

		if (in_array($this->UserRights, array(USER_OWNER, USER_ADMIN, USER_DEP_MANAGER))) {
			echo (new \Template)->render('departmentDocumentsManagement.php');
		} else {
			echo (new \Template)->render('departmentDocumentsView.php');
		}
	}



	private function SetVars() {
		$this->f3->set("_topLineColor", "");

		$department = new \DepartmentModel($this->f3);

		$departmentInfo = $department->getData(array("type" => "byId", "id" => $this->DepartmentId));
		$this->f3->set("DepartmentInfo", $departmentInfo);
	}
}