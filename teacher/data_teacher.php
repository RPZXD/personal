<?php 

session_start();


include_once("../config/Database.php");
include_once("../class/UserLogin.php");
include_once("../class/Utils.php");
include_once("../class/Person.php");

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize UserLogin class
$user = new UserLogin($db);

// Fetch terms and pee
$term = $user->getTerm();
$pee = $user->getPee();

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

// Initialize database connection for Person
$connectDBPerson = new Database_Person();
$dbPerson = $connectDBPerson->getConnection();

// Initialize Person class
$person = new Person($dbPerson);

// Fetch position and academic details
$position = $person->getPositionById($userData['Teach_Position']);
$academic = $person->getAcademicById($userData['Teach_Academic']);

// Fetch available positions and academic titles
$positions = $person->getAllPositions();
$academics = $person->getAllAcademics();

// Fetch available majors
$majors = $user->getAllMajors();

// Convert birth date to Thai format
$thaiBirthDate = Utils::convertToThaiDate($userData['Teach_birth']);

require_once('header.php');
?>

<body class="hold-transition sidebar-mini layout-fixed light-mode">
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
        <div class="col-sm-12 col-lg-4 col-md-9 mx-auto">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                <h2 class="text-center">
                  <i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;ข้อมูลครู</h2>
                </h3>
              </div>
              <!-- /.card-header -->
              <!-- Profile Image -->
            
            <!-- /.card -->

             

              <!-- /.card-body -->
            </div>

            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-rounded"
                       src="<?php echo $setting->getImgProfile().$userData['Teach_photo'];?>"
                       alt="<?php echo $userData['Teach_name'];?>" style="height:300px;width:auto;">
                </div>

                <h3 class="profile-username text-center mt-2"><?php echo $userData['Teach_name'];?></h3>

                <p class="text-muted text-center"><?php echo $userData['Teach_major'];?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;&nbsp;รหัสประจำตัวครู :</b> <a class="float-right"><?php echo $userData['Teach_id'];?></a>
                  </li>
                  <li class="list-group-item">
                    <b><i class="fa fa-venus-mars" aria-hidden="true"></i>&nbsp;&nbsp;เพศ :</b> <a class="float-right"><?php echo $userData['Teach_sex'];?></a>
                  </li>
                  <li class="list-group-item">
                    <b><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;ที่อยู่ :</b> <a class="float-right"><?php echo $userData['Teach_addr'];?></a>
                  </li>
                  <li class="list-group-item">
                    <b><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;วัน/เดือน/ปีเกิด :</b> <a class="float-right"><?php echo $thaiBirthDate;?></a>
                  </li>
                  <li class="list-group-item">
                    <b><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;ตำแหน่ง :</b> <a class="float-right"><?= $position;?></a>
                  </li>
                  <li class="list-group-item">
                    <b><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;วิทยฐานะ :</b> <a class="float-right"><?= $academic;?></a>
                  </li>
                  <li class="list-group-item">
                    <b><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;วุฒิการศึกษา (สูงสุด) :</b> <a class="float-right"><?= $userData['Teach_HiDegree'];?></a>
                  </li>
                  <li class="list-group-item">
                    <b><i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;&nbsp;เบอร์โทรศัพท์ :</b> <a class="float-right"><?= $userData['Teach_phone'];?></a>
                  </li>
                  <li class="list-group-item">
                    <b><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;E-Mail :</b> <a class="float-right"><?= $userData['Teach_email'];?></a>
                  </li>
                </ul>

                <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#editModal"><b>แก้ไขข้อมูล</b></button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php require_once('../footer.php');?>
</div>
<!-- ./wrapper -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลครู</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form to edit teacher data -->
                <form id="editTeacherForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="teachName">ชื่อ</label>
                        <input type="text" class="form-control" id="teachName" name="teachName" value="<?php echo $userData['Teach_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="teachMajor">สาขา</label>
                        <select class="form-control" id="teachMajor" name="teachMajor" required>
                            <?php foreach ($majors as $major): ?>
                                <option value="<?= $major['Teach_major']; ?>" <?= $major['Teach_major'] == $userData['Teach_major'] ? 'selected' : ''; ?>><?= $major['Teach_major']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teachAddr">ที่อยู่ <span class="text-danger">ตัวอย่าง 9/9 หมู่ 3 ตำบลในเมือง อำเภอพิชัย จังหวัดอุตรดิตถ์</span></label>
                        <input type="text" class="form-control" id="teachAddr" name="teachAddr" value="<?php echo $userData['Teach_addr']; ?>" required >
                    </div>
                    <div class="form-group">
                        <label for="teachPhone">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" id="teachPhone" name="teachPhone" value="<?php echo $userData['Teach_phone']; ?>" required pattern="\d{10}" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="teachEmail">E-Mail</label>
                        <input type="email" class="form-control" id="teachEmail" name="teachEmail" value="<?php echo $userData['Teach_email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="teachPosition">ตำแหน่ง</label>
                        <select class="form-control" id="teachPosition" name="teachPosition" required>
                            <?php foreach ($positions as $pos): ?>
                                <option value="<?= $pos['pid2']; ?>" <?= $pos['pid2'] == $userData['Teach_Position'] ? 'selected' : ''; ?>><?= $pos['namep2']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teachAcademic">วิทยฐานะ</label>
                        <select class="form-control" id="teachAcademic" name="teachAcademic" required>
                            <?php foreach ($academics as $acad): ?>
                                <option value="<?= $acad['cid']; ?>" <?= $acad['cid'] == $userData['Teach_Academic'] ? 'selected' : ''; ?>><?= $acad['namec']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teachHiDegree">วุฒิการศึกษาสูงสุด</label>
                        <input type="text" class="form-control" id="teachHiDegree" name="teachHiDegree" value="<?= $userData['Teach_HiDegree']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="teachPhoto">รูปภาพ</label>
                        <div class="mb-3">
                            <img id="currentPhoto" src="<?php echo $setting->getImgProfile().$userData['Teach_photo'];?>" alt="Current Photo" style="height:150px;width:auto;">
                        </div>
                        <input type="file" class="form-control" id="teachPhoto" name="teachPhoto" accept="image/*">
                    </div>
                    <!-- Add more fields as needed -->
                    <input type="hidden" name="teachId" value="<?= $userData['Teach_id']; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" id="saveChanges" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('teachPhoto').addEventListener('change', function(event) {
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('currentPhoto').src = e.target.result;
    }
    reader.readAsDataURL(event.target.files[0]);
});

document.getElementById('saveChanges').addEventListener('click', function() {
    const form = document.getElementById('editTeacherForm');
    if (form.checkValidity() === false) {
        form.reportValidity();
        return;
    }
    const formData = new FormData(form);

    // Log FormData entries
    for (let [key, value] of formData.entries()) {
        // console.log(key, value);
    }

    Swal.fire({
        title: 'กำลังบันทึกข้อมูล...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('api/update_datateacher.php', { // Ensure the correct path
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // console.log('Response Data:', data);
        Swal.close();
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถบันทึกข้อมูลได้'
        });
    });
});
</script>

<?php require_once('script.php');?>
</body>
</html>
