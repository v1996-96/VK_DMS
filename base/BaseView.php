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

		// Get current user token
		// $auth = $this->f3->get('auth');
		// $token = $auth->_getToken();

		// if (!$token) {
		// 	// Set default values
		// 	$this->f3->set('userInfo', array(
		// 		'name' => 'undefined name',
		// 		'avatar' => 'avatar/avatar.png'
		// 		));
		// 	return true;
		// }

		// // Get user info
		// $resp = $this->db->exec('SELECT * FROM admin 
		// 						 LEFT JOIN admin_token ON admin.id = admin_token.id_user
		// 						 WHERE admin_token.token = ?', $token);
		// if ($resp) {
		// 	$this->f3->set('userInfo', array(
		// 		'name' => $resp[0]['name'],
		// 		'avatar' => $resp[0]['avatar']
		// 		));
		// 	$this->f3->set('user', $resp[0]);
		// 	return true;
		// }
	}
}