<?php
/**
 * Teacher Profile Controller (data_teacher.php)
 */

session_start();

include_once("../config/Database.php");
include_once("../config/Setting.php");
include_once("../class/UserLogin.php");
include_once("../class/Utils.php");
include_once("../class/Person.php");

// Initialize settings
$setting = new Setting();

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


// Fetch position and academic details
$position = $person->getPositionById($userData['Teach_Position']);
$academic = $person->getAcademicById($userData['Teach_Academic']);

// Fetch lists for the edit modal
$positions = $person->getAllPositions();
$academics = $person->getAllAcademics();
$majors = $user->getAllMajors();

// Convert birth date to Thai format
$thaiBirthDate = Utils::convertToThaiDate($userData['Teach_birth']);

// Page settings
$title = "ข้อมูลครู - " . $userData['Teach_name'];
$page = "data_teacher";
$view = "../views/teacher/profile.php";

// Render view via layout
require_once "../views/layouts/teacher_app.php";
?>
