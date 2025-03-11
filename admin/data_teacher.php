<?php 

session_start();


include_once("../config/Database.php");
include_once("../class/UserLogin.php");
include_once("../class/Utils.php");

// Initialize database connection
$connectDB = new Database_User();
$db = $connectDB->getConnection();

// Initialize UserLogin class
$user = new UserLogin($db);

// Fetch terms and pee
$term = $user->getTerm();
$pee = $user->getPee();

if (isset($_SESSION['Admin_login'])) {
    $userid = $_SESSION['Admin_login'];
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

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTeacherModalLabel">แก้ไขข้อมูลครู</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTeacherForm">
                        <div class="form-group">
                            <input type="hidden" id="addTeach_id_old" name="addTeach_id_old" required>
                            <label for="addTeach_id">username : </label>
                            <input type="text" class="form-control text-center" id="addTeach_id" name="addTeach_id" maxlength="5" required>
                        </div>
                        <div class="form-group">
                            <label for="addTeach_pass">password : </label>
                            <input type="text" class="form-control text-center" id="addTeach_pass" name="addTeach_pass" maxlength="20" required>
                        </div>
                        <div class="form-group">
                            <label for="addTeach_name">ชื่อ - นามสกุล : <span class="text-danger">ใส่คำนำหน้าด้วย</span></label>
                            <input type="text" class="form-control text-center" id="addTeach_name" name="addTeach_name" maxlength="200" required>
                        </div>
                        <div class="form-group">
                            <label for="addTeach_major">กลุ่มสาระ : </label>
                            <select class="form-control text-center" name="addTeach_major" id="addTeach_major">
                                <option value="">-- โปรดเลือกกลุ่มสาระ --</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="addTeach_position2">ตำแหน่ง : </label>
                        <select class="form-control text-center" name="addTeach_position2" id="addTeach_position2">
                            <option value="">-- โปรดเลือกตำแหน่ง --</option>
                            <option value="ผู้บริหาร">ผู้บริหาร</option>
                            <option value="ครู">ครู</option>
                            <option value="พนักงานราชการ">พนักงานราชการ</option>
                            <option value="ลูกจ้างประจำ">ลูกจ้างประจำ</option>
                            <option value="ลูกจ้างชั่วคราว (สพฐ.)">ลูกจ้างชั่วคราว (สพฐ.)</option>
                            <option value="ลูกจ้างชั่วคราว (บกศ.)">ลูกจ้างชั่วคราว (บกศ.)</option>
                        </select>
                    </div>
                        <div class="form-group">
                            <label for="addTeach_class">ครูที่ปรึกษาระดับชั้น : </label>
                            <select class="form-control text-center" name="addTeach_class" id="addTeach_class">
                                <option value="">-- โปรดเลือกระดับชั้น --</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addTeach_room">ห้อง : </label>
                            <select class="form-control text-center" name="addTeach_room" id="addTeach_room">
                                <option value="">-- โปรดเลือกห้อง --</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addTeach_status">สถานะ : </label>
                            <select class="form-control text-center" name="addTeach_status" id="addTeach_status">
                                <option value="">-- โปรดเลือกสถานะ --</option>
                                <option value="1">ปกติ</option>
                                <option value="2">ย้าย รร.</option>
                                <option value="3">เกษียณอายุราชการ</option>
                                <option value="4">ลาออก</option>
                                <option value="9">เสียชีวิต</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addrole_std">บทบาทในโปรแกรมบุคลากร : </label>
                            <select class="form-control text-center" name="addrole_std" id="addrole_std">
                                <option value="">-- โปรดเลือกบทบาท --</option>
                                <option value="T">ครู</option>
                                <option value="OF">เจ้าหน้าที่</option>
                                <option value="VP">รองผู้อำนวยการ</option>
                                <option value="DIR">ผู้อำนวยการ</option>
                                <option value="ADM">Admin</option>
                            </select>
                        </div>
                        </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" id="submitAddForm" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editTeacherModal" tabindex="-1" role="dialog" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTeacherModalLabel">แก้ไขข้อมูลครู</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTeacherForm">
                    <div class="form-group">
                        <input type="hidden" id="editTeach_id_old" name="editTeach_id_old" required>
                        <label for="editTeach_id">username : </label>
                        <input type="text" class="form-control text-center" id="editTeach_id" name="editTeach_id" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label for="editTeach_pass">password : </label>
                        <input type="text" class="form-control text-center" id="editTeach_pass" name="editTeach_pass" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="editTeach_name">ชื่อ - นามสกุล : <span class="text-danger">ใส่คำนำหน้าด้วย</span></label>
                        <input type="text" class="form-control text-center" id="editTeach_name" name="editTeach_name" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <label for="editTeach_major">กลุ่มสาระ : </label>
                        <select class="form-control text-center" name="editTeach_major" id="editTeach_major">
                            <option value="">-- โปรดเลือกกลุ่มสาระ --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTeach_position2">ตำแหน่ง : </label>
                        <select class="form-control text-center" name="editTeach_position2" id="editTeach_position2">
                            <option value="">-- โปรดเลือกตำแหน่ง --</option>
                            <option value="ผู้บริหาร">ผู้บริหาร</option>
                            <option value="ครู">ครู</option>
                            <option value="พนักงานราชการ">พนักงานราชการ</option>
                            <option value="ลูกจ้างประจำ">ลูกจ้างประจำ</option>
                            <option value="ลูกจ้างชั่วคราว (สพฐ.)">ลูกจ้างชั่วคราว (สพฐ.)</option>
                            <option value="ลูกจ้างชั่วคราว (บกศ.)">ลูกจ้างชั่วคราว (บกศ.)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTeach_class">ครูที่ปรึกษาระดับชั้น : </label>
                        <select class="form-control text-center" name="editTeach_class" id="editTeach_class">
                            <option value="">-- โปรดเลือกระดับชั้น --</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTeach_room">ห้อง : </label>
                        <select class="form-control text-center" name="editTeach_room" id="editTeach_room">
                            <option value="">-- โปรดเลือกห้อง --</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTeach_status">สถานะ : </label>
                        <select class="form-control text-center" name="editTeach_status" id="editTeach_status">
                            <option value="">-- โปรดเลือกสถานะ --</option>
                            <option value="1">ปกติ</option>
                            <option value="2">ย้าย รร.</option>
                            <option value="3">เกษียณอายุราชการ</option>
                            <option value="4">ลาออก</option>
                            <option value="9">เสียชีวิต</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editrole_person">บทบาทในโปรแกรมบุคลากร : </label>
                        <select class="form-control text-center" name="editrole_person" id="editrole_person">
                            <option value="">-- โปรดเลือกบทบาท --</option>
                            <option value="T">ครู</option>
                            <option value="OF">เจ้าหน้าที่</option>
                            <option value="VP">รองผู้อำนวยการ</option>
                            <option value="DIR">ผู้อำนวยการ</option>
                            <option value="ADM">Admin</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" id="submitEditForm" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
            </div>
        </div>
    </div>
</div>



<section class="content">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="callout callout-success text-center">
                <h3 class="text-2xl bt-2">ครูในโรงเรียนพิชัยทั้งหมด<br></h3>
                <hr>
                <div class="text-left mt-2">
                    <button class="btn-lg btn-success" data-toggle="modal" data-target="#addTeacherModal">เพิ่มข้อมูลครู</button>
                    <button class="btn-lg btn-info" data-toggle="modal" data-target="#uploadExcelModal">เพิ่มจากไฟล์ Excel</button>
                    
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3 mb-3 mx-auto">
                    <div class="table-responsive">
                            <table class="display table-bordered responsive" id="record_table" style="width:100%;">
                                <thead class="table-dark text-white text-center">
                                    <tr>
                                    <th class="text-center" >#</th>
                                    <th class="text-center" >username</th>
                                    <th class="text-center" >ชื่อ - นามสกุล</th>
                                    <th class="text-center" >กลุ่มสาระ</th>
                                    <th class="text-center" >ตำแหน่ง</th>
                                    <th class="text-center" >สถานะ</th>
                                    <th class="text-center" >รูป</th>
                                    <th class="text-center" >บทบาท</th>
                                    <th class="text-center" >จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody></tbody> <!-- Data will be inserted here -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php require_once('../footer.php');?>
</div>
<!-- ./wrapper -->

<!-- Upload Excel Modal -->
<div class="modal fade" id="uploadExcelModal" tabindex="-1" role="dialog" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadExcelModalLabel">อัพโหลดไฟล์ Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadExcelForm" enctype="multipart/form-data">
                    <div class="form-group">
                    <a href="template/teacher_template.xlsx" class="btn-lg btn-warning">ดาวน์โหลดไฟล์ตัวอย่าง</a>
                    </div>
                    <div class="form-group">
                        <label for="excelFile">เลือกไฟล์ Excel:</label>
                        <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xlsx" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" id="submitUploadForm" class="btn btn-primary">อัพโหลด</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    // Function to load the table
    function loadTable() {
        $.ajax({
            url: 'api/fet_teacher.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#record_table').DataTable().clear().destroy(); // Clear and destroy the existing table
                $('#record_table tbody').empty();

                if (data.length === 0) {
                    $('#record_table tbody').append('<tr><td colspan="10" class="text-center">ไม่พบข้อมูล</td></tr>');
                } else {
                    $.each(data, function(index, item) {
                        var statusText;
                        switch (String(item.Teach_status)) { // Convert to string for comparison
                            case '1':
                                statusText = 'ปกติ';
                                break;
                            case '2':
                                statusText = 'ย้าย';
                                break;
                            case '3':
                                statusText = 'เกษียณ';
                                break;
                            case '4':
                                statusText = 'ลาออก';
                                break;
                            case '9':
                                statusText = 'เสียชีวิต';
                                break;
                            default:
                                statusText = 'ไม่ทราบสถานะ';
                        }

                        var roleText;
                        switch (item.role_person) {
                            case 'DIR':
                                roleText = 'ผู้อำนวยการ';
                                break;
                            case 'VP':
                                roleText = 'รองผู้อำนวยการ';
                                break;
                            case 'HOD':
                                roleText = 'หัวหน้าแผนก/กลุ่มสาระ';
                                break;
                            case 'T':
                                roleText = 'ครู';
                                break;
                            case 'OF':
                                roleText = 'เจ้าหน้าที่';
                                break;
                            case 'ADM':
                                roleText = 'Admin';
                                break;
                            default:
                                roleText = 'ไม่ทราบบทบาท';
                        }

                        var row = '<tr class="text-center">' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + item.Teach_id + '</td>' +
                            '<td>' + item.Teach_name + '</td>' +
                            '<td>' + item.Teach_major + '</td>' +
                            '<td>' + item.Teach_Position2 + '</td>' +
                            '<td>' + statusText + '</td>' +
                            '<td><a href="<?php echo $setting->getImgProfile();?>' + item.Teach_photo + '" data-toggle="lightbox" data-title="'+ item.Teach_name +'" data-gallery="gallery"><img src="<?php echo $setting->getImgProfile();?>' + item.Teach_photo + '" class="img-thumbnail rounded" style="width:auto;hight:auto;max-hight:180px;"></a></td>' +
                            '<td>' + roleText + '</td>' +
                            '<td>' +
                                '<button class="btn btn-primary btn-sm edit-btn" data-id="' + item.Teach_id + '"> <i class="fa fa-pen" aria-hidden="true"></i> edit</button> ' +
                                // '<button class="my-2 btn btn-danger btn-sm delete-btn" data-id="' + item.Teach_id + '"> <i class="fa fa-trash" aria-hidden="true"></i> del</button> ' +
                            '</td>' +
                        '</tr>';
                        $('#record_table tbody').append(row);
                    });
                }

                // Reinitialize DataTable with responsive settings
                $('#record_table').DataTable({
                    responsive: true, // Enable responsive mode
                    "autoWidth": false, // Disable automatic column width calculation
                    "columnDefs": [
                        { "orderable": false, "targets": -1 } // Disable sorting on the last column (Manage)
                    ]
                });
            },
            error: function(xhr, status, error) {
                Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
            }
        });
    }

    // Load the table initially
    loadTable();

    // Function to populate select elements
    function populateSelectElement(selectElementId, data) {
        const selectElement = document.getElementById(selectElementId);
        data.forEach(major => {
            const option = document.createElement('option');
            option.value = major.Teach_major;
            option.textContent = major.Teach_major;
            selectElement.appendChild(option);
        });
    }

    // Fetch majors and populate the selects
    fetch('api/fet_major.php')
        .then(response => response.json())
        .then(data => {
            populateSelectElement('addTeach_major', data);
            populateSelectElement('editTeach_major', data);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

    // Handle Add Teacher form submission
    $('#submitAddForm').on('click', function(event) {
        event.preventDefault();

        const formData = new FormData($('#addTeacherForm')[0]);
        const params = new URLSearchParams(formData);

        fetch('api/insert_teacher.php', {
            method: 'POST',
            body: params,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('การตอบสนองของเครือข่ายไม่โอเค');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire('สำเร็จ', 'เพิ่มข้อมูลเรียบร้อยแล้ว', 'success')
                .then(() => {
                    $('#addTeacherModal').modal('hide'); // Close the modal
                    location.reload(); // Reload the page
                });
            } else {
                Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเพิ่มข้อมูล: ' + data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล', 'error');
        });
    });

    // Edit button click handler
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');

        // Fetch data for the selected item
        $.ajax({
            url: 'api/get_teacher.php',
            method: 'GET',
            data: { teacher_id: id },
            dataType: 'json',
            success: function(data) {
                if (data) {
                    $('#editTeach_id_old').val(data.Teach_id);
                    $('#editTeach_id').val(data.Teach_id);
                    $('#editTeach_pass').val(data.Teach_password);
                    $('#editTeach_name').val(data.Teach_name);
                    $('#editTeach_major').val(data.Teach_major);
                    $('#editTeach_position2').val(data.Teach_Position2);
                    $('#editTeach_status').val(data.Teach_status);
                    $('#editrole_person').val(data.role_person);
                    $('#editTeach_class').val(data.Teach_class);
                    $('#editTeach_room').val(data.Teach_room);
                    $('#editTeacherModal').modal('show');
                } else {
                    Swal.fire('ข้อผิดพลาด', 'ไม่พบข้อมูลที่ต้องการแก้ไข', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
            }
        });
    });

    // Handle Edit Teacher form submission
    $('#submitEditForm').on('click', function(event) {
        event.preventDefault();

        const formData = new FormData(document.getElementById('editTeacherForm'));
        const params = new URLSearchParams(formData).toString();

        fetch('api/update_teacher.php', {
            method: 'POST',
            body: params,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check what is returned
            if (data.success) {
                Swal.fire('สำเร็จ', 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'success')
                .then(() => {
                    $('#editTeacherModal').modal('hide'); // Close the modal
                    loadTable(); // Reload table data
                });
            } else {
                Swal.fire('ข้อผิดพลาด', 'ไม่สามารถแก้ไขข้อมูล: ' + data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล', 'error');
        });

    });

    // Handle delete button click
    $(document).on('click', '.delete-btn', function(event) {
        event.preventDefault();
        
        // Get the ID of the item to delete
        const id = $(this).data('id');

        // Confirm the deletion
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send delete request to the server
                fetch('api/delete_teacher.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'id': id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('ลบแล้ว!', 'ข้อมูลได้ถูกลบแล้ว.', 'success');
                        loadTable(); // Reload table data
                    } else {
                        Swal.fire('ข้อผิดพลาด!', 'ไม่สามารถลบข้อมูล: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('ข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการลบข้อมูล.', 'error');
                });
            }
        });
    });

    // Handle Upload Excel form submission
    $('#submitUploadForm').on('click', function(event) {
        event.preventDefault();

        const formData = new FormData($('#uploadExcelForm')[0]);

        fetch('api/upload_teacher_excel.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('สำเร็จ', 'อัพโหลดข้อมูลเรียบร้อยแล้ว', 'success')
                .then(() => {
                    $('#uploadExcelModal').modal('hide'); // Close the modal
                    loadTable(); // Reload table data
                });
            } else {
                Swal.fire('ข้อผิดพลาด', 'ไม่สามารถอัพโหลดข้อมูล: ' + data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการอัพโหลดข้อมูล', 'error');
        });
    });

});
</script>
<?php require_once('script.php');?>
</body>
</html>
