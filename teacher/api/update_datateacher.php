<?php
session_start();

include_once("../../config/Database.php");
include_once("../../config/Setting.php");
include_once("../../class/Teacher.php");

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize Teacher class
$teacher = new Teacher($db);
$setting = new Setting();

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
    $file_tmp = $_FILES['teachPhoto']['tmp_name'];
    $file_ext = pathinfo($_FILES['teachPhoto']['name'], PATHINFO_EXTENSION);
    $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
    $new_filename = $Teach_id . "_" . $randomString . "." . $file_ext; // ตั้งชื่อไฟล์ให้เป็น ID ครู

    // ส่งไฟล์ไปยัง API ปลายทาง
    $upload_url = "https://std.phichai.ac.th/teacher/api/upload_api.php";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $upload_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            "photo" => new CURLFile($file_tmp, $_FILES['teachPhoto']['type'], $new_filename)
        ]
    ]);

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    if ($response && $response['status'] === 'success') {
        $Teach_photo = $new_filename;
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
