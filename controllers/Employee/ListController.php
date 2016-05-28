<?php

namespace Employee;

defined('_EXECUTED') or die('Restricted access');

class ListController extends \BaseController
{
	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ListView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'inviteEmployee':
					$this->InviteEmployee();
					break;

				case 'deleteInvite':
					$this->DeleteInvite();
					break;
			}
		}

		$this->view->ShowPage("employee_list");
	}


	private function InviteEmployee() {
		try {
			$invite = new \CompanyInviteModel($this->f3);
			$company = new \CompanyModel($this->f3);
			$employee = new \CompanyEmployeeModel($this->f3);

			$url = $this->f3->get("PARAMS")["CompanyUrl"];
			if (is_null($url)) 
				throw new \Exception("Неверная ссылка компании");

			$companyInfo = $company->getData(array("type" => "byUrl", "url" => $url));
			if (!$companyInfo) 
				throw new \Exception("Ошибка идентификации компании");

			if (!(isset($_POST["VK"]) && $_POST["VK"] !== "")) 
				throw new \Exception("Не указан vk id");

			if (!$this->CheckVkId($_POST["VK"])) 
				throw new \Exception("Неверный vk id");

			if (!$employee->getData(array("type" => "isVkNew", "id" => $companyInfo["CompanyId"], "vk" => $_POST["VK"]))) 
				throw new \Exception("Пользователь уже является сотрудником компании");
				
			$tries = 0;
			$maxTries = 10;
			$token = "";
			do {
				$token = md5( $this->Generate(16) );
				$tries++;
			} while ( $tries == $maxTries || 
					  !$invite->getData(array("type" => "isTokenUnique", "token" => $token)) );

			if ($tries == $maxTries) 
				throw new \Exception("Ошибка создания токена");

			$data = array(
				"CompanyId" => $companyInfo["CompanyId"], 
				"RegistrationToken" => $token, 
				"VK" => (int) $_POST["VK"], 
				"DateAdd" => date("Y-m-d H:i:s")
				);

			$invite->add($data);

		} catch (\Exception $e) {
			$this->f3->set("invite_error", $e->getMessage());
		}
	}


	private function DeleteInvite() {
		try {
			$invite = new \CompanyInviteModel($this->f3);

			$invite->remove($_POST);
		} catch (\Exception $e) {
			$this->f3->set("invite_error", $e->getMessage());
		}
	}
}