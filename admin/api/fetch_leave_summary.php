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

$date = isset($_GET['date']) ? $_GET['date'] : die();
$leaveSummary = $person->getLeaveSummaryByDate($date);

if ($leaveSummary) {
    foreach ($leaveSummary as &$leave) {
        $teacherDetails = $teacher->getTeacherById($leave['Teach_id']);
        $leave['teacher_details'] = $teacherDetails;
    }
    $response = array(
        "success" => true,
        "data" => $leaveSummary
    );
    echo json_encode($response);
} else {
    echo json_encode(array("success" => true, "data" => array()));
}
?>
