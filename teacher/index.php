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
                    <div class="callout callout-success text-center">
                        <h4 class="text-green-600">ยินดีต้อนรับคุณครู <?php echo $userData['Teach_name'] ?> เข้าสู่ระบบบริหารทั่วไป | โรงเรียนพิชัย</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="term">เลือกเทอม:</label>
                    <select id="term" class="form-control text-center">
                        <option value="" <?php echo $term == '' ? 'selected' : ''; ?>>ทั้งหมด</option>
                        <option value="1" <?php echo $term == '1' ? 'selected' : ''; ?>>ภาคเรียนที่ 1</option>
                        <option value="2" <?php echo $term == '2' ? 'selected' : ''; ?>>ภาคเรียนที่ 2</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="year">เลือกปี:</label>
                    <select id="year" class="form-control text-center">
                        <option value="" <?php echo $pee == '' ? 'selected' : ''; ?>>ทั้งหมด</option>
                        <?php foreach ($years as $year): ?>
                        <option value="<?= $year['year'] ?>" <?php echo $pee == $year['year'] ? 'selected' : ''; ?>><?= $year['year'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">ชั่วโมงการอบรม</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">จำนวนรางวัลที่ได้รับ</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="donutChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">จำนวนการลา</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="donutChart3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php require_once('../footer.php'); ?>
</div>
<!-- ./wrapper -->

<?php require_once('script.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('donutChart').getContext('2d');
    const donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let value = tooltipItem.raw || 0;
                            return `${value} ชั่วโมง`; // เพิ่มหน่วย ชั่วโมง
                        }
                    }
                }
            }
        }
    });

    const ctx2 = document.getElementById('donutChart2').getContext('2d');
    const donutChart2 = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let value = tooltipItem.raw || 0;
                            return `${value} รางวัล`; // เพิ่มหน่วย รางวัล
                        }
                    }
                }
            }
        }
    });

    const ctx3 = document.getElementById('donutChart3').getContext('2d');
    const donutChart3 = new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let value = tooltipItem.raw || 0;
                            return `${value} วัน`; // เพิ่มหน่วย รางวัล
                        }
                    }
                }
            }
        }
    });

    function fetchData() {
        const term = document.getElementById('term').value;
        const year = document.getElementById('year').value;

        fetch(`api/fetch_chart_training.php?tid=<?php echo $teacher_id; ?>&term=${term}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                donutChart.data.labels = data.map(item => item.topic);
                donutChart.data.datasets[0].data = data.map(item => parseFloat(item.total_hours)); // แปลงเป็นตัวเลข
                donutChart.update();
            });

        fetch(`api/fetch_chart_award.php?tid=<?php echo $teacher_id; ?>&term=${term}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                donutChart2.data.labels = data.map(item => item.level_name);
                donutChart2.data.datasets[0].data = data.map(item => item.total_awards); // Adjust based on your data structure
                donutChart2.update();
            });

        fetch(`api/fetch_chart_leave.php?tid=<?php echo $teacher_id; ?>&term=${term}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                donutChart3.data.labels = data.map(item => item.status_name);
                donutChart3.data.datasets[0].data = data.map(item => item.total_days); // Adjust based on your data structure
                donutChart3.update();
            });
    }

    document.getElementById('term').addEventListener('change', fetchData);
    document.getElementById('year').addEventListener('change', fetchData);

    fetchData(); // Initial fetch
});
</script>
</body>
</html>
