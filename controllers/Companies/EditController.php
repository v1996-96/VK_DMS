<?php

namespace Companies;

defined('_EXECUTED') or die('Restricted access');

class EditController extends \BaseController
{
	const PAGE_TYPE = "company_edit";

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');

		$this->view = new EditView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		$this->view->ShowPage( self::PAGE_TYPE );
	}
}