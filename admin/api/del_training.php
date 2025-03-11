<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

// Get parameters from request
$id = isset($_POST['id']) ? $_POST['id'] : '';

$response = array('success' => false, 'message' => '');

if (!empty($id)) {
    try {
        $delete = $person->deleteTrainingById($id);

        if ($delete) {
            $response['success'] = true;
            $response['message'] = 'ลบรายละเอียดการฝึกอบรมเรียบร้อยแล้ว';
        } else {
            $response['message'] = 'ไม่สามารถลบรายละเอียดการฝึกอบรมได้';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องกรอกข้อมูลที่จำเป็น';
}

echo json_encode($response);
?>
