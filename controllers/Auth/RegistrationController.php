<?php

namespace Auth;

defined("_EXECUTED") or die("Restricted access");

class RegistrationController
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

	// Class constructor
	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new View;
		$this->f3->set("pageTab", "register");
	}


	public function Gateway() {
		$this->CheckVkCallback();

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'connectVk':
					$this->ConnectVk();
					break;

				case 'register':
					$this->Register();
					break;
				
				default:
					$f3->reroute("/");
					break;
			}
		}

		$this->view->showLogin($f3);
	}


	/**
	 * Checks current vk status
	 */
	private function CheckVkCallback() {
		$vk = new \OAuthVK();
		$vk->URL_CALLBACK = "http://" . $_SERVER["HTTP_HOST"] . "/registration";

		// When user is already logged in
		if (isset($_POST["vk_logged"]) &&
			isset($_POST["userId"]) && 
			isset($_POST["access_token"]) &&
			isset($_POST["expires"])) {
			$this->f3->mset(array(
				"vk_logged" => 1,
				"userId" => $_POST["userId"],
				"access_token" => $_POST["access_token"],
				"expires" => $_POST["expires"],
				"showRegistrationFields" => 1
				));
			$this->RestoreFieldsData();
			
		} elseif ($vk->catchResponse()) { // When user tries to login

			$user = new \UserModel($this->f3);
			if (!($resp = $user->getData(array("type" => "isVkIdUnique", "id" => $vk->userId))) ) {
				$this->f3->set("vk_logged", 0);
				$this->f3->set("registration_error", "Вы уже зарегистрированы в системе.");
				return;
			}

			$this->f3->mset(array(
				"vk_logged" => 1,
				"userId" => $vk->userId,
				"access_token" => $vk->token,
				"expires" => $vk->expires,
				"showRegistrationFields" => 1
				));
			$this->GetUserDataFromVK();

		} else { // Other variants
			$this->f3->set("vk_logged", 0);
			$this->f3->set("registration_error", "Ошибка подключения к Вашему аккаунту Вконтакте");
		}
	}


	/**
	 * Redirects to VK auth page
	 */
	private function ConnectVk() {
		$vk = new \OAuthVK();
		$vk->URL_CALLBACK = "http://" . $_SERVER["HTTP_HOST"] . "/registration";
		$vk->goToAuth();
	}


	/**
	 * There we get user name and surname from VK
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
	 * There we save data from fields between pages
	 */
	private function RestoreFieldsData() {
		$fields = array("name", "surname", "email", "VK_Avatar");

		foreach ($fields as $fName) {
			if (isset($_POST[ $fName ])) {
				$this->f3->set( $fName, $_POST[ $fName ] );
			}
		}
	}


	/**
	 * There we register new user :)
	 */
	private function Register() {
		$this->ProcessRegistration();

		// Authorize new user
		$this->auth->loginVK( 
			htmlspecialchars($_POST["access_token"]), 
			(int)$_POST["userId"], 
			htmlspecialchars($_POST["expires"])
			);

		if ( $this->auth->hasError() )
			$errors[] = $this->auth->getStatus();

		// Throw if there are errors
		if (count($errors) > 0) {
			$this->f3->set("registration_error", implode("<br>", $errors));
			return;
		}
	}
}