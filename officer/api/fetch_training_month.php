<?php
include_once("../../config/Database.php");
include_once("../../class/Person.php");
include_once("../../class/Teacher.php");

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

$connectDBuser = new Database_User();
$teacherDb = $connectDBuser->getConnection();

// Initialize Person and Teacher classes
$person = new Person($db);
$teacher = new Teacher($teacherDb);

// Get parameters from request
$month = isset($_GET['month']) ? $_GET['month'] : die();

$trainSummary = $person->getTrainingByMonth($month);

if ($trainSummary) {
    foreach ($trainSummary as &$train) { // Use reference to modify the original array
        $teacherData = $teacher->getTeacherById2($train['tid']);
        if (is_array($teacherData) && isset($teacherData[0]['Teach_name'])) {
            $train['teacher_name'] = $teacherData[0]['Teach_name'];
            $train['teacher_department'] = $teacherData[0]['Teach_major'];
        } else {
            $train['teacher_name'] = "Unknown";
            $train['teacher_department'] = "Unknown";
        }
    }
    unset($train); // Break the reference with the last element

    // Sort the trainSummary by teacher_department
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
