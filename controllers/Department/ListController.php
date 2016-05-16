<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class ListController extends \BaseController
{
	function __construct($f3) {
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ListView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		$this->view->ShowPage("department_list");
	}
}