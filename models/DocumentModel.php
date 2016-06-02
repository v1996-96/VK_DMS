<?php

defined('_EXECUTED') or die('Restricted access');

class DocumentModel extends \BaseModel implements \IModel, \IDocumentModel
{
	function __construct($f3)
	{
		$this->f3 = $f3;
		$this->db = $f3->get('db');
		
		$this->entity = "Document";
		$this->required = array("VK_Id", "Title", "Extension", "Url", "Status");
		$this->optional = array("PackageId", "DepartmentId");
	}


	private function ById($id) {
		$response = $this->db->exec("SELECT * FROM Document WHERE DocumentId = ?", (int)$id);
		return $response ? $response[0] : null;
	}


	private function ByDepartment($departmentId) {
		return $this->db->exec("SELECT * FROM Document WHERE DepartmentId = ? 
									ORDER BY CASE WHEN Status = '".(int)FILE_DELETED."' THEN '1'
												  WHEN Status = '".(int)FILE_UNMANAGED."' THEN '2'
												  ELSE '3' END ASC", (int)$departmentId);
	}


	private function ByDepartmentNotManaged($departmentId) {
		return $this->db->exec("SELECT * FROM Document 
								WHERE DepartmentId = :id AND (Status = :deleted OR Status = :unmanaged)",
								array(
									"id" => (int)$departmentId, 
									"deleted" => FILE_DELETED,
									"unmanaged" => FILE_UNMANAGED
									));
	}


	private function ByPackage($packageId) {
		return $this->db->exec("SELECT * FROM Document WHERE PackageId = ?", (int)$packageId);
	}


	public function getData($search = array()) {
		if (isset($search["type"])) {
			switch ($search["type"]) {
				case 'byId':
					if (isset($search["id"])) {
						return $this->ById($search["id"]);
					} else return null;

				case 'byDepartment':
					if (isset($search["departmentId"])) {
						return $this->ByDepartment($search["departmentId"]);
					} else return null;

				case 'byDepartmentNotManaged':
					if (isset($search["departmentId"])) {
						return $this->ByDepartmentNotManaged($search["departmentId"]);
					} else return null;

				case 'byPackage':
					if (isset($search["packageId"])) {
						return $this->ByPackage($search["packageId"]);
					} else return null;
				
				default: return null;
			}
		} else return null;
	}


	public function add($data = array()) {
		return $this->insert($data);
	}


	public function edit($data = array()) {
		return $this->update($data, array("DocumentId"));
	}


	public function remove($find = null) {
		return $this->delete($find, array("DocumentId"));
	}


	public function releaseDocument($data = array()) {
		if (!isset($data["DocumentId"])) 
			throw new \Exception("Field DocumentId not given");

		return $this->db->exec("UPDATE Document SET PackageId = NULL WHERE DocumentID = ?", (int)$data["DocumentId"]);
	}
}