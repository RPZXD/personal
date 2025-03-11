<?php

include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

$id = $_POST['id'];

if ($person->deleteLeaveById($id)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'ไม่สามารถลบรายละเอียดการลาได้']);
}
?>
