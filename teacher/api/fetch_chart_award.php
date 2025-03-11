<?php
include_once("../../config/Database.php");
include_once("../../class/Person.php");

$database = new Database_Person();
$db = $database->getConnection();

$person = new Person($db);

$tid = $_GET['tid'];
$term = $_GET['term'] ?? '';
$year = $_GET['year'] ?? '';


$data = $person->getChartAwardsByTeacherId($tid, $term, $year);

echo json_encode($data);
?>
