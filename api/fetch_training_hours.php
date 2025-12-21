<?php
/**
 * Public Training Hours API
 * Returns total training hours and minutes for a teacher.
 * 
 * Parameters:
 * - tid: (optional) Teacher ID - if empty, returns total for all teachers
 * - term: (optional) Term number (1 or 2), or empty for all terms
 * - year: (optional) Academic year, or empty for all years
 * 
 * Response:
 * {
 *   "success": true,
 *   "total_hours": 24,
 *   "total_minutes": 30
 * }
 */
require_once "../config/Database.php";
require_once "../class/Person.php";

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

// Get parameters from request
$tid = isset($_GET['tid']) ? $_GET['tid'] : '';
$term = isset($_GET['term']) && $_GET['term'] !== 'all' ? $_GET['term'] : '';
$year = isset($_GET['year']) && $_GET['year'] !== 'all' ? $_GET['year'] : '';

$response = array('success' => false, 'total_hours' => 0, 'total_minutes' => 0, 'message' => '');

try {
    if (!empty($tid)) {
        // Get total for specific teacher
        $total = $person->getTotalHoursAndMinutes($tid, $term, $year);
    } else {
        // Get total for all teachers
        $total = $person->getAllTotalHoursAndMinutes($term, $year);
    }

    if ($total) {
        $response['success'] = true;
        $response['total_hours'] = $total['total_hours'];
        $response['total_minutes'] = $total['total_minutes'];
    } else {
        $response['success'] = true;
        $response['total_hours'] = 0;
        $response['total_minutes'] = 0;
        $response['message'] = 'ไม่พบชั่วโมงการฝึกอบรมสำหรับเกณฑ์ที่กำหนด';
    }
} catch (Exception $e) {
    $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
}

echo json_encode($response);
?>
