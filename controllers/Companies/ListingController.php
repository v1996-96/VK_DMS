<?php

namespace Companies;

defined('_EXECUTED') or die('Restricted access');

class ListingController extends \BaseController
{
	function __construct($f3) {
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ListingView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		$this->view->ShowPage("company_list");
	}
}