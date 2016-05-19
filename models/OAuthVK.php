<?php

class OAuthVK
{
	const APP_ID = 5469551;
    const APP_SECRET = 'H1bd60dJ2B2ozBb6nFep';
    const URL_AUTHORIZE = 'https://oauth.vk.com/authorize';


    public static function goToAuth( $urlCallback ) { 
        self::redirect(self::URL_AUTHORIZE . 
            '?client_id=' . self::APP_ID . 
            '&scope=offline' . 
            '&redirect_uri=' . urlencode($urlCallback) . 
            '&response_type=code'); 
    }


    public static function redirect($uri = '') {
        header("HTTP/1.1 301 Moved Permanently"); 
        header("Location: ".$uri, TRUE, 302);
        exit;
    }
}