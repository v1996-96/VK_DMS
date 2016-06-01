<?php

class OAuthVK
{
	const APP_ID = 5469551;
    const APP_SECRET = 'H1bd60dJ2B2ozBb6nFep';
    const URL_AUTHORIZE = 'https://oauth.vk.com/authorize';
    const URL_ACCESS_TOKEN = 'https://oauth.vk.com/access_token';
    const VERSION = '5.52';

    public $URL_CALLBACK = "";

    public $token; 
    public $userId;
    public $expires;

    public $errorText = "";


    public function goToAuth() { 
        $this->redirect(self::URL_AUTHORIZE . 
            '?client_id=' . self::APP_ID . 
            '&display=page' .
            '&scope=offline,docs,groups' . 
            '&redirect_uri=' . urlencode($this->URL_CALLBACK) . 
            '&response_type=code' . 
            '&v=' . self::VERSION); 
    }


    public function catchResponse() {
        if (isset($_GET["error"])) {
            $this->errorText = isset($_GET["error_description"]) ? $_GET["error_description"] : "";
            return false;

        } elseif (isset($_GET["code"])) {
            return $this->getToken($_GET["code"]);

        } else {
            return false;
        }
    }


    public function getToken($code) { 
        $url = self::URL_ACCESS_TOKEN . 
            '?client_id=' . self::APP_ID . 
            '&client_secret=' . self::APP_SECRET . 
            '&code=' . $_GET['code'] . 
            '&redirect_uri=' . urlencode($this->URL_CALLBACK); 

        if (!($res = @file_get_contents($url))) { 
            return false; 
        }

        $data = json_decode($res, true);
        if (isset($data["access_token"]) &&
            isset($data["user_id"]) &&
            isset($data["expires_in"])) {
            $this->token = $data["access_token"];
            $this->userId = $data["user_id"];
            $this->expires = $data["expires_in"];
            return true; 
        } else {
            return false;
        }
    }


    public function redirect($uri = '') {
        header("HTTP/1.1 301 Moved Permanently"); 
        header("Location: ".$uri, TRUE, 302);
        exit;
    }
}