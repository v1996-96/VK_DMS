<?php

namespace Department;

defined('_EXECUTED') or die('Restricted access');

class DocumentsController extends \BaseController
{

	const PAGE_TYPE = "department_documents";

	private $CompanyUrl = null;
	private $DepartmentId = null;
	private $UserRights = USER_UNKNOWN;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new DocumentsView($f3);

		$this->CheckAuthStatus();
	}


	private function GetUserRights() {
		// On the list level we use company-level rights
		$company = new \CompanyModel($this->f3);
		$department = new \DepartmentModel($this->f3);

		$companyData = $company->getData(array("type" => "byUrl", "url" => $this->CompanyUrl));
		if (!$companyData) return;

		$userRights = $company->getData(array(
			"type" => "getUserRights", 
			"userId" => $this->GetUserInfo()["id"],
			"companyId" => $companyData["CompanyId"]));

		if ($userRights == USER_EMPLOYEE) {
			$userRights = $department->getData(array(
				"type" => "getUserRights",
				"userId" => $this->GetUserInfo()["id"],
				"departmentId" => (int)$this->DepartmentId
				));
		}

		$this->UserRights = $userRights;
		$this->view->UserRights = $userRights;
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

		if (isset($this->f3->get("PARAMS")["DepartmentId"])) {
			$this->DepartmentId = $this->f3->get("PARAMS")["DepartmentId"];
			$this->view->DepartmentId = $this->DepartmentId;
		} else {
			$this->f3->set("department_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		// Get user rights
		$this->GetUserRights();

		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'sync': 
					$this->Sync();
					break;

				case 'getDocuments':
					$this->GetDocuments();
					break;

				case 'getPackages':
					$this->GetPackages();
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

				case 'addDocumentToPackage':
					$this->AddDocumentToPackage();
					break;

				case 'deleteDocumentFromPackage':
					$this->DeleteDocumentFromPackage();
					break;

				case 'clearDeletedDocument':
					$this->ClearDeletedDocument();
					break;

				default:
					$this->view->ShowPage( self::PAGE_TYPE );
			}
		} else {
			$this->view->ShowPage( self::PAGE_TYPE );
		}
	}


	private function Sync() {
		$document = new \DocumentModel($this->f3);
		$department = new \DepartmentModel($this->f3);
		$response = array();

		try {
			if (!isset($_POST["documents"])) 
				throw new \Exception("Не передан список документов");
				
			$groupDocuments = json_decode($_POST["documents"], true);
			if (!is_array($groupDocuments) || count($groupDocuments) < 1) 
				throw new \Exception("Передан неверный параметр");

			unset($groupDocuments[0]);
			$groupDocumentsIdList = array_map(function($item){
				return $item["did"];
			}, $groupDocuments);
			$groupDocumentsIdList = !is_null($groupDocumentsIdList) ? $groupDocumentsIdList : array();


			$departmentDocuments = $document->getData(array(
				"type" => "byDepartment", 
				"departmentId" => (int)$this->DepartmentId
				));
			$departmentDocuments = $departmentDocuments ? $departmentDocuments : array();

			$departmentDocumentsIdList = array_map(function($item){
				return $item["VK_Id"];
			}, $departmentDocuments);
			$departmentDocumentsIdList = !is_null($departmentDocumentsIdList) ? $departmentDocumentsIdList : array();


			$new = array();
			foreach ($groupDocuments as $item) {
				if (!in_array($item["did"], $departmentDocumentsIdList)) 
					$new[] = $item;
			}

			$deleted = array();
			foreach ($departmentDocuments as $item) {
				if (!in_array($item["VK_Id"], $groupDocumentsIdList)) 
					$deleted[] = $item;
			}

			foreach ($new as $item) {
				$document->add(array(
					"VK_Id" => $item["did"],
					"Title" => $item["title"],
					"Extension" => $item["ext"],
					"Url" => $item["url"],
					"Status" => FILE_UNMANAGED,
					"DepartmentId" => (int)$this->DepartmentId
					));
			}

			foreach ($deleted as $item) {
				$item["Status"] = FILE_DELETED;
				$document->edit($item);
				$document->releaseDocument($item);
			}


			die(json_encode(array(
				"documents" => $this->DocumentList(),
				"packages" => $this->PackageList()
				)));

		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function DocumentList() {
		$document = new \DocumentModel($this->f3);

		$list = $document->getData(array(
			"type" => "byDepartmentNotManaged", 
			"departmentId" => (int)$this->DepartmentId
			));

		return $this->RefactorDocumentList($list);
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


	private function PackageList() {
		$document = new \DocumentModel($this->f3);
		$departmentPackage = new \DepartmentPackageModel($this->f3);

		$packages = $departmentPackage->getData(array(
			"type" => "currentDepartmentPackages",
			"departmentId" => (int)$this->DepartmentId
			));

		$data = array();

		foreach ($packages as $item) {
			$documents = $document->getData(array(
				"type" => "byPackage",
				"packageId" => (int)$item["PackageId"]
				));

			switch ($item["PackageType"]) {
				case PACKAGE_INCOMING: $type = "package_incoming"; break;
				case PACKAGE_MANAGING:
				default: $type = "package"; break;
			}

			$data[] = array(
				"id" => "pack_" . $item["PackageId"],
				"text" => $item["Title"],
				"type" => $type,
				"children" => $this->RefactorDocumentList($documents)
				);
		}

		return $data;
	}


	private function GetDocuments() {
		try {
			die( json_encode( array("documents" => $this->DocumentList()) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function GetPackages() {
		try {
			die( json_encode( array("packages" => $this->PackageList()) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function CreatePackage() {
		$package = new \PackageModel($this->f3);
		$departmentPackage = new \DepartmentPackageModel($this->f3);

		try {
			$id = $package->add($_POST);

			if (is_null($id)) 
				throw new \Exception("Ошибка создания пакета");

			$success = $departmentPackage->add(array(
				"PackageId" => $id,
				"DepartmentId" => (int)$this->DepartmentId,
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


	private function AddDocumentToPackage() {
		$document = new \DocumentModel($this->f3);

		try {
			$document->edit(array_merge($_POST, array("Status" => FILE_MANAGED)));

			die("{}");
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function DeleteDocumentFromPackage() {
		$document = new \DocumentModel($this->f3);

		try {
			$document->edit(array_merge($_POST, array(
				"Status" => FILE_UNMANAGED
				)));
			$document->releaseDocument($_POST);

			die("{}");
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function ClearDeletedDocument() {
		$document = new \DocumentModel($this->f3);

		try {
			$document->remove($_POST);

			die("{}");
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}
}