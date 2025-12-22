<?php

header('Content-Type: application/json');
$response = [];

require_once '../../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database_User();
    $db = $database->getConnection();

    // Get POST data with sanitization
    $Teach_id = htmlspecialchars(trim($_POST['addTeach_id'] ?? ''));
    $password = trim($_POST['addPassword'] ?? '');
    $Teach_name = htmlspecialchars(trim($_POST['addTeach_name'] ?? ''));
    $Teach_sex = htmlspecialchars(trim($_POST['addTeach_sex'] ?? ''));
    $Teach_birth = htmlspecialchars(trim($_POST['addTeach_birth'] ?? ''));
    $Teach_phone = htmlspecialchars(trim($_POST['addTeach_phone'] ?? ''));
    $Teach_email = htmlspecialchars(trim($_POST['addTeach_email'] ?? ''));
    $Teach_addr = htmlspecialchars(trim($_POST['addTeach_addr'] ?? ''));
    $Teach_major = htmlspecialchars(trim($_POST['addTeach_major'] ?? ''));
    $Teach_position2 = htmlspecialchars(trim($_POST['addTeach_position2'] ?? ''));
    $Teach_HiDegree = htmlspecialchars(trim($_POST['addTeach_HiDegree'] ?? ''));
    $Teach_class = htmlspecialchars(trim($_POST['addTeach_class'] ?? '0'));
    $Teach_room = htmlspecialchars(trim($_POST['addTeach_room'] ?? '0'));
    $Teach_status = htmlspecialchars(trim($_POST['addTeach_status'] ?? '1'));
    $role_person = htmlspecialchars(trim($_POST['addrole_std'] ?? 'T'));

    // Validate input
    if (empty($Teach_id) || empty($password) || empty($Teach_name)) {
        $response['success'] = false;
        $response['message'] = 'กรุณากรอกข้อมูลที่จำเป็น (Username, รหัสผ่าน, ชื่อ-นามสกุล)';
        echo json_encode($response);
        exit;
    }

    try {
        // Check if ID already exists
        $checkQuery = "SELECT Teach_id FROM teacher WHERE Teach_id = :teach_id";
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->bindParam(':teach_id', $Teach_id);
        $checkStmt->execute();
        
        if ($checkStmt->rowCount() > 0) {
            $response['success'] = false;
            $response['message'] = 'รหัสผู้ใช้นี้มีอยู่ในระบบแล้ว';
            echo json_encode($response);
            exit;
        }

        // Hash password using bcrypt
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $query = "INSERT INTO teacher 
                  SET Teach_id = :Teach_id,
                      password = :password,
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

        $stmt = $db->prepare($query);
        $stmt->bindParam(':Teach_id', $Teach_id);
        $stmt->bindParam(':password', $hashed_password);
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

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'เพิ่มข้อมูลครูเรียบร้อยแล้ว';
        } else {
            $response['success'] = false;
            $response['message'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล';
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

