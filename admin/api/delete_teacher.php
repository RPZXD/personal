<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header('Content-Type: application/json');
$response = [];

require_once '../../config/Database.php'; // Adjust this path according to your setup
require_once '../../class/Teacher.php';  // This file contains the Teacher class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $database = new Database();
    $db = $database->getConnection();

    // Initialize the Teacher object
    $teacher = new Teacher($db);

    // Get the ID from POST data
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

    // Validate ID
    if (empty($id)) {
        $response['success'] = false;
        $response['message'] = 'Invalid ID';
        echo json_encode($response);
        exit;
    }

    // Set Teacher ID
    $teacher->Teach_id = $id;

    // Attempt to delete the teacher
    try {
        if ($teacher->delete()) {
            $response['success'] = true;
            $response['message'] = 'Record deleted successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to delete the record';
        }
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = 'Error: ' . $e->getMessage();
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
