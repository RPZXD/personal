<!-- Teacher Dashboard Content -->
<div class="space-y-6 animate-fade-in">
    <!-- Welcome Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-blue-600 to-cyan-500 p-6 md:p-10 shadow-2xl">
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl -mr-40 -mt-40 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -ml-32 -mb-32 animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-6 md:gap-8 text-center md:text-left">
            <div class="relative">
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-3xl bg-white/20 backdrop-blur-md flex items-center justify-center text-5xl shadow-inner border border-white/30">
                    <img src="<?php echo '../dist/img/' . $global['logoLink'] ?? '../dist/img/logo-phicha.png'; ?>" class="w-16 h-16 md:w-20 md:h-20 object-contain drop-shadow-lg" alt="Logo">
                </div>
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-emerald-500 border-4 border-indigo-600 rounded-full flex items-center justify-center text-white text-xs shadow-lg">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            <div class="text-white">
                <p class="text-indigo-100 font-medium mb-1 tracking-wide uppercase text-[10px] md:text-sm opacity-80">Teacher Insight Dashboard</p>
                <h2 class="text-2xl md:text-5xl font-extrabold tracking-tight mb-2 leading-tight">
                    ยินดีต้อนรับ, <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-200"><?php echo $userData['Teach_name'] ?? 'คุณครู'; ?></span>
                </h2>
                <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                    <span class="px-3 md:px-4 py-1.5 rounded-full bg-white/20 backdrop-blur text-[10px] md:text-sm font-medium border border-white/30 flex items-center gap-2">
                        <i class="fas fa-school text-blue-300"></i> <?php echo $global['nameschool'] ?? 'โรงเรียนพิชัย'; ?>
                    </span>
                    <span class="px-3 md:px-4 py-1.5 rounded-full bg-white/20 backdrop-blur text-[10px] md:text-sm font-medium border border-white/30 flex items-center gap-2">
                        <i class="fas fa-calendar-check text-emerald-300"></i> ปีการศึกษา <?php echo $pee; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Training Stats Card -->
        <?php 
            $curr_hours = $current_stats['training']['total_hours'] ?? 0;
            $prev_hours = $prev_stats['training']['total_hours'] ?? 0;
            $diff_hours = $curr_hours - $prev_hours;
            $is_up_hours = $diff_hours >= 0;
        ?>
        <div class="glass-morphism rounded-3xl p-6 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xl font-bold border border-emerald-500/30">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="flex items-center gap-1 text-xs font-semibold <?php echo $is_up_hours ? 'text-emerald-600' : 'text-rose-600'; ?> bg-emerald-500/10 px-2 py-1 rounded-lg">
                    <i class="fas fa-arrow-<?php echo $is_up_hours ? 'up' : 'down'; ?>"></i>
                    <?php echo abs(round($diff_hours, 1)); ?> ชั่งโมง
                </div>
            </div>
            <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium">ชั่วโมงการอบรมปีนี้</h4>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-gray-900 dark:text-white counter" data-target="<?php echo round($curr_hours, 1); ?>">0</span>
                <span class="text-gray-400 text-sm font-medium">ชั่วโมง</span>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50 flex justify-between text-xs">
                <span class="text-gray-500">จำนวน <?php echo $current_stats['training']['total_trainings'] ?? 0; ?> ครั้ง</span>
                <span class="text-emerald-500 font-bold">฿<?php echo number_format($current_stats['training']['total_budget'] ?? 0); ?></span>
            </div>
        </div>

        <!-- Awards Stats Card -->
        <?php 
            $curr_awards = $current_stats['awards'] ?? 0;
            $prev_awards = $prev_stats['awards'] ?? 0;
            $diff_awards = $curr_awards - $prev_awards;
        ?>
        <div class="glass-morphism rounded-3xl p-6 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 text-xl font-bold border border-amber-500/30">
                    <i class="fas fa-trophy"></i>
                </div>
                <?php if($diff_awards != 0): ?>
                <div class="flex items-center gap-1 text-xs font-semibold <?php echo $diff_awards > 0 ? 'text-emerald-600' : 'text-rose-600'; ?> bg-amber-500/10 px-2 py-1 rounded-lg">
                    <i class="fas fa-<?php echo $diff_awards > 0 ? 'plus' : 'minus'; ?>"></i>
                    <?php echo abs($diff_awards); ?> รายการ
                </div>
                <?php endif; ?>
            </div>
            <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium">รางวัลที่ได้รับปีนี้</h4>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-gray-900 dark:text-white counter" data-target="<?php echo $curr_awards; ?>">0</span>
                <span class="text-gray-400 text-sm font-medium">รางวัล</span>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                <div class="w-full bg-gray-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-full w-full opacity-60"></div>
                </div>
            </div>
        </div>

        <!-- Leave Stats Card (Sick) -->
        <div class="glass-morphism rounded-3xl p-6 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/20 flex items-center justify-center text-rose-600 dark:text-rose-400 text-xl font-bold border border-rose-500/30">
                    <i class="fas fa-medkit"></i>
                </div>
                <div class="text-xs font-bold text-gray-400"></div>
            </div>
            <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium">ลาป่วยทั้งหมด</h4>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-gray-900 dark:text-white counter" data-target="<?php echo $current_stats['leave']['sick_days'] ?? 0; ?>">0</span>
                <span class="text-gray-400 text-sm font-medium">วัน</span>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                <?php $sick_perc = min(100, ($current_stats['leave']['sick_days'] ?? 0) / 30 * 100); ?>
                <div class="w-full bg-gray-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-rose-500 h-full rounded-full transition-all duration-1000" style="width: <?php echo $sick_perc; ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Leave Stats Card (Personal) -->
        <div class="glass-morphism rounded-3xl p-6 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/20 flex items-center justify-center text-purple-600 dark:text-purple-400 text-xl font-bold border border-purple-500/30">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="text-xs font-bold text-gray-400"></div>
            </div>
            <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium">ลากิจทั้งหมด</h4>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-gray-900 dark:text-white counter" data-target="<?php echo $current_stats['leave']['personal_days'] ?? 0; ?>">0</span>
                <span class="text-gray-400 text-sm font-medium">วัน</span>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                <?php $pers_perc = min(100, ($current_stats['leave']['personal_days'] ?? 0) / 10 * 100); ?>
                <div class="w-full bg-gray-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-purple-500 h-full rounded-full transition-all duration-1000" style="width: <?php echo $pers_perc; ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Analysis Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Charts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Training Analysis -->
                <div class="glass rounded-2xl p-6 card-hover flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center bg-emerald-500 rounded-xl text-white shadow-lg">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white">ภาพรวมการอบรม</h3>
                        </div>
                        <select id="term_chart" class="text-xs font-medium bg-gray-100 dark:bg-slate-700 py-1.5 px-3 rounded-lg border-none focus:ring-0">
                            <option value="">ทั้งหมด</option>
                            <option value="1">เทอม 1</option>
                            <option value="2">เทอม 2</option>
                        </select>
                    </div>
                    <div class="relative flex-grow" style="min-height: 250px;">
                        <canvas id="trainingChart"></canvas>
                    </div>
                </div>

                <!-- Awards Analysis -->
                <div class="glass rounded-2xl p-6 card-hover flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center bg-amber-500 rounded-xl text-white shadow-lg">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white">สถิติรางวัล</h3>
                        </div>
                    </div>
                    <div class="relative flex-grow" style="min-height: 250px;">
                        <canvas id="awardsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Insights / Analysis Text -->
            <div class="glass rounded-3xl p-6 border border-primary-500/10 bg-gradient-to-r from-primary-500/5 to-transparent">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary-500/20 text-primary-500 rounded-2xl flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">บทวิเคราะห์และข้อแนะนำ</h4>
                        <ul class="space-y-3 text-gray-600 dark:text-gray-400 text-sm">
                            <?php if ($curr_hours < 20): ?>
                                <li class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                    <span>ปีนี้คุณมีการอบรมรวม <span class="text-amber-500 font-bold"><?php echo round($curr_hours, 1); ?> ชม.</span> ควรเพิ่มการอบรมอย่างน้อย 20 ชม. ต่อปี</span>
                                </li>
                            <?php else: ?>
                                <li class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                    <span>ยอดเยี่ยม! คุณมีการอบรมเกิน 20 ชม. ตามเกณฑ์มาตรฐานแล้วคือก <span class="text-emerald-500 font-bold"><?php echo round($curr_hours, 1); ?> ชม.</span></span>
                                </li>
                            <?php endif; ?>

                            <?php if ($current_stats['leave']['sick_days'] > 5): ?>
                                <li class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                    <span>ระวัง: สถิติการลาป่วยของคุณ <span class="text-rose-500 font-bold"><?php echo $current_stats['leave']['sick_days']; ?> วัน</span> ค่อนข้างสูงในช่วงนี้</span>
                                </li>
                            <?php endif; ?>

                            <li class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                <span>คุณได้รับรางวัลรวม <span class="text-blue-500 font-bold"><?php echo $curr_awards; ?> รายการ</span> <?php echo $diff_awards > 0 ? 'เพิ่มขึ้นจากปีที่แล้ว' : ''; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shortcuts & Leave Analysis -->
        <div class="space-y-6">
            <!-- Leave Distribution -->
            <div class="glass rounded-2xl p-6 card-hover">
                <h3 class="font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-calendar-minus text-rose-500"></i> สัดส่วนการลา
                </h3>
                <div class="relative" style="height: 200px;">
                    <canvas id="leaveChart"></canvas>
                </div>
                <div class="mt-6 space-y-2">
                    <div class="flex justify-between text-xs font-medium">
                        <span class="text-gray-500">วันลาที่ใช้ไปทั้งหมด</span>
                        <span class="text-gray-900 dark:text-white font-bold"><?php echo $current_stats['leave']['total_days'] ?? 0; ?> วัน</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full">
                        <?php $total_leave_perc = min(100, (($current_stats['leave']['total_days'] ?? 0) / 45) * 100); ?>
                        <div class="bg-primary-500 h-full rounded-full" style="width: <?php echo $total_leave_perc; ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass rounded-2xl p-6 overflow-hidden relative">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-primary-500/5 rounded-full"></div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-bolt text-amber-500"></i> เมนูลัดจัดการข้อมูล
                </h3>
                <div class="grid grid-cols-1 gap-3">
                    <a href="training.php" class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 group hover:bg-emerald-500 hover:text-white transition-all duration-300">
                        <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-colors">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="font-bold text-sm">บันทึกการอบรมใหม่</span>
                    </a>
                    <a href="awards.php" class="flex items-center gap-4 p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 group hover:bg-amber-500 hover:text-white transition-all duration-300">
                        <div class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-colors">
                            <i class="fas fa-award"></i>
                        </div>
                        <span class="font-bold text-sm">เพิ่มรางวัลที่ได้รับ</span>
                    </a>
                    <a href="leave.php" class="flex items-center gap-4 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 group hover:bg-rose-500 hover:text-white transition-all duration-300">
                        <div class="w-10 h-10 bg-rose-500 text-white rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-colors">
                            <i class="fas fa-id-card-alt"></i>
                        </div>
                        <span class="font-bold text-sm">แจ้งการลา/ไปราชการ</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        const count = target > 100 ? target - 50 : 0;
        counter.innerText = count;
        
        const updateCount = () => {
            const current = +counter.innerText;
            const inc = target / 100;
            if (current < target) {
                counter.innerText = (current + inc).toFixed(target % 1 === 0 ? 0 : 1);
                setTimeout(updateCount, 15);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

    const chartConfig = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                position: 'bottom',
                labels: { 
                    usePointStyle: true,
                    padding: 20,
                    font: { family: 'Inter', size: 11 } 
                }
            }
        }
    };

    // Training Chart
    const trainingCtx = document.getElementById('trainingChart').getContext('2d');
    const trainingChart = new Chart(trainingCtx, {
        type: 'doughnut',
        data: { labels: [], datasets: [{ data: [], backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899'], borderWidth: 0, hoverOffset: 15 }] },
        options: { ...chartConfig, cutout: '70%', plugins: { ...chartConfig.plugins, tooltip: { callbacks: { label: (item) => ` ${item.label}: ${item.raw} ชม.` } } } }
    });

    // Awards Chart
    const awardsCtx = document.getElementById('awardsChart').getContext('2d');
    const awardsChart = new Chart(awardsCtx, {
        type: 'bar',
        data: { labels: [], datasets: [{ label: 'จำนวนรางวัล', data: [], backgroundColor: '#f59e0b', borderRadius: 8 }] },
        options: { ...chartConfig, scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } } }
    });

    // Leave Chart
    const leaveCtx = document.getElementById('leaveChart').getContext('2d');
    const leaveChart = new Chart(leaveCtx, {
        type: 'pie',
        data: { labels: [], datasets: [{ data: [], backgroundColor: ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6'], borderWidth: 0 }] },
        options: chartConfig
    });

    function updateDashboard(term = '') {
        const tid = '<?php echo $teacher_id; ?>';
        const year = '<?php echo $pee; ?>';

        // Fetch Training Data
        fetch(`api/fetch_chart_training.php?tid=${tid}&term=${term}&year=${year}`)
            .then(res => res.json())
            .then(data => {
                trainingChart.data.labels = data.map(i => i.topic);
                trainingChart.data.datasets[0].data = data.map(i => parseFloat(i.total_hours));
                trainingChart.update();
            });

        // Fetch Awards Data
        fetch(`api/fetch_chart_award.php?tid=${tid}&term=${term}&year=${year}`)
            .then(res => res.json())
            .then(data => {
                awardsChart.data.labels = data.map(i => i.level_name);
                awardsChart.data.datasets[0].data = data.map(i => i.total_awards);
                awardsChart.update();
            });

        // Fetch Leave Data (Always full year or as defined by default)
        fetch(`api/fetch_chart_leave.php?tid=${tid}`)
            .then(res => res.json())
            .then(data => {
                leaveChart.data.labels = data.map(i => i.status_name);
                leaveChart.data.datasets[0].data = data.map(i => i.total_days);
                leaveChart.update();
            });
    }

    document.getElementById('term_chart').addEventListener('change', (e) => updateDashboard(e.target.value));
    
    updateDashboard();
});
</script>
