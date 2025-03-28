<?php
include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

$tid = $_GET['tid'];

$current_date = date('Y-m-d');
$year = date('Y');

// ตรวจสอบว่าเป็นครึ่งปีแรก (1 ต.ค. - 31 มี.ค.) หรือครึ่งปีหลัง (1 เม.ย. - 30 ก.ย.)
if ($current_date >= "$year-04-01" && $current_date <= "$year-09-30") {
    // ครึ่งปีหลัง (1 เม.ย. - 30 ก.ย.)
    $start_date = "$year-04-01";
    $end_date = "$year-09-30";
} else {
    // ครึ่งปีแรก (1 ต.ค. - 31 มี.ค.)
    if ($current_date >= "$year-01-01" && $current_date <= "$year-03-31") {
        // กรณีเดือน ม.ค. - มี.ค. ต้องใช้ปีที่แล้วเป็นปีเริ่มของช่วง ต.ค. - มี.ค.
        $start_date = ($year - 1) . "-10-01";
        $end_date = "$year-03-31";
    } else {
        $start_date = "$year-10-01";
        $end_date = ($year + 1) . "-03-31";
    }
}

$data = $person->getChartLeavesByTeacherIdAndDateRange($tid, $start_date, $end_date);

echo json_encode($data);
?>
