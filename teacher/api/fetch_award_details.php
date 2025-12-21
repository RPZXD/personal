<?php
require_once "../../config/Database.php";
header('Content-Type: application/json');
require_once "../../class/Person.php";

$response = array('success' => false, 'details' => array(), 'message' => '');

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

// Get parameters from request
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id)) {
    try {
        $details = $person->getAwardDetailsById($id);

        if ($details) {
            $response['success'] = true;
            $response['details'] = $details;
        } else {
            $response['message'] = 'ไม่พบรายละเอียดรางวัลสำหรับรหัสที่กำหนด';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องมีรหัสรางวัล';
}

echo json_encode($response);
?>
