<?php

defined('_EXECUTED') or die('Restricted access');

abstract class BaseView
{
	use CommonMethods;

	// Framework instance
	protected $f3 = null;

	// PDO instance
	protected $db = null;

	/**
	 * Template for view gateway
	 * @param  string $page Page name
	 * @param  object $f3   Fat free
	 */
	public abstract function ShowPage($page);


	/**
	 * Set some initial variables
	 * @param  string $page Page name
	 */
	public function PreparePage($page, $pageType){
		if (is_null($this->f3) || is_null($this->db)) 
			return false;

		$this->f3->set("_page_title", $page);
		$this->f3->set("_page_type", $pageType);
		$this->f3->set("_topLineColor", "white-bg");
		$this->f3->set("UserInfo", $this->GetUserInfo() );

		// Get company data and user rights relative to company
		if (isset($this->f3->get("PARAMS")["CompanyUrl"])) {
			$company = new \CompanyModel($this->f3);

			// Get company info
			$companyUrl = $this->f3->get("PARAMS")["CompanyUrl"];
			$companyData = $company->getData(array("type" => "byUrl", "url" => $companyUrl));
			$this->f3->set("CompanyData", $companyData);

			// Get user rights
			$userCompanyRights = $company->getData(array(
				"type" => "getUserRights", 
				"userId" => $this->GetUserInfo()["id"],
				"companyId" => $companyData["CompanyId"]));
			
			$this->f3->set("UserCompanyRights", $userCompanyRights);

			// Set common view locks
			$this->f3->mset(array(
				"CompanyRight_Edit" => in_array($userCompanyRights, array(USER_OWNER, USER_ADMIN)),
				"CompanyRight_Delete" => $userCompanyRights == USER_OWNER
				));
		}
	}
}