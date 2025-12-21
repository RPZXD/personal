<?php
require_once "../../config/Database.php";
header('Content-Type: application/json');
require_once "../../class/Person.php";

$response = array('success' => false, 'message' => '');

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

// Get parameters from request
$id = isset($_POST['id']) ? $_POST['id'] : '';

if (!empty($id)) {
    try {
        $result = $person->deleteAwardById($id);
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'ลบรายละเอียดรางวัลเรียบร้อยแล้ว';
        } else {
            $response['message'] = 'ไม่สามารถลบรายละเอียดรางวัลได้';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องกรอกข้อมูลที่จำเป็น';
}

echo json_encode($response);
?>
