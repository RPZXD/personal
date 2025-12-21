<?php
/**
 * Awards Page (General Personnel)
 * Displays award records for the currently logged-in user.
 */
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("config/Database.php");
include_once("class/UserLogin.php");
include_once("class/Utils.php");
include_once("class/Person.php");

// Database Connections
$connectDB = new Database_User();
$db = $connectDB->getConnection();

$connectDBPerson = new Database_Person();
$dbPerson = $connectDBPerson->getConnection();

// Initialize Classes
$user = new UserLogin($db);
$person = new Person($dbPerson);

// Fetch Page Data
$years = $person->getDistinctYears();
$pee = $user->getPee();
$term = $user->getTerm();

// Page Configuration
$pageTitle = 'รางวัลและผลงาน';

// Render View
ob_start();
require 'views/general/awards.php';
$content = ob_get_clean();

require 'views/layouts/app.php';
?>
