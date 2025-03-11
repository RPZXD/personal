<?php
header("Access-Control-Allow-Origin: *"); // อนุญาตให้ทุกโดเมนส่ง request มา
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$upload_dir = __DIR__ . "/../uploads/phototeach/"; // โฟลเดอร์ปลายทาง

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file_name = basename($_FILES['photo']['name']);
    $target_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)) {
        echo json_encode(["status" => "success", "message" => "Upload successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to upload file"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
