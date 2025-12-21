<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

$connectDB = new Database_Person();
$db = $connectDB->getConnection();
$person = new Person($db);

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'tid' => $_POST['tid'],
        'date_record' => $_POST['date_record'],
        'type' => $_POST['type'],
        'time_record' => $_POST['time_record'],
        'detail' => $_POST['detail'],
        'term' => $_POST['term'],
        'year' => $_POST['year']
    ];

    try {
        if ($person->insertLateEarly($data)) {
            $response['success'] = true;
            $response['message'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        } else {
            $response['message'] = 'ไม่สามารถบันทึกข้อมูลได้';
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
