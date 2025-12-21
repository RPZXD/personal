<?php

include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['id']) && !empty($data['teacher']) && !empty($data['status']) && !empty($data['date_start']) && !empty($data['date_end'])) {
        $data['tid'] = $data['teacher'];
        $data['other_leave_type'] = isset($data['other_leave_type']) ? $data['other_leave_type'] : '';

        // Adjust year if greater than 3000 (Thai Buddhist year handling)
        if (intval(substr($data['date_start'], 0, 4)) > 2500) {
            $data['date_start'] = (intval(substr($data['date_start'], 0, 4)) - 543) . substr($data['date_start'], 4);
        }
        if (intval(substr($data['date_end'], 0, 4)) > 2500) {
            $data['date_end'] = (intval(substr($data['date_end'], 0, 4)) - 543) . substr($data['date_end'], 4);
        }

        $result = $person->updateLeaveDetails($data);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'ไม่สามารถบันทึกการแก้ไขได้']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
