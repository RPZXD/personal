<?php 
$config = json_decode(file_get_contents(__DIR__ . '/../../config.json'), true);
$global = $config['global'];

// Menu configuration for Personnel System
$menuItems = [
    [
        'key' => 'home',
        'name' => 'หน้าหลัก',
        'url' => 'index.php',
        'icon' => 'fa-home',
        'gradient' => ['from' => 'blue-500', 'to' => 'blue-600'],
    ],
    [
        'key' => 'training',
        'name' => 'บันทึกการอบรม/สัมมนา',
        'url' => 'teacher/training.php',
        'icon' => 'fa-chalkboard-teacher',
        'gradient' => ['from' => 'purple-500', 'to' => 'indigo-500'],
    ],
    [
        'key' => 'awards',
        'name' => 'บันทึกรางวัล',
        'url' => 'teacher/awards.php',
        'icon' => 'fa-trophy',
        'gradient' => ['from' => 'amber-500', 'to' => 'orange-500'],
    ],
    [
        'key' => 'leave',
        'name' => 'ระบบการลา',
        'url' => 'teacher/leave.php',
        'icon' => 'fa-calendar-minus',
        'gradient' => ['from' => 'emerald-500', 'to' => 'teal-500'],
    ],
    [
        'key' => 'report',
        'name' => 'รายงาน',
        'url' => 'teacher/report.php',
        'icon' => 'fa-chart-bar',
        'gradient' => ['from' => 'rose-500', 'to' => 'pink-500'],
    ]
];
?>

<!-- Sidebar Overlay (Mobile) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 w-72 sm:w-64 h-screen transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <!-- Sidebar Background -->
    <div class="h-full overflow-y-auto bg-gradient-to-b from-slate-800 via-slate-900 to-slate-950 dark:from-slate-900 dark:via-slate-950 dark:to-black">
        
        <!-- Logo Section with Close Button -->
        <div class="px-4 sm:px-6 py-5 border-b border-white/10">
            <div class="flex items-center justify-between">
                <a href="index.php" class="flex items-center space-x-3 group flex-1 min-w-0">
                    <div class="relative flex-shrink-0">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-accent-500 rounded-full blur-lg opacity-50 group-hover:opacity-75 transition-opacity"></div>
                        <img src="dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>" class="relative w-10 h-10 sm:w-12 sm:h-12 rounded-full ring-2 ring-white/20 group-hover:ring-primary-400 transition-all" alt="Logo">
                    </div>
                    <div class="min-w-0">
                        <span class="text-base sm:text-lg font-bold text-white truncate block"><?php echo $global['nameTitle'] ?? 'PERSONNEL'; ?></span>
                        <p class="text-xs text-gray-400 truncate">ระบบจัดการบุคลากร</p>
                    </div>
                </a>
                <!-- Close button for mobile -->
                <button onclick="toggleSidebar()" class="lg:hidden p-2 -mr-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-4 sm:mt-6 px-2 sm:px-3 pb-20">
            <ul class="space-y-1">
                <!-- Main Menu Items -->
                <?php foreach ($menuItems as $menu): 
                    $fromColor = $menu['gradient']['from'];
                    $toColor = $menu['gradient']['to'];
                    $colorBase = explode('-', $fromColor)[0];
                ?>
                <li>
                    <a href="<?php echo htmlspecialchars($menu['url']); ?>" class="sidebar-item flex items-center px-3 sm:px-4 py-3 text-gray-300 rounded-xl hover:bg-white/10 hover:text-white group active:scale-95 transition-all" onclick="closeSidebarOnMobile()">
                        <span class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center bg-gradient-to-br from-<?php echo $fromColor; ?> to-<?php echo $toColor; ?> rounded-lg shadow-lg shadow-<?php echo $colorBase; ?>-500/30 group-hover:shadow-<?php echo $colorBase; ?>-500/50 transition-shadow">
                            <i class="fas <?php echo $menu['icon']; ?> text-white text-sm sm:text-base"></i>
                        </span>
                        <span class="ml-3 font-medium text-sm sm:text-base"><?php echo htmlspecialchars($menu['name']); ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
                
                <!-- Divider -->
                <li class="my-4 border-t border-white/10"></li>
                
                <!-- Login/Logout -->
                <?php if (isset($_SESSION['Teacher_login']) || isset($_SESSION['Officer_login']) || isset($_SESSION['Admin_login'])): ?>
                <li>
                    <a href="logout.php" class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-white/10 hover:text-white group">
                        <span class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg shadow-red-500/30 group-hover:shadow-red-500/50 transition-shadow">
                            <i class="fas fa-sign-out-alt text-white"></i>
                        </span>
                        <span class="ml-3 font-medium">ออกจากระบบ</span>
                    </a>
                </li>
                <?php else: ?>
                <li>
                    <a href="login.php" class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-white/10 hover:text-white group">
                        <span class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-gray-600 to-gray-700 rounded-lg shadow-lg shadow-gray-500/30 group-hover:shadow-gray-500/50 transition-shadow">
                            <i class="fas fa-sign-in-alt text-white"></i>
                        </span>
                        <span class="ml-3 font-medium">เข้าสู่ระบบ</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        
        <!-- Bottom Section -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10">
            <div class="text-center text-xs text-gray-500">
                <p><?php echo $global['nameschool'] ?? ''; ?></p>
                <p class="mt-1">Version 2.0</p>
            </div>
        </div>
    </div>
</aside>
