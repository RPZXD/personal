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
$term = isset($_GET['term']) && $_GET['term'] !== 'all' ? $_GET['term'] : '';
$year = isset($_GET['year']) && $_GET['year'] !== 'all' ? $_GET['year'] : '';

if (!empty($tid)) {
    try {
        $persons = $person->getTrainingByTeacherId($tid, $term, $year);

        if ($persons) {
            $response['success'] = true;
            $response['data'] = $persons;
        } else {
            $response['message'] = 'ไม่พบการฝึกอบรมสำหรับภาคเรียนและปีการศึกษาที่กำหนด';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องมีรหัสครู';
}

echo json_encode($response);
?>
