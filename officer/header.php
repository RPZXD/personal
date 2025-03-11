<?php
 session_start(); 
 require_once '../config/Setting.php';
 $setting = new Setting();
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $setting->getPageTitle(); ?></title>

    <!-- Google Font: Mali -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mali:wght@200;300;400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <link rel="icon" type="image/png" href="../dist/img/logo-phicha.png" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- jQuery UI CSS (optional, for default styling) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
    body {
        font-family: 'Mali', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        transition: background-color 0.5s, color 0.5s;
    }

    body.light-mode {
        background-color: #ffffff;
        color: #000000;
    }

    body.dark-mode {
        background-color: #121212;
        color: #ffffff;
    }

    .navbar-light.light-mode {
        background-color: #ffffff;
        color: #000000;
    }

    .navbar-dark.dark-mode {
        background-color: #121212;
        color: #ffffff;
    }

    .switch {
        display: flex;
        align-items: center;
        margin-left: auto;
    }

    .switch-label {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch-label input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 5px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    .slider .icon-light,
    .slider .icon-dark {
        font-size: 16px;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .slider .icon-light {
        color: #fbc02d;
    }

    .slider .icon-dark {
        color: #2196F3;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:checked + .slider .icon-light {
        opacity: 0;
    }

    input:checked + .slider .icon-dark {
        opacity: 1;
    }

    input:not(:checked) + .slider .icon-light {
        opacity: 1;
    }

    input:not(:checked) + .slider .icon-dark {
        opacity: 0;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .preloader {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #f4f6f9;
        z-index: 9999;
        transition: opacity 0.5s;
    }

    .preloader .animate-shake {
        animation: shake 1.5s infinite;
    }

    @keyframes shake {
        0% { transform: rotate(0deg); }
        25% { transform: rotate(-5deg); }
        50% { transform: rotate(0deg); }
        75% { transform: rotate(5deg); }
        100% { transform: rotate(0deg); }
    }

    .preloader p {
        margin-top: 20px;
        text-align: center;
    }

    @media (max-width: 576px) {
        .nav-item.d-none.d-sm-inline-block {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            float: none;
            text-align: center;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: none;
            text-align: center;
        }

        table.dataTable thead {
            display: table-header-group;
        }

        table.dataTable tbody {
            display: table-row-group;
        }
    }
</style>

</head>
