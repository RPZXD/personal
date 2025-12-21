<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Load config
$configPath = __DIR__ . '/../../config.json';
$config = file_exists($configPath) ? json_decode(file_get_contents($configPath), true) : ['global' => ['pageTitle' => 'Personnel System', 'nameschool' => 'School Name']];
$global = $config['global'];
?>
<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle ?? $global['pageTitle']; ?> | <?php echo $global['nameschool']; ?></title>
    
    <!-- Google Font: Mali -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mali:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS v3 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'mali': ['Mali', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f5f3ff', 100: '#ede9fe', 200: '#ddd6fe', 300: '#c4b5fd', 400: '#a78bfa',
                            500: '#8b5cf6', 600: '#7c3aed', 700: '#6d28d9', 800: '#5b21b6', 900: '#4c1d95',
                        },
                        secondary: {
                            50: '#fdf4ff', 100: '#fae8ff', 200: '#f5d0fe', 300: '#f0abfc', 400: '#e879f9',
                            500: '#d946ef', 600: '#c026d3', 700: '#a21caf', 800: '#86198f', 900: '#701a75',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' }, },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' }, }
                    }
                }
            }
        }
    </script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <style>
        * { font-family: 'Mali', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 4px; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .dark .glass { background: rgba(30, 41, 59, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); }
        .glass-morphism { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07); }
        .dark .glass-morphism { background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3); }
        .sidebar-item { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-item:hover { transform: translateX(8px); }
        .loader { border: 3px solid rgba(139, 92, 246, 0.2); border-top: 3px solid #8b5cf6; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        @media print {
            .no-print, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate, button, .btn { display: none !important; }
            nav, aside, footer, #preloader, #sidebar, #navbar, .sidebar-overlay, .filters-section { display: none !important; }
            main { margin: 0 !important; padding: 0 !important; }
            .lg\:ml-64 { margin-left: 0 !important; }
            body { background: white !important; color: black !important; }
            
            body, p, span, div, td, th, h1, h2, h3, h4, h5, h6 { 
                color: black !important; 
                text-shadow: none !important;
                -webkit-text-fill-color: black !important;
            }
            
            #print_header, #print_header *, #summary-header, #summary-header * {
                color: black !important;
                background: transparent !important;
            }

            table.dataTable thead .sorting:before,
            table.dataTable thead .sorting:after,
            table.dataTable thead .sorting_asc:before,
            table.dataTable thead .sorting_asc:after,
            table.dataTable thead .sorting_desc:before,
            table.dataTable thead .sorting_desc:after {
                display: none !important;
            }

            .glass, .glass-morphism { background: white !important; backdrop-filter: none !important; border: 1px solid #eee !important; box-shadow: none !important; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
    
    <link rel="icon" type="image/png" href="../dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>">
</head>

<body class="font-mali bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen transition-colors duration-500">
    
    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-slate-900 transition-opacity duration-500">
        <div class="text-center">
            <img src="../dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>" alt="Logo" class="w-24 h-24 mx-auto animate-bounce-slow">
            <div class="loader mx-auto mt-6"></div>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300 animate-pulse font-bold"><?php echo $global['nameschool'] ?? 'ระบบจัดการข้อมูลบุคลากร'; ?></p>
            <p class="text-xs text-primary-500 font-bold uppercase tracking-widest mt-1">Administrator Portal</p>
        </div>
    </div>
    
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../../views/components/admin_sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Navbar -->
            <div class="no-print">
                <?php include __DIR__ . '/../../views/components/admin_navbar.php'; ?>
            </div>
            
            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto animate-fade-in">
                    <?php 
                    if (isset($view)) {
                        include $view;
                    } else {
                        echo $content ?? '';
                    }
                    ?>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="py-4 px-6 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700">
                <p>&copy; <?php echo date('Y') + 543; ?> <?php echo $global['nameschool']; ?> - All rights reserved.</p>
                <p class="mt-1 opacity-50 italic">Admin Management System 2.0</p>
            </footer>
        </div>
    </div>
    
    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            setTimeout(() => {
                preloader.style.opacity = '0';
                setTimeout(() => { preloader.style.display = 'none'; }, 500);
            }, 800);
        });
        
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
        
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
    </script>
</body>
</html>
