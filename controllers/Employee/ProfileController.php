<?php

namespace Employee;

defined('_EXECUTED') or die('Restricted access');

class ProfileController extends \BaseController
{
	function __construct($f3) {
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ProfileView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		$this->view->ShowPage("employee_profile");
	}
}