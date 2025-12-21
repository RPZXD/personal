<!-- Public School Performance Report View -->
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-fuchsia-700 p-8 md:p-12 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
            <div class="flex-1">
                <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">รายงานสรุปผลงานระดับสถานศึกษา</h2>
                <p class="text-indigo-100/80 mt-2 font-medium italic text-lg opacity-90">
                    ภาพรวมความสำเร็จและบุคลากร | ปีการศึกษา <span id="current_year_display"><?php echo $pee; ?></span>
                </p>
            </div>
            
            <div class="glass-morphism rounded-2xl p-4 flex items-center gap-4 bg-white/10 border border-white/20 shrink-0">
                <i class="fas fa-calendar-alt text-2xl"></i>
                <div class="text-left">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200">ตรวจสอบย้อนหลัง</p>
                    <select id="select_year" class="bg-transparent text-white font-black text-xl outline-none cursor-pointer border-none p-0 focus:ring-0">
                        <?php foreach ($years as $year): ?>
                        <option value="<?= $year['year'] ?>" <?= $year['year'] == $pee ? 'selected' : '' ?> class="text-black"><?= $year['year'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Training - Max Hours -->
        <div class="glass-morphism rounded-[2.5rem] p-6 border border-white/20 relative overflow-hidden group bg-white dark:bg-slate-900 shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-emerald-500/20 transition-all"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shadow-inner border border-emerald-500/10">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white">การพัฒนาตนเอง</h3>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Top Training Hours</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="text-center py-3 bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl">
                        <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400" id="max_train_hours">0</span>
                        <span class="text-sm font-bold text-emerald-500">ชม.</span>
                        <p class="text-[10px] text-gray-500 mt-1 font-bold">ชั่วโมงมากสุด</p>
                    </div>
                    <p id="top_trainer_name" class="text-[10px] text-center text-gray-600 dark:text-gray-400 font-bold truncate">-</p>
                    <div class="flex justify-between text-[10px] font-bold text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-2">
                        <span>รวมทั้งหมด</span>
                        <span class="text-emerald-600"><span id="total_train_hours">0</span> ชม. | <span id="train_count">0</span> คน</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Awards - Renamed -->
        <div class="glass-morphism rounded-[2.5rem] p-6 border border-white/20 relative overflow-hidden group bg-white dark:bg-slate-900 shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-amber-500/20 transition-all"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shadow-inner border border-amber-500/10">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white">ผลงานรางวัล</h3>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Awards & Honors</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="text-center py-3 bg-amber-50 dark:bg-amber-500/10 rounded-2xl">
                        <span class="text-3xl font-black text-amber-500 dark:text-amber-400" id="total_awards">0</span>
                        <p class="text-[10px] text-gray-500 mt-1 font-bold">รางวัลทั้งหมด</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-rose-50 dark:bg-rose-500/5 p-2 rounded-xl text-center">
                            <span class="block text-lg font-black text-rose-600 dark:text-rose-400" id="awards_national">0</span>
                            <span class="text-[8px] font-bold text-rose-400 uppercase">ระดับชาติ+</span>
                        </div>
                        <div class="bg-indigo-50 dark:bg-indigo-500/5 p-2 rounded-xl text-center">
                            <span class="block text-lg font-black text-indigo-600 dark:text-indigo-400" id="awards_other">0</span>
                            <span class="text-[8px] font-bold text-indigo-400 uppercase">ระดับอื่นๆ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Today -->
        <div class="glass-morphism rounded-[2.5rem] p-6 border border-white/20 relative overflow-hidden group bg-white dark:bg-slate-900 shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/10 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-rose-500/20 transition-all"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-center text-xl shadow-inner border border-rose-500/10">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white">การลาประจำวัน</h3>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Today's Attendance</p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div id="leave_summary_container" class="space-y-1 max-h-24 overflow-y-auto">
                        <!-- Loaded by AJAX -->
                        <div class="animate-pulse flex items-center justify-between p-2">
                            <div class="h-3 bg-gray-200 dark:bg-slate-700 rounded w-1/3"></div>
                            <div class="h-3 bg-gray-200 dark:bg-slate-700 rounded w-8"></div>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-gray-100 dark:border-gray-700/50 flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-500 uppercase">รวมวันนี้</span>
                        <span class="text-lg font-black text-rose-600 dark:text-rose-400"><span id="total_leave_count">0</span> <span class="text-[10px] text-gray-400 font-normal">ท่าน</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Personnel -->
        <div class="glass-morphism rounded-[2.5rem] p-6 border border-white/20 relative overflow-hidden group bg-white dark:bg-slate-900 shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-sky-500/10 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-sky-500/20 transition-all"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100 dark:bg-sky-500/20 text-sky-600 dark:text-sky-400 flex items-center justify-center text-xl shadow-inner border border-sky-500/10">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white">ข้อมูลบุคลากร</h3>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Personnel Summary</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="text-center py-3 bg-sky-50 dark:bg-sky-500/10 rounded-2xl">
                        <span class="text-3xl font-black text-sky-600 dark:text-sky-400" id="total_personnel">0</span>
                        <p class="text-[10px] text-gray-500 mt-1 font-bold">บุคลากรทั้งหมด</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-center">
                        <div class="bg-purple-50 dark:bg-purple-500/5 p-2 rounded-xl">
                            <span class="block text-lg font-black text-purple-600 dark:text-purple-400" id="avg_train_hours">0</span>
                            <span class="text-[8px] font-bold text-purple-400 uppercase">ชม.เฉลี่ย/คน</span>
                        </div>
                        <div class="bg-teal-50 dark:bg-teal-500/5 p-2 rounded-xl">
                            <span class="block text-lg font-black text-teal-600 dark:text-teal-400" id="trained_pct">0%</span>
                            <span class="text-[8px] font-bold text-teal-400 uppercase">อบรมแล้ว</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-center mt-8">
        <button onclick="window.print()" class="px-10 py-4 rounded-3xl bg-slate-900 text-white font-black hover:bg-black transition-all shadow-2xl flex items-center gap-3 hover:scale-105 active:scale-95">
            <i class="fas fa-file-pdf text-xl"></i> พิมพ์รายงานภาพรวมโรงเรียน
        </button>
    </div>

    <!-- Print Only Section -->
    <div id="print_report" class="hidden">
        <div class="text-center mb-12 border-b-4 border-black pb-6">
            <div class="flex items-center justify-center gap-8 mb-6">
                <img src="dist/img/logo-phicha.png" class="w-24 h-24 object-contain">
                <div class="text-left">
                    <h1 class="text-4xl font-black text-black">โรงเรียนพิชัย</h1>
                    <p class="text-xl font-bold text-black uppercase tracking-tight">Phichai School Institutional Performance Report</p>
                </div>
            </div>
            <h2 class="text-2xl font-black text-black mt-4">สรุปสถิติด้านบุคลากรและผลงานทางวิชาการ</h2>
            <p class="text-xl font-bold text-black">ประจำปีการศึกษา <span class="print-year"><?= $pee ?></span></p>
        </div>

        <div class="space-y-12 text-black">
            <section>
                <h3 class="text-xl font-black border-l-8 border-black pl-4 mb-6 uppercase">สรุปด้านการพัฒนาตนเอง (Training)</h3>
                <div class="grid grid-cols-2 gap-8 text-lg">
                    <div class="p-6 border-2 border-black rounded-2xl">
                        <p class="text-gray-600 mb-1">ชั่วโมงการอบรมรวมทั้งโรงเรียน</p>
                        <p class="text-3xl font-black text-black"><span id="p_train_h">0</span> ชั่วโมง</p>
                    </div>
                    <div class="p-6 border-2 border-black rounded-2xl">
                        <p class="text-gray-600 mb-1">จำนวนบุคลากรที่เข้ารับการอบรม</p>
                        <p class="text-3xl font-black text-black"><span id="p_train_c">0</span> ท่าน</p>
                    </div>
                </div>
            </section>

            <section>
                <h3 class="text-xl font-black border-l-8 border-black pl-4 mb-6 uppercase">สรุปด้านรางวัลและเกียรติยศ (Awards)</h3>
                <table class="w-full border-4 border-black text-lg">
                    <thead class="bg-gray-100 border-b-4 border-black">
                        <tr>
                            <th class="p-4 text-left border-r-4 border-black">ประเภทรางวัล</th>
                            <th class="p-4 text-center">จำนวนที่ได้รับ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black">
                        <tr>
                            <td class="p-4 border-r-4 border-black font-bold">ระดับชาติ และนานาชาติ</td>
                            <td class="p-4 text-center font-black text-2xl" id="p_award_n">0</td>
                        </tr>
                        <tr>
                            <td class="p-4 border-r-4 border-black font-bold">ระดับอื่นๆ (ภาค/จังหวัด/เขต)</td>
                            <td class="p-4 text-center font-black text-2xl" id="p_award_o">0</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="p-4 border-r-4 border-black font-black uppercase">รวมทั้งสิ้น</td>
                            <td class="p-4 text-center font-black text-3xl" id="p_award_t">0</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function loadSchoolData() {
        const year = $('#select_year').val();
        $('#current_year_display, .print-year').text(year);
        
        Swal.fire({ title: 'กำลังรวบรวมข้อมูล...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        // 1. Fetch Training Summary
        const trainReq = $.ajax({
            url: 'admin/api/fetch_training_summary.php',
            data: { year: year, term: 'all' },
            dataType: 'json'
        });

        // 2. Fetch Awards Summary
        const awardReq = $.ajax({
            url: 'api/fetch_award_summary.php',
            data: { year: year, term: 'all' },
            dataType: 'json'
        });

        // 3. Fetch Today's Leave Summary
        const leaveReq = $.ajax({
            url: 'admin/api/fetch_leave_summary.php',
            data: { date: '<?php echo date('Y-m-d'); ?>' },
            dataType: 'json'
        });

        // 4. Fetch Personnel Count
        const personnelReq = $.ajax({
            url: 'admin/api/fetch_teachers.php',
            data: { department: 'all' },
            dataType: 'json'
        });

        Promise.all([trainReq, awardReq, leaveReq, personnelReq]).then(responses => {
            Swal.close();
            const [train, award, leave, personnel] = responses;

            // Handle Training - Calculate max and totals
            if (train.success) {
                let totalH = 0, totalM = 0;
                let maxH = 0, topTrainer = '-';
                
                train.data.forEach(t => { 
                    const h = parseInt(t.total_hours) || 0;
                    const m = parseInt(t.total_minutes) || 0;
                    totalH += h; 
                    totalM += m;
                    
                    // Track max hours trainer
                    const totalTrainerH = h + Math.floor(m / 60);
                    if (totalTrainerH > maxH) {
                        maxH = totalTrainerH;
                        topTrainer = t.teacher_name || '-';
                    }
                });
                totalH += Math.floor(totalM / 60);
                
                $('#max_train_hours').text(maxH);
                $('#top_trainer_name').text(topTrainer);
                $('#total_train_hours, #p_train_h').text(totalH);
                $('#train_count, #p_train_c').text(train.data.length);
                
                // Calculate average and percentage
                const avgHours = train.data.length > 0 ? (totalH / train.data.length).toFixed(1) : 0;
                $('#avg_train_hours').text(avgHours);
            }

            // Handle Awards
            if (award.success) {
                let n = 0, o = 0;
                award.data.forEach(a => {
                    const level = String(a.level);
                    if (['3', '4'].includes(level)) n++;
                    else o++;
                });
                $('#total_awards, #p_award_t').text(award.data.length);
                $('#awards_national, #p_award_n').text(n);
                $('#awards_other, #p_award_o').text(o);
            }

            // Handle Leave
            if (leave.success) {
                const summary = { 'ลาป่วย': 0, 'ลากิจ': 0, 'ไปราชการ': 0, 'อื่นๆ': 0 };
                leave.data.forEach(l => {
                    const type = getLeaveTypeText(l.status);
                    summary[type] = (summary[type] || 0) + 1;
                });
                
                let html = '';
                Object.entries(summary).forEach(([label, count]) => {
                    if (count > 0) {
                        html += `
                            <div class="flex justify-between items-center p-1.5 rounded-lg bg-gray-50 dark:bg-slate-800/50">
                                <span class="text-[10px] font-bold text-gray-500">${label}</span>
                                <span class="text-sm font-black text-gray-900 dark:text-white">${count}</span>
                            </div>`;
                    }
                });
                $('#leave_summary_container').html(html || '<p class="text-[10px] text-center text-gray-400 py-2">วันนี้ไม่มีการลา</p>');
                $('#total_leave_count').text(leave.data.length);
            }

            // Handle Personnel
            if (personnel.success && personnel.data) {
                const totalPersonnel = personnel.data.length;
                $('#total_personnel').text(totalPersonnel);
                
                // Calculate trained percentage
                if (train.success && totalPersonnel > 0) {
                    const trainedCount = train.data.length;
                    const trainedPct = Math.round((trainedCount / totalPersonnel) * 100);
                    $('#trained_pct').text(trainedPct + '%');
                }
            } else {
                // Fallback: use trained count as personnel if API fails
                if (train.success) {
                    $('#total_personnel').text(train.data.length);
                    $('#trained_pct').text('100%');
                }
            }
        }).catch(err => {
            Swal.close();
            console.error('Error loading data:', err);
        });
    }

    function getLeaveTypeText(status) {
        const s = String(status);
        switch (s) {
            case '1': return 'ลาป่วย';
            case '2': return 'ลากิจ';
            case '3': return 'ไปราชการ';
            default: return 'อื่นๆ';
        }
    }

    $('#select_year').on('change', loadSchoolData);
    loadSchoolData();
});
</script>

<style>
@media print {
    body { background: white !important; }
    .animate-fade-in > div:not(#print_report), nav, #sidebar, button, select, .swal2-container {
        display: none !important;
    }
    #print_report { display: block !important; position: static; width: 100%; color: black !important; }
    @page { size: portrait; margin: 1.5cm; }
}
</style>
