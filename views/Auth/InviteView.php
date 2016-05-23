<?php

namespace Auth;

defined("_EXECUTED") or die("Restricted access");

class InviteView
{
	public function ShowPage() {
		echo (new \Template)->render('invite.php');
	}
}