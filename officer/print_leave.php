<?php
// Title: Print Leave Details

session_start();

include_once("../config/Database.php");
include_once("../class/Person.php");
include_once("../class/UserLogin.php");
include_once("../class/Utils.php");
require_once __DIR__ . '/../teacher/vendor/autoload.php';

// Initialize database connection for Person
$connectDBPerson = new Database_Person();
$dbPerson = $connectDBPerson->getConnection();

// Initialize Person class
$person = new Person($dbPerson);

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $leaveDetails = $person->getLeaveDetailsById($id);

    if ($leaveDetails) {
        $teacher_id = $leaveDetails['Teach_id'];
        $status = $leaveDetails['status'];
        $date_start = $leaveDetails['date_start'];
        $date_end = $leaveDetails['date_end'];
        $detail = $leaveDetails['detail'];
        $other_leave_type = $leaveDetails['other_leave_type']; // Add this line
    } else {
        echo "ไม่พบข้อมูลการแจ้งลา";
        exit;
    }
} else {
    echo "ไม่พบข้อมูลการแจ้งลา";
    exit;
}

// Initialize UserLogin class
$user = new UserLogin($db);
$userData = $user->userData($teacher_id);

$position = $person->getPositionById($userData['Teach_Position']);
$academic = $person->getAcademicById($userData['Teach_Academic']);

if (isset($_SESSION['Officer_login'])) {
    $userid = $_SESSION['Officer_login'];
} else {
    $sw2 = new SweetAlert2(
        'คุณยังไม่ได้เข้าสู่ระบบ',
        'error',
        '../login.php' // Redirect URL
    );
    $sw2->renderAlert();
    exit;
}


function getThaiMonth($monthNumber) {
    $thaiMonths = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม'
    ];
    return $thaiMonths[$monthNumber];
}
function getLeaveStatusText($status, $other_leave_type = '') {
    switch ($status) {
        case '1':
            return 'ลาป่วย';
        case '2':
            return 'ลากิจส่วนตัว';
        case '3':
            return 'ไปราชการ';
        case '9':
            return $other_leave_type ; // Update this line
        default:
            return 'ไม่ระบุ';
    }
}

function PositionTrue($status) {
    switch ($status) {
        case '1':
            return '<div style="position:absolute;top:255px;left:106px;width: 570px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;font-weight: bold;">/</div></div>';
        case '2':
            return '<div style="position:absolute;top:280px;left:106px;width: 570px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;font-weight: bold;">/</div></div>';
        case '3':
            return '';
        case '4':
            return '<div style="position:absolute;top:305px;left:106px;width: 570px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;font-weight: bold;">/</div></div>';
        case '9':
            return '<div style="position:absolute;top:330px;left:106px;width: 570px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;font-weight: bold;">/</div></div>';
        default:
            return '';
    }
}
$sb = '&nbsp;';
$officer = 'นางสาวธีรัฉรา&nbsp;&nbsp;ปลิวทอง';
$director = 'นางนภาศรี&nbsp;&nbsp;สว่างแสง';
$headpersonal = 'นางสาวสุรัตน์&nbsp;&nbsp;ปานศักดิ์';

$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 16,
    'default_font' => 'sarabun'
]);

$mpdf->SetTitle('ใบ' . getLeaveStatusText($status, $other_leave_type) . 'ของ'. $userData['Teach_name'] . ' วันที่ ' . date('j') . ' เดือน ' . getThaiMonth(date('n')) . ' พ.ศ. ' . (date('Y') + 543));

// <div style="position:absolute;top:685px;left:350px;width: 400px; height: 90px; text-align: center;">
// <div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;font-weight: bold;">ความเห็นของหัวหน้ากลุ่มบริหารงานบุคคล</div></div>

// logo && header
$html = '<div style="position:absolute;top:40px;left:180px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;font-weight: bold;">แบบใบลาป่วย ลาคลอดบุตร ลากิจส่วนตัว ลาบวช</div></div>';

