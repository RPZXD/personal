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
        <button id="addLeave" class="btn btn-lg btn-success my-2"> <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มการแจ้งลา</button>
          <div class="callout callout-success text-center">
          <img src="../dist/img/logo-phicha.png" alt="Phichai Logo" id="logoPrint" class="brand-image rounded-full opacity-80 mb-3 w-12 h-12 mx-auto">
                        
                        <h6 class="font-bold bt-2">รายงานการลา<br>
                        ของ     <?= $teacher_name?><br>
                        <br>
                        </h6>
                                <button class="btn btn-success text-left mb-3 mt-2" id="printButton" onclick="printPage()"> <i class="fa fa-print" aria-hidden="true"></i> พิมพ์รายงาน  <i class="fa fa-print" aria-hidden="true"></i></button>
                                
                <div class="row">
                  <div class="col-md-12">
                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons" id="dateRangeSelector">
                      <label class="btn btn-outline-info">
                        <input type="radio" name="dateRange" id="range1" autocomplete="off">ครึ่งปีแรก(1 ต.ค. - 31 มี.ค.)
                      </label>
                      <label class="btn btn-outline-warning">
                        <input type="radio" name="dateRange" id="range2" autocomplete="off">ครึ่งปีหลัง(1 เม.ย. - 30 ก.ย.)
                      </label>
                      <label class="btn btn-outline-primary">
                        <input type="radio" name="dateRange" id="customRange" autocomplete="off"> กำหนดเอง
                      </label>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-group mb-3" id="date_start_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_date_start">วันที่เริ่มต้น:</label>
                          </div>
                          <input type="date" class="form-control text-center" id="select_date_start">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="input-group mb-3" id="date_end_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_date_end">วันที่สิ้นสุด:</label>
                          </div>
                          <input type="date" class="form-control text-center" id="select_date_end" >
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
                            <th style="width: 10%;" class="text-center text-white bg-gray-800">แจ้งการลา</th>
                            <th class="text-center text-white bg-gray-800">วันที่เริ่มต้น</th>
                            <th class="text-center text-white bg-gray-800">วันที่สิ้นสุด</th>
                            <th class="text-center text-white bg-gray-800">รวมวันลา</th>
                            <th class="text-center text-white bg-gray-800">เหตุผล</th>
                            <th class="text-center text-white bg-gray-800">จัดการ</th>
                            <!-- Add more table column headers as needed -->
                        </tr>
                        </thead>       
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-center">รวมวันลาทั้งหมด</th>
                                <th id="total_leave_days" class="text-center">-</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-center">รวมวันลาป่วย</th>
                                <th id="total_sick_leave_days" class="text-center">-</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-center">รวมวันลากิจ</th>
                                <th id="total_personal_leave_days" class="text-center">-</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-center">รวมวันไปราชการ</th>
                                <th id="total_official_leave_days" class="text-center">-</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-center">รวมวันลาอื่นๆ</th>
                                <th id="total_other_leave_days" class="text-center">-</th>
                                <th></th>
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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">เพิ่มการแจ้งลา <span class="text-danger text-bold">** ข้อมูลจะถูกบันทึกไปเป็นใบลา **</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addForm">
          <div class="form-group">
            <label for="addStatus">แจ้งการลา:</label>
            <select name="status" id="addStatus" class="form-control text-center" required>
              <option value="">เลือก</option>
              <option value="1">ลาป่วย</option>
              <option value="2">ลากิจ</option>
              <option value="3">ไปราชการ</option>
              <option value="4">ลาคลอด</option>
              <option value="9">อื่นๆ</option>
            </select>
          </div>
          <div class="form-group" id="otherLeaveTypeGroup" style="display: none;">
            <label for="otherLeaveType">หัวข้อการลา (เช่น ลาอุปสมบท, ลาศึกษาต่อ):</label>
            <input type="text" class="form-control text-center" id="otherLeaveType" name="other_leave_type">
          </div>
          <div class="form-group">
            <label for="addDateStart">วันที่เริ่มต้น:</label>
            <input type="date" class="form-control text-center" id="addDateStart" name="date_start" required>
          </div>
          <div class="form-group">
            <label for="addDateEnd">วันที่สิ้นสุด:</label>
            <input type="date" class="form-control text-center" id="addDateEnd" name="date_end" required>
          </div>
          <div class="form-group">
              <label for="addDetail">เหตุผล:<span class="text-danger text-bold">** จำกัด 100 ตัวอักษร โปรดใช้คำให้เหมาะสม **</span></label>
              <textarea class="form-control text-center" id="addDetail" name="detail" required maxlength="100" oninput="updateCharCount()"></textarea>
              <small id="charCount">0 / 100</small>
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
      let elementsToHide = $('#printButton, #date_start_selector, #date_end_selector, #filter, #reset, #addLeave, #footer, #range1, #range2, #customRange, #dateRangeSelector, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info');
      let lastColumn = $('#record_table th:last-child, #record_table td:last-child');

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
    var style = '@page { size: A4 landscape; margin: 0.5in; }';
    var printStyle = document.createElement('style');
    printStyle.appendChild(document.createTextNode(style));
    document.head.appendChild(printStyle);
  }

  // Call setupPrintLayout when document is ready
  setupPrintLayout();

  $('#addLeave').on('click', function() {
    $('#addModal').modal('show');
  });

  $('#addStatus').change(function() {
    if ($(this).val() == '9') {
      $('#otherLeaveTypeGroup').show();
    } else {
      $('#otherLeaveTypeGroup').hide();
      $('#otherLeaveType').val('');
    }
  });

  $('#saveAdd').on('click', function() {
    const form = document.getElementById('addForm');
    const formData = new FormData(form);

    // Check if all required fields are filled
    let isValid = true;
    form.querySelectorAll('[required]').forEach(function(input) {
      if (!input.value) {
        isValid = false;
        input.classList.add('is-invalid');
      } else {
        input.classList.remove('is-invalid');
      }
    });

    if (!isValid) {
      Swal.fire('ข้อผิดพลาด', 'กรุณากรอกข้อมูลให้ครบทุกช่อง', 'error');
      return;
    }

    $.ajax({
      url: 'api/insert_leave.php', // Updated URL
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      beforeSend: function() {
        // Show progress bar
        Swal.fire({
            title: 'กำลังบันทึก...',
            text: 'กรุณารอสักครู่',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
      },
      success: function(data) {
        if (data.success) {
          Swal.fire('สำเร็จ', 'เพิ่มการแจ้งลาเรียบร้อยแล้ว', 'success').then(() => {
            $('#addModal').modal('hide');
            location.reload(); // Reload the page with updated data
          });
        } else {
          Swal.fire('ข้อผิดพลาด', data.message, 'error');
        }
      },
      error: function(error) {
        console.error('Error:', error);
        console.error('Error Details:', error.responseText);
        Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
      }
    });
  });

  $('input[name="dateRange"]').change(function() {
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const nextYear = currentYear + 1;
    const prevYear = currentYear - 1;

    if (this.id === 'range1') {
      if (currentDate < new Date(`${currentYear}-04-01`)) {
        $('#select_date_start').val(`${prevYear}-10-01`);
        $('#select_date_end').val(`${currentYear}-03-31`);
      } else {
        $('#select_date_start').val(`${currentYear}-10-01`);
        $('#select_date_end').val(`${nextYear}-03-31`);
      }
    } else if (this.id === 'range2') {
      if (currentDate < new Date(`${currentYear}-04-01`)) {
        $('#select_date_start').val(`${currentYear}-04-01`);
        $('#select_date_end').val(`${currentYear}-09-30`);
      } else {
        $('#select_date_start').val(`${nextYear}-04-01`);
        $('#select_date_end').val(`${nextYear}-09-30`);
      }
    } else {
      $('#select_date_start').val('');
      $('#select_date_end').val('');
    }
  });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filter').addEventListener('click', fetchLeaveData);
    document.getElementById('reset').addEventListener('click', resetFilters);

    // Automatically fetch data when date inputs or range options are changed
    document.getElementById('select_date_start').addEventListener('change', fetchLeaveData);
    document.getElementById('select_date_end').addEventListener('change', fetchLeaveData);
    document.getElementById('range1').addEventListener('change', fetchLeaveData);
    document.getElementById('range2').addEventListener('change', fetchLeaveData);
    document.getElementById('customRange').addEventListener('change', fetchLeaveData);

    // Fetch leave data on page load
    fetchLeaveData();
    updateCharCount();

    function fetchLeaveData() {
        const tid = <?= json_encode($userData['Teach_id']); ?>;
        const dateStart = document.getElementById('select_date_start').value;
        const dateEnd = document.getElementById('select_date_end').value;
        // console.log('Teacher ID:', tid); // Log the Teacher ID being sent
        // console.log('Date Start:', dateStart); // Log the selected start date
        // console.log('Date End:', dateEnd); // Log the selected end date

        $.ajax({
            url: 'api/fetch_leave.php',
            method: 'GET',
            dataType: 'json',
            data: {
                tid: tid,
                date_start: dateStart,
                date_end: dateEnd
            },
            success: function(data) {
                // console.log('Response Data:', data); // Log the response data
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
    function updateCharCount() {
    const textarea = document.getElementById("addDetail");
    const charCount = document.getElementById("charCount");
    const maxLength = 100;

    textarea.addEventListener("input", function () {
        const currentLength = textarea.value.length;

        // Update the character count display
        charCount.textContent = `${currentLength} / ${maxLength}`;

        // Change color to red if the limit is reached
        charCount.style.color = currentLength >= maxLength ? "red" : "black";

        // Trim the input if it exceeds the maximum length
        if (currentLength > maxLength) {
            textarea.value = textarea.value.substring(0, maxLength);
        }
    });
}

// Call the function to ensure it is set up
updateCharCount();

    function resetFilters() {
        document.getElementById('select_date_start').value = '';
        document.getElementById('select_date_end').value = '';
        fetchLeaveData();
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

    function populateLeaveTable(leaves) {
        const table = $('#record_table').DataTable();
        table.clear(); // Clear existing data

        let totalLeaveDays = 0;
        let totalSickLeaveDays = 0;
        let totalPersonalLeaveDays = 0;
        let totalOfficialLeaveDays = 0;
        let totalOtherLeaveDays = 0;

        if (leaves.length === 0) {
            table.row.add(['ไม่พบข้อมูล', '', '', '', '', '']).draw();
        } else {
            leaves.forEach((leave, index) => {
                // แปลงวันที่จากสตริงเป็น Date object
                const startDate = new Date(leave.date_start);
                const endDate = new Date(leave.date_end);

                // คำนวณจำนวนวัน (รวมวันแรกและวันสุดท้ายด้วย)
                const totalLeave = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                totalLeaveDays += totalLeave;

                // Update specific leave type totals
                switch (leave.status) {
                    case '1':
                        totalSickLeaveDays += totalLeave;
                        break;
                    case '2':
                        totalPersonalLeaveDays += totalLeave;
                        break;
                    case '3':
                        totalOfficialLeaveDays += totalLeave;
                        break;
                    case '9':
                        totalOtherLeaveDays += totalLeave;
                        break;
                }

                let printButton = '';
                if (['1', '2', '4', '9'].includes(leave.status)) {
                    printButton = `<a href="print_leave.php?id=${leave.id}" target="_blank" class="btn-sm btn-warning ">พิมพ์</a>`;
                }

                table.row.add([
                    index + 1,
                    getLeaveStatusText(leave.status),
                    convertToThaiDate(leave.date_start),
                    convertToThaiDate(leave.date_end),
                    totalLeave,
                    leave.detail,
                    printButton
                ]).draw();
            });

            // Update footer with total leave days
            document.getElementById('total_leave_days').innerText = totalLeaveDays;
            document.getElementById('total_sick_leave_days').innerText = totalSickLeaveDays;
            document.getElementById('total_personal_leave_days').innerText = totalPersonalLeaveDays;
            document.getElementById('total_official_leave_days').innerText = totalOfficialLeaveDays;
            document.getElementById('total_other_leave_days').innerText = totalOtherLeaveDays;
        }
    }

    function getLeaveStatusText(status) {
        switch (status) {
            case '1':
                return 'ลาป่วย';
            case '2':
                return 'ลากิจ';
            case '3':
                return 'ไปราชการ';
            case '4':
                return 'ลาคลอด';
            case '9':
                return 'อื่นๆ';
            default:
                return 'ไม่ระบุ';
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
              { "orderable": false, "targets": [0] }, 
              { "className": "text-center", "targets": "_all" }, 
              { "width": "300px", "targets": [5] }, // Set width for the "เหตุผล" column (index 5)
              { "targets": [5], "render": function (data, type, row) { // Target the "เหตุผล" column (index 5)
                  return '<div class="text-wrap" style="white-space: normal; word-wrap: break-word; max-width: 300px;">' + data + '</div>';
              }}
          ]
      });
  });


});
</script>

<?php require_once('script.php');?>
</body>
</html>
