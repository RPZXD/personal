<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header('Content-Type: application/json');
$response = [];

require_once '../../config/Database.php'; // Adjust this path according to your setup
require_once '../../class/Teacher.php';  // This file contains the Teacher class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $database = new Database_User();
    $db = $database->getConnection();

    // Initialize the Teacher object
    $teacher = new Teacher($db);

    // Set Teacher properties from POST data with sanitization
    $teacher->Teach_id_old = htmlspecialchars(trim($_POST['editTeach_id_old'] ?? ''));
    $teacher->Teach_id = htmlspecialchars(trim($_POST['editTeach_id'] ?? ''));
    $teacher->Teach_password = htmlspecialchars(trim($_POST['editTeach_pass'] ?? ''));
    $teacher->Teach_name = htmlspecialchars(trim($_POST['editTeach_name'] ?? ''));
    $teacher->Teach_major = htmlspecialchars(trim($_POST['editTeach_major'] ?? ''));
    $teacher->Teach_position2 = htmlspecialchars(trim($_POST['editTeach_position2'] ?? ''));
    $teacher->Teach_status = htmlspecialchars(trim($_POST['editTeach_status'] ?? ''));
    $teacher->role_person = htmlspecialchars(trim($_POST['editrole_person'] ?? ''));
    $teacher->Teach_class = htmlspecialchars(trim($_POST['editTeach_class'] ?? ''));
    $teacher->Teach_room = htmlspecialchars(trim($_POST['editTeach_room'] ?? ''));

    // Validate input
    if (empty($teacher->Teach_id_old) || empty($teacher->Teach_id) || empty($teacher->Teach_name)) {
        $response['success'] = false;
        $response['message'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
        echo json_encode($response);
        exit;
    }

    // Update teacher data in the database
    try {
        if ($teacher->updateDataTeacherPerson()) {
            $response['success'] = true;
            $response['message'] = 'อัปเดตข้อมูลครูเรียบร้อยแล้ว';
        } else {
            $response['success'] = false;
            $response['message'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
        }
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['success'] = false;
    $response['message'] = 'คำขอไม่ถูกต้อง';
}

echo json_encode($response);
?>
