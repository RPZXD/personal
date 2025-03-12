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

// Fetch distinct years from table_seminar
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
        <button id="addTraining" class="btn btn-lg btn-success my-2"> <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มข้อมูลการอบรม/สัมมนา</button>
          <div class="callout callout-success text-center">
          <img src="../dist/img/logo-phicha.png" alt="Phichai Logo" class="brand-image rounded-full opacity-80 mb-3 w-12 h-12 mx-auto">
                        
                        <h6 class="fw-bold bt-2">รายงานการอบรม/สัมมนา<br>
                        ของ     <?= $teacher_name?><br>
                        <span id="selected_term">-</span> ปีการศึกษา <span id="selected_year">-</span><br>
                        รวมชั่วโมงที่ได้รับการอรม/สัมมนา <span id="total_hours">-</span><br>
                        </h6>
                                <button class="btn btn-success text-left mb-3 mt-2" id="printButton" onclick="printPage()"> <i class="fa fa-print" aria-hidden="true"></i> พิมพ์รายงาน  <i class="fa fa-print" aria-hidden="true"></i></button>
                                
                <div class="row">
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
                                <?php endforeach; ?>
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
                            <th style="width:5%" class="text-center text-light bg-dark">ครั้งที่</th>
                            <th  class="text-center text-light bg-dark">ชื่อเรื่อง</th>
                            <th style="width: 10%;" class="text-center text-light bg-dark">วันที่</th>
                            <th class="text-center text-light bg-dark">จำนวนชั่วโมง</th>
                            <th class="text-center text-light bg-dark">ภาคเรียนที่</th>
                            <th class="text-center text-light bg-dark">เกียรติบัตร/หลักฐาน</th>
                            <th style="width: 20%" class="text-center text-light bg-dark">จัดการ</th>
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

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"> <!-- Changed modal size to large -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">รายละเอียดการอบรม/สัมมนา</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Training details will be populated here -->
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
        <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลการอบรม/สัมมนา</h5>
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
        <h5 class="modal-title" id="addModalLabel">เพิ่มข้อมูลการอบรม/สัมมนา</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addForm" enctype="multipart/form-data">
          <div class="form-group">
            <label for="addTopic">ชื่อเรื่อง:</label>
            <input type="text" class="form-control text-center" id="addTopic" name="topic" required>
          </div>
          <div class="form-group">
            <label>ช่วงวันที่อบรม/สัมมนา</label>
            <div class="flex gap-2">
                <div class="w-1/2">
                    <label for="addDateStart">เริ่มวันที่:</label>
                    <input type="date" class="form-control text-center" id="addDateStart" name="dstart" required>
                </div>
                <div class="w-1/2 ml-2">
                    <label for="addDateEnd">สิ้นสุดวันที่:</label>
                    <input type="date" class="form-control text-center" id="addDateEnd" name="dend" required>
                </div>
            </div>
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
            <label>จำนวนชั่วโมงในการอบรม/สัมมนา</label>
            <div class="flex gap-2">
                <div class="w-1/2">
                    <label for="addHours">จำนวนชั่วโมง:</label>
                    <input type="number" class="form-control text-center" id="addHours" name="hours" min="0" max="200" required>
                </div>
                <div class="w-1/2 ml-2">
                    <label for="addMinutes">จำนวนนาที:</label>
                    <input type="number" class="form-control text-center" id="addMinutes" name="mn" min="0" max="60" value="0" required>
                </div>
            </div>
        </div>

          <div class="form-group">
            <label for="addSupports">หน่วยงานที่จัด:</label>
            <input type="text" class="form-control text-center" id="addSupports" name="supports" required>
          </div>
          <div class="form-group">
            <label for="addPlace">สถานที่:</label>
            <input type="text" class="form-control text-center" id="addPlace" name="place" required>
          </div>
          <div class="form-group">
            <label>ข้อมูลการอบรม/สัมมนา</label>
            <div class="flex gap-2">
                <div class="w-1/2">
                    <label for="addType">ประเภทการอบรม/สัมมนา:</label>
                    <select name="types" id="addType" class="form-control text-center" required>
                        <option value="">เลือกประเภทการอบรม</option>
                        <option value="1">ภายใน</option>
                        <option value="2">ภายนอก</option>
                    </select>
                </div>
                <div class="w-1/2 ml-2">
                    <label for="addBudget">งบประมาณที่ใช้:</label>
                    <input type="number" class="form-control text-center" id="addBudget" name="budget" value="0" min="0" required>
                </div>
            </div>
        </div>
          <div class="form-group">
            <label for="addKnow">สรุปความรู้ที่ได้รับ:</label>
            <textarea name="know" id="addKnow" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label for="addWay">วิธีการ/แนวทาง ขยายผลให้ครู/บุคลากรในกลุ่มสาระฯ/ครูในโรงเรียน:</label>
            <textarea name="way" id="addWay" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label for="addSuggest">ข้อเสนอแนะเพิ่มเติม:</label>
            <textarea name="suggest" id="addSuggest" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="addSdoc">เกียติบัตร/หลักฐาน:</label>
            <input type="file" class="form-control text-center" id="addSdoc" name="sdoc" required accept="image/*">
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
  window.printPage = function() {
    let elementsToHide = $('#term_selector, #year_selector, #printButton, #filter, #reset, #addTraining, #footer, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info');

    // Hide the elements you want to exclude from the print
    elementsToHide.hide();
    $('thead').css('display', 'table-header-group'); // Ensure header shows

    // Hide the last column
    $('table tr').each(function() {
        $(this).find('td:last-child, th:last-child').hide();
    });

    setTimeout(() => {
        window.print();
        elementsToHide.show();

        // After printing, restore the last column
        $('table tr').each(function() {
            $(this).find('td:last-child, th:last-child').show();
        });
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

  $('#addTraining').on('click', function() {
    $('#addModal').modal('show');
  });

  $('#saveAdd').on('click', function() {
    const formData = new FormData(document.getElementById('addForm'));

    $.ajax({
      url: 'api/insert_training.php',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(data) {
        if (data.success) {
          Swal.fire('สำเร็จ', 'เพิ่มข้อมูลการอบรม/สัมมนาเรียบร้อยแล้ว', 'success');
          $('#addModal').modal('hide');
          // fetchTrainingData();
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
    document.getElementById('filter').addEventListener('click', fetchTrainingData);
    document.getElementById('reset').addEventListener('click', resetFilters);

    // Fetch training data on page load
    fetchTrainingData();

    function fetchTrainingData() {
        const tid = <?= json_encode($userData['Teach_id']); ?>;
        const term = document.getElementById('select_term').value;
        const year = document.getElementById('select_year').value;
        // console.log('Teacher ID:', tid); // Log the Teacher ID being sent
        // console.log('Term:', term); // Log the selected term
        // console.log('Year:', year); // Log the selected year

        // Update selected term and year
        const selectedTermElement = document.getElementById('selected_term');
        const selectedYearElement = document.getElementById('selected_year');
        if (selectedTermElement) {
            selectedTermElement.innerText = term ? `ภาคเรียนที่ ${term}` : '';
        }
        if (selectedYearElement) {
            selectedYearElement.innerText = year || '-';
        }

        $.ajax({
            url: 'api/fetch_training.php',
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
                    populateTrainingTable(data.data);
                    fetchTotalHours(tid, term, year);
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
                    
                } else {
                    // document.getElementById('total_hours').innerText = '-';
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
        // document.getElementById('total_hours').innerText = '-';
        fetchTrainingData();
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

    function populateTrainingTable(trainings) {
        const table = $('#record_table').DataTable();
        table.clear(); // Clear existing data

        let totalHours = 0;
        let totalMinutes = 0;

        if (trainings.length === 0) {
            table.row.add(['ไม่พบข้อมูล', '', '', '', '', '', '']).draw();
        } else {
            trainings.forEach((training, index) => {
                totalHours += parseInt(training.hours);
                totalMinutes += parseInt(training.mn);

                table.row.add([
                    index + 1,
                    training.topic,
                    convertToThaiDate(training.dstart),
                    `${training.hours} ชั่วโมง ${training.mn} นาที`,
                    `${training.term}/${training.year}`,
                    `<img src="<?= $setting->getImgTraining()?>${training.sdoc}" alt="Certificate" style="height: 150px; width: auto;">`,
                    `
                    <button class="btn btn-info my-1 mx-1 btn-print" data-id="${training.semid}">พิมพ์</button>
                    <button class="btn btn-primary my-1 mx-1 btn-view" data-id="${training.semid}">ดู</button>
                    <button class="btn btn-warning my-1 mx-1 btn-edit" data-id="${training.semid}">แก้ไข</button>
                    <button class="btn btn-danger my-1 mx-1 btn-del" data-id="${training.semid}">ลบ</button>
                    `
                ]).draw();
            });

            // Calculate total hours and minutes
            totalHours += Math.floor(totalMinutes / 60);
            totalMinutes = totalMinutes % 60;

            // Update footer with total hours
            document.getElementById('total_hours_footer').innerText = `${totalHours} ชั่วโมง ${totalMinutes} นาที`;
            document.getElementById('total_hours').innerText = `${totalHours} ชั่วโมง ${totalMinutes} นาที`;
            

            // Add event listeners for view, edit, and delete buttons
            document.querySelectorAll('.btn-view').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    viewTrainingDetails(id);
                });
            });

            document.querySelectorAll('.btn-print').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    window.open(`print_training.php?id=${id}`, '_blank');
                });
            });


            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    editTrainingDetails(id);
                });
            });

            document.querySelectorAll('.btn-del').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    deleteTrainingDetails(id);
                });
            });
        }
    }

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
            { "width": "300px", "targets": [1] }, // Set column width for columns 1 and 2
            { "targets": "_all", "render": function (data, type, row) {
                return '<div class="text-wrap">' + data + '</div>';
            }}
        ]
    });

    function viewTrainingDetails(id) {
        // Fetch training details and populate the view modal
        $.ajax({
            url: 'api/fetch_training_details.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function(data) {
                if (data.success) {
                    const details = `
                        <p><strong>ชื่อเรื่อง:</strong> ${data.details.topic}</p>
                        <p><strong>เริ่มวันที่:</strong> ${convertToThaiDate(data.details.dstart)}</p>
                        <p><strong>ถึงวันที่:</strong> ${convertToThaiDate(data.details.dend)}</p>
                        <p><strong>จำนวนชั่วโมง:</strong> ${data.details.hours}</p>
                        <p><strong>หน่วยงานที่จัด:</strong> ${data.details.supports}</p>
                        <p><strong>สถานที่:</strong> ${data.details.place}</p>
                        <p><strong>ภาคเรียนที่:</strong> ${data.details.term}/${data.details.year}</p>
                        <p><strong>งบประมาณที่ใช้:</strong> ${data.details.budget} บาท</p>
                        <hr>
                        <p><strong>ความรู้ที่ได้รับ:</strong> ${data.details.know}</p>
                        <p><strong>วิธีการ/แนวทาง ขยายผลให้ครู/บุคลากรในกลุ่มสาระฯ/ครูในโรงเรียน:</strong> ${data.details.way}</p>
                        <p><strong>ข้อเสนอแนะเพิ่มเติม:</strong> ${data.details.suggest}</p>
                        <hr>
                        <p><strong>เกียรติบัตร/หลักฐาน:</strong> <img src="<?= $setting->getImgTraining()?>${data.details.sdoc}" alt="Certificate" style="height: 150px; width: auto;"></p>
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

    function editTrainingDetails(id) {
        // Fetch training details and populate the edit form
        $.ajax({
            url: 'api/fetch_training_details.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function(data) {
                if (data.success) {
                    const form = `
                        <div class="form-group">
                            <label for="editTopic">ชื่อเรื่อง:</label>
                            <input type="text" class="form-control" id="editTopic" name="topic" value="${data.details.topic}">
                        </div>
                        <div class="form-group">
                        <label for="editDateStart">เริ่มวันที่:</label>
                        <input type="date" class="form-control" id="editDateStart" name="dstart" value="${data.details.dstart}">
                        </div>
                        <div class="form-group">
                        <label for="editDateEnd">สิ้นสุดวันที่:</label>
                        <input type="date" class="form-control" id="editDateEnd" name="dend" value="${data.details.dend}">
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
                            <label for="editHours">จำนวนชั่วโมง:</label>
                            <input type="number" class="form-control" id="editHours" name="hours" value="${data.details.hours}">
                        </div>
                        <div class="form-group">
                            <label for="editMinutes">จำนวนนาที:</label>
                            <input type="number" class="form-control" id="editMinutes" name="mn" value="${data.details.mn}">
                        </div>
                        <div class="form-group">
                            <label for="editSupports">หน่วยงานที่จัด:</label>
                            <input type="text" class="form-control" id="editSupports" name="supports" value="${data.details.supports}">
                        </div>
                        <div class="form-group">
                            <label for="editPlace">สถานที่:</label>
                            <input type="text" class="form-control" id="editPlace" name="place" value="${data.details.place}">
                        </div>
                        <div class="form-group">
                            <label for="editType">ประเภทการอบรม/สัมมนา:</label>
                            <input type="text" class="form-control" id="editType" name="types" value="${data.details.types}">
                        </div>
                        <div class="form-group">
                            <label for="editBudget">งบประมาณที่ใช้:</label>
                            <input type="number" class="form-control" id="editBudget" name="budget" value="${data.details.budget}">
                        </div>
                        <div class="form-group">
                            <label for="editKnow">สรุปความรู้ที่ได้รับ:</label>
                            <input type="text" class="form-control" id="editKnow" name="know" value="${data.details.know}">
                        </div>
                        <div class="form-group">
                            <label for="editWay">วิธีการ/แนวทาง ขยายผลให้ครู/บุคลากรในกลุ่มสาระฯ/ครูในโรงเรียน:</label>
                            <input type="text" class="form-control" id="editWay" name="way" value="${data.details.way}">
                        </div>
                        <div class="form-group">
                            <label for="editSuggest">ข้อเสนอแนะเพิ่มเติม:</label>
                            <input type="text" class="form-control" id="editSuggest" name="suggest" value="${data.details.suggest}">
                        </div>

                        <div class="form-group">
                            <label for="editSdoc">เกียรติบัตร/หลักฐาน:</label>
                            <input type="file" class="form-control" id="editSdoc" name="sdoc">
                            <img src="<?= $setting->getImgTraining()?>${data.details.sdoc}" alt="Certificate" style="height: 150px; width: auto; margin-top: 10px;">
                        </div>
                        <input type="hidden" id="editTid" name="tid" value="${data.details.tid}">
                        <input type="hidden" id="editId" name="semid" value="${data.details.semid}">
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
        formData.append('semid', id);

        $.ajax({
            url: 'api/update_training.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    Swal.fire('สำเร็จ', 'บันทึกการเปลี่ยนแปลงเรียบร้อยแล้ว', 'success');
                    $('#editModal').modal('hide');
                    fetchTrainingData();
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

    function deleteTrainingDetails(id) {
      Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการลบข้อมูลการอบรม/สัมมนานี้หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'api/del_training.php',
            method: 'POST',
            dataType: 'json',
            data: { id: id },
            success: function(data) {
              if (data.success) {
                Swal.fire('ลบแล้ว!', 'ข้อมูลการอบรม/สัมมนาถูกลบเรียบร้อยแล้ว.', 'success');
                fetchTrainingData();
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
</script>

<?php require_once('script.php');?>
</body>
</html>
