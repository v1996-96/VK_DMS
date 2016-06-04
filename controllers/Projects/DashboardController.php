<?php

namespace Projects;

defined('_EXECUTED') or die('Restricted access');

class DashboardController extends \BaseController
{

	const PAGE_TYPE = "project_dashboard";

	private $CompanyUrl = null;
	private $ProjectId = null;

	function __construct($f3) {
		$this->f3 = $f3;
		$this->auth = $f3->get('auth');
		$this->db   = $f3->get('db');
		$this->view = new DashboardView($f3);

		$this->CheckAuthStatus();
	}


	public function Gateway() {
		// Company url
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$this->CompanyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$this->view->CompanyUrl = $this->CompanyUrl;
		} else {
			$this->f3->set("project_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}

		if (isset($this->f3->get("PARAMS")["ProjectId"])) {
			$this->ProjectId = $this->f3->get("PARAMS")["ProjectId"];
			$this->view->ProjectId = $this->ProjectId;
		} else {
			$this->f3->set("project_error", "Не задан url компании");
			$this->view->ShowPage( self::PAGE_TYPE );
			return;
		}


		if (isset($_POST["action"])) {
			switch ($_POST["action"]) {
				case 'editProject':
					$this->EditProject();
					$this->view->ShowPage( self::PAGE_TYPE );
					break;

				case 'deleteProject':
					$this->DeleteProject();
					$this->view->ShowPage( self::PAGE_TYPE );
					break;

				case 'addManagers':
					$this->AddEmployees(true);
					$this->view->ShowPage( self::PAGE_TYPE );
					break;

				case 'addEmployees':
					$this->AddEmployees(false);
					$this->view->ShowPage( self::PAGE_TYPE );
					break;

				case 'deleteManager':
					$this->DeleteEmployee(true);
					$this->view->ShowPage( self::PAGE_TYPE );
					break;

				case 'deleteEmployee':
					$this->DeleteEmployee(false);
					$this->view->ShowPage( self::PAGE_TYPE );
					break;

				case 'addTask':
					$this->AddTask();
					$this->view->ShowPage( self::PAGE_TYPE );
					break;

				case 'editTask':
					$this->EditTask();
					break;

				case 'taskSummary':	
					$this->TaskSummary();
					break;

				case 'getAvailablePackagesList':
					$this->GetAvailablePackagesList();
					break;

				case 'getDepartments':
					$this->GetDepartments();
					break;

				case 'transferPackages':
					$this->TransferPackages();
					$this->view->ShowPage( self::PAGE_TYPE );
					break;
			}
		} else $this->view->ShowPage( self::PAGE_TYPE );
	}


	private function DeleteEmployee($isManager) {
		$projectEmployee = new \ProjectEmployeeModel($this->f3);

		try {
			if (!isset($_POST["UserId"])) 
				throw new \Exception("Не указан id сотрудника");
				
			if ($isManager) {
				$managers = $projectEmployee->getData(array(
					"type" => "getManagers",
					"id" => (int)$this->ProjectId
					));
				if ($managers && count($managers) <= 1) {
					throw new \Exception("У проекта должен быть как минимум один менеджер");
				}
			}

			$projectEmployee->remove(array(
				"UserId" => (int)$_POST["UserId"],
				"ProjectId" => (int)$this->ProjectId
				));
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}


	private function AddEmployees($isManager) {
		$projectEmployee = new \ProjectEmployeeModel($this->f3);

		try {
			if (isset($_POST["employeeList"]) &&
				count($_POST["employeeList"]) > 0) {
				foreach ($_POST["employeeList"] as $employee) {
					$projectEmployee->add(array(
						"UserId" => (int)$employee,
						"ProjectId" => (int)$this->ProjectId,
						"IsManager" => (int)$isManager
						));
				}
			}
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}


	private function EditProject() {
		$project = new \ProjectModel($this->f3);

		try {
			$project->edit(array_merge($_POST, array("ProjectId" => $this->ProjectId)));
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}


	private function DeleteProject() {
		$project = new \ProjectModel($this->f3);

		try {
			$success = $project->remove(array("ProjectId" => $this->ProjectId));
			if ($success) 
				$this->f3->reroute("/" . $this->CompanyUrl . "/projects/");
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}


	private function AddTask() {
		$task = new \TaskModel($this->f3);

		try {
			$task->add(array_merge($_POST, array("ProjectId" => $this->ProjectId)));
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}


	private function EditTask() {
		$task = new \TaskModel($this->f3);
		$taskPackage = new \TaskPackageModel($this->f3);
		$package = new \PackageModel($this->f3);

		try {
			if (!isset($_POST["TaskId"])) 
				throw new \Exception("Не указан id задачи");

			$currentPackages = $taskPackage->getData(array(
				"type" => "byTask",
				"taskId" => (int)$_POST["TaskId"]
				));

			$transfer = false;

			if (isset($_POST["IsClosed"]) &&
				$_POST["IsClosed"] == 1) {
				$data = array_merge($_POST, array("DateClosed" => date("Y-m-d H:i:s")));

				if (count($currentPackages) > 0) 
					$transfer = true;
			} else {
				$data = $_POST;
			}

			$task->edit($data);

			if (isset($_POST["Package"])) {

				if (is_array($_POST["Package"])) {
					$packageList = array();
					foreach ($_POST["Package"] as $pack) {
						$packInfo = $package->getData(array(
							"type" => "byId",
							"id" => (int)$pack
							));
						if (!$packInfo) 
							throw new \Exception("Ошибка обработки списка пактов документов");
						$packageList[] = (int)$pack;
					}

					$this->db->begin();

					foreach ($currentPackages as $pack) {
						$taskPackage->remove($pack);
					}
					foreach ($packageList as $pack) {
						$taskPackage->add(array(
							"PackageId" => $pack,
							"TaskId" => (int)$_POST["TaskId"]
							));
					}

					$this->db->commit();
				} elseif ($_POST["Package"] == "delete_all") {
					foreach ($currentPackages as $pack) {
						$taskPackage->remove($pack);
					}
				}
			}

			$response = array(
				"success" => true,
				"transfer" => $transfer
				);

			if ($transfer) {
				$packageList = $taskPackage->getData(array(
					"type" => "byTask",
					"taskId" => (int)$_POST["TaskId"]
					));

				$response["packages"] = $packageList;
			}

			die( json_encode( $response ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function TaskSummary() {
		$task = new \TaskModel($this->f3);
		$taskPackage = new \TaskPackageModel($this->f3);

		try {
			if (!isset($_POST["TaskId"])) 
				throw new \Exception("Не указан id задачи");

			$summary = $task->getData(array(
				"type" => "byId",
				"id" => (int)$_POST["TaskId"]
				));

			if (!$summary) 
				throw new \Exception("Задача не найдена");
			
			$packageList = $taskPackage->getData(array(
				"type" => "byTask",
				"taskId" => (int)$_POST["TaskId"]
				));

			die(json_encode(array(
				"summary" => $summary,
				"packages" => $this->RefactorPackageList($packageList)
				)));

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
				default: $type = "package"; break;
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
				"type" => $type
				);
		}, $list);

		return $data;
	}


	private function GetAvailablePackagesList() {
		$taskPackage = new \TaskPackageModel($this->f3);

		try {
			if (!isset($_POST["TaskId"])) 
				throw new \Exception("Не указан id задачи");

			$packages = $taskPackage->getData(array(
				"type" => "getAvailable",
				"taskId" => (int)$_POST["TaskId"]
				));

			die( json_encode( array("packages" => $packages) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function GetDepartments() {
		$department = new \DepartmentModel($this->f3);

		try {
			$departmentList = $department->getData(array(
				"type" => "byCompanyUrl",
				"url" => $this->CompanyUrl
				));

			die( json_encode( array("departments" => $departmentList) ) );
		} catch (\Exception $e) {
			die( json_encode( array("error" => $e->getMessage()) ) );
		}
	}


	private function TransferPackages() {
		$departmentPackage = new \DepartmentPackageModel($this->f3);
		$taskPackage = new \TaskPackageModel($this->f3);
		$department = new \DepartmentModel($this->f3);
		$project = new \ProjectModel($this->f3);

		try {
			if (isset($_POST["PackageId"]) &&
				is_array($_POST["PackageId"]) &&
				isset($_POST["DepartmentId"]) &&
				is_array($_POST["DepartmentId"])) {
				
				$data = array();

				$currentProject = $project->getData(array(
					"type" => "byId",
					"id" => $this->ProjectId
					));

				if (!$currentProject) 
					throw new \Exception("Неверный id проекта");

				// Get keys
				foreach ($_POST["PackageId"] as $key => $value) {
					if (isset($_POST["DepartmentId"][ $key ])) {
						$departmentId = $_POST["DepartmentId"][ $key ];

						$action = "";
						switch ($departmentId) {
							case '-1': $action =  "transferBack"; break;
							case '0' : $action =  "doNothing"; break;
							default: $action =  "transferForward"; break;
						}

						$data[] = array(
							"action" => $action,
							"PackageId" => $value,
							"DepartmentId" => $departmentId
							);
					} else
						throw new \Exception("Передан неверный список параметров");
				}


				// Resolve keys
				foreach ($data as $resolve) {
					$previousLink = $departmentPackage->getData(array(
						"type" => "byId",
						"packageId" => $resolve["PackageId"],
						"departmentId" => $currentProject["DepartmentId"]
						));

					switch ($resolve["action"]) {
						case 'transferBack':
							$taskPackage->remove(array("PackageId" => $resolve["PackageId"]));
							break;

						case 'transferForward':
							$this->db->begin();
							$previousLink["PackageType"] = PACKAGE_OUTCOMING;
							$departmentPackage->edit($previousLink);
							$resolve["PackageType"] = PACKAGE_INCOMING;
							$departmentPackage->add($resolve);
							$taskPackage->remove(array("PackageId" => $resolve["PackageId"]));
							$this->db->commit();
							break;
					}
				}
			}
		} catch (\Exception $e) {
			$this->f3->set("project_error", $e->getMessage());
		}
	}
}