<?php 
/**
 * Index Page - Dashboard
 * Uses the new MVC layout with modern UI
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read configuration from JSON file
$config = json_decode(file_get_contents('config.json'), true);
$global = $config['global'];

$pageTitle = 'หน้าหลัก';

// Render view with layout
ob_start();
require 'views/home/index.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
