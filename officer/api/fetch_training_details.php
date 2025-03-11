<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Homeroom class
$person = new Person($db);

// Get parameters from request
$id = isset($_GET['id']) ? $_GET['id'] : '';

$response = array('success' => false, 'details' => array(), 'message' => '');

if (!empty($id)) {
    try {
        $details = $person->getTrainingDetailsById($id);

        if ($details) {
            $response['success'] = true;
            $response['details'] = $details;
        } else {
            $response['message'] = 'ไม่พบรายละเอียดการฝึกอบรมสำหรับรหัสที่กำหนด';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องมีรหัสการฝึกอบรม';
}

echo json_encode($response);
?>
