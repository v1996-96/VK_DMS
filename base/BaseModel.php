<?php

abstract class BaseModel
{	
	// Fat Free instance
	protected $f3 = null;

	// PDO instance
	protected $db = null;

	// List of required fields
	protected $required = array();

	// List of optional fields
	protected $optional = array();

	// Name of db entity (table)
	protected $entity = "";

	/**
	 * Get list of required fields
	 * @return array
	 */
	public function getRequired(){
		return $this->required;
	}


	/**
	 * Get list of optional fields
	 * @return array
	 */
	public function getOptional(){
		return $this->optional;
	}



	/**
	 * Insert record into DB
	 * @param  array  $data             
	 * @param  array  $additionalFields 
	 * @return bool                   
	 */
	protected function insert($data, $additionalFields = array()){
		$dataNeeded = array();
		$givenOptional = array();

		$required = $this->checkForExistance($this->required, $data);
		$additional = $this->checkForExistance($additionalFields, $data);
		$optional = $this->getExisting($this->optional, $data, $givenOptional);

		$dataNeeded = array_merge($required, $optional, $additional);
		$fields = array_merge($this->required, $givenOptional, $additionalFields);

		$fNames = implode(", ", $fields);
		$fValues = ":" . implode(", :", $fields);

		return $this->db->exec('INSERT INTO '.$this->entity.' ('.$fNames.') VALUES ('.$fValues.')', $dataNeeded);
	}



	/**
	 * Update record in DB
	 * @param  array $data             
	 * @param  array $conditionFields  
	 * @param  array  $additionalFields 
	 * @return bool                   
	 */
	protected function update($data, $conditionFields, $additionalFields = array()){
		$dataNeeded = array();
		$givenOptional = array();

		$required = $this->checkForExistance($this->required, $data);
		$additional = $this->checkForExistance($additionalFields, $data);
		$optional = $this->getExisting($this->optional, $data, $givenOptional);

		$dataNeeded = array_merge($required, $optional, $additional);
		$fields = array_merge($this->required, $givenOptional, $additionalFields);

		$this->clearArray($fields, $conditionFields);

		$fieldsList = $this->getQueryString($fields);
		$conditionFieldsList = $this->getQueryString($conditionFields);

		return $this->db->exec('UPDATE '.$this->entity.' SET '.$fieldsList.' WHERE '.$conditionFieldsList, $data);
	}



	/**
	 * Delete record from DB
	 * @param  array $data            
	 * @param  array $conditionFields 
	 * @return bool                  
	 */
	protected function delete($data, $conditionFields){
		$dataNeeded = $this->checkForExistance($conditionFields, $data);

		$conditionFieldsList = $this->getQueryString($conditionFields);

		return $this->db->exec('DELETE FROM '.$this->entity.' WHERE '.$conditionFieldsList, $dataNeeded);
	}




	protected function checkForExistance($list, $data){
		$output = array();
		foreach ($list as $value) {
			if (!isset($data[ $value ])) {
				throw new \Exception("Fields were not specified in given array");
			} else {
				$output[ $value  ] = $data[ $value ];
			}
		}
		return $output;
	}

	protected function getExisting($list, $data, &$listOfExisting){
		$output = array();
		foreach ($list as $value) {
			if (isset($data[ $value ])) {
				$output[ $value ] = $data[ $value ];
				$listOfExisting[] = $value;
			}
		}
		return $output;
	}

	protected function clearArray(&$given, $deleting){
		foreach ($deleting as $d) {
			if (in_array($d, $given)) {
				unset( $given[ array_search( $d, $given ) ] );
			}
		}	
	}

	protected function getQueryString($array){
		$array = array_map(function($el){
			return $el . " = :" . $el;
		}, $array);
		return implode(", ", $array);
	}
}