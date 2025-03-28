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

if (isset($_SESSION['Officer_login'])) {
    $userid = $_SESSION['Officer_login'];
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

// Fetch all majors
$majors = $user->getAllMajors();

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

          <div class="callout callout-success text-center">
          <img src="../dist/img/logo-phicha.png" alt="Phichai Logo" id="logoPrint" class="brand-image rounded-full opacity-80 mb-3 w-12 h-12 mx-auto">
                        
                        <h6 class="font-bold bt-2">รายงานรางวัลครู<br>
                        ของ <span id="selected_teacher"></span><br>
                        กลุ่มสาระ <span id="selected_department"></span><br>
                        <span id="selected_term"></span> ปีการศึกษา <span id="selected_year"></span><br>
                        <br>
                        </h6>
                                <button class="btn btn-success text-left mb-3 mt-2" id="printButton" onclick="printPage()"> <i class="fa fa-print" aria-hidden="true"></i> พิมพ์รายงาน  <i class="fa fa-print" aria-hidden="true"></i></button>
                                
                <div class="row">
                  <div class="col-md-12">
                    
                    <div class="row">
                      <div class="col-md-3">
                        <div class="input-group mb-3" id="department_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_department">เลือกกลุ่ม:</label>
                          </div>
                          <select name="select_department" id="select_department" class="form-control text-center">
                            <option value="">เลือกกลุ่ม</option>
                            <?php foreach ($majors as $major): ?>
                              <option value="<?= $major['Teach_major'] ?>"><?= $major['Teach_major'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="input-group mb-3" id="teacher_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_teacher">เลือกครู:</label>
                          </div>
                          <select name="select_teacher" id="select_teacher" class="form-control text-center">
                            <option value="">เลือกครู</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="input-group mb-3" id="term_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_term">ภาคเรียนที่:</label>
                          </div>
                          <select name="select_term" id="select_term" class="form-control text-center">
                            <option value="">ทั้งสองภาคเรียน</option>
                            <option value="1">ภาคเรียนที่ 1</option>
                            <option value="2">ภาคเรียนที่ 2</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
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


<script>
$(document).ready(function() {
  // Function to handle printing
  window.printPage = function () {
      let elementsToHide = $('#printButton,#department_selector,#teacher_selector, #term_selector, #year_selector, #filter, #reset, #footer, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info');
      let lastColumn = $('#record_table th:last-child, #record_table td:last-child');
      $('#record_table_wrapper .dt-buttons').hide(); // Hides the export buttons

      elementsToHide.hide();
      lastColumn.hide(); // Hide the last column
      $('thead').css('display', 'table-header-group'); // บังคับให้หัวข้อแสดง

      setTimeout(() => {
          window.print();
          elementsToHide.show();
          lastColumn.show(); // Show the last column after printing
          $('#record_table_wrapper .dt-buttons').show();
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

  $('#select_department').change(function() {
    const selectedDepartment = $(this).val();
    if (selectedDepartment) {
      $.ajax({
        url: 'api/fetch_teachers.php',
        method: 'GET',
        data: { department: selectedDepartment },
        dataType: 'json',
        success: function(data) {
          if (data.success) {
            const teachers = data.data;
            $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
            teachers.forEach(function(teacher) {
              $('#select_teacher').append(`<option value="${teacher.Teach_id}">${teacher.Teach_name}</option>`);
            });
          } else {
            Swal.fire('ข้อผิดพลาด', data.message, 'error');
          }
        },
        error: function(error) {
          Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูลครู', 'error');
        }
      });
    } else {
      $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
    }
  });

  $('#filter').click(function() {
    fetchAwardData();
  });

  $('#reset').click(function() {
    $('#select_department').val('');
    $('#select_teacher').val('');
    $('#select_term').val('');
    $('#select_year').val('');
    fetchAwardData();
  });

  function fetchAwardData() {
    const tid = $('#select_teacher').val();
    const term = $('#select_term').val();
    const year = $('#select_year').val();

    $.ajax({
      url: 'api/fetch_award.php',
      method: 'GET',
      dataType: 'json',
      data: {
        tid: tid,
        term: term,
        year: year
      },
      success: function(data) {
          if (data.success) {
              populateAwardTable(data.data);
              
              // อัปเดตชื่อของ teacher
              $('#selected_teacher').text($('#select_teacher option:selected').text());
              
              // อัปเดตชื่อของ department
              $('#selected_department').text($('#select_department option:selected').text());
              
              // อัปเดตข้อความสำหรับ term (ตรวจสอบว่าไม่ได้เลือก "ทั้งสองภาคเรียน")
              var selectedTerm = $('#select_term option:selected').val();
              if (selectedTerm === "") {
                  $('#selected_term').text(''); // หากเลือก "ทั้งสองภาคเรียน" จะไม่แสดงข้อความ
              } else {
                  $('#selected_term').text('ภาคเรียนที่ ' + selectedTerm);
              }
              
              // อัปเดตข้อความปีการศึกษา
              $('#selected_year').text($('#select_year option:selected').val());
          } else {
              Swal.fire('ข้อผิดพลาด', data.message, 'error');
          }
      },
      error: function(error) {
        Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
      }
    });
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
          `<a href="../teacher/uploads/file_award/${award.certificate}"target="_blank">
              <img src="../teacher/uploads/file_award/${award.certificate}" alt="Certificate" class="h-36 w-auto">
          </a>`,
          `<button class="btn-sm btn-primary ml-2 mt-2 edit-award" data-id="${award.awid}">แก้ไข</button>`
        ]).draw();
      });
    }
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
      "autoWidth": false,
      "responsive": true,
      "scrollX": true,
      "scrollCollapse": true,
      "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<span class="btn btn-success">Export to Excel</span>',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: ':not(:last-child)', // ไม่รวมคอลัมน์สุดท้าย
                            modifier: {
                                selected: null
                            },
                            rows: {
                                search: 'applied',
                                order: 'applied'
                            }
                        }
                    }
                ],
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
        { "orderable": false, "targets": [0] },
        { "className": "text-center", "targets": "_all" },
        { "width": "400px", "targets": [1] },
        { "targets": "_all", "render": function (data, type, row) {
          return '<div class="text-wrap">' + data + '</div>';
        }}
      ]
    });
  });

  $(document).on('click', '.edit-award', function() {
    const awardId = $(this).data('id');
    $.ajax({
      url: 'api/get_award.php',
      method: 'GET',
      dataType: 'json',
      data: { id: awardId },
      success: function(data) {
        if (data.success) {
          const award = data.data;
          $('#editAwardId').val(award.awid);
          $('#editTeacherId').val(award.tid);
          $('#editAward').val(award.award);
          $('#editLevel').val(award.level);
          $('#editDate1').val(award.date1);
          $('#editTerm').val(award.term);
          $('#editYear').val(award.year);
          $('#editDepartment').val(award.department);
          $('#editCertificate').val(award.certificate);
          $('#editModal').modal('show');
        } else {
          Swal.fire('ข้อผิดพลาด', data.message, 'error');
        }
      },
      error: function(error) {
        Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
      }
    });
  });

  $('#saveEdit').on('click', function() {
    const form = document.getElementById('editForm');
    const formData = new FormData(form);

    $.ajax({
      url: 'api/update_award.php',
      method: 'POST',
      data: JSON.stringify(Object.fromEntries(formData.entries())),
      contentType: 'application/json',
      dataType: 'json',
      success: function(data) {
        if (data.success) {
          Swal.fire('สำเร็จ', 'แก้ไขข้อมูลรางวัลเรียบร้อยแล้ว', 'success').then(() => {
            $('#editModal').modal('hide');
            fetchAwardData();
          });
        } else {
          Swal.fire('ข้อผิดพลาด', data.message, 'error');
        }
      },
      error: function(error) {
        Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
      }
    });
  });
});
</script>

<?php require_once('script.php');?>
</body>
</html>
