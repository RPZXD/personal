<?php

header('Content-Type: application/json');
$response = [];

require_once '../../config/Database.php';
require_once '../../class/Teacher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database_User();
    $db = $database->getConnection();

    $teacher = new Teacher($db);

    // Set Teacher properties
    $teacher->Teach_id = isset($_POST['addTeach_id']) ? $_POST['addTeach_id'] : '';
    $teacher->Teach_password = isset($_POST['addTeach_pass']) ? $_POST['addTeach_pass'] : '';
    $teacher->Teach_name = isset($_POST['addTeach_name']) ? $_POST['addTeach_name'] : '';
    $teacher->Teach_major = isset($_POST['addTeach_major']) ? $_POST['addTeach_major'] : '';
    $teacher->Teach_class = isset($_POST['addTeach_class']) ? $_POST['addTeach_class'] : '';
    $teacher->Teach_position2 = isset($_POST['addTeach_position2']) ? $_POST['addTeach_position2'] : '';
    $teacher->Teach_room = isset($_POST['addTeach_room']) ? $_POST['addTeach_room'] : '';
    $teacher->Teach_status = isset($_POST['addTeach_status']) ? $_POST['addTeach_status'] : '';
    $teacher->role_std = isset($_POST['addrole_std']) ? $_POST['addrole_std'] : '';

    // Validate input
    if (empty($teacher->Teach_id) || empty($teacher->Teach_password) || empty($teacher->Teach_name)) {
        $response['success'] = false;
        $response['message'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
        echo json_encode($response);
        exit;
    }

    // Insert data into the database
    if ($teacher->create()) {
        $response['success'] = true;
        $response['message'] = 'เพิ่มข้อมูลครูเรียบร้อยแล้ว';
    } else {
        $response['success'] = false;
        $response['message'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'คำขอไม่ถูกต้อง';
}

echo json_encode($response);

?>
