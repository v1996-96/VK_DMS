<?php

namespace Companies;

defined('_EXECUTED') or die('Restricted access');

class DashboardController extends \BaseController
{

	const PAGE_TYPE = "company_dashboard";
	
	private $CompanyUrl = null;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');

		$this->view = new DashboardView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		// Company url
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$this->CompanyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$this->view->CompanyUrl = $this->CompanyUrl;
		} else {
			$this->f3->set("department_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'getActivityByDay':
					$this->GetActivityByDay();
					break;
				
				case 'getActivityByMonth':
					$this->GetActivityByMonth();
					break;

				case 'getActivityByYear':
					$this->GetActivityByYear();
					break;

				case 'getTaskCompletition':
					$this->GetTaskCompletition();
					break;
			}
		}

		$this->view->ShowPage( self::PAGE_TYPE );
	}


	private function GetActivityByDay() {
		$company = new \CompanyModel($this->f3);

		try {
			$activity = $company->getData(array(
				"type" => "getActivityByDay",
				"url" => $this->CompanyUrl
				));

			die( json_encode( array("data" => $activity) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function GetActivityByMonth() {
		$company = new \CompanyModel($this->f3);

		try {
			$activity = $company->getData(array(
				"type" => "getActivityByMonth",
				"url" => $this->CompanyUrl
				));

			die( json_encode( array("data" => $activity) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function GetActivityByYear() {
		$company = new \CompanyModel($this->f3);

		try {
			$activity = $company->getData(array(
				"type" => "getActivityByYear",
				"url" => $this->CompanyUrl
				));

			die( json_encode( array("data" => $activity) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function GetTaskCompletition () {
		$task = new \TaskModel($this->f3);

		try {
			$summary = $task->getData(array(
				"type" => "forCompanySummary",
				"url" => $this->CompanyUrl
				));

			$response = array(
				array(
					"label" => "Открытые задачи",
					"color" => "#27ae60",
					"data" => (int)$summary["CountOpened"]
					),

				array(
					"label" => "Закрытые задачи",
					"color" => "#34495e",
					"data" => (int)$summary["CountClosed"]
					)
				);

			die( json_encode( array("data" => $response) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}
}