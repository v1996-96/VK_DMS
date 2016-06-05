<?php

defined('_EXECUTED') or die('Restricted access');

class DepartmentPackageModel extends \BaseModel implements \IModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "DepartmentPackage";
		$this->required = array("PackageId", "DepartmentId", "PackageType", "DateAdd");
		$this->optional = array();
	}


	private function ById($packageId, $departmentId) {
		$response = $this->db->exec("SELECT * FROM DepartmentPackage 
										WHERE PackageId = :packageId AND DepartmentId = :departmentId",
										array("packageId" => $packageId, "departmentId" => $departmentId));
		return $response ? $response[0] : null;
	}


	private function CurrentDepartmentPackages($departmentId) {
		return $this->db->exec("SELECT p.*, dp.PackageType FROM DepartmentPackage as dp
								LEFT JOIN Package as p ON p.PackageId = dp.PackageId
								WHERE (dp.PackageType = '".(int)PACKAGE_INCOMING."' OR dp.PackageType = '".(int)PACKAGE_MANAGING."')
									AND dp.DepartmentId = ?", $departmentId);
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'byId':
					if (isset($search["packageId"]) && isset($search["departmentId"])) {
						return $this->ById($search["packageId"], $search["departmentId"]);
					} else return null;

				case 'currentDepartmentPackages':
					if (isset($search["departmentId"])) {
						return $this->CurrentDepartmentPackages($search["departmentId"]);
					} else return null;
				
				default: return null;
			}
		} else return null;
	}


	public function add($data = array()) {
		$data["DateAdd"] = date("Y-m-d H:i:s");
		return $this->insert($data);
	}


	public function edit($data = array()) {
		return $this->update($data, array("PackageId", "DepartmentId"));
	}


	public function remove($find = null) {
		return $this->delete($find, array("PackageId", "DepartmentId"));
	}
}