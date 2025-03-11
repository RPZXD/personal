<?php

include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $awardDetails = $person->getAwardDetailsById($id);

    if ($awardDetails) {
        echo json_encode(['success' => true, 'details' => $awardDetails]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบรายละเอียดรางวัล']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'วิธีการร้องขอไม่ถูกต้อง']);
}
?>
