<?php
// Title: Print Leave Details

session_start();

include_once("../config/Database.php");
include_once("../class/Person.php");
include_once("../class/UserLogin.php");
include_once("../class/Utils.php");
require_once __DIR__ . '/vendor/autoload.php';

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
    $trainingDetails = $person->getTrainingDetailsById($id);

    if ($trainingDetails) {

    } else {
        echo "ไม่พบข้อมูลการอบรม";
        exit;
    }
} else {
    echo "ไม่พบข้อมูลการอบรม";
    exit;
}

// Initialize UserLogin class
$user = new UserLogin($db);
$userData = $user->userData($teacher_id);


if (isset($_SESSION['Teacher_login'])) {
    $userid = $_SESSION['Teacher_login'];
    $userData = $user->userData($userid);
} else {
    $sw2 = new SweetAlert2(
        'คุณยังไม่ได้เข้าสู่ระบบ',
        'error',
        '../login.php' // Redirect URL
    );
    $sw2->renderAlert();
    exit;
}

$teacherData = $user->userData($trainingDetails['tid']);

$position = $person->getPositionById($teacherData['Teach_Position']);
$academic = $person->getAcademicById($teacherData['Teach_Academic']);
$sb = '&nbsp;&nbsp;';

$mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 14,
	'default_font' => 'sarabun'
]);

$mpdf->SetTitle('แบบรายงานผลการประชุม/อบรม/สัมมนา/ศึกษาดูงานของ'.$teacherData['Teach_name']);


// logo && header
$html = '<div style="position:absolute;top:30px;left:370px;"><img src="../dist/img/logo-phicha.png" alt="" style="width:65px;height:65px;"></div>';
$html .= '<div style="position:absolute;top:90px;left:120px;width: 550px; height: 150px; border: 0px solid black;font-weight: bold;text-align: center;">
            <div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;font-size: 20px;">
            แบบรายงานผลการประชุม/อบรม/สัมมนา/ศึกษาดูงานของครู
            <br>และบุคลากรทางการศึกษา
            <br>โรงเรียนพิชัย อำเภอพิชัย จังหวัดอุตรดิตถ์
            <br>ประจำปีการศึกษา ' . $trainingDetails['year'] .
            '</div>
            </div>
            ';
$str_type[1] = 'ภายใน'; 
$str_type[2] = 'ภายนอก';

$html .= '<div style="position:absolute;top:230px;left:80px;width: 650px; height: 500px; border: 0px solid black;font-weight: bold;">
            <div style="display: flex; justify-content: left; align-items: left;margin-top: 8px;margin-left: 15px;">'
            .'ชื่อ : '. $sb . $teacherData['Teach_name']
            .'<br>ตำแหน่ง : '. $sb . $position . $sb . $sb . 'วิทยฐานะ : ' .$sb . $academic
            .'<br>กลุ่มสาระ : '. $sb . $teacherData['Teach_major'] = str_replace('คอมพิวเตอร์', 'วิทยาศาสตร์และเทคโนโลยี', $teacherData['Teach_major'])
            .'<br>ชื่อเรื่องการอบรม/สัมมนา : '. $sb . $trainingDetails['topic']
            .'<br>วันที่ : '. $sb . Utils::convertToThaiDatePlus($trainingDetails['dstart']).' - '.Utils::convertToThaiDatePlus($trainingDetails['dstart'])
            .'<br>ภาคเรียนที่ : '. $sb . $trainingDetails['term'].'/'. $trainingDetails['year']
            .'<br>สถานที่จัดอบรม/สัมมนา : '. $sb . $trainingDetails['place']
            .'<br>หน่วยงานที่จัดอบรม/สัมมนา : '. $sb . $trainingDetails['supports']
            .'<br>จำนวนชั่วโมงในการอบรม/สัมมนา : '. $sb . $trainingDetails['hours'] . $sb . 'ชั่วโมง' . $sb . $trainingDetails['mn'] . $sb . 'นาที'
            .'<br>จำนวนวันในการอบรม/สัมมนา : '. $sb . $trainingDetails['numday']
            .'<br>ประเภทการอบรม/สัมมนา : '. $sb . $str_type[$trainingDetails['types']]
            .'<br>งบประมาณที่ใช้ : '. $sb . number_format($trainingDetails['budget'], 2) . $sb . 'บาท'
            .'<br>สรุปความรู้ที่ได้รับ : '. $sb . $trainingDetails['know'] 
            .'<br>วิธีการ/แนวทาง ขยายผลให้ครู/บุคลากรในกลุ่มสาระฯ/ครูในโรงเรียน : '. $sb . $trainingDetails['way'] 
            .'<br>ข้อเสนอแนะเพิ่มเติม : '. $sb . $trainingDetails['suggest'] 
            .'</div>
            </div>
            ';


$html .= '<div style="position:absolute;top:760px;left:80px;width: 650px; height: 200px; border: 0px solid black;text-align: center;">
<img src="uploads/file_seminar/'. $trainingDetails['sdoc'] .'" alt="" style="width:auto;height:auto;"></div>';

$html .= '<div style="position:absolute;top:1000px;left:480px;width: 300px; height: 80px; border: 0px solid black;font-weight: bold;text-align: center;">
            <div style="display: flex; justify-content: left; align-items: left;margin-top: 10px;margin-left: 5px;">'
            .'ลงชื่อ'. str_repeat(".", 70)  
            .'<br>('. $teacherData['Teach_name'] .')'
            .'</div>
            </div>
            ';

$html .= '<div style="position:absolute;top:1060px;left:50px;width: 600px; height: 50px; border: 0px solid black;font-weight: bold;text-align: left;">
            <div style="display: flex; justify-content: left; align-items: left;margin-top: 10px;margin-left: 5px;">'
            .'หมายเหตุ การเข้าสัมมนาเชิงปฏิบัติการครั้งนี้เป็นครั้งที่ '. str_repeat(".", 8) . '/' .  str_repeat(".", 15)
            
            .'</div>
            </div>
            ';

$mpdf->WriteHTML($html);

$mpdf->Output();

?>
