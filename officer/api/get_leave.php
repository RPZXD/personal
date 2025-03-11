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
    $response = array(
        "success" => true,
        "data" => $leaveDetails
    );
    echo json_encode($response);
} else {
    echo json_encode(array("success" => false, "message" => "ไม่พบข้อมูล"));
}
?>