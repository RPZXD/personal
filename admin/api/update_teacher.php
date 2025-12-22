<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header('Content-Type: application/json');
$response = [];

require_once '../../config/Database.php';
require_once '../../class/Teacher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $database = new Database_User();
    $db = $database->getConnection();

    // Get POST data with sanitization
    $Teach_id_old = htmlspecialchars(trim($_POST['editTeach_id_old'] ?? ''));
    $Teach_id = htmlspecialchars(trim($_POST['editTeach_id'] ?? ''));
    $password = trim($_POST['editPassword'] ?? '');
    $Teach_name = htmlspecialchars(trim($_POST['editTeach_name'] ?? ''));
    $Teach_sex = htmlspecialchars(trim($_POST['editTeach_sex'] ?? ''));
    $Teach_birth = htmlspecialchars(trim($_POST['editTeach_birth'] ?? ''));
    $Teach_phone = htmlspecialchars(trim($_POST['editTeach_phone'] ?? ''));
    $Teach_email = htmlspecialchars(trim($_POST['editTeach_email'] ?? ''));
    $Teach_addr = htmlspecialchars(trim($_POST['editTeach_addr'] ?? ''));
    $Teach_major = htmlspecialchars(trim($_POST['editTeach_major'] ?? ''));
    $Teach_position2 = htmlspecialchars(trim($_POST['editTeach_position2'] ?? ''));
    $Teach_HiDegree = htmlspecialchars(trim($_POST['editTeach_HiDegree'] ?? ''));
    $Teach_status = htmlspecialchars(trim($_POST['editTeach_status'] ?? ''));
    $role_person = htmlspecialchars(trim($_POST['editrole_person'] ?? ''));
    $Teach_class = htmlspecialchars(trim($_POST['editTeach_class'] ?? ''));
    $Teach_room = htmlspecialchars(trim($_POST['editTeach_room'] ?? ''));

    // Validate input
    if (empty($Teach_id_old) || empty($Teach_id) || empty($Teach_name)) {
        $response['success'] = false;
        $response['message'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
        echo json_encode($response);
        exit;
    }

    // Build update query
    try {
        $query = "UPDATE teacher SET 
                    Teach_id = :Teach_id, 
                    Teach_name = :Teach_name, 
                    Teach_sex = :Teach_sex,
                    Teach_birth = :Teach_birth,
                    Teach_phone = :Teach_phone,
                    Teach_email = :Teach_email,
                    Teach_addr = :Teach_addr,
                    Teach_major = :Teach_major, 
                    Teach_Position2 = :Teach_Position2,
                    Teach_HiDegree = :Teach_HiDegree,
                    Teach_class = :Teach_class, 
                    Teach_room = :Teach_room, 
                    Teach_status = :Teach_status, 
                    role_person = :role_person";
        
        // Only update password if provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password = :password";
        }
        
        $query .= " WHERE Teach_id = :Teach_id_old";

        $stmt = $db->prepare($query);
        
        // Bind all parameters
        $stmt->bindParam(':Teach_id', $Teach_id);
        $stmt->bindParam(':Teach_name', $Teach_name);
        $stmt->bindParam(':Teach_sex', $Teach_sex);
        $stmt->bindParam(':Teach_birth', $Teach_birth);
        $stmt->bindParam(':Teach_phone', $Teach_phone);
        $stmt->bindParam(':Teach_email', $Teach_email);
        $stmt->bindParam(':Teach_addr', $Teach_addr);
        $stmt->bindParam(':Teach_major', $Teach_major);
        $stmt->bindParam(':Teach_Position2', $Teach_position2);
        $stmt->bindParam(':Teach_HiDegree', $Teach_HiDegree);
        $stmt->bindParam(':Teach_class', $Teach_class);
        $stmt->bindParam(':Teach_room', $Teach_room);
        $stmt->bindParam(':Teach_status', $Teach_status);
        $stmt->bindParam(':role_person', $role_person);
        $stmt->bindParam(':Teach_id_old', $Teach_id_old);
        
        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password);
        }

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'อัปเดตข้อมูลครูเรียบร้อยแล้ว';
        } else {
            $response['success'] = false;
            $response['message'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
        }
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['success'] = false;
    $response['message'] = 'คำขอไม่ถูกต้อง';
}

echo json_encode($response);
?>
