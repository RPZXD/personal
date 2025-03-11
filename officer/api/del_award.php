<?php

include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $result = $person->deleteAwardById($id);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถลบรางวัลได้']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'วิธีการร้องขอไม่ถูกต้อง']);
}
?>