$html .= '<div style="position:absolute;top:70px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">เขียนที่............โรงเรียนพิชัย............</div></div>';

$html .= '<div style="position:absolute;top:100px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">วันที่.......' . date('j') . '.......เดือน.......' . getThaiMonth(date('n')) . '.......พ.ศ.' . (date('Y') + 543) . '.......</div></div>';


// Replace spaces with dots in the teacher's name
$teacher_name_with_dots = str_replace(' ', '..', $userData['Teach_name']);
$teacher_addr_with_dots = str_replace(' ', '..', $userData['Teach_addr']);

// Convert dates to Thai format
$date_start_thai = Utils::convertToThaiDatePlus($date_start);
$date_end_thai = Utils::convertToThaiDatePlus($date_end);

// Calculate total leave days
$date_start_obj = new DateTime($date_start);
$date_end_obj = new DateTime($date_end);
$total_leave = $date_start_obj->diff($date_end_obj)->days + 1; // Including the start date

// รายละเอียดดการลา 
$html .= '<div style="position:absolute;top:135px;left:50px;width: 570px; height: 35px;  bold;text-align: left;">
            <div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">
            เรื่อง&nbsp;&nbsp;ขออนุญาต' . getLeaveStatusText($status, $other_leave_type) . '
            </div>
            </div>
            ';

$html .= '<div style="position:absolute;top:165px;left:50px;width: 570px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">เรียน&nbsp;&nbsp;ผู้อำนวยการโรงเรียนพิชัย</div></div>';

$html .= '<div style="position:absolute;top:195px;left:90px;width: 570px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">ข้าพเจ้า..............' . $teacher_name_with_dots . '.............&nbsp;&nbsp;ตำแหน่ง.............' . $position;
if ($position == 'ครู') {
    $html .= $academic;
}
$html .= '............</div></div>';

$html .= '<div style="position:absolute;top:225px;left:50px;width: 570px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">สังกัด&nbsp;&nbsp; สำนักงานเขตพื้นที่การศึกษามัธยมศึกษาพิษณุโลก&nbsp;&nbsp;อุตรดิตถ์&nbsp;&nbsp;กระทรวงศึกษาธิการ</div></div>';

$html .= '<div style="position:absolute;top:290px;left:50px;width: 570px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">ขอลา</div></div>';

$html .= '<div style="position:absolute;top:255px;left:100px;width: 570px; height: 35px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;"><input type="checkbox">&nbsp;&nbsp;ป่วย&nbsp;&nbsp;เนื่องจาก</div></div>';

$html .= '<div style="position:absolute;top:262px;left:230px;width: 800px; height: 35px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;">';
if ($status == '1') {
    $html .= $shortDetail = mb_strlen($detail, 'UTF-8') > 100 ? mb_substr($detail, 0, 100, 'UTF-8') . "..." : $detail;
} else {
    $html .= '..........................................................................................................';
}
$html .= '...</div></div>';

$html .= '<div style="position:absolute;top:280px;left:100px;width: 570px; height: 35px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;"><input type="checkbox">&nbsp;&nbsp;กิจส่วนตัว&nbsp;&nbsp;เนื่องจาก</div></div>';

$html .= '<div style="position:absolute;top:287px;left:260px;width: 800px; height: 35px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;">';
if ($status == '2') {
    $html .= $shortDetail = mb_strlen($detail, 'UTF-8') > 100 ? mb_substr($detail, 0, 100, 'UTF-8') . "..." : $detail;
} else {
    $html .= '.................................................................................................';
}
$html .= '...</div></div>';

$html .= '<div style="position:absolute;top:305px;left:100px;width: 570px; height: 35px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;"><input type="checkbox">&nbsp;&nbsp;คลอดบุตร</div></div>';

