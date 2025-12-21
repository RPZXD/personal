<?php
/**
 * Public Training API
 * Returns training records for a teacher, filtered by term and year.
 * 
 * Parameters:
 * - tid: (optional) Teacher ID - if empty, returns all training records
 * - term: (optional) Term number (1 or 2), or empty for all terms
 * - year: (optional) Academic year, or empty for all years
 * 
 * Response:
 * {
 *   "success": true,
 *   "data": [
 *     {
 *       "semid": 1,
 *       "topic": "การอบรมหลักสูตร...",
 *       "supports": "สพฐ.",
 *       "dstart": "2024-05-15",
 *       "hours": 6,
 *       "mn": 30,
 *       "term": 1,
 *       "year": 2567,
 *       "sdoc": "certificate.jpg"
 *     },
 *     ...
 *   ]
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

$response = array('success' => false, 'data' => array(), 'message' => '');

try {
    if (!empty($tid)) {
        // Get training for specific teacher
        $trainings = $person->getTrainingByTeacherId($tid, $term, $year);
    } else {
        // Get all training records with filters
        $trainings = $person->getAllTrainingRecords($term, $year);
    }

    if ($trainings) {
        $response['success'] = true;
        $response['data'] = $trainings;
    } else {
        $response['success'] = true;
        $response['data'] = array();
        $response['message'] = 'ไม่พบการฝึกอบรมสำหรับภาคเรียนและปีการศึกษาที่กำหนด';
    }
} catch (Exception $e) {
    $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
}

echo json_encode($response);
?>
