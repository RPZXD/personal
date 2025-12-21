<?php

include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $awardid = $_POST['awardid'];
    $tid = $_POST['tid'];
    $award = $_POST['award'];
    $level = $_POST['level'];
    $date1 = $_POST['date1'];
    $term = $_POST['term'];
    $year = $_POST['year'];
    $department = $_POST['department'];
    $certificate = '';

    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/file_award/";
        $fileName = basename($_FILES['certificate']['name']);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['certificate']['tmp_name'], $targetFilePath)) {
            $certificate = $fileName;
        }
    }

    $result = $person->updateAwardDetails($awardid, $tid, $award, $level, $date1, $term, $year, $department, $certificate);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปเดตรายละเอียดรางวัลได้']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'วิธีการร้องขอไม่ถูกต้อง']);
}
?>