$html .= '<div style="position:absolute;top:330px;left:100px;width: 570px; height: 35px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;"><input type="checkbox">&nbsp;&nbsp;อื่น ๆ&nbsp;&nbsp;เนื่องจาก</div></div>';
$html .= '<div style="position:absolute;top:337px;left:240px;width: 800px; height: 35px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;">';
if ($status == '9') {
    $html .= $other_leave_type.'....' . $shortDetail = mb_strlen($detail, 'UTF-8') > 90 ? mb_substr($detail, 0, 90, 'UTF-8') . "..." : $detail;
} else {
    $html .= '........................................................................................................';
}
$html .= '</div></div>';

$html .= '<div style="position:absolute;top:360px;left:50px;width: 650px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">ตั้งแต่วันที่.......' . $date_start_thai . '.......ถึงวันที่.......' . $date_end_thai . '........มีกำหนด.......' . $total_leave . '.......วัน</div></div>';

$html .= '<div style="position:absolute;top:390px;left:50px;width: 650px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">ข้าพเจ้าได้ลา</div></div>';

$html .= '<div style="position:absolute;top:390px;left:150px;width: 650px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;"><input type="checkbox">&nbsp;&nbsp;ป่วย' . str_repeat($sb, 10) . '<input type="checkbox">&nbsp;&nbsp;กิจส่วนตัว' . str_repeat($sb, 10) . '<input type="checkbox">&nbsp;&nbsp;คลอดบุตร' . str_repeat($sb, 10). '<input type="checkbox">&nbsp;&nbsp;อื่นๆ' . str_repeat($sb, 10) . 'ครั้งสุดท้าย</div></div>';

$html .= '<div style="position:absolute;top:420px;left:50px;width: 650px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">เมื่อวันที่..............................................ถึงวันที่..............................................มีกำหนด........................วัน</div></div>';


$html .= '<div style="position:absolute;top:450px;left:50px;width: 750px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">ในระหว่างลา ติดต่อข้าพเจ้าได้ที่ บ้านเลขที่....'. $teacher_addr_with_dots . '.......</div></div>';

$html .= '<div style="position:absolute;top:480px;left:0px;left:50px;width: 750px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">เบอร์โทรศัพท์.....'. $userData['Teach_phone'] .'........</div></div>';

$html .= '<div style="position:absolute;top:505px;left:350px;width: 750px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">ขอแสดงความนับถือ</div></div>';

$html .= '<div style="position:absolute;top:560px;left:215px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">('. $userData['Teach_name'] .')</div></div>';

$html .= '<div style="position:absolute;top:580px;left:215px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">ตำแหน่ง...' . $position;
if ($position == 'ครู') {
    $html .= $academic;
}
$html .= '...</div></div>';

$html .= '<div style="position:absolute;top:605px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;font-weight: bold;">ความเห็นของหัวหน้ากลุ่มสาระ/หัวหน้างาน</div></div>';

$html .= '<div style="position:absolute;top:630px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">.........................................................................</div></div>';


$html .= '<div style="position:absolute;top:655px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">(ลงชื่อ)..............................................................</div></div>';

$html .= '<div style="position:absolute;top:680px;left:370px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">(.............................................................)</div></div>';

$html .= '<div style="position:absolute;top:705px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">ตำแหน่ง...........................................................</div></div>';

$html .= '<div style="position:absolute;top:730px;left:360px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">วันที่............./........................./.................</div></div>';

$html .= '<div style="position:absolute;top:755px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;font-weight: bold;">ความเห็นของหัวหน้ากลุ่มบริหารงานบุคคล</div></div>';

$html .= '<div style="position:absolute;top:780px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">.........................................................................</div></div>';

$html .= '<div style="position:absolute;top:805px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">(ลงชื่อ)..............................................................</div></div>';

$html .= '<div style="position:absolute;top:830px;left:360px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">('. $headpersonal .')</div></div>';

$html .= '<div style="position:absolute;top:855px;left:360px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">วันที่............./........................./.................</div></div>';

$html .= '<div style="position:absolute;top:880px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">ลงชื่อ.................................................ผู้ตรวจสอบ</div></div>';

$html .= '<div style="position:absolute;top:910px;left:210px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;font-weight: bold;text-decoration: underline;">คำสั่ง</div></div>';

