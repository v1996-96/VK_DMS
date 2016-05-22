<?php

defined('_EXECUTED') or die('Restricted access');

abstract class BaseView
{
	// Framework instance
	protected $f3 = null;

	// PDO instance
	protected $db = null;

	/**
	 * Template for view gateway
	 * @param  string $page Page name
	 * @param  object $f3   Fat free
	 */
	public abstract function ShowPage($page);


	/**
	 * Set some initial variables
	 * @param  string $page Page name
	 */
	public function PreparePage($page, $pageType){
		if (is_null($this->f3) || is_null($this->db)) 
			return false;

		$this->f3->set("_page_title", $page);
		$this->f3->set("_page_type", $pageType);
		$this->f3->set("_topLineColor", "white-bg");
	}
}