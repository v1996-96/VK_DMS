<?php

namespace Auth;

defined("_EXECUTED") or die("Restricted access");

class InviteController
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
		$this->view = new InviteView($f3);
		$this->f3->set("pageTab", "login");
		$this->f3->set("showRegistrationFields", false);
	}


	public function Gateway() {

	}
}