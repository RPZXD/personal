<?php 
require_once('header.php');
session_start();
include_once("class/Utils.php");
$bs = new Bootstrap();

function redirectUser() {
    $roles = [
        'Teacher_login' => 'teacher/index.php',
        'Director_login' => 'director/index.php',
        'Group_leader_login' => 'groupleader/index.php',
        'Officer_login' => 'officer/index.php',
        'Admin_login' => 'admin/index.php',
        'Student_login' => 'student/index.php'
    ];

    foreach ($roles as $sessionKey => $redirectPath) {
        if (isset($_SESSION[$sessionKey])) {
            header("Location: $redirectPath");
            exit(); // Prevent further execution
        }
    }
}

redirectUser();
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php require_once('wrapper.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">

        <div class="container-fluid">

            <div class="row">
            <div class="col-md-6 mx-auto">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                <h2 class="text-center ">
                  ..:: ลงชื่อเข้าสู่ระบบ ::..</h2>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body text-center">
              <?php 

                include_once("config/Database.php");
                include_once("class/UserLogin.php");
                include_once("class/Utils.php");

                $connectDB = new Database_User();
                $db = $connectDB->getConnection();

                $user = new UserLogin($db);
                $bs = new Bootstrap();

                if (isset($_POST['signin'])) {
                    $username = filter_input(INPUT_POST, 'txt_username_email', FILTER_SANITIZE_STRING);
                    $password = filter_input(INPUT_POST, 'txt_password', FILTER_SANITIZE_STRING);

                    $allowed_roles = ['Admin', 'Teacher', 'Officer'];
                    $role = filter_input(INPUT_POST, 'txt_role', FILTER_SANITIZE_STRING);
                    
                    if (!in_array($role, $allowed_roles)) {
                        $role = 'Teacher'; // หรือค่าที่ปลอดภัยอื่นๆ
                    }

                    $user->setUsername($username);
                    $user->setPassword($password);

                    if ($user->userNotExists()) {
                        $sw2 = new SweetAlert2(
                            'ไม่มีชื่อผู้ใช้นี้',
                            'error',
                            'login.php' // Redirect URL
                        );
                        $sw2->renderAlert();
                    } else {
                        if ($user->verifyPassword()) {
                            $userRole = $user->getUserRole();
                            $allowedUserRoles = [
                                'Teacher' => ['T', 'ADM', 'VP', 'OF', 'DIR'],
                                'Officer' => ['ADM', 'OF'],
                                'Admin' => ['ADM']
                            ];
                            
                            if (in_array($userRole, $allowedUserRoles[$role])) {
                                $_SESSION[$role . '_login'] = $_SESSION['user'];

                                $sw2 = new SweetAlert2(
                                    'ลงชื่อเข้าสู่ระบบเรียบร้อย',
                                    'success',
                                    strtolower($role) . '/index.php' // Redirect URL
                                );
                                $sw2->renderAlert();
                            } else {
                                $sw2 = new SweetAlert2(
                                    'บทบาทผู้ใช้ไม่ถูกต้อง',
                                    'error',
                                    'login.php' // Redirect URL
                                );
                                $sw2->renderAlert();
                            } 
                        } else {
                            $sw2 = new SweetAlert2(
                                'พาสเวิร์ดไม่ถูกต้อง',
                                'error',
                                'login.php' // Redirect URL
                            );
                            $sw2->renderAlert();
                        }
                    }
                }
                ?>


                          
                    <div class="callout callout-success">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="form-horizontal my-5" method="POST">
                            <div class= "form-group">
                                <label for="username" class="col-sm-6 control-label">ชื่อผู้ใช้งาน</label>
                                <div class="col-sm-12">
                                    <input type="text" name="txt_username_email" class="form-control text-center" placeholder="กรุณากรอกชื่อผู้ใช้งาน...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-6 control-label">รหัสผ่าน</label>
                                <div class="col-sm-12">
                                    <input type="password" name="txt_password" class="form-control text-center" placeholder="กรุณากรอกรหัสผ่าน...">
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="role" class="col-sm-6 control-label">ประเภทผู้ใช้</label>
                                <div class="col-sm-12">
                                    <select class="form-control text-center" name="txt_role">
                                        <option value="Teacher" selected="selected">ครู</option>
                                        <option value="Officer">เจ้าหน้าที่</option>
                                        <!-- <option value="Director">ผู้บริหาร</option> -->
                                        <option value="Admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="signin" class="btn btn-primary form-control">เข้าสู่ระบบ</button>
                                </div>
                            </div>
                        </form>
                    </div>



                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>

                
        </div>
    </div><!-- /.container-fluid -->
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php require_once('footer.php');?>
</div>
<!-- ./wrapper -->


<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<?php require_once('script.php');?>
</body>
</html>
