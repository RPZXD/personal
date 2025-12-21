<?php
/**
 * Public Award Summary API
 * Returns aggregate award data for all teachers.
 */
include_once("../config/Database.php");
include_once("../class/Person.php");
include_once("../class/Teacher.php");

// Initialize database connection
$connectDB = new Database_Person();
$db = $connectDB->getConnection();

$connectDBuser = new Database_User();
$teacherDb = $connectDBuser->getConnection();

// Initialize Person and Teacher classes
$person = new Person($db);
$teacher = new Teacher($teacherDb);

// Get parameters from request
$term = isset($_GET['term']) ? $_GET['term'] : 'all';
$year = isset($_GET['year']) ? $_GET['year'] : 'all';

$query = "SELECT tid, award, level, term, year, department, certificate, date1 FROM tb_award WHERE 1=1";
$params = [];

if ($term !== 'all' && !empty($term)) {
    $query .= " AND term = :term";
    $params[':term'] = $term;
}
if ($year !== 'all' && !empty($year)) {
    $query .= " AND year = :year";
    $params[':year'] = $year;
}
$query .= " ORDER BY date1 DESC";

$stmt = $db->prepare($query);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->execute();
$awards = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($awards) {
    foreach ($awards as &$item) {
        $teacherData = $teacher->getTeacherById2($item['tid']);
        if (is_array($teacherData) && isset($teacherData[0]['Teach_name'])) {
            $item['teacher_name'] = $teacherData[0]['Teach_name'];
            $item['teacher_major'] = $teacherData[0]['Teach_major'];
        } else {
            $item['teacher_name'] = "Unknown";
            $item['teacher_major'] = "Unknown";
        }
    }
    unset($item);

    $response = array(
        "success" => true,
        "data" => $awards
    );
    echo json_encode($response);
} else {
    echo json_encode(array("success" => true, "data" => array()));
}
?>
