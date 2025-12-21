<!-- Teacher Navbar -->
<nav class="sticky top-0 z-30 flex items-center justify-between px-4 md:px-8 py-4 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border-b border-gray-200 dark:border-gray-800 transition-all duration-300">
    <div class="flex items-center gap-4">
        <!-- Sidebar Toggle (Mobile) -->
        <button onclick="toggleSidebar()" class="lg:hidden p-2.5 rounded-2xl bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-all">
            <i class="fas fa-bars text-xl"></i>
        </button>
        
        <!-- Breadcrumbs or Page Title -->
        <div class="hidden sm:block">
            <h1 class="text-xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-2 h-8 bg-gradient-to-b from-primary-500 to-secondary-500 rounded-full"></span>
                <?php echo $pageTitle ?? 'Dashboard'; ?>
            </h1>
        </div>
    </div>

    <!-- Right Actions -->
    <div class="flex items-center gap-2 md:gap-4">
        <!-- Date Display -->
        <div class="hidden md:flex items-center px-4 py-2 rounded-2xl bg-gray-50 dark:bg-slate-800/50 border border-gray-100 dark:border-gray-700">
            <i class="far fa-calendar-alt text-primary-500 mr-2"></i>
            <span class="text-xs font-bold text-slate-600 dark:text-slate-400">
                <?php 
                    $thai_months = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
                    echo date('j') . " " . $thai_months[date('n')] . " " . (date('Y') + 543);
                ?>
            </span>
        </div>

        <!-- Dark Mode Toggle -->
        <button onclick="toggleDarkMode()" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-amber-400 hover:scale-110 active:scale-95 transition-all shadow-sm border border-slate-200 dark:border-slate-700">
            <i class="fas fa-sun dark:hidden"></i>
            <i class="fas fa-moon hidden dark:block"></i>
        </button>

        <!-- Profile Menu -->
        <div class="relative group">
            <button class="flex items-center gap-3 p-1.5 pr-4 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-black shadow-lg shadow-primary-500/20">
                    <?php if(!empty($userData['Teach_photo'])): ?>
                        <img src="../dist/img/person/<?php echo $userData['Teach_photo']; ?>" class="w-full h-full object-cover rounded-xl">
                    <?php else: ?>
                        <?php echo mb_substr($userData['Teach_name'] ?? 'T', 0, 1, 'UTF-8'); ?>
                    <?php endif; ?>
                </div>
                <div class="hidden sm:block text-left">
                    <p class="text-xs font-black text-slate-900 dark:text-white leading-none"><?php echo $userData['Teach_name'] ?? 'Teacher'; ?></p>
                    <p class="text-[10px] font-bold text-primary-500 uppercase tracking-tighter mt-0.5">Teacher</p>
                </div>
                <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
            </button>
            
            <!-- Dropdown -->
            <div class="absolute right-0 mt-3 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100">
                <div class="p-2 rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-100 dark:border-slate-800">
                    <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 transition-all">
                        <i class="fas fa-user-shield text-primary-500"></i>
                        <span class="text-sm font-bold">แผงควบคุม</span>
                    </a>
                    <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                    <a href="../logout.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-rose-50 dark:hover:bg-rose-900/20 text-rose-600 transition-all font-bold">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="text-sm">ออกจากระบบ</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
