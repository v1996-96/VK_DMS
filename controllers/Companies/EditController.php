<?php

namespace Companies;

defined('_EXECUTED') or die('Restricted access');

require 'base/plugins/Resize.php';

class EditController extends \BaseController
{
	const PAGE_TYPE = "company_edit";

	private $CompanyUrl = null;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');

		$this->view = new EditView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		// Company url
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$this->CompanyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$this->view->CompanyUrl = $this->CompanyUrl;
		} else {
			$this->f3->set("company_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'imageUpload':
					$this->UploadImage();
					break;

				case 'edit' :
					$this->EditCompany();
					$this->view->ShowPage( self::PAGE_TYPE );
					break;

				case 'remove' :
					$this->RemoveCompany();
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



	private function EditCompany() {
		try {
			$company = new \CompanyModel($this->f3);

			$companyInfo = $company->getData(array(
				"type" => "byUrl",
				"url" => $this->CompanyUrl
				));

			if (!$companyInfo) 
				throw new \Exception("Неверная ссылка на компанию");

			if (isset($_POST["Url"])){
				if(!preg_match("/^[a-z\d_]{1,}$/", $_POST["Url"]))
					throw new \Exception("Неверный url");

				if(!$company->getData(array(
					"type" => "isUrlUnique", 
					"url" => $_POST["Url"],
					"id" => (int)$companyInfo["CompanyId"]
					))) 
					throw new \Exception("Введенный url уже зарегистрирован");
					
			} else throw new \Exception("Получены не все поля");

			$userInfo = $this->GetUserInfo();
			if (is_null($userInfo["id"])) 
				throw new \Exception("Ошибка создания компании. Неверный id пользователя.");
				
			$data = array_merge($_POST, array("CompanyId" => (int)$companyInfo["CompanyId"]));

			$status = $company->edit( $data );

			if ($status) {
				$this->f3->reroute("/" . $_POST["Url"] . "/edit/");
			}

		} catch (\Exception $e) {
			$this->RestoreFieldValues();
			$this->f3->set("company_error", $e->getMessage());
		}
	}



	private function RemoveCompany() {
		$company = new \CompanyModel($this->f3);

		try {
			$companyInfo = $company->getData(array(
				"type" => "byUrl",
				"url" => $this->CompanyUrl
				));

			if ($companyInfo) {
				$success = $company->remove($companyInfo);

				if ($success) {
					$this->f3->reroute("/companies");
				}
			}

		} catch (\Exception $e) {
			$this->f3->set("company_error", $e->getMessage());
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