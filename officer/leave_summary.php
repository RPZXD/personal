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

require_once('header.php');

?>
<style>
  .vertical-text {
    writing-mode: vertical-rl; /* หมุนตัวอักษรจากล่างขึ้นบน */
    transform: rotate(180deg); /* หมุนกลับให้ตรง */
    white-space: nowrap;
}

@media print {
    body {
        background-color: white !important;
        color: black !important;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        background-color: white;
    }
    th, td {
        border: 1px solid black !important;
        padding: 5px;
        color: black !important;
        background-color: white !important;
    }
    .vertical-text {
        writing-mode: vertical-rl;
        transform: rotate(180deg);
        white-space: nowrap;
        font-size: 10px;
    }
}


</style>
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
        <button class="btn btn-success text-left mb-3 mt-2" id="printButton" onclick="printPage()"> <i class="fa fa-print" aria-hidden="true"></i> พิมพ์รายงาน  <i class="fa fa-print" aria-hidden="true"></i></button>
          <div class="callout callout-success text-center">
          <img src="../dist/img/logo-phicha.png" alt="Phichai Logo" id="logoPrint" class="brand-image rounded-full opacity-80 mb-3 w-12 h-12 mx-auto">
                        
                        <h6 class="font-bold bt-2">สรุปการมาปฏิบัติงานของข้าราชการครูและบุคคลากรทางการศึกษาโรงเรียนพิชัย
                        </h6>
                                
                                
                <div class="row mt-3">
                  <div class="col-md-12">
                    
                    <div class="row align-items-center">
                      
                      <div class="col-md-6 mx-auto">
                        <div class="input-group mb-3" id="date_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_date">เลือกวัน:</label>
                          </div>
                          <input type="date" class="form-control text-center" id="select_date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                      </div>
                    </div>
                <div>
                  <button id="filter" class="btn btn-sm btn-outline-info"> <i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                  <button id="reset" class="btn btn-sm btn-outline-warning"> <i class="fa fa-trash" aria-hidden="true"></i> ล้างค่า</button>
                </div>
        <div class="row">
            <div class="col-md-12 mt-3 mb-3 mx-auto">
              <div class="table-responsive mx-auto bg-white">
                <table class="display table-bordered responsive nowrap border border-black bg-white" id="record_table" style="width:100%;">
                    <thead class="thead-secondary">
                        <tr class="text-black border border-black bg-white">
                            <th rowspan="2" class="text-center p-2 w-[5%] align-middle border border-black ">ลำดับ</th>
                            <th rowspan="2" class="text-center p-2 w-[20%] align-middle border border-black ">ชื่อสกุล</th>
                            <th class="text-center p-2 border border-black " colspan="6">ตำแหน่ง</th>
                            <th class="text-center p-2 border border-black " colspan="7">สาเหตุ</th>
                        </tr>
                        <tr class="text-black border border-black bg-white">
                            <th class="text-center p-2 vertical-text border border-black text-xs">ผู้บริหาร</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ครู</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">พนักงานราชการ</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ลูกจ้างประจำ</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ลูกจ้างชั่วคราว (สพฐ.)</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ลูกจ้างชั่วคราว (บกศ.)</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ไปราชการ</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ลากิจ</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ลาป่วย</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ลาคลอดบุตร</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ลาบวช</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">มาสาย</th>
                            <th class="text-center p-2 vertical-text border border-black text-xs">ไม่ทราบสาเหตุ</th>
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
      let elementsToHide = $('#printButton,#date_selector, #filter, #reset, #addLeave, #footer, #range1, #range2, #customRange, #dateRangeSelector, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info');
      let lastColumn = $();

      elementsToHide.hide();
      lastColumn.hide(); // Hide the last column
      $('thead').css('display', 'table-header-group'); // บังคับให้หัวข้อแสดง

      setTimeout(() => {
          window.print();
          elementsToHide.show();
          lastColumn.show(); // Show the last column after printing
      }, 100);
  };

  // Function to set up the print layout
  function setupPrintLayout() {
    // Set page properties for landscape A4 with 0.5 inch margins
    var style = '@page { size: A4 portrait; margin: 0.5in; }';
    var printStyle = document.createElement('style');
    printStyle.appendChild(document.createTextNode(style));
    document.head.appendChild(printStyle);
  }

  // Call setupPrintLayout when document is ready
  setupPrintLayout();

  // Fetch data when date is selected
  $('#select_date').change(function() {
    fetchLeaveData();
  });

});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filter').addEventListener('click', fetchLeaveData);
    document.getElementById('reset').addEventListener('click', resetFilters);

    function fetchLeaveData() {
        const selectedDate = document.getElementById('select_date').value;

        $.ajax({
            url: 'api/fetch_leave_summary.php',
            method: 'GET',
            dataType: 'json',
            data: {
                date: selectedDate
            },
            success: function(data) {
                if (data.success) {
                    populateLeaveTable(data.data);
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
        document.getElementById('select_date').value = '<?php echo date('Y-m-d'); ?>';
        fetchLeaveData();
    }

    function populateLeaveTable(leaves) {
        const table = $('#record_table').DataTable();
        table.clear(); // Clear existing data

        if (leaves.length === 0) {
            table.row.add(['', '', '', '', '', '', '', '', '', '', '', '', '', '', '']).draw();
        } else {
            leaves.forEach((leave, index) => {
                table.row.add([
                    index + 1,
                    leave.teacher_details[0].Teach_name,
                    leave.teacher_details[0].Teach_Position2 === 'ผู้บริหาร' ? '✔' : '',
                    leave.teacher_details[0].Teach_Position2 === 'ครู' ? '✔' : '',
                    leave.teacher_details[0].Teach_Position2 === 'พนักงานราชการ' ? '✔' : '',
                    leave.teacher_details[0].Teach_Position2 === 'ลูกจ้างประจำ' ? '✔' : '',
                    leave.teacher_details[0].Teach_Position2 === 'ลูกจ้างชั่วคราว (สพฐ.)' ? '✔' : '',
                    leave.teacher_details[0].Teach_Position2 === 'ลูกจ้างชั่วคราว (บกศ.)' ? '✔' : '',
                    leave.status === 3 ? '✔' : '',
                    leave.status === 2 ? '✔' : '',
                    leave.status === 1 ? '✔' : '',
                    leave.status === 4 ? '✔' : '',
                    leave.other_leave_type === 'ลาอุปสมบท' ? '✔' : '',
                    leave.status === 6 ? '✔' : '',
                    leave.status === 7 ? '✔' : ''
                ]).draw();
            });
        }
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
          "autoWidth": false, // ปิด autoWidth เพื่อควบคุมขนาดคอลัมน์เอง
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
              { "orderable": false, "targets": [0] }, // ปิดการเรียงลำดับของคอลัมน์แรก
              { "className": "text-left", "targets": [1] }, // จัดกึ่งกลางทุกคอลัมน์
              { "className": "text-center", "targets": [0] }, // จัดกึ่งกลางทุกคอลัมน์
              { "width": "400px", "targets": [5] }, // กำหนดขนาดคอลัมน์ที่ 1,2 ไม่ให้กว้างเกินไป
              { "targets": "_all", "render": function (data, type, row) {
                  return '<div class="text-wrap">' + data + '</div>';
              }}
          ]
      });
  });

});
</script>

<?php require_once('script.php');?>
</body>
</html>
