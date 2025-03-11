<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Homeroom class
$person = new Person($db);

// Get parameters from request
$tid = isset($_GET['tid']) ? $_GET['tid'] : '';
$term = isset($_GET['term']) && $_GET['term'] !== 'all' ? $_GET['term'] : '';
$year = isset($_GET['year']) && $_GET['year'] !== 'all' ? $_GET['year'] : '';

$response = array('success' => false, 'total_hours' => 0, 'total_minutes' => 0, 'message' => '');

if (!empty($tid)) {
    try {
        $total = $person->getTotalHoursAndMinutes($tid, $term, $year);

        if ($total) {
            $response['success'] = true;
            $response['total_hours'] = $total['total_hours'];
            $response['total_minutes'] = $total['total_minutes'];
        } else {
            $response['message'] = 'ไม่พบชั่วโมงการฝึกอบรมสำหรับเกณฑ์ที่กำหนด';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องมีรหัสครู';
}

echo json_encode($response);
?>
