<?php

namespace Documents;

defined('_EXECUTED') or die('Restricted access');

class MainController extends \BaseController
{

	const PAGE_TYPE = "documents";

	private $CompanyUrl = null;
	private $UserRights = USER_UNKNOWN;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new MainView($f3);

		$this->CheckAuthStatus();
	}


	private function GetUserRights() {
		// On the list level we use company-level rights
		$company = new \CompanyModel($this->f3);

		$companyData = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
		if (!$companyData) return;

		$userCompanyRights = $company->getData(array(
			"type" => "getUserRights", 
			"userId" => $this->GetUserInfo()["id"],
			"companyId" => $companyData["CompanyId"]));

		$this->UserRights = $userCompanyRights;
		$this->view->UserRights = $userCompanyRights;
	}


	public function Gateway() {
		// Company url
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$this->CompanyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$this->view->CompanyUrl = $this->CompanyUrl;
		} else {
			$this->f3->set("department_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		// Get user rights
		$this->GetUserRights();

		if ($_POST["action"]) {
			switch ($_POST["action"]) {
				case 'getTreeData':
					$this->GetTreeData();
					break;

				case 'createPackage':
					$this->CreatePackage();
					break;

				case 'editPackage':
					$this->EditPackage();
					break;

				case 'deletePackage':
					$this->DeletePackage();
					break;
			}
		} else {
			$this->view->ShowPage( self::PAGE_TYPE );
		}
	}


	private function GetTreeData() {
		$department = new \DepartmentModel($this->f3);
		$departmentPackage = new \DepartmentPackageModel($this->f3);
		$document = new \DocumentModel($this->f3);

		try {
			$data = array();

			$departmentList = $department->getData(array(
				"type" => "byCompanyUrl",
				"url" => $this->CompanyUrl
				));

			foreach ($departmentList as $dep) {
				$managing = $departmentPackage->getData(array(
					"type" => "managingPackages",
					"departmentId" => $dep["DepartmentId"]
					));

				$incoming = $departmentPackage->getData(array(
					"type" => "incomingPackages",
					"departmentId" => $dep["DepartmentId"]
					));

				$notManaged = $document->getData(array(
					"type" => "byDepartmentNotManaged",
					"departmentId" => $dep["DepartmentId"]
					));

				$data[] = array(
					"id" => "dep_" . $dep["DepartmentId"],
					"text" => $dep["Title"],
					"type" => "department",
					"state" => array( "opened" => true ),
					"children" => array(
						array(
							"id" => "package_managing" . $dep["DepartmentId"],
							"text" => "Внутренние пакеты",
							"type" => "package_managing_list",
							"children" => $this->RefactorPackageList( $managing )
							), 

						array(
							"id" => "package_incoming" . $dep["DepartmentId"],
							"text" => "Входящие пакеты",
							"type" => "package_incoming_list",
							"children" => $this->RefactorPackageList( $incoming )
							), 

						array(
							"id" => "files_unmanaged" . $dep["DepartmentId"],
							"text" => "Неклассифицированные файлы",
							"type" => "files_unmanaged_list",
							"children" => $this->RefactorDocumentList( $notManaged )
							)
						)
					);
			}

			die( json_encode( array("data" => $data) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function RefactorPackageList($list) {
		$document = new \DocumentModel($this->f3);
		$packagesData = array();

		foreach ($list as $package) {
			$documentList = $document->getData(array(
				"type" => "byPackage",
				"packageId" => $package["PackageId"]
				));

			switch ($package["PackageType"]) {
				case PACKAGE_INCOMING: $type = "package_incoming"; break;
				case PACKAGE_MANAGING:
				default: $type = "package_managing"; break;
			}

			$packagesData[] = array(
				"id" => "pack_" . $package["PackageId"],
				"text" => $package["Title"],
				"type" => $type,
				"children" => $this->RefactorDocumentList( $documentList )
				);
		}

		return $packagesData;
	}


	private function RefactorDocumentList($list) {
		$data = array_map(function($item){
			switch ($item["Status"]) {
				case FILE_UNMANAGED: $type = "new";	break;
				case FILE_MANAGED: $type = "file";	break;
				case FILE_DELETED: $type = "deleted";	break;
				
				default: $type = "unknown"; break;
			}

			return array(
				"id" => "doc_" . $item["DocumentId"],
				"text" => $item["Title"],
				"type" => $type,
				"li_attr" => array( 
					"data-url" => $item["Url"] 
					)
				);
		}, $list);

		return $data;
	}


	private function CreatePackage() {
		$package = new \PackageModel($this->f3);
		$departmentPackage = new \DepartmentPackageModel($this->f3);

		try {
			if (!isset($_POST["DepartmentId"]))
				throw new \Exception("Не передан id отдела");

			$id = $package->add($_POST);

			if (is_null($id)) 
				throw new \Exception("Ошибка создания пакета");

			$success = $departmentPackage->add(array(
				"PackageId" => $id,
				"DepartmentId" => (int)$_POST["DepartmentId"],
				"PackageType" => PACKAGE_MANAGING
				));
				
			die( json_encode( array("id" => "pack_".$id) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function EditPackage() {
		$package = new \PackageModel($this->f3);

		try {
			$package->edit($_POST);

			die("{}");
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function DeletePackage() {
		$package = new \PackageModel($this->f3);
		$document = new \DocumentModel($this->f3);

		try {
			if (!isset($_POST["PackageId"])) 
				throw new \Exception("Не передан id пакета");

			$packageDocument = $document->getData(array(
				"type" => "byPackage",
				"packageId" => (int)$_POST["PackageId"]
				));

			foreach ($packageDocument as $item) {
				$item["Status"] = FILE_UNMANAGED;
				$document->edit($item);
			}

			$package->remove($_POST);

			die("{}");
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}
}