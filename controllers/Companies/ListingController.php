<?php

namespace Companies;

defined('_EXECUTED') or die('Restricted access');

require 'base/plugins/Resize.php';

class ListingController extends \BaseController
{
	const PAGE_TYPE = "company_list";

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');

		$this->f3->set("UserInfo", $this->GetUserInfo() );

		$this->view = new ListingView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'imageUpload':
					$this->UploadImage();
					break;

				case 'create' :
					$this->Create();
					$this->view->ShowPage( self::PAGE_TYPE );
					break;
				
				default:
					$this->view->ShowPage( self::PAGE_TYPE );
					break;
			}
		} else {
			$this->view->ShowPage( self::PAGE_TYPE );
		}
	}



	private function RestoreFieldValues() {
		$fieldList = array("Title", "Logo", "Url", "Slogan");

		foreach ($fieldList as $field) {
			if (isset($_POST[ $field ])) {
				$this->f3->set( "Field" . $field, $_POST[ $field ] );
			}
		}
	}



	private function Create() {
		try {
			$company = new \CompanyModel($this->f3);

			if (isset($_POST["Url"])){
				if(!preg_match("/^[a-z_]{1,}$/", $_POST["Url"]))
					throw new \Exception("Неверный url");

				if(!$company->getData(array("type" => "isUrlUnique", "url" => $_POST["Url"]))) 
					throw new \Exception("Введенный url уже зарегистрирован");
					
			} else throw new \Exception("Получены не все поля");

			$userInfo = $this->f3->get("UserInfo");
			if (is_null($userInfo["id"])) 
				throw new \Exception("Ошибка создания компании. Неверный id пользователя.");
				
			$companyData = array_merge($_POST, array("CreatorId" => $userInfo["id"], "DateAdd" => date("Y-m-d H:i:s")) );

			$status = $company->add( $companyData );

		} catch (\Exception $e) {
			$this->RestoreFieldValues();
			$this->f3->set("companyAddError", $e->getMessage());
		}
	}



	private function UploadImage(){
		try {
			$newFileUrl = $this->SaveImage("image", "images/company/");
			$img = new \Resize( $newFileUrl );
			$img -> resizeImage(400, 400, "crop");
			$img -> saveImage( $newFileUrl , 80);

			die( $newFileUrl );
		} catch (\Exception $e) {
			die("error");
		}
	}
}