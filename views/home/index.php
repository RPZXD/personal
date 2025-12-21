<!-- Home Page Content -->
<div class="space-y-8">
    <!-- Hero Section with Animated Background -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-8 md:p-12">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-48 -mt-48 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -ml-36 -mb-36 animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative flex flex-col lg:flex-row items-center gap-8">
            <div class="flex-shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-xl animate-pulse"></div>
                    <img src="dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>" 
                        alt="<?php echo $global['nameschool']; ?> Logo"
                        class="relative w-32 h-32 md:w-40 md:h-40 rounded-full shadow-2xl border-4 border-white/30 hover:scale-110 transition-transform duration-500">
                </div>
            </div>
            <div class="text-center lg:text-left text-white">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-4">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    ระบบพร้อมใช้งาน
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3">
                    ระบบจัดการข้อมูลบุคลากร
                </h1>
                <p class="text-lg md:text-xl text-white/80 mb-6">
                    <?php echo $global['nameschool']; ?>
                </p>
                <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2">
                        <span>📚</span> การอบรม/สัมมนา
                    </span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2">
                        <span>🏆</span> รางวัล
                    </span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2">
                        <span>📅</span> การลา
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- การอบรม/สัมมนา -->
        <a href="training.php" class="group">
            <div class="glass rounded-2xl p-6 h-full relative overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500 to-cyan-400 opacity-20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl shadow-lg text-white mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">ระบบบันทึกชั่วโมงการอบรม/สัมมนา</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">บันทึกการอบรม สัมมนา และประมวลผลข้อมูล</p>
                    <ul class="text-gray-500 dark:text-gray-400 text-sm space-y-1 mb-4">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>บันทึกการอบรม</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>บันทึกการสัมมนา</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>ประมวลผลข้อมูล</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>ปริ้นรายงาน</li>
                    </ul>
                    <div class="flex items-center text-blue-600 dark:text-blue-400 font-medium text-sm">
                        เข้าใช้งาน 
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- รางวัล -->
        <a href="awards.php" class="group">
            <div class="glass rounded-2xl p-6 h-full relative overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500 to-orange-500 opacity-20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl shadow-lg text-white mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-trophy text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">ระบบบันทึกรางวัล</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">บันทึกรางวัลและประมวลผลข้อมูล</p>
                    <ul class="text-gray-500 dark:text-gray-400 text-sm space-y-1 mb-4">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>บันทึกรางวัล</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>ประมวลผลข้อมูล</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>ปริ้นรายงาน</li>
                    </ul>
                    <div class="flex items-center text-amber-600 dark:text-amber-400 font-medium text-sm">
                        เข้าใช้งาน 
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- การลา -->
        <a href="leave.php" class="group">
            <div class="glass rounded-2xl p-6 h-full relative overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500 to-teal-400 opacity-20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-400 rounded-2xl shadow-lg text-white mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-minus text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">ระบบการแจ้งลา</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">บันทึกการลาและคำนวณวันลา</p>
                    <ul class="text-gray-500 dark:text-gray-400 text-sm space-y-1 mb-4">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>บันทึกการลา</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>คำนวณวันเวลาในการลา</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>ปริ้นรายงานผล</li>
                    </ul>
                    <div class="flex items-center text-emerald-600 dark:text-emerald-400 font-medium text-sm">
                        เข้าใช้งาน 
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="glass rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <span class="text-2xl">⚡</span> เข้าสู่ระบบเพื่อใช้งาน
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="login.php" class="group p-5 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-white/20 backdrop-blur rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-sign-in-alt text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">เข้าสู่ระบบ</h4>
                        <p class="text-sm text-white/80">สำหรับบุคลากร</p>
                    </div>
                </div>
            </a>
            
            <a href="officer/" class="group p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-shield text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">เจ้าหน้าที่</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Officer Portal</p>
                    </div>
                </div>
            </a>
            
            <a href="teacher/" class="group p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">ครู/บุคลากร</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Teacher Portal</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="glass rounded-2xl p-6 text-center">
        <div class="text-4xl mb-3">🎓</div>
        <p class="text-gray-600 dark:text-gray-400 font-medium"><?php echo $global['nameschool']; ?></p>
        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Personnel Management System v2.0</p>
    </div>
</div>

<style>
    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgba(255,255,255,0.1)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>
