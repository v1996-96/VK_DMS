<?php

namespace Auth;

defined('_EXECUTED') or die('Restricted access');

class View
{
	/**
	 * Shows login page
	 */
	public function showLogin($f3){
		echo (new \Template)->render('login.php');
	}


	/**
	 * Shows lockscreen page
	 */
	public function showLockscreen($f3){
		$this->preparePage($f3);

		echo (new \Template)->render('lockscreen.php');
	}


	/**
	 * Set some initial variables
	 * @param  string $page Page name
	 */
	public function preparePage($f3){
		$db = $f3->get('db');
	}
}