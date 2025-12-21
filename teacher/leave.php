<?php
/**
 * Teacher Leave Controller
 */

session_start();
include_once("../config/Database.php");
include_once("../class/UserLogin.php");
include_once("../class/Utils.php");
include_once("../class/Person.php");

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize UserLogin class
$user = new UserLogin($db);

// Fetch terms and pee
$term = $user->getTerm();
$pee = $user->getPee();

if (isset($_SESSION['Teacher_login'])) {
    $userid = $_SESSION['Teacher_login'];
    // Support both old format (direct ID) and new format (array)
    if (is_array($userid)) {
        $userid = $userid['Teach_id'];
    }
    $userData = $user->userData($userid);
} else {
    header("Location: ../login.php");
    exit;
}


$teacher_id = $userData['Teach_id'];
$teacher_name = $userData['Teach_name'];


// Initialize database connection for Person
$connectDBPerson = new Database_Person();
$dbPerson = $connectDBPerson->getConnection();

// Initialize Person class
$person = new Person($dbPerson);

// Fetch distinct years from table_seminar
$years = $person->getDistinctYears();

// Page settings
$title = "รายงานการลา / ไปราชการ - " . $userData['Teach_name'];
$page = "leave";
$view = "../views/teacher/leave.php";

// Render view via layout
require_once "../views/layouts/teacher_app.php";
?>
