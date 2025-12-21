<?php 

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

if (isset($_SESSION['Admin_login'])) {
    $userid = $_SESSION['Admin_login'];
    $userData = $user->userData($userid);
} elseif (isset($_SESSION['Officer_login'])) {
    $userid = $_SESSION['Officer_login'];
    $userData = $user->userData($userid);
} else {
    $sw2 = new SweetAlert2(
        'คุณยังไม่ได้เข้าสู่ระบบ',
        'error',
        '../login.php' // Redirect URL
    );
    $sw2->renderAlert();
    exit;
}

// Initialize database connection for Person
$connectDBPerson = new Database_Person();
$dbPerson = $connectDBPerson->getConnection();

// Initialize Person class
$person = new Person($dbPerson);

// Fetch distinct years from tb_seminar
$years = $person->getDistinctYears();

$pageTitle = 'สรุปชั่วโมงการอบรม';
$view = '../views/admin/training_summary.php';
require '../views/layouts/admin_app.php';
?>
