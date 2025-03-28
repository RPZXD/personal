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

$teacher_id = $userData['Teach_id'];
$teacher_name = $userData['Teach_name'];
$class = $userData['Teach_class'];
$room = $userData['Teach_room'];

// Initialize database connection for Person
$connectDBPerson = new Database_Person();
$dbPerson = $connectDBPerson->getConnection();

// Initialize Person class
$person = new Person($dbPerson);

// Fetch distinct years from tb_award
$years = $person->getDistinctYearsFromAwards();

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

        <div class="col-md-12">
        <button id="addAward" class="btn btn-lg btn-success my-2"> <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มข้อมูลรางวัล</button>
          <div class="callout callout-success text-center">
          <img src="../dist/img/logo-phicha.png" alt="Phichai Logo" class="brand-image rounded-full opacity-80 mb-3 w-12 h-12 mx-auto">
                        
                        <h6 class="font-bold bt-2">รายงานรางวัล<br>
                        ของ     <?= $teacher_name?><br>
                        <span id="selected_term">-</span> ปีการศึกษา <span id="selected_year">-</span><br>
                        </h6>
                                <button class="btn btn-success text-left mb-3 mt-2" id="printButton" onclick="printPage()"> <i class="fa fa-print" aria-hidden="true"></i> พิมพ์รายงาน  <i class="fa fa-print" aria-hidden="true"></i></button>
                                
                <div class="row">้
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-group mb-3" id="term_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_term">ภาคเรียน:</label>
                          </div>
                          <select class="custom-select text-center" id="select_term">
                            <option value="">ทั้งหมด</option>
                            <option value="1">ภาคเรียนที่ 1</option>
                            <option value="2">ภาคเรียนที่ 2</option>
                            <!-- Add your room options here -->
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="input-group mb-3" id="year_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_year">ปีการศึกษา:</label>
                          </div>
                          <select class="custom-select text-center" id="select_year">
                                <option value="">ทั้งหมด</option>
                                <?php foreach ($years as $year): ?>
                                <option value="<?= $year['year'] ?>"><?= $year['year'] ?></option>
                                <?php endforeach; ?>>
                          </select>
                        </div>
                      </div>
                    </div>
                <div>
                  <button id="filter" class="btn btn-sm btn-outline-info"> <i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                  <button id="reset" class="btn btn-sm btn-outline-warning"> <i class="fa fa-trash" aria-hidden="true"></i> ล้างค่า</button>
                </div>
        <div class="row">
            <div class="col-md-12 mt-3 mb-3 mx-auto">
                <div class="table-responsive mx-auto">
                    <table class="display table-bordered responsive nowrap" id="record_table" style="width:100%;">
                        <thead class="thead-secondary">
                        <tr >
                            <th style="width:5%" class="text-center text-white bg-gray-800">ครั้งที่</th>
                            <th  class="text-center text-white bg-gray-800">ชื่อรางวัล</th>
                            <th style="width: 10%;" class="text-center text-white bg-gray-800">วันที่ได้รับ</th>
                            <th class="text-center text-white bg-gray-800">ระดับรางวัล</th>
                            <th class="text-center text-white bg-gray-800">ภาคเรียนที่</th>
                            <th class="text-center text-white bg-gray-800">หน่วยงานที่มอบรางวัล</th>
                            <th class="text-center text-white bg-gray-800">เอกสารประกอบ</th>
                            <th style="width: 13%" class="text-center text-white bg-gray-800">จัดการ</th>
                            <!-- Add more table column headers as needed -->
                        </tr>
                        </thead>       
                        <tbody>

                        </tbody>
                    </table>
                </div>
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

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"> <!-- Changed modal size to large -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">รายละเอียดรางวัล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Award details will be populated here -->
        <div id="viewDetails"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลรางวัล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Edit form will be populated here -->
        <form id="editForm" enctype="multipart/form-data">
          <!-- Form fields will be populated here -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="saveChanges">บันทึกการเปลี่ยนแปลง</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">เพิ่มข้อมูลรางวัล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addForm" enctype="multipart/form-data">
          <div class="form-group">
            <label for="addAward">ชื่อรางวัล:</label>
            <input type="text" class="form-control text-center" id="addAward" name="award" required>
          </div>
          <div class="form-group">
            <label for="addLevel">ระดับรางวัล:</label>
            <select name="level" id="addLevel" class="form-control text-center" required>
                <option value="">เลือกระดับรางวัล</option>
                <option value="1">เขต/จังหวัด</option>
                <option value="2">ภาค</option>
                <option value="3">ชาติ</option>
                <option value="4">นานาชาติ</option>
            </select>
          </div>
          <div class="form-group">
            <label for="addDate">วันที่ได้รับ:</label>
            <input type="date" class="form-control text-center" id="addDate" name="date1" required>
          </div>
          <div class="form-group">
            <label>ภาคการศึกษา</label>
            <div class="flex gap-2">
                <div class="w-1/2">
                    <label for="addTerm">เทอม:</label>
                    <select name="term" id="addTerm" class="form-control text-center" required>
                        <option value="">เลือกเทอม</option>
                        <option value="1" <?= ($term == 1) ? 'selected' : '' ?>>ภาคเรียนที่ 1</option>
                        <option value="2" <?= ($term == 2) ? 'selected' : '' ?>>ภาคเรียนที่ 2</option>
                    </select>
                </div>
                <div class="w-1/2 ml-2">
                    <label for="addYear">ปีการศึกษา:</label>
                    <input type="text" class="form-control text-center" id="addYear" name="year" value="<?= $pee ?>" required>
                </div>
            </div>
        </div>
          <div class="form-group">
            <label for="addDepartment">หน่วยงานที่มอบรางวัล:</label>
            <input type="text" class="form-control text-center" id="addDepartment" name="department" required>
          </div>
          <div class="form-group">
            <label for="addCertificate">เอกสารประกอบ (เกียรติบัตร,รูปภาพ):</label>
            <input type="file" class="form-control text-center" id="addCertificate" name="certificate" required accept="image/*">
          </div>
          <input type="hidden" id="addTid" name="tid" value="<?= $teacher_id ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="saveAdd">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // Function to handle printing
  window.printPage = function () {
        let elementsToHide = $('#term_selector, #year_selector, #printButton, #filter, #reset, #addAward, #footer, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info');

        elementsToHide.hide();
        $('thead').css('display', 'table-header-group'); // บังคับให้หัวข้อแสดง

        setTimeout(() => {
            window.print();
            elementsToHide.show();
        }, 100);
    };

  // Function to set up the print layout
  function setupPrintLayout() {
    // Set page properties for landscape A4 with 0.5 inch margins
    var style = '@page { size: A4 landscape; margin: 0.5in; }';
    var printStyle = document.createElement('style');
    printStyle.appendChild(document.createTextNode(style));
    document.head.appendChild(printStyle);
  }

  // Call setupPrintLayout when document is ready
  setupPrintLayout();

  $('#addAward').on('click', function() {
    $('#addModal').modal('show');
  });

  $('#saveAdd').on('click', function() {
    const formData = new FormData(document.getElementById('addForm'));

    $.ajax({
      url: 'api/insert_award.php',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(data) {
        if (data.success) {
          Swal.fire('สำเร็จ', 'เพิ่มข้อมูลรางวัลเรียบร้อยแล้ว', 'success');
          $('#addModal').modal('hide');
          window.location.replace(window.location.href);
        } else {
          Swal.fire('ข้อผิดพลาด', data.message, 'error');
        }
      },
      error: function(error) {
        console.error('Error:', error);
        console.error('Error Details:', error.responseText);
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filter').addEventListener('click', fetchAwardData);
    document.getElementById('reset').addEventListener('click', resetFilters);

    // Fetch award data on page load
    fetchAwardData();

    function fetchAwardData() {
        const tid = <?= json_encode($userData['Teach_id']); ?>;
        const term = document.getElementById('select_term').value;
        const year = document.getElementById('select_year').value;
        // console.log('Teacher ID:', tid); // Log the Teacher ID being sent
        // console.log('Term:', term); // Log the selected term
        // console.log('Year:', year); // Log the selected year

        // Update selected term and year
        const selectedTermElement = document.getElementById('selected_term');
        const selectedYearElement = document.getElementById('selected_year');
        if (term == 1) {
            selectedTermElement.innerText = 'ภาคเรียนที่ 1' ;
        } else if (term == 2) {
            selectedTermElement.innerText = 'ภาคเรียนที่ 2' ;
        } else {
            selectedTermElement.innerText =  '';
        }
        if (selectedYearElement) {
            selectedYearElement.innerText = year || '';
        }

        $.ajax({
            url: 'api/fetch_award.php',
            method: 'GET',
            dataType: 'json',
            data: {
                tid: tid,
                term: term || 'all',
                year: year || 'all'
            },
            success: function(data) {
                // console.log('Response Data:', data); // Log the response data
                if (data.success) {
                    populateAwardTable(data.data);
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                console.error('Error Details:', error.responseText);
            }
        });
    }

    function resetFilters() {
        document.getElementById('select_term').value = '';
        document.getElementById('select_year').value = '';
        const selectedTermElement = document.getElementById('selected_term');
        const selectedYearElement = document.getElementById('selected_year');
        if (selectedTermElement) {
            selectedTermElement.innerText = '-';
        }
        if (selectedYearElement) {
            selectedYearElement.innerText = '-';
        }
        fetchAwardData();
    }

    function convertToThaiDate(dateString) {
        const months = [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        ];
        const date = new Date(dateString);
        const day = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear() + 543; // Convert to Buddhist year
        return `${day} ${month} ${year}`;
    }

    function populateAwardTable(awards) {
        const table = $('#record_table').DataTable();
        table.clear(); // Clear existing data

        if (awards.length === 0) {
            table.row.add(['ไม่พบข้อมูล', '', '', '', '', '', '', '']).draw();
        } else {
            awards.forEach((award, index) => {
                table.row.add([
                    index + 1,
                    award.award,
                    convertToThaiDate(award.date1),
                    getAwardLevelText(award.level),
                    `${award.term}/${award.year}`,
                    award.department,
                    `<a href="<?= $setting->getImgAwards()?>${award.certificate}"target="_blank">
                    <img src="<?= $setting->getImgAwards()?>${award.certificate}" alt="Certificate" class="h-36 w-auto">
                    </a>`,
                    `
                    <button class="btn btn-primary btn-view" data-id="${award.awid}">ดู</button>
                    <button class="btn btn-warning my-2 mx-2 btn-edit" data-id="${award.awid}">แก้ไข</button>
                    <button class="btn btn-danger btn-del" data-id="${award.awid}">ลบ</button>
                    `
                ]).draw();
            });

            // Add event listeners for view, edit, and delete buttons
            document.querySelectorAll('.btn-view').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    viewAwardDetails(id);
                });
            });

            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    editAwardDetails(id);
                });
            });

            document.querySelectorAll('.btn-del').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    deleteAwardDetails(id);
                });
            });
        }
    }

    function getAwardLevelText(level) {
        switch (level) {
            case '1':
                return 'เขต/จังหวัด';
            case '2':
                return 'ภาค';
            case '3':
                return 'ชาติ';
            case '4':
                return 'นานาชาติ';
            default:
                return 'ไม่ระบุ';
        }
    }

    function viewAwardDetails(id) {
        // Fetch award details and populate the view modal
        $.ajax({
            url: 'api/fetch_award_details.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function(data) {
                if (data.success) {
                    const details = `
                        <p><strong>ชื่อรางวัล:</strong> ${data.details.award}</p>
                        <p><strong>วันที่ได้รับ:</strong> ${convertToThaiDate(data.details.date1)}</p>
                        <p><strong>ระดับรางวัล:</strong> ${data.details.level}</p>
                        <p><strong>หน่วยงานที่มอบรางวัล:</strong> ${data.details.department}</p>
                        <p><strong>ภาคเรียนที่:</strong> ${data.details.term}/${data.details.year}</p>
                        <hr>
                        <p><strong>เอกสารประกอบ:</strong> <img src="<?= $setting->getImgAwards()?>${data.details.certificate}" alt="Certificate" style="height: 150px; width: auto;"></p>
                    `;
                    document.getElementById('viewDetails').innerHTML = details;
                    $('#viewModal').modal('show');
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                console.error('Error Details:', error.responseText);
            }
        });
    }

    function editAwardDetails(id) {
        // Fetch award details and populate the edit form
        $.ajax({
            url: 'api/fetch_award_details.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function(data) {
                if (data.success) {
                    const form = `
                        <div class="form-group">
                            <label for="editAward">ชื่อรางวัล:</label>
                            <input type="text" class="form-control" id="editAward" name="award" value="${data.details.award}">
                        </div>
                        <div class="form-group">
                        <label for="editDate">วันที่ได้รับ:</label>
                        <input type="date" class="form-control" id="editDate" name="date1" value="${data.details.date1}">
                        </div>
                        <div class="form-group">
                        <label for="editTerm">เทอม:</label>
                        <input type="text" class="form-control" id="editTerm" name="term" value="${data.details.term}">
                        </div>
                        <div class="form-group">
                        <label for="editYear">ปีการศึกษา:</label>
                        <input type="text" class="form-control" id="editYear" name="year" value="${data.details.year}">
                        </div>
                        <div class="form-group">
                            <label for="editLevel">ระดับรางวัล:</label>
                            <input type="text" class="form-control" id="editLevel" name="level" value="${data.details.level}">
                        </div>
                        <div class="form-group">
                            <label for="editDepartment">หน่วยงานที่มอบรางวัล:</label>
                            <input type="text" class="form-control" id="editDepartment" name="department" value="${data.details.department}">
                        </div>
                        <div class="form-group">
                            <label for="editCertificate">เอกสารประกอบ:</label>
                            <input type="file" class="form-control" id="editCertificate" name="certificate">
                            <a href="<?= $setting->getImgAwards()?>${data.details.certificate}"target="_blank"><img src="<?= $setting->getImgAwards()?>${data.details.certificate}" alt="Certificate" style="height: 150px; width: auto; margin-top: 10px;"></a>
                        </div>
                        <input type="hidden" id="editTid" name="tid" value="${data.details.tid}">
                        <input type="hidden" id="editId" name="awardid" value="${data.details.awardid}">
                    `;
                    document.getElementById('editForm').innerHTML = form;
                    $('#editModal').modal('show');

                    document.getElementById('saveChanges').addEventListener('click', function() {
                        saveChanges(id);
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                console.error('Error Details:', error.responseText);
            }
        });
    }

    function saveChanges(id) {
        const formData = new FormData(document.getElementById('editForm'));
        formData.append('awardid', id);

        $.ajax({
            url: 'api/update_award.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    Swal.fire('สำเร็จ', 'บันทึกการเปลี่ยนแปลงเรียบร้อยแล้ว', 'success');
                    $('#editModal').modal('hide');
                    fetchAwardData();
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                console.error('Error Details:', error.responseText);
            }
        });
    }

    function deleteAwardDetails(id) {
      Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการลบข้อมูลรางวัลนี้หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'api/del_award.php',
            method: 'POST',
            dataType: 'json',
            data: { id: id },
            success: function(data) {
              if (data.success) {
                Swal.fire('ลบแล้ว!', 'ข้อมูลรางวัลถูกลบเรียบร้อยแล้ว.', 'success');
                fetchAwardData();
              } else {
                Swal.fire('ข้อผิดพลาด', data.message, 'error');
              }
            },
            error: function(error) {
              console.error('Error:', error);
              console.error('Error Details:', error.responseText);
            }
          });
        }
      });
    }
});

$(document).ready(function() {
    $('#record_table').DataTable({
      dom: 'Bfrtip',
          buttons: [
              {
                  extend: 'print',
                  text: 'พิมพ์ข้อมูล',
                  customize: function (win) {
                      $(win.document.body).find('thead').css('display', 'table-header-group');
                  }
              }
          ],
        "pageLength": 50,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false, // Disable autoWidth to control column size
        "responsive": true,
        "scrollX": true,
        "scrollCollapse": true,
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูลที่จะแสดง",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
            "search": "ค้นหา:",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [0] }, // Disable sorting for the first column
            { "className": "text-center", "targets": "_all" }, // Center align all columns
            { "width": "400px", "targets": [1] }, // Set column width for columns 1 and 2
            { "targets": "_all", "render": function (data, type, row) {
                return '<div class="text-wrap">' + data + '</div>';
            }}
        ]
    });
});
</script>

<?php require_once('script.php');?>
</body>
</html>
