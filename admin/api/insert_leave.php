<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

// Initialize Person class
$person = new Person($db);

// Get data from POST request
$data = [
    'tid' => isset($_POST['teacher']) ? $_POST['teacher'] : '',
    'status' => isset($_POST['status']) ? $_POST['status'] : '',
    'date_start' => isset($_POST['date_start']) ? $_POST['date_start'] : '',
    'date_end' => isset($_POST['date_end']) ? $_POST['date_end'] : '',
    'detail' => isset($_POST['detail']) ? $_POST['detail'] : '',
    'other_leave_type' => isset($_POST['other_leave_type']) ? $_POST['other_leave_type'] : ''
];

// Adjust year if greater than 3000
if (intval(substr($data['date_start'], 0, 4)) > 2500) {
    $data['date_start'] = (intval(substr($data['date_start'], 0, 4)) - 543) . substr($data['date_start'], 4);
}
if (intval(substr($data['date_end'], 0, 4)) > 2500) {
    $data['date_end'] = (intval(substr($data['date_end'], 0, 4)) - 543) . substr($data['date_end'], 4);
}

$response = ['success' => false, 'message' => ''];

if (!empty($data['tid']) && !empty($data['status']) && !empty($data['date_start']) && !empty($data['date_end'])) {
    try {
        if ($person->isLeavePeriodOverlapping($data['tid'], $data['date_start'], $data['date_end'])) {
            $response['message'] = 'ช่วงเวลาการลาทับซ้อนกับการลาที่มีอยู่แล้ว';
        } else {
            $result = $person->insertLeaveDetails($data);
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'เพิ่มรายละเอียดการลาเรียบร้อยแล้ว';
            } else {
                $response['message'] = 'ไม่สามารถเพิ่มรายละเอียดการลาได้';
            }
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องกรอกข้อมูลทุกช่อง';
}

echo json_encode($response);
?>
