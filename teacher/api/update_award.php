<?php
require_once "../../config/Database.php";
header('Content-Type: application/json');
require_once "../../config/Setting.php";
require_once "../../class/Person.php";

$response = array('success' => false, 'message' => '');

// Initialize database connection
$database = new Database_Person();
$db = $database->getConnection();

// Initialize Person class
$person = new Person($db);
$setting = new Setting();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $awardid = isset($_POST['awardid']) ? $_POST['awardid'] : '';
    $tid = isset($_POST['tid']) ? $_POST['tid'] : '';
    $award = isset($_POST['award']) ? $_POST['award'] : '';
    $level = isset($_POST['level']) ? $_POST['level'] : '';
    $date1 = isset($_POST['date1']) ? $_POST['date1'] : '';
    
    // Adjust year if greater than 2500
    if (intval(substr($date1, 0, 4)) > 2500) {
        $date1 = (intval(substr($date1, 0, 4)) - 543) . substr($date1, 4);
    }
    
    $term = isset($_POST['term']) ? $_POST['term'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $certificate = '';

    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] === UPLOAD_ERR_OK) {
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        $fileExtension = pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            $response['message'] = 'อนุญาติแค่ไฟล์ภาพเท่านั้น';
            echo json_encode($response);
            exit;
        }

        $targetDir = "../../uploads/file_award/";
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        $fileName = $tid . '_' . $date1 . '_' . $randomString . '.' . $fileExtension;
        $targetFilePath = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['certificate']['tmp_name'], $targetFilePath)) {
            $certificate = $fileName;
        } else {
            $response['message'] = 'ไม่สามารถอัปโหลดไฟล์ได้';
            echo json_encode($response);
            exit;
        }
    }

    if (!empty($awardid) && !empty($tid) && !empty($award)) {
        try {
            $result = $person->updateAwardDetails($awardid, $tid, $award, $level, $date1, $term, $year, $department, $certificate);
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'อัปเดตรายละเอียดรางวัลเรียบร้อยแล้ว';
            } else {
                $response['message'] = 'ไม่สามารถอัปเดตรายละเอียดรางวัลได้';
            }
        } catch (Exception $e) {
            $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'จำเป็นต้องกรอกข้อมูลที่จำเป็น';
    }
} else {
    $response['message'] = 'วิธีการร้องขอไม่ถูกต้อง';
}

echo json_encode($response);
?>
