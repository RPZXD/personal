<?php
require_once "../../config/Database.php";
header('Content-Type: application/json');
require_once "../../class/Person.php";

$response = array('success' => false, 'data' => array(), 'message' => '');

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

// Get parameters from request
$tid = isset($_GET['tid']) ? $_GET['tid'] : '';
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : '';
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : '';

if (!empty($tid)) {
    try {
        $leaves = $person->getLeavesByTeacherIdAndDateRange($tid, $date_start, $date_end);

        if ($leaves) {
            // Ensure status is correctly fetched
            foreach ($leaves as &$leave) {
                $leave['status'] = (string)$leave['status'];
            }
            $response['success'] = true;
            $response['data'] = $leaves;
        } else {
            $response['message'] = 'ไม่พบข้อมูลการลาตามเกณฑ์ที่กำหนด';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'ต้องระบุรหัสครู';
}

echo json_encode($response);
?>
