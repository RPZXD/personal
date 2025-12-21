<!-- Admin Dashboard View -->
<div class="space-y-8 animate-fade-in">
    
    <!-- Welcome Header -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-primary-600 via-primary-700 to-indigo-800 p-8 md:p-12 shadow-2xl text-white">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-48 -mt-48 transition-transform duration-1000 group-hover:scale-110"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary-500/20 rounded-full blur-3xl -ml-32 -mb-32"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-8">
            <!-- Icon/Logo -->
            <div class="w-24 h-24 md:w-32 md:h-32 rounded-[2rem] bg-white/20 backdrop-blur-xl flex items-center justify-center text-5xl md:text-6xl shadow-inner border border-white/30 shrink-0 transform hover:rotate-6 transition-transform">
                👑
            </div>
            
            <div class="text-center md:text-left space-y-4">
                <div class="space-y-1">
                    <span class="inline-flex items-center px-4 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-black uppercase tracking-[0.2em] border border-white/20">
                        Administrator Portal
                    </span>
                    <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-tight pt-2">
                        ยินดีต้อนรับท่านผู้ดูแลระบบ
                    </h2>
                </div>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-black/20 backdrop-blur-sm border border-white/10">
                        <i class="fas fa-user-circle text-primary-300"></i>
                        <span class="text-sm font-bold opacity-90"><?php echo $userData['Teach_name']; ?></span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-black/20 backdrop-blur-sm border border-white/10">
                        <i class="fas fa-school text-primary-300"></i>
                        <span class="text-sm font-bold opacity-90"><?php echo $global['nameschool']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats / Shortcuts -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Manage Teachers -->
        <a href="data_teacher.php" class="group relative overflow-hidden glass-morphism rounded-[2rem] p-8 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 border-2 border-transparent hover:border-primary-500/20">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/5 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-primary-500/10 transition-colors"></div>
            <div class="relative z-10 space-y-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white text-2xl shadow-xl shadow-primary-500/20 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2">จัดการข้อมูลคุณครู</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">แก้ไขข้อมูลส่วนตัว, ปรับเปลี่ยนตำแหน่ง และจัดการสถานะบุคลากรในระบบ</p>
                </div>
                <div class="flex items-center text-primary-600 dark:text-primary-400 font-black text-xs uppercase tracking-widest gap-2">
                    จัดการข้อมูล <i class="fas fa-arrow-right animate-pulse"></i>
                </div>
            </div>
        </a>

        <!-- View Reports -->
        <a href="training_summary.php" class="group relative overflow-hidden glass-morphism rounded-[2rem] p-8 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 border-2 border-transparent hover:border-secondary-500/20">
            <div class="absolute top-0 right-0 w-32 h-32 bg-secondary-500/5 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-secondary-500/10 transition-colors"></div>
            <div class="relative z-10 space-y-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-secondary-500 to-pink-600 flex items-center justify-center text-white text-2xl shadow-xl shadow-secondary-500/20 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2">รายงานและสรุปผล</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">ตรวจสอบสถิติการอบรม, การลา และรางวัลของบุคลากรรายเทอมหรือรายปี</p>
                </div>
                <div class="flex items-center text-secondary-600 dark:text-secondary-400 font-black text-xs uppercase tracking-widest gap-2">
                    ดูรายงาน <i class="fas fa-arrow-right animate-pulse"></i>
                </div>
            </div>
        </a>

        <!-- System Logs/Status (Placeholder/Info) -->
        <div class="group relative overflow-hidden glass-morphism rounded-[2rem] p-8 border-2 border-transparent">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl -mr-16 -mt-16"></div>
            <div class="relative z-10 space-y-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-2xl shadow-xl shadow-emerald-500/20">
                    <i class="fas fa-shield-virus"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2">สถานะระบบ</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter italic">Database Status</span>
                            <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-primary-500/5 border border-primary-500/10">
                            <span class="text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-tighter italic">Security Level</span>
                            <span class="text-[10px] font-black text-primary-500">OPTIMAL</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Description Callout -->
    <div class="glass-morphism rounded-[2rem] p-8 border border-white/20">
        <div class="flex flex-col md:flex-row gap-8 items-center">
            <div class="shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-primary-500 rounded-full blur-2xl opacity-10"></div>
                    <img src="../dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>" class="relative w-24 h-24 object-contain opacity-80" alt="App Logo">
                </div>
            </div>
            <div class="space-y-2 text-center md:text-left">
                <h4 class="text-lg font-black text-slate-800 dark:text-slate-100">Personnel Management System v2.0 (Admin Edition)</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-2xl">
                    ระบบบริหารจัดการข้อมูลบุคลากรเวอร์ชันปรับปรุงใหม่ เน้นความรวดเร็ว ปลอดภัย และใช้งานง่าย 
                    ในฐานะผู้ดูแลระบบ ท่านสามารถตรวจสอบและจัดการข้อมูลทุกส่วนของบุคลากรได้อย่างเต็มรูปแบบ 
                    กรุณาใช้ความระมัดระวังในการแก้ไขข้อมูลสำคัญ และตรวจสอบความถูกต้องทุกครั้งก่อนบันทึก
                </p>
            </div>
        </div>
    </div>

</div>
