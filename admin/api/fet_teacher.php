<?php
// Include the database configuration and User class file
require_once '../../config/Database.php'; // Adjust this path according to your setup
require_once '../../class/Teacher.php'; // This file contains the User class

// Create an instance of the Database class
$database = new Database_User(); // Adjust this according to your Database class
$db = $database->getConnection();

// Check if connection was successful
if ($db === null) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Get the department from the request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    try {

        // Create an instance of the Subject class
        $teacher = new Teacher($db);

        // Fetch subjects based on Teach_id
        $teachers = $teacher->userTeacher();

        // Output data as JSON
        header('Content-Type: application/json');
        echo json_encode($teachers);

    } catch (Exception $e) {
        // Handle any errors
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    } else {
    // Teach_id is not provided
    http_response_code(400);
    echo json_encode(['error' => 'Teach_id is required']);
}
?>
