<?php 

require_once('header.php');
require_once('config/Setting.php');
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
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
            <div class="row">
              <div class="w-full">
                      <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 text-center">
                          <h4 class="text-lg font-semibold">ยินดีต้อนรับเข้าสู่<?php echo $setting->getPageTitle() ?></h4>
                      </div>
                  </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-12">
                  <div class="flex flex-wrap mt-4">
                      <div class="w-full md:w-1/3 px-2 mb-4">
                        <!-- small box -->  
                        <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                          <p class="mt-2">ระบบบันทึกชั่วโมงการอบรม/สัมมนา</p>
                          <p class="mt-2 ml-5">- บันทึกการอบรม</p>
                          <p class="mt-2 ml-5">- บันทึกการสัมมนา</p>
                          <p class="mt-2 ml-5">- ประมวลผลข้อมูลการอบรม/สัมมนา</p>
                          <p class="mt-2 ml-5">- ปริ้นรายงาน</p>
                        </div>
                      </div>
                      <!-- ./col -->
                      <div class="w-full md:w-1/3 px-2 mb-4">
                        <!-- small box -->
                        <div class="bg-pink-500 text-white p-4 rounded-lg shadow">
                          <p class="mt-2">ระบบบันทึกรางวัล</p>
                          <p class="mt-2 ml-5">- บันทึกรางวัล</p>
                          <p class="mt-2 ml-5">- ประมวลผลข้อมูล</p>
                          <p class="mt-2 ml-5">- ปริ้นรายงาน</p>
                        </div>
                      </div>
                      <div class="w-full md:w-1/3 px-2 mb-4">
                        <!-- small box -->
                        <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                          <p class="mt-2">ระบบการแจ้งลา</p>
                          <p class="mt-2 ml-5">- บันทึกการลา</p>
                          <p class="mt-2 ml-5">- คำนวณวันเวลาในการลา</p>
                          <p class="mt-2 ml-5">- ปริ้นรายงานผล</p>
                        </div>
                      </div>

                  
                  </div>
                </div>
            </div>

            </div>
                

        

                

    </div>
</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php require_once('footer.php');?>
</div>
<!-- ./wrapper -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php require_once('script.php');?>
</body>
</html>
