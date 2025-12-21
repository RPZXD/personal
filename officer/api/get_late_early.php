<?php
require_once "../../config/Database.php";
require_once "../../class/Person.php";

$connectDB = new Database_Person();
$db = $connectDB->getConnection();
$person = new Person($db);

$id = isset($_GET['id']) ? $_GET['id'] : '';

$response = array('success' => false, 'data' => null);

if (!empty($id)) {
    try {
        $data = $person->getLateEarlyById($id);
        if ($data) {
            $response['success'] = true;
            $response['data'] = $data;
        } else {
            $response['message'] = 'Data not found';
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
} else {
    $response['message'] = 'ID is required';
}

echo json_encode($response);
?>
