<?php

namespace Companies;

defined('_EXECUTED') or die('Restricted access');

class DashboardView extends \BaseView
{
	// Class constructor
	function __construct($f3){
		$this->f3 = $f3;
		$this->db = $f3->get('db');
	}



	public function ShowPage($page){
		$this->PreparePage("Компании", $page);
		$this->SetVars();

		echo (new \Template)->render('companyDashboard.php');
	}



	private function SetVars() {
		try {
			$company = new \CompanyModel($this->f3);

			$companyUrl = $this->f3->get("PARAMS")["CompanyUrl"];

			$companyData = $this->f3->get("CompanyData");
			if (is_null($companyData))
				throw new \Exception("Ошибка получения информации о компании");

			$summary = $company->getData(array("type" => "summary", "id" => $companyData["CompanyId"]));

			$this->f3->mset(array(
				"DepartmentsCount" => $summary["DepartmentsCount"],
				"ProjectsCount" => $summary["ProjectsCount"],
				"Activity" => $summary["Activity"],
				"EmployeeCount" => $summary["EmployeeCount"]
				));
		} catch (\Exception $e) {
			$this->f3->set("company_error", "Произошла непредвиденная ошибка.<br>".$e->getMessage());
		}
	}
}