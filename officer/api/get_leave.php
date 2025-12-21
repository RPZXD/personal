<?php
include_once("../../config/Database.php");
include_once("../../class/Person.php");

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

$id = isset($_GET['id']) ? $_GET['id'] : die();
$leaveDetails = $person->getLeaveById($id);

if ($leaveDetails) {
    // Also fetch teacher department for easier UI handling
    // Note: teacher table is in phichaia_student database (Database_User)
    $tid = $leaveDetails['Teach_id'];
    $connectUser = new Database_User();
    $dbUser = $connectUser->getConnection();
    $stmt = $dbUser->prepare("SELECT Teach_major FROM teacher WHERE Teach_id = :tid");
    $stmt->execute([':tid' => $tid]);
    $dept = $stmt->fetchColumn();
    $leaveDetails['Teach_major'] = $dept;

    $response = array(
        "success" => true,
        "data" => $leaveDetails
    );
    echo json_encode($response);
} else {
    echo json_encode(array("success" => false, "message" => "ไม่พบข้อมูล"));
}
?>