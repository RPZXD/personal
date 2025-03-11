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

// Fetch distinct years from tb_seminar
$years = $person->getDistinctYears();

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
                        
                        <h6 class="font-bold bt-2">รายงานการฝึกอบรม<br>
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
                            <option value="">เลือกภาคเรียน</option>
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
                            <th  class="text-center text-white bg-gray-800">ชื่อการฝึกอบรม</th>
                            <th style="width: 10%;" class="text-center text-white bg-gray-800">วันที่</th>
                            <th class="text-center text-white bg-gray-800">จำนวนชั่วโมง</th>
                            <th class="text-center text-white bg-gray-800">ปีการศึกษา</th>
                            <th class="text-center text-white bg-gray-800">สถานที่</th>
                            <th class="text-center text-white bg-gray-800">เกียรติบัตร/หลักฐาน</th>
                            <th style="width: 13%" class="text-center text-white bg-gray-800">จัดการ</th>
                            <!-- Add more table column headers as needed -->
                        </tr>
                        </thead>       
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-center">รวมชั่วโมงทั้งหมด</th>
                                <th id="total_hours_footer" class="text-center">-</th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
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
      let tfoot = $('#record_table tfoot');

      elementsToHide.hide();
      lastColumn.hide(); // Hide the last column
      $('thead').css('display', 'table-header-group'); // Force the header to display

      setTimeout(() => {
          tfoot.css('display', 'table-footer-group'); // Ensure footer is displayed only at the end
          window.print();
          elementsToHide.show();
          lastColumn.show(); // Show the last column after printing
          tfoot.css('display', ''); // Reset footer display
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
    fetchTrainingData();
  });

  $('#reset').click(function() {
    $('#select_department').val('');
    $('#select_teacher').val('');
    $('#select_term').val('');
    $('#select_year').val('');
    fetchTrainingData();
  });

  function fetchTrainingData() {
    const tid = $('#select_teacher').val();
    const term = $('#select_term').val();
    const year = $('#select_year').val();

    $.ajax({
      url: 'api/fetch_training.php',
      method: 'GET',
      dataType: 'json',
      data: {
        tid: tid,
        term: term,
        year: year
      },
      success: function(data) {
        if (data.success) {
          populateTrainingTable(data.data);
          $('#selected_teacher').text($('#select_teacher option:selected').text());
          $('#selected_department').text($('#select_department option:selected').text());
          $('#selected_term').text($('#select_term option:selected').text());
          $('#selected_year').text($('#select_year option:selected').val());
          fetchTotalHours(tid, term, year); // Fetch total hours
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

    function fetchTotalHours(tid, term, year) {
        $.ajax({
            url: 'api/fetch_training_hours.php',
            method: 'GET',
            dataType: 'json',
            data: {
                tid: tid,
                term: term,
                year: year
            },
            success: function(data) {
                // console.log('Total Hours Data:', data); // Log the response data
                if (data.success) {
                    document.getElementById('total_hours_footer').innerText = `${data.total_hours} ชั่วโมง ${data.total_minutes} นาที`;
                } else {
                    document.getElementById('total_hours_footer').innerText = '-';
                }
            },
            error: function(error) {
                console.error('Error:', error);
                console.error('Error Details:', error.responseText);
            }
        });
    }

  function populateTrainingTable(trainings) {
    const table = $('#record_table').DataTable();
    table.clear(); // Clear existing data

    let totalHours = 0;
    let totalMinutes = 0;

    if (trainings.length === 0) {
      table.row.add(['ไม่พบข้อมูล', '', '', '', '', '', '', '']).draw();
    } else {
      trainings.forEach((training, index) => {
        totalHours += parseInt(training.hours);
        totalMinutes += parseInt(training.mn);

        table.row.add([
          index + 1,
          `<div class="text-wrap">${training.topic}</div>`,
          `<div class="text-wrap">${convertToThaiDate(training.dstart)} - ${convertToThaiDate(training.dend)}</div>`,
          `<div class="text-wrap">${training.hours} ชั่วโมง ${training.mn} นาที</div>`,
          `<div class="text-wrap">${training.term}/${training.year}</div>`,
          `<div class="text-wrap">${training.supports}</div>`,
          `<div class="text-wrap"><img src="<?= $setting->getImgTraining()?>${training.sdoc}" alt="Certificate" style="height: 150px; width: auto;"></div>`,
          `<div class="text-wrap"><button class="btn-sm btn-primary ml-2 mt-2 edit-training" data-id="${training.semid}">แก้ไข</button></div>`
        ]).draw();
      });
    }

    // Calculate total hours and minutes
    totalHours += Math.floor(totalMinutes / 60);
    totalMinutes = totalMinutes % 60;

    // Update footer with total hours
    document.getElementById('total_hours_footer').innerText = `${totalHours} ชั่วโมง ${totalMinutes} นาที`;
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

  // Calculate total hours and minutes
  totalHours += Math.floor(totalMinutes / 60);
            totalMinutes = totalMinutes % 60;

  // Update footer with total hours
  document.getElementById('total_hours_footer').innerText = `${totalHours} ชั่วโมง ${totalMinutes} นาที`;

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
        "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false, // Disable autoWidth to control column size
        "responsive": true,
        "scrollX": false,
        "scrollCollapse": false,
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
            { "width": "200px", "targets": [1] }, // Set column width for columns 1 and 2
            { "targets": "_all", "render": function (data, type, row) {
                return '<div class="text-wrap">' + data + '</div>';
            }}
        ]
    });

  $(document).on('click', '.edit-training', function() {
    const trainingId = $(this).data('id');
    $.ajax({
      url: 'api/get_training.php',
      method: 'GET',
      dataType: 'json',
      data: { id: trainingId },
      success: function(data) {
        if (data.success) {
          const training = data.data;
          $('#editTrainingId').val(training.training_id);
          $('#editTeacherId').val(training.tid);
          $('#editTrainingName').val(training.training_name);
          $('#editStartDate').val(training.start_date);
          $('#editEndDate').val(training.end_date);
          $('#editTerm').val(training.term);
          $('#editYear').val(training.year);
          $('#editLocation').val(training.location);
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
      url: 'api/update_training.php',
      method: 'POST',
      data: JSON.stringify(Object.fromEntries(formData.entries())),
      contentType: 'application/json',
      dataType: 'json',
      success: function(data) {
        if (data.success) {
          Swal.fire('สำเร็จ', 'แก้ไขข้อมูลการฝึกอบรมเรียบร้อยแล้ว', 'success').then(() => {
            $('#editModal').modal('hide');
            fetchTrainingData();
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
