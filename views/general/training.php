<!-- Public Training Summary View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-teal-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    📚
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">สรุปข้อมูลการอบรม/สัมมนา</h2>
                    <p class="text-emerald-100/80 mt-1 font-medium italic text-xs md:text-base">
                        ภาพรวมการพัฒนาตนเองบุคลากร | <span id="selected_term_display">ทั้งหมด</span> ปีการศึกษา <span id="selected_year_display"><?php echo $pee; ?></span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button onclick="window.print()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-emerald-700 text-sm md:text-base font-bold hover:bg-emerald-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-emerald-500/10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center text-2xl shrink-0">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">ชั่วโมงรวมทั้งโรงเรียน</p>
                    <h3 id="stat_total_hours" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
                </div>
            </div>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-blue-500/10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center text-2xl shrink-0">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">บุคลากรที่เข้ารับการอบรม</p>
                    <h3 id="stat_total_teachers" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
                </div>
            </div>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-amber-500/10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center text-2xl shrink-0">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">ชั่วโมงเฉลี่ยต่อคน</p>
                    <h3 id="stat_avg_hours" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass-morphism rounded-3xl p-6">
        <div class="flex flex-col lg:flex-row gap-6 items-stretch lg:items-end">
            <div class="flex-1 space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1 italic">
                    <i class="fas fa-filter text-emerald-500 mr-2"></i>ภาคเรียน
                </label>
                <select id="select_term" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold">
                    <option value="">ทั้งหมด</option>
                    <option value="1" <?= $term == '1' ? 'selected' : '' ?>>ภาคเรียนที่ 1</option>
                    <option value="2" <?= $term == '2' ? 'selected' : '' ?>>ภาคเรียนที่ 2</option>
                </select>
            </div>
            <div class="flex-1 space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1 italic">
                    <i class="fas fa-calendar-check text-emerald-500 mr-2"></i>ปีการศึกษา
                </label>
                <select id="select_year" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($years as $year): ?>
                    <option value="<?= $year['year'] ?>" <?= $year['year'] == $pee ? 'selected' : '' ?>><?= $year['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex gap-3">
                <button id="filterBtn" class="flex-1 lg:flex-none px-10 py-3 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-all shadow-lg hover:scale-105 active:scale-95">
                    <i class="fas fa-search mr-2"></i>แสดงข้อมูล
                </button>
            </div>
        </div>
    </div>

    <!-- Content Tabs/Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Table (Left 2/3) -->
        <div class="lg:col-span-2 glass-morphism rounded-[2rem] p-6 border border-white/20 shadow-xl bg-white/50 backdrop-blur-xl">
            <div class="flex items-center justify-between mb-6 px-2">
                <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="w-2 h-8 bg-emerald-500 rounded-full"></div>
                    ตารางรายชื่อบุคลากรและชั่วโมงอบรม
                </h3>
            </div>
            <div class="table-responsive">
                <table class="w-full" id="summary_table">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">ลำดับ</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">ชื่อ - สกุล</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">กลุ่มสาระ/ฝ่าย</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">ชั่วโมงรวม</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        <!-- Loaded by AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Department Analysis (Right 1/3) -->
        <div class="space-y-6">
            <div class="glass-morphism rounded-[2rem] p-8 border border-white/20 shadow-xl bg-gradient-to-br from-gray-900 to-black text-white overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-emerald-500/20 transition-all"></div>
                <h4 class="text-sm font-black uppercase tracking-widest text-emerald-400 mb-6 flex items-center gap-2">
                    <i class="fas fa-chart-pie"></i> สรุปรายกลุ่มสาระ
                </h4>
                <div id="dept_analysis" class="space-y-4">
                    <!-- Loaded by AJAX -->
                </div>
            </div>
            
            <div class="glass-morphism rounded-[2rem] p-6 border border-emerald-500/10 bg-emerald-50/50 dark:bg-emerald-500/5">
                <h4 class="text-xs font-black text-emerald-800 dark:text-emerald-400 uppercase tracking-widest mb-4">หมายเหตุ</h4>
                <p class="text-[10px] text-emerald-700/70 dark:text-emerald-400/70 leading-relaxed font-medium">
                    * ข้อมูลชั่วโมงการอบรมนี้ เป็นข้อมูลเบื้องต้นที่บุคลากรในสังกัดบันทึกผ่านระบบ เพื่อใช้ในการประเมินผลงานทางวิชาการและสรุปผลการปฏิบัติงานรายปี
                </p>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const table = $('#summary_table').DataTable({
        pageLength: 20,
        dom: 'rtip',
        language: {
            emptyTable: "ไม่พบข้อมูลการอบรม",
            paginate: { next: "ถัดไป", previous: "ก่อนหน้า" }
        },
        columnDefs: [
            { className: "text-center font-bold text-gray-400", targets: [0] },
            { className: "font-bold text-gray-900 dark:text-white", targets: [1] },
            { className: "text-sm text-gray-500", targets: [2] },
            { className: "text-center font-black text-emerald-600 bg-emerald-500/5 rounded-xl", targets: [3] }
        ]
    });

    function fetchData() {
        const term = $('#select_term').val() || '';
        const year = $('#select_year').val() || '';
        
        $('#selected_term_display').text(term ? 'ภาคเรียนที่ ' + term : 'ทั้งหมด');
        $('#selected_year_display').text(year || 'ทั้งหมด');

        Swal.fire({ title: 'กำลังประมวลผล...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.ajax({
            url: 'admin/api/fetch_training_summary.php',
            method: 'GET',
            data: { term, year },
            dataType: 'json',
            success: function(res) {
                Swal.close();
                if (res.success) {
                    populateTable(res.data);
                    renderAnalysis(res.data);
                }
            }
        });
    }

    function populateTable(data) {
        table.clear();
        let totalH = 0, totalM = 0;
        data.forEach((row, idx) => {
            totalH += parseInt(row.total_hours);
            totalM += parseInt(row.total_minutes);
            table.row.add([
                idx + 1,
                row.teacher_name,
                `<span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 rounded-lg text-xs font-bold uppercase">${row.teacher_department}</span>`,
                `${row.total_hours} ชม. ${row.total_minutes} น.`
            ]);
        });
        table.draw();
        
        totalH += Math.floor(totalM / 60);
        $('#stat_total_hours').text(totalH + ' ชม.');
        $('#stat_total_teachers').text(data.length + ' คน');
        $('#stat_avg_hours').text(data.length ? (totalH / data.length).toFixed(1) + ' ชม.' : '0 ชม.');
    }

    function renderAnalysis(data) {
        const depts = {};
        data.forEach(item => {
            const d = item.teacher_department || 'ไม่ระบุ';
            depts[d] = (depts[d] || 0) + parseInt(item.total_hours);
        });

        const sorted = Object.entries(depts).sort((a, b) => b[1] - a[1]);
        const max = sorted.length ? sorted[0][1] : 1;
        
        let html = '';
        sorted.slice(0, 5).forEach(([name, hours]) => {
            const pct = Math.max((hours / max) * 100, 5);
            html += `
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-bold">
                        <span class="text-gray-400">${name}</span>
                        <span class="text-emerald-400">${hours} ชม.</span>
                    </div>
                    <div class="w-full bg-white/5 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-1000" style="width: ${pct}%"></div>
                    </div>
                </div>`;
        });
        $('#dept_analysis').html(html || '<p class="text-xs text-center text-gray-500">ไม่มีข้อมูลการอบรม</p>');
    }

    $('#filterBtn').on('click', fetchData);
    fetchData();
});
</script>

<style>
@media print {
    /* Basic Reset */
    #sidebar, nav, .glass-morphism:has(#select_term), button, aside {
        display: none !important;
    }
    
    body { background: white !important; padding: 0 !important; margin: 0 !important; }
    
    .glass-morphism { 
        box-shadow: none !important; 
        border: none !important; 
        background: transparent !important; 
        padding: 0 !important;
    }

    .lg\:col-span-2 { width: 100% !important; }
    .lg\:grid-cols-3 { grid-template-columns: 1fr !important; }
    
    table { width: 100% !important; border-collapse: collapse !important; border: 1px solid black !important; }
    th, td { border: 1px solid black !important; padding: 10px !important; color: black !important; font-size: 11pt !important; }
    th { background: #f5f5f5 !important; font-weight: bold !important; }

    @page { size: portrait; margin: 1cm; }
}
</style>
