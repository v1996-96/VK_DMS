<?php

defined('_EXECUTED') or die('Restricted access');

abstract class BaseController
{
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
	 * Returns current user data from DB
	 */
	protected function GetUserInfo() {
		$token = $this->auth->_getToken();

		$userInfo = array(
			"id" => null,
			"Name" => "Name",
			"Surname" => "Surname",
			"Email" => "email@email.com",
			"Role" => 0,
			"VK" => 0
			);

		if (!$token)
			return $userInfo;

		$resp = $this->db->exec('SELECT User.id, User.Name, User.Surname, User.Email, User.Role, User.VK FROM User 
								 LEFT JOIN UserToken ON User.id = UserToken.UserId
								 WHERE UserToken.Token = ?', $token);
		return $resp ? $resp[0] : $userInfo;
	}


	/**
	 * Saves image to defined directory
	 */
	protected function SaveImage($imageName, $path, $generateLength = 16) {
		if(isset($_FILES[$imageName])){
			$blacklist = array(".php", ".phtml", ".php3", ".php4", ".php5");
			foreach ($blacklist as $item) {
				if(preg_match("/$item\$/i", $_FILES[$imageName]['name'])) {
					throw new \Exception("Extension is in the black list");
				}
			}
			$imageinfo = getimagesize($_FILES[$imageName]['tmp_name']);
			if( ($imageinfo['mime'] != 'image/gif') && 
				($imageinfo['mime'] != 'image/jpeg') &&
				($imageinfo['mime'] != 'image/png') ) {
				throw new \Exception("Wrong mime type");
				
			}
			if($imageinfo['mime'] == 'image/gif') $ext = '.gif';
			if($imageinfo['mime'] == 'image/jpeg') $ext = '.jpg';
			if($imageinfo['mime'] == 'image/png') $ext = '.png';

			$url = $this->Generate($generateLength) . $ext;
			$uploaddir = $path;
			$uploadfile = $uploaddir . $url;

			while (file_exists($uploadfile)){
				$url = $this->Generate($generateLength) . $ext;
				$uploadfile = $uploaddir . $url;
			}

			if (!$flag = @move_uploaded_file($_FILES[$imageName]['tmp_name'], $uploadfile)) {
				throw new \Exception("Error while saving");
				
			} else {		
				return $path . $url;
			}
		} else {
			throw new \Exception("Image not found");
		}
	}



	/**
	 * Generates random string whith defined length
	 * @param string $number Length
	 */
	protected function Generate($number){
	    $arr = array('a','b','c','d','e','f',
	    'g','h','i','j','k','l',
	    'm','n','o','p','r','s',
	    't','u','v','x','y','z',
	    'A','B','C','D','E','F',
	    'G','H','I','J','K','L',
	    'M','N','O','P','R','S',
	    'T','U','V','X','Y','Z',
	    '1','2','3','4','5','6',
	    '7','8','9','0');
	    $random = "";
	    for($i = 0; $i < $number; $i++){
	        $index = rand(0, count($arr) - 1);
	        $random .= $arr[$index];
	    }
	    return $random;
	}


	/**
	 * Pattern for gateway
	 */
	public abstract function Gateway();
}