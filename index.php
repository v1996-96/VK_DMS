<?php

// Common constants
define("_EXECUTED", 1);
define("SITE_TITLE", "VKDMS");


// Database credentials
define("HOST", "localhost");
define("DB_LOGIN", "root");
define("DB_PWD", "");
define("DB", "vkdms");

// Framework instance
$f3 = require('lib/base.php');

// Get AuthPHP instance
$auth = require('base/AuthPHP/Base.php');

// Auth settings
$auth->iniConfig('base/AuthPHP/config.ini');
$auth->connect(HOST, DB, DB_LOGIN, DB_PWD);

// PDO instance
$db = new DB\SQL( 'mysql:host='.HOST.';port=3306;dbname='.DB, DB_LOGIN, DB_PWD );

// Initial settings
$f3->set('AUTOLOAD', 'controllers/; views/; models/; base/');
$f3->set('CACHE', FALSE);
$f3->set('DEBUG', 3);
$f3->set('UI', 'ui/');
$f3->set('db', $db);
$f3->set('auth', $auth);


/* ROUTES
 ************************************************/

// Authorization & registration & restore
$f3->route('GET|POST /', 'Auth\AuthController->Login');
$f3->route('GET|POST /registration', 'Auth\RegistrationController->Register');
$f3->route("GET|POST /logOut", "Auth\AuthController->LogOut");
$f3->route("GET|POST /lockscreen", "Auth\AuthController->Lockscreen");
$f3->route("GET|POST /checkStatus", "Auth\AuthController->CheckStatus");

// Companies page
$f3->route('GET|POST /companies', 'Companies\ListingController->Gateway');
$f3->route('GET|POST /@company/dashboard', 'Companies\DashboardController->Gateway');

// Employee
$f3->route('GET|POST /@company/employee', 'Employee\ListController->Gateway');
$f3->route('GET|POST /@company/employee/@EmployeeId', 'Employee\ProfileController->Gateway');

// Departments
$f3->route('GET|POST /@company/departments', 'Department\ListController->Gateway');
$f3->route('GET|POST /@company/departments/@DepartmentId', 'Department\DashboardController->Gateway');
$f3->route('GET|POST /@company/departments/@DepartmentId/documents', 'Department\DocumentsController->Gateway');

// Projects
$f3->route('GET|POST /@company/projects', 'Projects\ListController->Gateway');

// Documents
$f3->route('GET|POST /@company/documents', 'Documents\MainController->Gateway');


// $f3->set('ONERROR',
//     function($f3) {
//         switch($f3->get('ERROR.code')){
//         	case "404": 
//         		$f3->reroute("/404");
//         		break;

//         	default: 
//         		$f3->reroute("/500");
//         		break;
//         }
//     }
// );

$f3->run();