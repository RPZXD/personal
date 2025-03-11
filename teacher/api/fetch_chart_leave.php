<?php
include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

$tid = $_GET['tid'];
$term = $_GET['term'] ?? '';
$year = $_GET['year'] - 543 ?? '';


if ($term == 1 ) {
    $date_start = $year . '-05-01';
    $date_end = $year . '-10-31';
} else if ($term == 2) {
    $date_start = $year . '-11-01';
    $date_end = ($year + 1) . '-04-30';
} else {
    $date_start = $year . '-05-01';
    $date_end = ($year + 1) . '-04-30';
}

// echo $date_start;
// echo '<br>';
// echo $date_end;


$data = $person->getChartLeavesByTeacherIdAndDateRange($tid, $date_start, $date_end);

echo json_encode($data);
?>
