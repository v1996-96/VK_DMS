<?php

namespace Auth;

defined("_EXECUTED") or die("Restricted access");

trait RegistrationTrait
{
	protected function ProcessRegistration() {
		$user = new \UserModel($this->f3);

		$errors = array();
		$fields = array("name", "surname", "email", "pwd", "pwdRepeat");

		// Check field existance
		foreach ($fields as $fName)
			if (!isset($_POST[ $fName ]))
				$errors[] = "Поле " . $fName . " не определено";
		
		// Throw if there are errors
		if (count($errors) > 0) {
			$this->f3->set("registration_error", implode("<br>", $errors));
			return;
		}



		// Check name
		if (!preg_match("/^[а-яА-Яa-z]{1,}$/iu", $_POST["name"])) {
			$errors[] = "Неверное имя";
		}

		// Check surname
		if (!preg_match("/^[а-яА-Яa-z]{1,}$/iu", $_POST["surname"])) {
			$errors[] = "Неверная фамилия";
		}

		// Check email
		if (!preg_match("/^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i", $_POST["email"])) {
			$errors[] = "Неверный email";
		}

		// Check passwords
		if ($_POST["pwd"] !== $_POST["pwdRepeat"]) {
			$errors[] = "Пароли не совпадают";
		}

		// Hash password
		$_POST["pwd"] = $this->auth->_hash( $_POST["pwd"] );

		// Throw if there are errors
		if (count($errors) > 0) {
			$this->f3->set("registration_error", implode("<br>", $errors));
			return;
		}



		// Is email unique
		if (!($resp = $user->getData(array("type" => "isEmailUnique", "email" => $_POST["email"]))) ) {
			$errors[] = "Введенный email зарегистрирован в системе. ";
		}

		// Throw if there are errors
		if (count($errors) > 0) {
			$this->f3->set("registration_error", implode("<br>", $errors));
			return;
		}



		// Add user to DB
		$data = array();
		$fieldComparison = array(
			'name' => 'Name', 'surname' => 'Surname',
			'email' => 'Email', 'pwd' => 'Password',
			'VK_Avatar' => 'VK_Avatar'
			);
		$additionalData = array(
			'Role' => 0,
			'VK' => (int)$_POST["userId"],
			"DateRegistered" => date("Y-m-d H:i:s")
			);

		foreach ($fieldComparison as $key => $value) {
			$data[ $value ] = htmlspecialchars($_POST[ $key ]);
		}
		foreach ($additionalData as $key => $value) {
			$data[ $key ] = $value;
		}

		try {
			$newUserId = $user->add($data);

			if (is_null($newUserId)) {
				throw new \Exception("Ошибка регистрации");
			}
		} catch (\Exception $e) {
			$errors[] = $e->getMessage();
		}

		// Throw if there are errors
		if (count($errors) > 0) {
			$this->f3->set("registration_error", implode("<br>", $errors));
			return;
		}
	}
}