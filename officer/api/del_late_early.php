<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

$connectDB = new Database_Person();
$db = $connectDB->getConnection();
$person = new Person($db);

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (!empty($id)) {
        try {
            if ($person->deleteLateEarly($id)) {
                $response['success'] = true;
                $response['message'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            } else {
                $response['message'] = 'ไม่สามารถลบข้อมูลได้';
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
    } else {
        $response['message'] = 'ID is required';
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
