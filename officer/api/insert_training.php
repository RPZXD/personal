<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

// Get parameters from request
$tid = isset($_POST['tid']) ? $_POST['tid'] : '';
$topic = isset($_POST['topic']) ? $_POST['topic'] : '';
$dstart = isset($_POST['dstart']) ? $_POST['dstart'] : '';
$dend = isset($_POST['dend']) ? $_POST['dend'] : '';
// Adjust year if greater than 3000
if (intval(substr($dstart, 0, 4)) > 2500) {
    $dstart = (intval(substr($dstart, 0, 4)) - 543) . substr($dstart, 4);
}
if (intval(substr($dend, 0, 4)) > 2500) {
    $dend = (intval(substr($dend, 0, 4)) - 543) . substr($dend, 4);
}
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
    $uploadDir = '../uploads/seminar/';
    $uploadFile = $uploadDir . $newFileName;
    if (move_uploaded_file($_FILES['sdoc']['tmp_name'], $uploadFile)) {
        $sdoc = $newFileName;
    } else {
        $response['message'] = 'ไม่สามารถอัปโหลดไฟล์ได้';
        echo json_encode($response);
        exit;
    }
}

$response = array('success' => false, 'message' => '');

if (!empty($tid) && !empty($topic) && !empty($dstart) && !empty($dend) && !empty($term) && !empty($year)) {
    try {
        $insert = $person->insertTrainingDetails($tid, $topic, $dstart, $dend, $term, $year, $supports, $place, $hours, $mn, $numday, $types, $budget, $sdoc, $know, $way, $suggest);

        if ($insert) {
            $response['success'] = true;
            $response['message'] = 'เพิ่มรายละเอียดการฝึกอบรมเรียบร้อยแล้ว';
        } else {
            $response['message'] = 'ไม่สามารถเพิ่มรายละเอียดการฝึกอบรมได้';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องกรอกข้อมูลที่จำเป็น';
}

echo json_encode($response);
?>
