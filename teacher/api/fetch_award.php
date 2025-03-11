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

$response = array('success' => false, 'data' => array(), 'message' => '');

if (!empty($tid)) {
    try {
        $persons = $person->getAwardsByTeacherId($tid, $term, $year);

        if ($persons) {
            $response['success'] = true;
            $response['data'] = $persons;
        } else {
            $response['message'] = 'ไม่พบรางวัลสำหรับภาคเรียนและปีการศึกษาที่กำหนด';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องมีรหัสครู';
}

echo json_encode($response);
?>
