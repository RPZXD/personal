<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

$connectDB = new Database_Person();
$db = $connectDB->getConnection();
$person = new Person($db);

$tid = isset($_GET['tid']) ? $_GET['tid'] : '';
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : '';
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : '';

$response = array('success' => false, 'data' => array());

try {
    $data = $person->getAllLateEarly($tid, $date_start, $date_end);
    $response['success'] = true;
    $response['data'] = $data;
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
