<?php

namespace Projects;

defined('_EXECUTED') or die('Restricted access');

class ListController extends \BaseController
{

	const PAGE_TYPE = "project_list";

	private $CompanyUrl = null;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new ListView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		// Company url
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$this->CompanyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$this->view->CompanyUrl = $this->CompanyUrl;
		} else {
			$this->f3->set("project_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		$this->view->ShowPage(self::PAGE_TYPE);
	}
}