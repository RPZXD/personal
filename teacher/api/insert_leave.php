<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";
require_once "../../class/UserLogin.php";

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

$connectDBuser = new Database_User();
$teacherDb = $connectDBuser->getConnection();
// Initialize Person class
$person = new Person($db);
// Initialize UserLogin class
$teacher = new UserLogin($teacherDb);



function sendLineNotifyMessage($accessToken, $message) {
    $url = 'https://notify-api.line.me/api/notify';
    
    $headers = array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer ' . $accessToken
    );
    
    $data = array(
        'message' => $message
    );
    
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false
    );
    
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    
    $response = curl_exec($curl);
    $error = curl_error($curl);
    
    curl_close($curl);
    
    if ($error) {
    } else {
    }
}

function DateThai($strDate) {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

// Get data from POST request
$data = [
    'tid' => isset($_POST['tid']) ? $_POST['tid'] : '',
    'status' => isset($_POST['status']) ? $_POST['status'] : '',
    'date_start' => isset($_POST['date_start']) ? $_POST['date_start'] : '',
    'date_end' => isset($_POST['date_end']) ? $_POST['date_end'] : '',
    'detail' => isset($_POST['detail']) ? $_POST['detail'] : '',
    'other_leave_type' => isset($_POST['other_leave_type']) ? $_POST['other_leave_type'] : ''
];

// Fetch teacher data
$teacherData = $teacher->userData($data['tid']);

$statusText = '';
switch ($data['status']) {
    case '1':
        $statusText = 'ลาป่วย';
        break;
    case '2':
        $statusText = 'ลากิจ';
        break;
    case '3':
        $statusText = 'ไปราชการ';
        break;
    case '4':
        $statusText = 'ลาคลอด';
        break;
    case '9':
        $statusText = $data['other_leave_type'];
        break;
    // Add more cases as needed
    default:
        $statusText = '';
        break;
}

// Adjust year if greater than 3000
if (intval(substr($data['date_start'], 0, 4)) > 2500) {
    $data['date_start'] = (intval(substr($data['date_start'], 0, 4)) - 543) . substr($data['date_start'], 4);
}
if (intval(substr($data['date_end'], 0, 4)) > 2500) {
    $data['date_end'] = (intval(substr($data['date_end'], 0, 4)) - 543) . substr($data['date_end'], 4);
}

$message = "📢 (แจ้งการลา/ไปราชการของบุคลากร) \n"
. "👤 ชื่อ: " . $teacherData['Teach_name'] . "\n"
. "📚 กลุ่มสาระ: " . $teacherData['Teach_major'] . "\n"
. "📞 เบอร์โทร: " . $teacherData['Teach_phone'] . "\n"
. "📋 แจ้ง: " . $statusText . "\n"
. "📝 เหตุผล: " . $data['detail'] . "\n"
. "📅 ตั้งแต่วันที่: " . DateThai($data['date_start']) . " ถึงวันที่: " . DateThai($data['date_end']);

$response = ['success' => false, 'message' => ''];

if (!empty($data['tid']) && !empty($data['status']) && !empty($data['date_start']) && !empty($data['date_end'])) {
    try {
        if ($person->isLeavePeriodOverlapping($data['tid'], $data['date_start'], $data['date_end'])) {
            $response['message'] = 'ช่วงเวลาการลาทับซ้อนกับการลาที่มีอยู่แล้ว';
        } else {
            $result = $person->insertLeaveDetails($data);
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'เพิ่มรายละเอียดการลาเรียบร้อยแล้ว';
                
                // $accessToken = 'gcnrtipxst3eESLWC3Sf29NMOOw9ESqMS0c0xZUAqcA';
                $accessToken = '58u62JYCRrFsX94Mewxh0yLqzphbF8zEzqLGBs3wtCB';
                sendLineNotifyMessage($accessToken, $message);
            } else {
                $response['message'] = 'ไม่สามารถเพิ่มรายละเอียดการลาได้';
            }
        }
    } catch (Exception $e) {
        $response['message'] = 'ข้อผิดพลาด: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'จำเป็นต้องกรอกข้อมูลทุกช่อง';
}

echo json_encode($response);
?>
