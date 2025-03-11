<?php

include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['id']) && !empty($data['status']) && !empty($data['date_start']) && !empty($data['date_end']) && !empty($data['detail'])) {
        $result = $person->updateLeaveDetails($data);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update leave details.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Incomplete data.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
