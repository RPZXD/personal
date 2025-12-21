<?php
/**
 * Login Page
 * Uses the new MVC layout with modern UI
 */
session_start();

// โหลด config
$config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);
$global = $config['global'];

// ตรวจสอบว่า login แล้วหรือยัง
$roles = [
    'Teacher_login' => 'teacher/index.php',
    'Officer_login' => 'officer/index.php',
    'Admin_login' => 'admin/index.php'
];

foreach ($roles as $sessionKey => $redirectPath) {
    if (isset($_SESSION[$sessionKey])) {
        header("Location: $redirectPath");
        exit();
    }
}

// เรียกใช้ LoginController
require_once __DIR__ . '/controllers/LoginController.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])) {
    $input_username = $_POST['username'] ?? '';
    $input_password = $_POST['password'] ?? '';
    $input_role = $_POST['role'] ?? 'Teacher';

    $controller = new LoginController();
    $error = $controller->login($input_username, $input_password, $input_role);
}

$pageTitle = 'เข้าสู่ระบบ';

// Render view with layout
ob_start();
require 'views/auth/login.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
?>

<?php if (isset($error) && $error !== 'success' && $error !== null) { ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'เข้าสู่ระบบไม่สำเร็จ',
    text: <?= json_encode($error) ?>,
    confirmButtonText: 'ปิด',
    confirmButtonColor: '#3085d6'
});
</script>
<?php } ?>

<?php if (isset($_GET['logout']) && $_GET['logout'] == '1') { ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'ออกจากระบบสำเร็จ',
    text: 'คุณได้ออกจากระบบเรียบร้อยแล้ว',
    confirmButtonText: 'ตกลง',
    confirmButtonColor: '#3085d6'
});
</script>
<?php } ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($error) && $error === 'success') { 
    $controller = new LoginController();
    $redirect = $controller->getRedirectUrl($_POST['role'] ?? 'Teacher');
?>
<script>
Swal.fire({
    icon: 'success',
    title: 'เข้าสู่ระบบสำเร็จ',
    text: 'กำลังเข้าสู่ระบบ...',
    showConfirmButton: false,
    timer: 1500
}).then(() => {
    window.location.href = <?= json_encode($redirect) ?>;
});
</script>
<?php } ?>
