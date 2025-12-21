<?php
require_once "../../config/Database.php";
header('Content-Type: application/json');
require_once "../../class/Person.php";

$response = array('success' => false, 'message' => '');

// Initialize database connection
$database = new Database_Person();
$db = $database->getConnection();

// Initialize Person class
$person = new Person($db);

// Get parameters from request
$id = isset($_POST['id']) ? $_POST['id'] : '';

if (!empty($id)) {
    try {
        if ($person->deleteLeaveById($id)) {
            $response['success'] = true;
            $response['message'] = 'ลบรายละเอียดการลาเรียบร้อยแล้ว';
        } else {
            $response['message'] = 'ไม่สามารถลบรายละเอียดการลาได้';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องระบุรหัสการลา';
}

echo json_encode($response);
?>
