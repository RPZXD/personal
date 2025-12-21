<?php 

session_start();


include_once("../config/Database.php");
include_once("../class/UserLogin.php");
include_once("../class/Utils.php");

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize UserLogin class
$user = new UserLogin($db);

// Fetch terms and pee
$term = $user->getTerm();
$pee = $user->getPee();

if (isset($_SESSION['Officer_login'])) {
    $userid = $_SESSION['Officer_login'];
    if (is_array($userid)) {
        $userid = $userid['Teach_id'];
    }
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

$pageTitle = 'หน้าหลัก';

// Render view with layout
$view = '../views/officer/dashboard.php';
require '../views/layouts/officer_app.php';
?>
