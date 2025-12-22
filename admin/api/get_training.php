<?php
include_once("../../config/Database.php");
include_once("../../class/Person.php");

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

$id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id)) {
    echo json_encode(array("success" => false, "message" => "ต้องระบุรหัสการอบรม"));
    exit;
}

$training = $person->getTrainingById($id);

if ($training) {
    $response = array(
        "success" => true,
        "data" => $training
    );
    echo json_encode($response);
} else {
    echo json_encode(array("success" => false, "message" => "ไม่พบข้อมูลการอบรม"));
}
?>
