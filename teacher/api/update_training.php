<?php
require_once "../../config/Database.php";
header('Content-Type: application/json');
require_once "../../config/Setting.php";
require_once "../../class/Person.php";

$response = array('success' => false, 'message' => '');

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);
$setting = new Setting();

// Get parameters from request
$id = isset($_POST['semid']) ? $_POST['semid'] : '';
$tid = isset($_POST['tid']) ? $_POST['tid'] : '';
$topic = isset($_POST['topic']) ? $_POST['topic'] : '';
$dstart = isset($_POST['dstart']) ? $_POST['dstart'] : '';
$dend = isset($_POST['dend']) ? $_POST['dend'] : '';
$term = isset($_POST['term']) ? $_POST['term'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$supports = isset($_POST['supports']) ? $_POST['supports'] : '';
$place = isset($_POST['place']) ? $_POST['place'] : '';
$hours = isset($_POST['hours']) ? $_POST['hours'] : '';
$mn = isset($_POST['mn']) ? $_POST['mn'] : '';
$numday = isset($_POST['numday']) ? $_POST['numday'] : '';
$types = isset($_POST['types']) ? $_POST['types'] : '';
$budget = isset($_POST['budget']) ? $_POST['budget'] : '';
$know = isset($_POST['know']) ? $_POST['know'] : '';
$way = isset($_POST['way']) ? $_POST['way'] : '';
$suggest = isset($_POST['suggest']) ? $_POST['suggest'] : '';
$sdoc = '';

if (isset($_FILES['sdoc']) && $_FILES['sdoc']['error'] == 0) {
    $randomString = substr(md5(rand()), 0, 5);
    $newFileName = $tid . '-' . $dstart . '-' . $randomString . '.' . pathinfo($_FILES['sdoc']['name'], PATHINFO_EXTENSION);
    $uploadDir = $setting->getUploadDir_seminar();
    $uploadFile = $uploadDir . $newFileName;
    if (move_uploaded_file($_FILES['sdoc']['tmp_name'], $uploadFile)) {
        $sdoc = $newFileName;
    } else {
        $response['message'] = 'Failed to upload file.';
        echo json_encode($response);
        exit;
    }
}

if (!empty($id) && !empty($tid) && !empty($topic) && !empty($dstart) && !empty($dend) && !empty($term) && !empty($year)) {
    try {
        $update = $person->updateTrainingDetails($id, $tid, $topic, $dstart, $dend, $term, $year, $supports, $place, $hours, $mn, $numday, $types, $budget, $sdoc, $know, $way, $suggest);

        if ($update) {
            $response['success'] = true;
            $response['message'] = 'อัปเดตรายละเอียดการฝึกอบรมเรียบร้อยแล้ว';
        } else {
            $response['message'] = 'ไม่สามารถอัปเดตรายละเอียดการฝึกอบรมได้';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องกรอกข้อมูลที่จำเป็น';
}

echo json_encode($response);
?>
