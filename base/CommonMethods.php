<?php

trait CommonMethods
{
	/**
	 * Returns current user data from DB
	 */
	protected function GetUserInfo() {
		$token = $this->f3->get("auth")->_getToken();

		$userInfo = array(
			"id" => null,
			"Name" => "Name",
			"Surname" => "Surname",
			"Email" => "email@email.com",
			"Role" => 0,
			"VK" => 0,
			"VK_Avatar" => "",
			"VK_Authorized" => false,
			"VK_AccessToken" => null,
			"VK_ExpiresIn" => null
			);

		if (!$token)
			return $userInfo;

		$resp = $this->db->exec('SELECT 
									User.id, User.Name, User.Surname, 
									User.Email, User.Role, User.VK, 
									User.VK_Avatar,  
									UserToken.VK_Authorized,
									UserToken.VK_AccessToken,
									UserToken.VK_ExpiresIn
								 FROM User 
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
	 * Check vk id on vk.com
	 */
	protected function CheckVkId($vk) {
		$url = "https://api.vk.com/method/users.get?user_ids=" . $vk;
		if (!($res = @file_get_contents($url))) { 
            return false; 
        }

        $data = json_decode($res, true);
        if (isset($data["error"])) {
        	return false;
        } elseif (isset($data["response"]) && count($data["response"]) == 1) {
        	return $data;
        } else {
        	return false;
        }
	}
}