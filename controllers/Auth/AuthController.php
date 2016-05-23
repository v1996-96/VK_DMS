<?php

namespace Auth;

defined("_EXECUTED") or die("Restricted access");

class AuthController
{
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
		$this->f3->set("pageTab", "login");
		$this->f3->set("showRegistrationFields", false);
	}


	/**
	 * Login / registration page
	 */
	public function Login() {

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'loginAuth':
					$this->LoginAuth();
					break;

				case 'loginVK':
					$this->LoginVK();
					break;
				
				default:
					$this->LoginAuth();
					break;
			}
		}

		$this->view->showLogin($this->f3);
	}


	/**
	 * Login through system credentials
	 */
	private function LoginAuth() {
		if ( isset($_POST['email']) && isset($_POST['password']) ) {
			$this->auth->login( $_POST['email'], $_POST['password'], isset($_POST['remember']) );
		} else {
			$this->auth->check();
		}

		if ( $this->auth->hasError() )
			$this->f3->set('login_error', $this->auth->getStatus());

		if (isset($_GET["vk_error"])) {
			$errorText = isset($_GET["vk_desc"]) ? 
							$_GET["vk_desc"] : "Ошибка авторизации Вконтакте";

			$this->f3->set('login_error', $errorText);
		}
	}


	/**
	 * Login through VKontakte account
	 */
	private function LoginVK() {
		$vk = new \OAuthVK();
		$vk->URL_CALLBACK = "http://" . $_SERVER["HTTP_HOST"] . "/vkCallback";
		$vk->goToAuth();
	}


	/**
	 * That method catches redirect from VK
	 */
	public function VKCallback() {
		$vk = new \OAuthVK();
		$vk->URL_CALLBACK = "http://" . $_SERVER["HTTP_HOST"] . "/vkCallback";
		if ($vk->catchResponse()) {
			$this->auth->loginVK( $vk->token, $vk->userId, $vk->expires );

			if ( $this->auth->hasError() )
				$this->f3->reroute("/?vk_error=1");

		} else {
			$desc = $vk->errorText != "" ? "&vk_desc=" . $vk->errorText : "";
			$this->f3->reroute("/?vk_error=1" . $desc);
		}
	}


	/**
	 * Lockscreen page
	 */
	public function Lockscreen() {
		if ( isset($_POST['password']) ) {
			$this->auth->lockscreen( $_POST['password'], isset($_POST['remember']) );
		} else {
			$this->auth->check();
		}

		if ( $this->auth->hasError() )
			$this->f3->set('login_error', $this->auth->getStatus());

		$this->view->showLockscreen($f3);
	}


	/**
	 * Logout action
	 */
	public function LogOut() {
		$this->auth->logOut();
	}


	/**
	 * Checks auth status
	 */
	public function CheckStatus() {
		$this->auth->config(array("reroute" => false));

		die( $this->auth->check() ? "User is logged in" : $this->auth->getStatus() );
	}
}