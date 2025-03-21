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
                        
                        <h6 class="font-bold bt-2">รายงานบันทึกการอบรม<br>
                        <span id="selected_month"></span><br>
                        <br>
                        </h6>
                                <button class="btn btn-success text-left mb-3 mt-2" id="printButton" onclick="printPage()"> <i class="fa fa-print" aria-hidden="true"></i> พิมพ์รายงาน  <i class="fa fa-print" aria-hidden="true"></i></button>
                                
                <div class="row">
                  <div class="col-md-12">
                    
                    <div class="row justify-content-center">
                      <div class="col-md-3">
                        <div class="input-group mb-3" id="term_selector">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="select_month">เลือกเดือน:</label>
                          </div>
                          <input type="month" lang="th" class="form-control text-center text-bold" name="select_month" id="select_month">
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
                    <table class="display table-bordered responsive" id="record_table" style="width:100%;">
                        <thead class="table-dark text-white text-center">
                        <tr >
                            <th style="width:10%" class="text-center text-white bg-gray-800">ที่</th>
                            <th  class="text-center text-white bg-gray-800">ชื่อ-สกุล</th>
                            <th  class="text-center text-white bg-gray-800">กลุ่มสาระฯ</th>
                            <th style="width:20%" class="text-center text-white bg-gray-800">เรื่อง</th>
                            <th class="text-center text-white bg-gray-800">ว/ด/ป</th>
                            <th class="text-center text-white bg-gray-800">สถานที่</th>
                            <th class="text-center text-white bg-gray-800">งบประมาณ</th>
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
  // Initialize DataTable
  var table = $('#record_table').DataTable({
    "pageLength": 10,
    "paging": true,
    "lengthChange": true,
    "ordering": true,
    "responsive": true,
    "dom": 'Bfrtip',
    "buttons": [
        {
            extend: 'excelHtml5',
            text: '<span class="btn btn-success">Export to Excel</span>',
            className: 'btn btn-success',
            exportOptions: {
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
      "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Thai.json"
    },
    "columns": [
      { "width": "5%" }, // ที่
      { "width": "20%" }, // ชื่อ - สกุล
      { "width": "10%" }, // กลุ่มสาระ
      { "width": "20%" }, //เรื่อง
      { "width": "10%" }, // ว/ด/ป
      { "width": "10%" }, // สถานที่
      { "width": "10%" } // งบประมาณ
    ]
  });

  // Function to handle printing
  window.printPage = function () {
      let elementsToHide = $('#printButton,#department_selector,#teacher_selector, #term_selector, #year_selector, #filter, #reset, #footer, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info');
      // let lastColumn = $('#record_table th:last-child, #record_table td:last-child');

      elementsToHide.hide();
      // lastColumn.hide(); // Hide the last column
      $('thead').css('display', 'table-header-group'); // Force the header to display

      setTimeout(() => {

          window.print();
          elementsToHide.show();
          // lastColumn.show(); // Show the last column after printing
      }, 100);
  };

  // Function to set up the print layout
  function setupPrintLayout() {
    // Set page properties for landscape A4 with 0.5 inch margins
    var style = '@page { size: A4 portrait ; margin: 0.5in; }';
    var printStyle = document.createElement('style');
    printStyle.appendChild(document.createTextNode(style));
    document.head.appendChild(printStyle);
  }

  // Call setupPrintLayout when document is ready
  setupPrintLayout();


  $('#filter').click(function() {
    fetchTrainingSummary();
  });

  $('#select_month').change(function() {
      let month = $('#select_month').val();

      if (month) {
          fetchTrainingSummary();
      }
  });


  function fetchTrainingSummary() {
    const month = $('#select_month').val();

    $.ajax({
      url: 'api/fetch_training_month.php',
      method: 'GET',
      dataType: 'json',
      data: {
        month: month
      },
      success: function(data) {
        if (data.success) {
          populateTrainingTable(data.data);
          $('#selected_month').text($('#select_month').val());
        } else {
          Swal.fire('ข้อผิดพลาด', data.message, 'error');
        }
      },
      error: function(error) {
        Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
      }
    });
  }

  function populateTrainingTable(data) {
    const tableBody = $('#record_table tbody');
    
    table.clear().draw(); // Clear the table before adding new data

    if (data.length > 0) {
      data.forEach((record, index) => {
        let row = `<tr>
          <td class="text-center">${index + 1}</td>
          <td class="text-left ml-2">${record.teacher_name}</td>
          <td>${record.teacher_department}</td>
          <td class="text-center">${record.topic}</td>
          <td class="text-center">${formatThaiDate(record.dstart)} - ${formatThaiDate(record.dend)}</td>
          <td class="text-center">${record.place}</td>
          <td class="text-right">${record.budget.toLocaleString('th-TH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} บาท</td>
        </tr>`;

        table.row.add($(row)).draw(); // Add new data to the table
      });
    } else {
      const row = `<tr><td colspan="7" class="text-center">ไม่มีข้อมูล</td></tr>`;
      table.row.add($(row)).draw(); // Add no data row to the table
    }
}

  function formatThaiDate(date) {
    const months = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    const d = new Date(date);
    const day = d.getDate();
    const month = months[d.getMonth()];
    const year = d.getFullYear() + 543;
    return `${day} ${month} ${year}`;
  }


});
</script>

<?php require_once('script.php');?>
</body>
</html>
