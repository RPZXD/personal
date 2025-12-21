<?php
/**
 * Public Training Summary API
 * Returns aggregate training hours data for all teachers.
 * 
 * Parameters:
 * - term: (optional) Term number (1 or 2), or empty for all terms
 * - year: (optional) Academic year, or empty for all years
 * 
 * Response:
 * {
 *   "success": true,
 *   "data": [
 *     {
 *       "tid": "T001",
 *       "total_hours": 24,
 *       "total_minutes": 30,
 *       "teacher_name": "นายสมชาย ใจดี",
 *       "teacher_department": "วิทยาศาสตร์"
 *     },
 *     ...
 *   ]
 * }
 */
include_once("../config/Database.php");
include_once("../class/Person.php");
include_once("../class/Teacher.php");

// Initialize database connections
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

$connectDBuser = new Database_User();
$teacherDb = $connectDBuser->getConnection();

// Initialize Person and Teacher classes
$person = new Person($db);
$teacher = new Teacher($teacherDb);

// Get parameters from request
$term = (isset($_GET['term']) && $_GET['term'] !== '') ? $_GET['term'] : 'all';
$year = (isset($_GET['year']) && $_GET['year'] !== '') ? $_GET['year'] : 'all';

// Fetch training summary data
$trainSummary = $person->getTotalHoursAndMinutesByTermAndYear($term, $year);

if ($trainSummary) {
    foreach ($trainSummary as &$train) {
        $teacherData = $teacher->getTeacherById2($train['tid']);
        if (is_array($teacherData) && isset($teacherData[0]['Teach_name'])) {
            $train['teacher_name'] = $teacherData[0]['Teach_name'];
            $train['teacher_department'] = $teacherData[0]['Teach_major'];
        } else {
            $train['teacher_name'] = "Unknown";
            $train['teacher_department'] = "Unknown";
        }
    }
    unset($train);

    // Sort by department
    usort($trainSummary, function($a, $b) {
        return strcmp($a['teacher_department'], $b['teacher_department']);
    });

    $response = array(
        "success" => true,
        "data" => $trainSummary
    );
    echo json_encode($response);
} else {
    echo json_encode(array("success" => true, "data" => array()));
}
?>
