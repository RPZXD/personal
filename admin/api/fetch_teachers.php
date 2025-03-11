<?php
require_once "../../config/Database.php";
require_once "../../class/UserLogin.php";

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize UserLogin class
$user = new UserLogin($db);

// Get department from request
$department = isset($_GET['department']) ? $_GET['department'] : '';

$response = array('success' => false, 'data' => array(), 'message' => '');

if (!empty($department)) {
    try {
        $query = "SELECT Teach_id, Teach_name FROM teacher WHERE Teach_major = :department AND Teach_status = '1' ORDER BY Teach_id ASC";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':department', $department);
        $stmt->execute();
        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($teachers) {
            $response['success'] = true;
            $response['data'] = $teachers;
        } else {
            $response['message'] = 'ไม่พบข้อมูลครูในกลุ่มที่เลือก';
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'ต้องระบุกลุ่ม';
}

echo json_encode($response);
?>
