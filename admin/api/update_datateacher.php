<?php
session_start();

include_once("../../config/Database.php");
include_once("../../class/Teacher.php");

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize Teacher class
$teacher = new Teacher($db);

// Get POST data
$Teach_id = $_POST['teachId'];
$Teach_name = $_POST['teachName'];
$Teach_major = $_POST['teachMajor'];
$Teach_phone = $_POST['teachPhone'];
$Teach_addr = $_POST['teachAddr'];
$Teach_email = $_POST['teachEmail'];
$Teach_Position = $_POST['teachPosition'];
$Teach_Academic = $_POST['teachAcademic'];
$Teach_HiDegree = $_POST['teachHiDegree'];

// Handle file upload
$Teach_photo = null;
if (isset($_FILES['teachPhoto']) && $_FILES['teachPhoto']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../../../stdcare/teacher/uploads/phototeach/';
    $uploadFile = $uploadDir . $Teach_id . '.' . pathinfo($_FILES['teachPhoto']['name'], PATHINFO_EXTENSION);
    if (move_uploaded_file($_FILES['teachPhoto']['tmp_name'], $uploadFile)) {
        $Teach_photo = basename($uploadFile);
    }
}

// Update teacher data
$response = [];
if ($teacher->update_person($Teach_id, $Teach_name, $Teach_major, $Teach_phone, $Teach_addr, $Teach_email, $Teach_Position, $Teach_Academic, $Teach_HiDegree, $Teach_photo)) {
    $response['success'] = true;
    $response['message'] = "ข้อมูลครูถูกอัปเดตเรียบร้อยแล้ว";
} else {
    $response['success'] = false;
    $response['message'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูลครู";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
