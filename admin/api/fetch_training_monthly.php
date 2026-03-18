<?php
/**
 * Admin Monthly Training Summary API
 * Returns detailed training records for all teachers filtered by month.
 * 
 * Parameters:
 * - month: (required) Month in YYYY-MM format
 */
include_once("../../config/Database.php");
include_once("../../class/Person.php");
include_once("../../class/Teacher.php");

// Initialize database connections
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

$connectDBuser = new Database_User();
$teacherDb = $connectDBuser->getConnection();

// Initialize Person and Teacher classes
$person = new Person($db);
$teacher = new Teacher($teacherDb);

// Get month parameter
$month = isset($_GET['month']) ? $_GET['month'] : null;

if (!$month) {
    echo json_encode(["success" => false, "message" => "กรุณาระบุเดือน"]);
    exit;
}

// Fetch training records
$trainRecords = $person->getTrainingByMonthRecords($month);

if ($trainRecords) {
    foreach ($trainRecords as &$record) {
        $teacherData = $teacher->getTeacherById2($record['tid']);
        if (is_array($teacherData) && isset($teacherData[0]['Teach_name'])) {
            $record['teacher_name'] = $teacherData[0]['Teach_name'];
            $record['teacher_department'] = $teacherData[0]['Teach_major'];
        } else {
            $record['teacher_name'] = "ไม่พบชื่อครู";
            $record['teacher_department'] = "ไม่ระบุ";
        }
    }
    unset($record);

    // Initial sort by tid then dstart
    // Actually already ordered in SQL

    $response = [
        "success" => true,
        "data" => $trainRecords
    ];
    echo json_encode($response);
} else {
    echo json_encode(["success" => true, "data" => []]);
}
?>
