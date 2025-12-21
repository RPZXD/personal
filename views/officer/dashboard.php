<!-- Officer Dashboard View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-pink-600 to-indigo-700 p-8 shadow-2xl text-white">
        <!-- Abstract background shapes -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-pink-500/20 rounded-full blur-2xl -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur-xl flex items-center justify-center text-4xl shadow-inner border border-white/30 transform hover:rotate-6 transition-transform">
                    🏢
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight leading-tight">ระบบเจ้าหน้าที่บริหารทั่วไป</h2>
                    <p class="text-pink-100/80 mt-1 font-medium italic">ยินดีต้อนรับคุณ <?php echo $userData['Teach_name']; ?> | โรงเรียนพิชัย</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 bg-white/10 backdrop-blur rounded-xl border border-white/20 text-center">
                    <p class="text-[10px] uppercase font-bold text-pink-200">ปีการศึกษา</p>
                    <p class="text-lg font-black"><?php echo $pee; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions / Stats Placeholder -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Training -->
        <a href="training.php" class="glass-morphism rounded-3xl p-6 group hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 transform hover:-translate-y-2 border border-emerald-500/20">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="text-[10px] font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">จัดการ</div>
            </div>
            <h3 class="mt-4 text-xl font-bold text-gray-800 dark:text-white">การอบรมครู</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic">จัดการข้อมูลการฝึกอบรมและสัมมนาของครูรายบุคคล</p>
        </a>

        <!-- Card 2: Awards -->
        <a href="awards.php" class="glass-morphism rounded-3xl p-6 group hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 transform hover:-translate-y-2 border border-amber-500/20">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="text-[10px] font-bold text-amber-500 bg-amber-50 dark:bg-amber-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">จัดการ</div>
            </div>
            <h3 class="mt-4 text-xl font-bold text-gray-800 dark:text-white">รางวัลครู</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic">บันทึกและตรวจสอบผลงาน/รางวัลของคณะครู</p>
        </a>

        <!-- Card 3: Leave Management -->
        <a href="leave.php" class="glass-morphism rounded-3xl p-6 group hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 transform hover:-translate-y-2 border border-rose-500/20">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-calendar-minus"></i>
                </div>
                <div class="text-[10px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">จัดการ</div>
            </div>
            <h3 class="mt-4 text-xl font-bold text-gray-800 dark:text-white">การขอลาครู</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic">ระบบจัดการข้อมูลวันลาและสถิติการลาของบุคลากร</p>
        </a>

        <!-- Card 4: Summary/Report -->
        <a href="training_summary.php" class="glass-morphism rounded-3xl p-6 group hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 transform hover:-translate-y-2 border border-blue-500/20">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="text-[10px] font-bold text-blue-500 bg-blue-50 dark:bg-blue-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">รายงาน</div>
            </div>
            <h3 class="mt-4 text-xl font-bold text-gray-800 dark:text-white">สรุปภาพรวม</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic">ดูสถิติและสรุปรายงานต่างๆ ในระบบบริหารทั่วไป</p>
        </a>
    </div>

    <!-- Welcome Message Card -->
    <div class="glass-morphism rounded-3xl p-10 text-center relative overflow-hidden group">
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-pink-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
        
        <div class="relative">
            <img src="../dist/img/logo-phicha.png" alt="Phichai Logo" class="w-24 h-24 mx-auto mb-6 drop-shadow-2xl">
            <h2 class="text-2xl font-black text-gray-800 dark:text-white mb-2 italic">โรงเรียนพิชัย</h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-lg mx-auto leading-relaxed">
                ระบบจัดการข้อมูลบุคลากรเวอร์ชันใหม่ ออกแบบมาเพื่อเพิ่มความสะดวกในการจัดการข้อมูลครูและบุคลากรภายในโรงเรียน 
                คุณสามารถจัดการข้อมูลการฝึกอบรม รางวัล และการลาได้จากเมนูด้านข้าง
            </p>
        </div>
    </div>
</div>
