<?php

require_once("../../config/Database.php");
require_once("../../class/Teacher.php");
require_once("../../class/Utils.php");
require_once("../../vendor/autoload.php"); // Ensure this path is correct

use PhpOffice\PhpSpreadsheet\IOFactory;

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
    $fileTmpPath = $_FILES['excelFile']['tmp_name'];
    $spreadsheet = IOFactory::load($fileTmpPath);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    $connectDB = new Database_User();
    $db = $connectDB->getConnection();
    $teacher = new Teacher($db);

    foreach ($sheetData as $row) {
        if ($row['A'] !== 'username') { // Skip header row
            // Set Teacher properties
            $teacher->Teach_id = isset($row['A']) ? $row['A'] : null;
            $teacher->Teach_password = isset($row['B']) ? $row['B'] : null;
            $teacher->Teach_name = isset($row['C']) ? $row['C'] : null;
            $teacher->Teach_major = isset($row['D']) ? $row['D'] : null;
            $teacher->Teach_position2 = isset($row['E']) ? $row['E'] : null;
            $teacher->Teach_status = isset($row['F']) ? $row['F'] : null;
            $teacher->role_person = isset($row['G']) ? $row['G'] : null;
            $teacher->Teach_class = isset($row['H']) ? $row['H'] : null;
            $teacher->Teach_room = isset($row['I']) ? $row['I'] : null;

            // Log the values being set
            error_log("Teach_id: " . $teacher->Teach_id);
            error_log("Teach_password: " . $teacher->Teach_password);
            error_log("Teach_name: " . $teacher->Teach_name);
            error_log("Teach_major: " . $teacher->Teach_major);
            error_log("Teach_position2: " . $teacher->Teach_position2);
            error_log("Teach_status: " . $teacher->Teach_status);
            error_log("role_person: " . $teacher->role_person);
            error_log("Teach_class: " . $teacher->Teach_class);
            error_log("Teach_room: " . $teacher->Teach_room);

            // Ensure Teach_id is not null
            if ($teacher->Teach_id === null) {
                error_log("Teach_id is null for row: " . json_encode($row));
                continue; // Skip this row
            }

            // Insert data into the database
            $teacher->create();
        }
    }
    $response['success'] = true;
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
