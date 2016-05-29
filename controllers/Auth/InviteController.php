<?php

namespace Auth;

defined("_EXECUTED") or die("Restricted access");

class InviteController
{
	use RegistrationTrait;


	// AuthPHP instance
	private $auth = null;

	// PDO instance
	private $db = null;

	// View instance
	private $view = null;

	// FatFree instance
	private $f3 = null;

	// Invite token
	private $token = null;

	// Class constructor
	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new InviteView($f3);

		$this->token = $this->f3->get("PARAMS")["InviteToken"];
	}


	/**
	 * Common controller gateway
	 */
	public function Gateway() {
		// Give access only for registered tokens
		if (!$this->CheckInviteToken()) {
			$this->f3->set("invite_error", "Нераспознанное приглашение");
			$this->view->ShowPage();
			return;
		}

		$this->f3->mset(array(
			"showRegistrationFields" => false,
			"showAcceptFields" => false
			));

		$this->CatchCallback();		

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'loginVK':
					$this->LoginVK();
					break;

				case 'register':
					$this->Register();
					break;

				case 'accept':
					$this->Accept();
					break;

				case 'decline':
					$this->Decline();
					break;
			}
		}

		$this->view->ShowPage();
	}


	/**
	 * Check current token
	 */
	private function CheckInviteToken() {
		if (is_null($this->token)) 
			return null;

		$invite = new \CompanyInviteModel($this->f3);
		$inviteData = $invite->getData(array("type" => "byToken", "token" => $this->token));

		if ($inviteData) {
			$company = new \CompanyModel($this->f3);
			$companyData = $company->getData(array("type" => "byId", "id" => $inviteData[0]["CompanyId"]));

			if ($companyData) {
				$this->f3->set("CompanyData", $companyData[0]);
			}
		}

		return $inviteData;
	}


	/**
	 * Check user for registration by vk id
	 * @param int $userVkId 
	 */
	private function CheckIsUserRegistered($userVkId) {
		$user = new \UserModel($this->f3);
		return (bool)$user->getData(array("type" => "byVkId", "id" => $userVkId));
	}


	/**
	 * Login through vk
	 */
	private function LoginVK() {
		$vk = new \OAuthVK();
		$vk->URL_CALLBACK = "http://" . $_SERVER["HTTP_HOST"] . "/invite/" . $this->token;
		$vk->goToAuth();
	}


	/**
	 * Catch vk callback and save data
	 */
	private function CatchCallback() {
		$vk = new \OAuthVK();
		$vk->URL_CALLBACK = "http://" . $_SERVER["HTTP_HOST"] . "/invite/" . $this->token;

		if ($this->CatchVkFormData()) {
			/* If user will renew page */
			$this->RestoreFields();

			$vkId = $this->f3->get("userId");

			$this->ProcessCallback($vkId);

		} elseif ($vk->catchResponse()) {
			/* There we catch reroute from vk */
			$this->f3->mset(array(
				"vk_logged" => 1,
				"userId" => $vk->userId,
				"access_token" => $vk->token,
				"expires" => $vk->expires
				));

			$this->ProcessCallback($vk->userId);

			$this->GetUserDataFromVK();

		} elseif (isset($_GET["error"])) {
			$this->f3->set("invite_error", "Ошибка авторизации Вконтакте");
		}
	}


	/**
	 * Process vk callback
	 * @param int $userVkId 
	 */
	private function ProcessCallback($userVkId) {
		$invite = new \CompanyInviteModel($this->f3);
		$currentInvite = $invite->getData(array("type" => "byToken", "token" => $this->token));

		if (!$currentInvite) {
			$this->f3->set("invite_error", "Нераспознанное приглашение");
			return;
		}

		if ((int)$currentInvite[0]["VK"] !== (int)$userVkId) {
			$this->f3->set("invite_error", "Ошибка! Приглашение адресовано не Вам. (( ");
			return;
		}

		/* Show apropriate section */
		if ($this->CheckIsUserRegistered($userVkId)) {
			$this->f3->set("showAcceptFields", true);
		} else {
			$this->f3->set("showRegistrationFields", true);
		}
	}


	/**
	 * Catch vk personal data between pages
	 */
	private function CatchVkFormData() {
		if (isset($_POST["vk_logged"]) &&
			isset($_POST["userId"]) && 
			isset($_POST["access_token"]) &&
			isset($_POST["expires"])) {
			$this->f3->mset(array(
				"vk_logged" => 1,
				"userId" => $_POST["userId"],
				"access_token" => $_POST["access_token"],
				"expires" => $_POST["expires"]
				));
			return true;
		} else return false;
	}


	/**
	 * Restore form values after form submit
	 */
	private function RestoreFields() {
		$fields = array("name", "surname", "email", "VK_Avatar");

		foreach ($fields as $fName) {
			if (isset($_POST[ $fName ])) {
				$this->f3->set( $fName, $_POST[ $fName ] );
			}
		}
	}


	/**
	 * Get username and avatar from vk
	 */
	private function GetUserDataFromVK() {
		$uri =  "https://api.vk.com/method/users.get?" . 
				"user_ids=" . $this->f3->get("userId") .
				"&fields=photo_50" .
				"&access_token=" . $this->f3->get("access_token");

		if ($res = @file_get_contents($uri)) { 
            $data = json_decode($res, true);

            $this->f3->set("name", (isset($data["response"][0]["first_name"]) ? $data["response"][0]["first_name"] : "") );
            $this->f3->set("surname", (isset($data["response"][0]["first_name"]) ? $data["response"][0]["last_name"] : "") );
            $this->f3->set("email", "");
            $this->f3->set("VK_Avatar", (isset($data["response"][0]["photo_50"]) ? $data["response"][0]["photo_50"] : ""));
        }
	}


	/**
	 * Register new user
	 */
	private function Register() {
		$this->ProcessRegistration();

		if ($this->f3->exists("registration_error")) {
			$this->f3->mset(array(
				"showRegistrationFields" => true,
				"showAcceptFields" => false
				));
		} else {
			$this->f3->mset(array(
				"showRegistrationFields" => false,
				"showAcceptFields" => true
				));
		}
	}


	/**
	 * Accept invite
	 */
	private function Accept() {
		// Process invite
		$invite = new \CompanyInviteModel($this->f3);
		$user = new \UserModel($this->f3);
		$employee = new \CompanyEmployeeModel($this->f3);

		// Get user vk id
		if (!$this->CatchVkFormData()) {
			$this->f3->set("invite_error", "Вы не можете приянять приглашение, поскльку не авторизованы в ВК.");
			return;
		}

		// Get user data from db
		$userVkId = $this->f3->get("userId");
		$userData = $user->getData(array("type" => "byVkId", "id" => $userVkId));
		if (!$userData) {
			$this->f3->set("invite_error", "Вы не зарегистрированы в системе.");
			return;
		}

		// Add new employee
		try {
			$currentInvite = $invite->getData(array("type" => "byToken", "token" => $this->token));

			if ($currentInvite) {
				$employee->add(array(
					"CompanyId" => $currentInvite[0]["CompanyId"], 
					"UserId" => $userData[0]["id"], 
					"IsAdmin" => false, 
					"DateAdd" => date("Y-m-d H:i:s"), 
					"RoleDescription" => "Новый сотрудник"
					));

				$invite->remove(array("id" => $currentInvite[0]["id"]));
			} else throw new \Exception("Нераспознанное приглашение");
			
		} catch (\Exception $e) {
			$this->f3->set("invite_error", $e->getMessage());
			return;
		}

		// Authorize new user
		$this->auth->loginVK( 
			htmlspecialchars($_POST["access_token"]), 
			(int)$_POST["userId"], 
			htmlspecialchars($_POST["expires"])
			);

		if ( $this->auth->hasError() ) {
			$this->f3->set("invite_error", $this->auth->getStatus());
		}
	}


	/**
	 * Decline invite
	 */
	private function Decline() {
		$invite = new \CompanyInviteModel($this->f3);

		try {
			$currentInvite = $invite->getData(array("type" => "byToken", "token" => $this->token));
			if ($currentInvite) {
				$invite->remove(array("id" => $currentInvite[0]["id"]));
			}
		} catch (\Exception $e) {
			
		}

		$this->f3->reroute("/");
	}
}