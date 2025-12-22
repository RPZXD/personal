<?php 
$configPath = __DIR__ . '/../../config.json';
$config = file_exists($configPath) ? json_decode(file_get_contents($configPath), true) : ['global' => ['logoLink' => 'logo-phicha.png', 'nameTitle' => 'PERSONNEL', 'nameschool' => 'School Name']];
$global = $config['global'];

// Menu configuration for Admin Portal
$menuItems = [
    [
        'key' => 'dashboard',
        'name' => 'หน้าหลัก',
        'url' => 'index.php',
        'icon' => 'fa-home',
        'gradient' => ['from' => 'blue-500', 'to' => 'indigo-600'],
    ],
    [
        'key' => 'teachers',
        'name' => 'จัดการข้อมูลครู',
        'url' => 'data_teacher.php',
        'icon' => 'fa-users-cog',
        'gradient' => ['from' => 'purple-500', 'to' => 'violet-600'],
    ],
    [
        'key' => 'training',
        'name' => 'การอบรมรายบุคคล',
        'url' => 'training.php',
        'icon' => 'fa-chalkboard-teacher',
        'gradient' => ['from' => 'emerald-500', 'to' => 'teal-600'],
    ],
    [
        'key' => 'training_summary',
        'name' => 'สรุปการอบรม',
        'url' => 'training_summary.php',
        'icon' => 'fa-chart-pie',
        'gradient' => ['from' => 'indigo-500', 'to' => 'purple-600'],
    ],
    [
        'key' => 'leave',
        'name' => 'การลารายบุคคล',
        'url' => 'leave.php',
        'icon' => 'fa-calendar-minus',
        'gradient' => ['from' => 'rose-500', 'to' => 'pink-600'],
    ],
    [
        'key' => 'leave_summary',
        'name' => 'สรุปวันลารายวัน',
        'url' => 'leave_summary.php',
        'icon' => 'fa-clipboard-check',
        'gradient' => ['from' => 'cyan-500', 'to' => 'blue-600'],
    ],
    [
        'key' => 'awards',
        'name' => 'รางวัลบุคลากร',
        'url' => 'awards.php',
        'icon' => 'fa-trophy',
        'gradient' => ['from' => 'amber-500', 'to' => 'orange-600'],
    ],
];
?>

<!-- Sidebar Overlay (Mobile) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 w-72 sm:w-64 h-screen transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <div class="h-full overflow-y-auto bg-gradient-to-b from-slate-900 via-slate-950 to-black">
        
        <!-- Logo Section -->
        <div class="px-6 py-8 border-b border-white/5">
            <div class="flex items-center justify-between">
                <a href="../index.php" class="flex items-center space-x-4 group flex-1">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full blur-lg opacity-40 group-hover:opacity-70 transition-opacity"></div>
                        <img src="../dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>" class="relative w-12 h-12 rounded-full ring-2 ring-white/10 group-hover:ring-primary-400/50 transition-all" alt="Logo">
                    </div>
                    <div>
                        <span class="text-xl font-black text-white tracking-tight uppercase"><?php echo $global['nameTitle'] ?? 'PERSONNEL'; ?></span>
                        <p class="text-[10px] font-bold text-primary-400 tracking-[0.2em] uppercase">Administrator</p>
                    </div>
                </a>
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-400 hover:text-white rounded-xl hover:bg-white/5">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- User Profile Card -->
        <?php if (isset($userData)): ?>
        <div class="px-4 py-6">
            <div class="p-4 rounded-3xl bg-white/5 border border-white/5 backdrop-blur-sm">
                <div class="flex items-center space-x-3">
                    <div class="relative flex-shrink-0">
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary-500 to-secondary-500 rounded-2xl blur opacity-30"></div>
                        <div class="relative w-12 h-12 rounded-2xl border border-white/10 overflow-hidden bg-slate-800 flex items-center justify-center">
                            <?php if(!empty($userData['Teach_photo'])): ?>
                                <img src="https://std.phichai.ac.th/teacher/uploads/phototeach/<?php echo $userData['Teach_photo']; ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-lg font-black text-white"><?php echo mb_substr($userData['Teach_name'] ?? 'A', 0, 1, 'UTF-8'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-white truncate"><?php echo $userData['Teach_name'] ?? 'Administrator'; ?></p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-500/10 text-primary-400 border border-primary-500/20 mt-1">
                            <i class="fas fa-shield-alt mr-1"></i> ADMIN
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Navigation -->
        <nav class="mt-2 px-3 pb-24">
            <div class="mb-4 px-4">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Menu Navigation</p>
            </div>
            <ul class="space-y-1.5">
                <?php foreach ($menuItems as $menu): 
                    $fromColor = $menu['gradient']['from'];
                    $toColor = $menu['gradient']['to'];
                    $isActive = basename($_SERVER['PHP_SELF']) == basename($menu['url']);
                    $colorName = explode('-', $fromColor)[0];
                ?>
                <li>
                    <a href="<?php echo htmlspecialchars($menu['url']); ?>" 
                       class="sidebar-item flex items-center px-4 py-3 rounded-2xl transition-all group active:scale-[0.98] <?php echo $isActive ? 'bg-white/10 text-white border border-white/5 shadow-xl shadow-black/20' : 'text-gray-400 hover:bg-white/5 hover:text-white'; ?>">
                        <span class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-<?php echo $fromColor; ?> to-<?php echo $toColor; ?> rounded-xl shadow-lg shadow-<?php echo $colorName; ?>-500/20 group-hover:shadow-<?php echo $colorName; ?>-500/40 transition-shadow">
                            <i class="fas <?php echo $menu['icon']; ?> text-white text-base"></i>
                        </span>
                        <span class="ml-4 font-bold text-sm tracking-tight"><?php echo htmlspecialchars($menu['name']); ?></span>
                        <?php if($isActive): ?>
                            <div class="ml-auto w-1.5 h-1.5 rounded-full bg-primary-500 shadow-[0_0_8px_rgba(139,92,246,0.6)]"></div>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endforeach; ?>
                
                <!-- System Divider -->
                <li class="my-6 px-4">
                    <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
                </li>
                
                <!-- Logout -->
                <li>
                    <a href="../logout.php" class="sidebar-item flex items-center px-4 py-3 text-gray-400 rounded-2xl hover:bg-rose-500/10 hover:text-rose-400 group">
                        <span class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-rose-500 to-red-600 rounded-xl shadow-lg shadow-rose-500/20 group-hover:shadow-rose-500/40 transition-shadow">
                            <i class="fas fa-sign-out-alt text-white"></i>
                        </span>
                        <span class="ml-4 font-bold text-sm tracking-tight">ออกจากระบบ</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- Bottom Credits -->
        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black to-transparent">
            <div class="text-center">
                <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest"><?php echo $global['nameschool'] ?? 'โรงเรียนพิชัย'; ?></p>
                <p class="text-[8px] text-gray-700 mt-1 font-bold italic opacity-50 uppercase tracking-tighter">Admin Control v2.0</p>
            </div>
        </div>
    </div>
</aside>
