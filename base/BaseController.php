<?php

defined('_EXECUTED') or die('Restricted access');

abstract class BaseController
{
	use CommonMethods;

	// AuthPHP instance
	protected $auth = null;

	// DB instance
	protected $db   = null;

	// View instance
	protected $view = null;

	// FatFree instance
	protected $f3 = null;


	/**
	 * Check current authorization status
	 */
	protected function CheckAuthStatus(){
		if ($this->auth)
			$this->auth->check();
	}


	/**
	 * Pattern for gateway
	 */
	public abstract function Gateway();
}