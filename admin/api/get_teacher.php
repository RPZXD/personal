<?php
// Include the database connection and user class file
require_once '../../config/Database.php'; // Adjust this path according to your setup
require_once '../../class/Teacher.php'; // This file contains the User class

// Create an instance of Database_User
$database = new Database_User();
$db = $database->getConnection();

// Check if connection was successful
if ($db === null) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Sanitize and validate the teacher number from the request
$teach_id = isset($_GET['teacher_id']) ? filter_var($_GET['teacher_id'], FILTER_SANITIZE_SPECIAL_CHARS) : null;

if (!$teach_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid teacher number provided']);
    exit();
}

try {
    // Create an instance of the User class
    $user = new Teacher($db);

    // Fetch teacher details by teacher ID
    $teachers = $user->getTeacherById($teach_id);

    if (!empty($teachers)) {
        $teacherDetails = $teachers[0]; // Assuming getTeacherById returns an array
        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($teacherDetails);
    } else {
        echo json_encode(['error' => 'Teacher not found']);
    }
} catch (Exception $e) {
    // Handle any errors
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
