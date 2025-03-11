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
        <div class="col-md-12">
            <div class="callout callout-danger text-center">
                <h4>ยินดีต้อนรับเข้าสู่<?php echo $setting->getPageTitle(); ?></h4>
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
