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

		$this->view->showLogin($f3);
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
	}


	/**
	 * Login through VKontakte account
	 */
	private function LoginVK() {
		\OAuthVK::goToAuth( "http://trush.prodans.ru" );
	}


	/**
	 * That method catches redirect from VK
	 */
	public function VKCallback() {
		echo "string";
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