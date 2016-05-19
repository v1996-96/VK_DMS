<?php

namespace Documents;

defined('_EXECUTED') or die('Restricted access');

class MainController extends \BaseController
{
	function __construct($f3) {
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new MainView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		$this->view->ShowPage("documents");
	}
}