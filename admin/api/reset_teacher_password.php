<?php
/**
 * Reset Teacher Password API
 * This API resets the password for a teacher with password hashing
 */
header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

require_once '../../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'คำขอไม่ถูกต้อง';
    echo json_encode($response);
    exit;
}

// Get POST data
$teacher_id = isset($_POST['teacher_id']) ? trim($_POST['teacher_id']) : '';
$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

// Validate input
if (empty($teacher_id)) {
    $response['message'] = 'กรุณาระบุรหัสครู';
    echo json_encode($response);
    exit;
}

if (empty($new_password) || strlen($new_password) < 4) {
    $response['message'] = 'รหัสผ่านต้องมีอย่างน้อย 4 ตัวอักษร';
    echo json_encode($response);
    exit;
}

try {
    // Database connection
    $database = new Database_User();
    $db = $database->getConnection();

    // Hash the new password using PASSWORD_DEFAULT (bcrypt)
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in database
    $query = "UPDATE teacher SET password = :password WHERE Teach_id = :teach_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':teach_id', $teacher_id);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'รีเซ็ทรหัสผ่านเรียบร้อยแล้ว';
        } else {
            $response['message'] = 'ไม่พบข้อมูลครูที่ต้องการ';
        }
    } else {
        $response['message'] = 'เกิดข้อผิดพลาดในการอัปเดตรหัสผ่าน';
    }
} catch (Exception $e) {
    $response['message'] = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
}

echo json_encode($response);
?>
