<?php 
/**
 * Teacher Dashboard
 * Uses the new MVC layout with modern UI
 */
session_start();

include_once("../config/Database.php");
include_once("../class/UserLogin.php");
include_once("../class/Utils.php");
include_once("../class/Person.php");

// โหลด config
$config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);
$global = $config['global'];

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize UserLogin class
$user = new UserLogin($db);

// Fetch terms and pee
$term = $user->getTerm();
$pee = $user->getPee();

// Check login
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

// Fetch dashboard stats for current and previous year
$current_stats = $person->getDashboardStats($teacher_id, $pee);
$prev_pee = intval($pee) - 1;
$prev_stats = $person->getDashboardStats($teacher_id, $prev_pee);

$pageTitle = 'Dashboard';

// Render view with layout
$view = '../views/teacher/dashboard.php';
require '../views/layouts/teacher_app.php';