$html .= '<div style="position:absolute;top:930px;left:320px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;font-weight: bold;"><input type="checkbox">อนุญาต&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox">ไม่อนุญาต</div></div>';

$html .= '<div style="position:absolute;top:955px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">.........................................................................</div></div>';

$html .= '<div style="position:absolute;top:980px;left:350px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">(ลงชื่อ)..............................................................</div></div>';

$html .= '<div style="position:absolute;top:1005px;left:360px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">('. $director .')</div></div>';

$html .= '<div style="position:absolute;top:1030px;left:360px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">ตำแหน่งรองผู้อำนวยการโรงเรียนพิชัย ปฏิบัติราชการแทน</div></div>';

$html .= '<div style="position:absolute;top:1055px;left:360px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">ผู้อำนวยการโรงเรียนพิชัย</div></div>';

$html .= '<div style="position:absolute;top:1080px;left:360px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">วันที่............./........................./.................</div></div>';




$html .= '<div style="position:absolute;top:670px;left:50px;width: 400px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;font-weight: bold;text-decoration: underline;">สถิติการลาในปีงบประมาณนี้</div></div>';

$html .= '<div style="position:absolute;top:695px;left:50px;width: 400px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;"><input type="radio">&nbsp;&nbsp;ช่วงครึ่งปีแรก (1 ต.ค.-31 มี.ค.)</div></div>';

$html .= '<div style="position:absolute;top:720px;left:50px;width: 400px; height: 90px; text-align: left;">
<div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;"><input type="radio">&nbsp;&nbsp;ช่วงครึ่งปีหลัง (1 เม.ย.-30 ก.ย.)</div></div>';

$html .= '<div style="position:absolute;top:750px;left:50px;width: 340px; height: 160px; text-align: left;">
    <div style="display: flex; justify-content: left; align-items: left; margin-top: 8px; margin-left: 15px;">
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <tr>
                <th style="padding: 5px;">ประเภทลา</th>
                <th style="padding: 5px;">ลามาแล้ว<br>(ครั้ง/วันทำการ)</th>
                <th style="padding: 5px;">ลาครั้งนี้<br>(ครั้ง/วันทำการ)</th>
                <th style="padding: 5px;">รวมเป็น<br>(ครั้ง/วันทำการ)</th>
            </tr>
            <tr>
                <td style="padding: 5px;">ป่วย</td>
                <td style="padding: 5px;"></td>
                <td style="padding: 5px;"></td>
                <td style="padding: 5px;"></td>
            </tr>
            <tr>
                <td style="padding: 5px;">กิจส่วนตัว</td>
                <td style="padding: 5px;"></td>
                <td style="padding: 5px;"></td>
                <td style="padding: 5px;"></td>
            </tr>
            <tr>
                <td style="padding: 5px;">คลอดบุตร</td>
                <td style="padding: 5px;"></td>
                <td style="padding: 5px;"></td>
                <td style="padding: 5px;"></td>
            </tr>
            <tr>
                <td style="padding: 5px;">ลาบวช/อื่นๆ</td>
                <td style="padding: 5px;"></td>
                <td style="padding: 5px;"></td>
                <td style="padding: 5px;"></td>
            </tr>
        </table>
    </div>
</div>';

$html .= '<div style="position:absolute;top:910px;left:0px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">(ลงชื่อ).........................................................ผู้ตรวจสอบ</div></div>';

$html .= '<div style="position:absolute;top:935px;left:-5px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">('. $officer .')</div></div>';

$html .= '<div style="position:absolute;top:960px;left:-5px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">เจ้าหน้าที่</div></div>';

$html .= '<div style="position:absolute;top:985px;left:0px;width: 400px; height: 90px; text-align: center;">
<div style="display: flex; justify-content: center; align-items: center;margin-top: 8px;margin-left: 15px;">วันที่............./........................./.................</div></div>';





$html .=  PositionTrue($status);

$mpdf->WriteHTML($html);
$mpdf->Output();
?>
