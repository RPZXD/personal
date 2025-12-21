<?php
session_start();
header('Content-Type: application/json');

require_once "../../config/Database.php";
require_once "../../config/Setting.php";
require_once "../../class/Teacher.php";

$response = array('success' => false, 'message' => '');

// Check authentication
if (!isset($_SESSION['Teacher_login'])) {
    $response['message'] = 'คุณยังไม่ได้เข้าสู่ระบบ';
    echo json_encode($response);
    exit;
}

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize Teacher class
$teacher = new Teacher($db);
$setting = new Setting();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $Teach_id = isset($_POST['teachId']) ? $_POST['teachId'] : '';
    $Teach_name = isset($_POST['teachName']) ? $_POST['teachName'] : '';
    $Teach_major = isset($_POST['teachMajor']) ? $_POST['teachMajor'] : '';
    $Teach_phone = isset($_POST['teachPhone']) ? $_POST['teachPhone'] : '';
    $Teach_addr = isset($_POST['teachAddr']) ? $_POST['teachAddr'] : '';
    $Teach_email = isset($_POST['teachEmail']) ? $_POST['teachEmail'] : '';
    $Teach_Position = isset($_POST['teachPosition']) ? $_POST['teachPosition'] : '';
    $Teach_Academic = isset($_POST['teachAcademic']) ? $_POST['teachAcademic'] : '';
    $Teach_HiDegree = isset($_POST['teachHiDegree']) ? $_POST['teachHiDegree'] : '';

    if (empty($Teach_id) || empty($Teach_name)) {
        $response['message'] = 'รหัสครูและชื่อ-นามสกุลจำเป็นต้องระบุ';
        echo json_encode($response);
        exit;
    }

    // Handle file upload
    $Teach_photo = null;
    if (isset($_FILES['teachPhoto']) && $_FILES['teachPhoto']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['teachPhoto']['tmp_name'];
        $file_ext = pathinfo($_FILES['teachPhoto']['name'], PATHINFO_EXTENSION);
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        $new_filename = $Teach_id . "_" . $randomString . "." . $file_ext;

        // Remote upload using CURL
        $upload_url = "https://std.phichai.ac.th/teacher/api/upload_api.php";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $upload_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                "photo" => new CURLFile($file_tmp, $_FILES['teachPhoto']['type'], $new_filename)
            ]
        ]);

        $remote_res = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if ($remote_res && $remote_res['status'] === 'success') {
            $Teach_photo = $new_filename;
        } else {
            $response['message'] = "ไม่สามารถอัปโหลดรูปภาพได้: " . (isset($remote_res['message']) ? $remote_res['message'] : 'Remote Error');
            echo json_encode($response);
            exit;
        }
    }

    // Update teacher data
    try {
        if ($teacher->update_person($Teach_id, $Teach_name, $Teach_major, $Teach_phone, $Teach_addr, $Teach_email, $Teach_Position, $Teach_Academic, $Teach_HiDegree, $Teach_photo)) {
            $response['success'] = true;
            $response['message'] = "ข้อมูลครูถูกอัปเดตเรียบร้อยแล้ว";
        } else {
            $response['message'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูลครูในฐานข้อมูล";
        }
    } catch (Exception $e) {
        $response['message'] = "ข้อผิดพลาด: " . $e->getMessage();
    }
} else {
    $response['message'] = 'วิธีการร้องขอไม่ถูกต้อง';
}

echo json_encode($response);
?>
