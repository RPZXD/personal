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
        

<!-- Filter Controls -->
<div class="w-full flex flex-wrap gap-4 mb-6 justify-center items-end">
  <div class="flex flex-col">
    <label for="select_department" class="mb-1 font-semibold text-gray-700">กลุ่มสาระ</label>
    <select name="select_department" id="select_department" class="block w-48 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      <option value="">เลือกกลุ่ม</option>
      <?php foreach ($majors as $major): ?>
        <option value="<?= $major['Teach_major'] ?>"><?= $major['Teach_major'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="flex flex-col">
    <label for="select_teacher" class="mb-1 font-semibold text-gray-700">ครู</label>
    <select name="select_teacher" id="select_teacher" class="block w-48 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      <option value="">เลือกครู</option>
    </select>
  </div>
  <div class="flex flex-col">
    <label for="select_date_start" class="mb-1 font-semibold text-gray-700">วันที่เริ่มต้น</label>
    <input type="date" id="select_date_start" class="block w-44 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
  </div>
  <div class="flex flex-col">
    <label for="select_date_end" class="mb-1 font-semibold text-gray-700">วันที่สิ้นสุด</label>
    <input type="date" id="select_date_end" class="block w-44 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
  </div>
  <div class="flex flex-col">
    <button id="filter" class="w-32 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2">ค้นหา</button>
    <button id="reset" class="w-32 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">ล้างค่า</button>
  </div>
</div>

<!-- Tailwind Leave Summary Cards -->
<div class="flex flex-wrap gap-4 mb-6 justify-center">
  <div class="w-48 bg-blue-600 text-white rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
    <div class="px-4 py-2 font-semibold text-center border-b border-blue-700">รวมวันลาทั้งหมด</div>
    <div class="p-4 text-3xl font-bold text-center animate-pulse" id="card_total_leave_days">-</div>
  </div>
  <div class="w-48 bg-red-500 text-white rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
    <div class="px-4 py-2 font-semibold text-center border-b border-red-600">ลาป่วย</div>
    <div class="p-4 text-3xl font-bold text-center" id="card_total_sick_leave_days">-</div>
  </div>
  <div class="w-48 bg-yellow-400 text-gray-900 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
    <div class="px-4 py-2 font-semibold text-center border-b border-yellow-500">ลากิจ</div>
    <div class="p-4 text-3xl font-bold text-center" id="card_total_personal_leave_days">-</div>
  </div>
  <div class="w-48 bg-green-500 text-white rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
    <div class="px-4 py-2 font-semibold text-center border-b border-cyan-600">ไปราชการ</div>
    <div class="p-4 text-3xl font-bold text-center" id="card_total_official_leave_days">-</div>
  </div>
  <div class="w-48 bg-gray-700 text-white rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
    <div class="px-4 py-2 font-semibold text-center border-b border-gray-800">ลาอื่นๆ</div>
    <div class="p-4 text-3xl font-bold text-center" id="card_total_other_leave_days">-</div>
  </div>
</div>

<!-- Tailwind Leave Regulation Card -->
<!-- <div class="w-full mb-6 flex justify-center">
  <div class="w-full max-w-2xl bg-green-100 border-l-4 border-green-500 rounded-xl shadow p-6">
    <div class="flex items-center mb-2">
      <svg class="w-6 h-6 text-green-600 mr-2 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z"/></svg>
      <span class="font-bold text-green-700 text-lg">ระเบียบวันลาตามแนวปฏิบัติ (ข้าราชการครู)</span>
    </div>
    <ul class="list-disc pl-6 text-green-900">
      <li>ลาป่วย: <span class="font-bold">ไม่เกิน 30 วัน/ปี</span></li>
      <li>ลากิจ: <span class="font-bold">ไม่เกิน 10 วัน/ปี</span></li>
      <li>ไปราชการ: <span class="font-bold">ตามที่ได้รับอนุมัติ</span></li>
      <li>ลาอื่นๆ: <span class="font-bold">ตามระเบียบ</span></li>
    </ul>
    <div id="leave-warning" class="mt-3"></div>
  </div>
</div> -->

<div class="overflow-x-auto rounded-xl shadow-lg bg-white">
  <table class="min-w-full divide-y divide-gray-200" id="record_table">
    <thead class="bg-gray-800">
      <tr>
        <th class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider">ครั้งที่</th>
        <th class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider">แจ้งการลา</th>
        <th class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider">วันที่เริ่มต้น</th>
        <th class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider">วันที่สิ้นสุด</th>
        <th class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider">รวมวันลา</th>
        <th class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider">เหตุผล</th>
        <th class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider">จัดการ</th>
      </tr>
    </thead>
    <tbody></tbody>
    <tfoot class="bg-gray-100">
      <tr>
        <th colspan="5" class="text-center font-semibold">รวมวันลาทั้งหมด</th>
        <th id="total_leave_days" class="text-center">-</th>
        <th></th>
      </tr>
      <tr>
        <th colspan="5" class="text-center font-semibold">รวมวันลาป่วย</th>
        <th id="total_sick_leave_days" class="text-center">-</th>
        <th></th>
      </tr>
      <tr>
        <th colspan="5" class="text-center font-semibold">รวมวันลากิจ</th>
        <th id="total_personal_leave_days" class="text-center">-</th>
        <th></th>
      </tr>
      <tr>
        <th colspan="5" class="text-center font-semibold">รวมวันไปราชการ</th>
        <th id="total_official_leave_days" class="text-center">-</th>
        <th></th>
      </tr>
      <tr>
        <th colspan="5" class="text-center font-semibold">รวมวันลาอื่นๆ</th>
        <th id="total_other_leave_days" class="text-center">-</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลการลา</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editLeaveId" name="id">
                    <input type="hidden" id="editTeacherId" name="tid"> <!-- Add this line -->
                    <div class="form-group">
                        <label for="editStatus">สถานะการลา</label>
                        <select class="form-control" id="editStatus" name="status" required>
                            <option value="1">ลาป่วย</option>
                            <option value="2">ลากิจ</option>
                            <option value="3">ไปราชการ</option>
                            <option value="4">ลาคลอด</option>
                            <option value="9">อื่นๆ</option>
                        </select>
                    </div>
                    <div class="form-group" id="editOtherLeaveTypeGroup" style="display: none;">
                        <label for="editOtherLeaveType">ระบุประเภทการลาอื่นๆ</label>
                        <input type="text" class="form-control" id="editOtherLeaveType" name="other_leave_type">
                    </div>
                    <div class="form-group">
                        <label for="editStartDate">วันที่เริ่มต้น</label>
                        <input type="date" class="form-control" id="editStartDate" name="date_start" required>
                    </div>
                    <div class="form-group">
                        <label for="editEndDate">วันที่สิ้นสุด</label>
                        <input type="date" class="form-control" id="editEndDate" name="date_end" required>
                    </div>
                    <div class="form-group">
                        <label for="editDetail">รายละเอียด</label>
                        <textarea class="form-control" id="editDetail" name="detail" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="saveEdit">บันทึกการแก้ไข</button>
            </div>
        </div>
    </div>
</div>


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
            <label for="addDepartment">เลือกกลุ่ม:</label>
            <select name="department" id="addDepartment" class="form-control text-center" required>
              <option value="">เลือกกลุ่ม</option>
              <?php foreach ($majors as $major): ?>
                <option value="<?= $major['Teach_major'] ?>"><?= $major['Teach_major'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="addTeacher">เลือกครู:</label>
            <select name="teacher" id="addTeacher" class="form-control text-center" required>
              <option value="">เลือกครู</option>
            </select>
          </div>
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
      let elementsToHide = $('#printButton,#department_selector,#teacher_selector, #date_start_selector, #date_end_selector, #filter, #reset, #addLeave, #footer, #range1, #range2, #customRange, #dateRangeSelector, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info');
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
        // console.error('Error:', error);
        // console.error('Error Details:', error.responseText);
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
          // console.error('Error:', error);
          Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูลครู', 'error');
        }
      });
    } else {
      $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
    }
  });
  
  $('#addDepartment').change(function() {
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
            $('#addTeacher').empty().append('<option value="">เลือกครู</option>');
            teachers.forEach(function(teacher) {
              $('#addTeacher').append(`<option value="${teacher.Teach_id}">${teacher.Teach_name}</option>`);
            });
          } else {
            Swal.fire('ข้อผิดพลาด', data.message, 'error');
          }
        },
        error: function(error) {
          // console.error('Error:', error);
          Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูลครู', 'error');
        }
      });
    } else {
      $('#addTeacher').empty().append('<option value="">เลือกครู</option>');
    }
  });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filter').addEventListener('click', fetchLeaveData);
    document.getElementById('reset').addEventListener('click', resetFilters);

    
    function fetchLeaveData() {
        const tid = document.getElementById('select_teacher').value;
        const dateStart = document.getElementById('select_date_start').value;
        const dateEnd = document.getElementById('select_date_end').value;


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
                    $('#selected_teacher').text($('#select_teacher option:selected').text());
                    $('#selected_department').text($('#select_department option:selected').text());
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
                // Robust date parsing
                let totalLeave = 0;
                let printButton = '', editButton = '', delButton = '';
                try {
                    const startDate = new Date(leave.date_start);
                    const endDate = new Date(leave.date_end);
                    if (!isNaN(startDate) && !isNaN(endDate) && startDate <= endDate) {
                        // Count only weekdays (Mon-Fri)
                        let current = new Date(startDate);
                        while (current <= endDate) {
                            const day = current.getDay();
                            if (day !== 0 && day !== 6) { // 0 = Sunday, 6 = Saturday
                                totalLeave++;
                            }
                            current.setDate(current.getDate() + 1);
                        }
                    }
                } catch (e) {
                    totalLeave = 0;
                }
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

                if (['1', '2', '4', '9'].includes(leave.status)) {
                    printButton = `<a href="print_leave.php?id=${leave.id}" target="_blank" class="btn-sm bg-blue-500 text-white ml-2 mt-2">พิมพ์</a>`;
                    editButton = `<button class="btn-sm bg-yellow-500 text-white ml-2 mt-2 edit-leave" data-id="${leave.id}">แก้ไข</button>`;
                    delButton = `<button class="btn-sm bg-red-500 text-white ml-2 mt-2 del-leave" data-id="${leave.id}">ลบ</button>`;
                }

                table.row.add([
                    index + 1,
                    getLeaveStatusText(leave.status),
                    convertToThaiDate(leave.date_start),
                    convertToThaiDate(leave.date_end),
                    totalLeave,
                    leave.detail,
                    printButton + editButton + delButton
                ]).draw();
            });

            // Update footer and summary cards with total leave days
            document.getElementById('total_leave_days').innerText = totalLeaveDays;
            document.getElementById('total_sick_leave_days').innerText = totalSickLeaveDays;
            document.getElementById('total_personal_leave_days').innerText = totalPersonalLeaveDays;
            document.getElementById('total_official_leave_days').innerText = totalOfficialLeaveDays;
            document.getElementById('total_other_leave_days').innerText = totalOtherLeaveDays;

            // Update summary cards
            document.getElementById('card_total_leave_days').innerText = totalLeaveDays;
            document.getElementById('card_total_sick_leave_days').innerText = totalSickLeaveDays;
            document.getElementById('card_total_personal_leave_days').innerText = totalPersonalLeaveDays;
            document.getElementById('card_total_official_leave_days').innerText = totalOfficialLeaveDays;
            document.getElementById('card_total_other_leave_days').innerText = totalOtherLeaveDays;

            // Regulation warning
            let warning = '';
            if (totalSickLeaveDays > 30) {
                warning += '<span class="bg-red-500 text-white px-2 py-1 rounded">ลาป่วยเกิน 30 วัน/ปี</span> ';
            }
            if (totalPersonalLeaveDays > 10) {
                warning += '<span class="bg-red-500 text-white px-2 py-1 rounded">ลากิจเกิน 10 วัน/ปี</span> ';
            }
            document.getElementById('leave-warning').innerHTML = warning;
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

  $(document).on('click', '.edit-leave', function() {
        const leaveId = $(this).data('id');
        $.ajax({
            url: 'api/get_leave.php', // สร้างไฟล์ api/get_leave.php เพื่อดึงข้อมูลการลา
            method: 'GET',
            dataType: 'json',
            data: { id: leaveId },
            success: function(data) {
                if (data.success) {
                    const leave = data.data;
                    // console.log('Leave Data:', leave);
                    $('#editLeaveId').val(leave.id);
                    $('#editTeacherId').val(leave.Teach_id); // Add this line
                    $('#editStatus').val(leave.status);
                    if (leave.status === '9') {
                        $('#editOtherLeaveTypeGroup').show();
                        $('#editOtherLeaveType').val(leave.other_leave_type);
                    } else {
                        $('#editOtherLeaveTypeGroup').hide();
                        $('#editOtherLeaveType').val('');
                    }
                    $('#editStartDate').val(leave.date_start);
                    $('#editEndDate').val(leave.date_end);
                    $('#editDetail').val(leave.detail);
                    $('#editModal').modal('show');
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
            }
        });
    });

    $(document).on('click', '.del-leave', function() {
        const leaveId = $(this).data('id');

        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/del_leave.php',
                    method: 'POST',
                    dataType: 'json',
                    data: { id: leaveId },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('ลบสำเร็จ!', 'ข้อมูลการลาถูกลบเรียบร้อย', 'success');
                            $(`.del-leave[data-id="${leaveId}"]`).closest('tr').remove(); // ลบแถวจากตาราง (ถ้าอยู่ในตาราง)
                        } else {
                            Swal.fire('ข้อผิดพลาด', response.message || 'ไม่สามารถลบข้อมูลได้', 'error');
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                    }
                });
            }
        });
    });


    // Handle save edit button click
    $('#saveEdit').on('click', function() {
        const form = document.getElementById('editForm');
        const formData = new FormData(form);

        // Log FormData entries
        // for (let [key, value] of formData.entries()) {
        //     console.log(key, value);
        // }

        $.ajax({
            url: 'api/update_leave.php', // สร้างไฟล์ api/update_leave.php เพื่ออัปเดตข้อมูลการลา
            method: 'POST',
            data: JSON.stringify(Object.fromEntries(formData.entries())), // Convert FormData to JSON string
            contentType: 'application/json',
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    Swal.fire('สำเร็จ', 'แก้ไขข้อมูลการลาเรียบร้อยแล้ว', 'success').then(() => {
                        $('#editModal').modal('hide');
                        fetchLeaveData(); // รีโหลดข้อมูล
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        });
    });

    // Show/hide other leave type input
    $('#editStatus').change(function() {
        if ($(this).val() === '9') {
            $('#editOtherLeaveTypeGroup').show();
        } else {
            $('#editOtherLeaveTypeGroup').hide();
            $('#editOtherLeaveType').val('');
        }
    });


});
</script>

<?php require_once('script.php');?>
</body>
</html>
