<!-- Public Awards Summary View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    🏆
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">สรุปรางวัลและผลงานเชิดชูเกียรติ</h2>
                    <p class="text-indigo-100/80 mt-1 font-medium italic text-xs md:text-base">
                        ความภูมิใจของชาวพิชัย | <span id="selected_term_display">ทั้งหมด</span> ปีการศึกษา <span id="selected_year_display"><?php echo $pee; ?></span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button onclick="window.print()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-indigo-700 text-sm md:text-base font-bold hover:bg-indigo-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์รายงานสรุป
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-indigo-500/10 bg-indigo-50/10">
            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">รางวัลทั้งหมด</p>
            <h3 id="stat_total" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-rose-500/10 bg-rose-50/10">
            <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest">ระดับชาติ/นานาชาติ</p>
            <h3 id="stat_national" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-amber-500/10 bg-amber-50/10">
            <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">ระดับภูมิภาค</p>
            <h3 id="stat_regional" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-emerald-500/10 bg-emerald-50/10">
            <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">จังหวัด/เขต</p>
            <h3 id="stat_local" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass-morphism rounded-3xl p-6 border border-white/20 shadow-xl">
        <div class="flex flex-col lg:flex-row gap-6 items-stretch lg:items-end">
            <div class="w-full lg:w-1/3 space-y-2">
                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">ภาคเรียน</label>
                <select id="select_term" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-bold">
                    <option value="">ทั้งหมด</option>
                    <option value="1" <?= $term == '1' ? 'selected' : '' ?>>ภาคเรียนที่ 1</option>
                    <option value="2" <?= $term == '2' ? 'selected' : '' ?>>ภาคเรียนที่ 2</option>
                </select>
            </div>
            <div class="w-full lg:w-1/3 space-y-2">
                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">ปีการศึกษา</label>
                <select id="select_year" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-bold">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($years as $year): ?>
                    <option value="<?= $year['year'] ?>" <?= $year['year'] == $pee ? 'selected' : '' ?>><?= $year['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button id="filterBtn" class="px-10 py-3 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-all shadow-lg flex-1 lg:flex-none">
                <i class="fas fa-search mr-2"></i> ค้นหารางวัล
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="glass-morphism rounded-3xl p-6 border border-white/20 shadow-xl bg-white/50 backdrop-blur-xl">
        <div class="table-responsive">
            <table class="w-full text-left" id="record_table">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">#</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">ผู้ได้รับรางวัล</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">รางวัลที่ได้รับ</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">ระดับ</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">ปี/เทอม</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">หลักฐาน</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    <!-- Loaded by AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 z-[100] hidden overflow-y-auto bg-black/80 backdrop-blur-sm animate-fade-in flex items-center justify-center p-4">
    <div class="relative w-full max-w-5xl animate-slide-up">
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors text-2xl">
            <i class="fas fa-times mr-2"></i> ปิด
        </button>
        <div class="rounded-3xl overflow-hidden bg-white dark:bg-slate-900 shadow-2xl border border-white/20">
            <img id="modalImage" src="" class="w-full h-auto max-h-[85vh] object-contain mx-auto">
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const recordTable = $('#record_table').DataTable({
        "pageLength": 25,
        "dom": 'rtip',
        "language": {
            "emptyTable": "ไม่พบข้อมูลรางวัล",
            "paginate": { "next": ">", "previous": "<" }
        },
        "columnDefs": [
            { "className": "text-center font-bold text-gray-400", "targets": [0] },
            { "className": "text-center", "targets": [3, 4, 5] }
        ]
    });

    function fetchData() {
        const term = $('#select_term').val() || '';
        const year = $('#select_year').val() || '';
        
        $('#selected_term_display').text(term ? 'เทอม ' + term : 'ทั้งหมด');
        $('#selected_year_display').text(year || 'ทั้งหมด');

        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.ajax({
            url: 'api/fetch_award_summary.php',
            method: 'GET',
            data: { term, year },
            dataType: 'json',
            success: function(res) {
                Swal.close();
                if (res.success) {
                    populateTable(res.data);
                    updateStats(res.data);
                }
            }
        });
    }

    function populateTable(data) {
        recordTable.clear();
        data.forEach((item, index) => {
            recordTable.row.add([
                index + 1,
                `<div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-[10px]">
                        ${item.teacher_name.charAt(0)}
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white uppercase">${item.teacher_name}</div>
                        <div class="text-[10px] text-gray-400 font-bold">${item.teacher_major}</div>
                    </div>
                </div>`,
                `<div class="font-bold text-indigo-700 dark:text-indigo-400">${item.award}</div><div class="text-[10px] text-gray-400 mt-1">${item.department}</div>`,
                `<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black ${getLevelBadgeClass(item.level)}">${getAwardLevelText(item.level)}</span>`,
                `<span class="text-xs font-black text-gray-900 dark:text-white">${item.term}/${item.year}</span>`,
                item.certificate ? 
                `<button onclick="viewImage('uploads/file_award/${item.certificate}')" class="block w-16 mx-auto rounded-lg overflow-hidden border border-gray-100 opacity-80 hover:opacity-100 transition-all cursor-zoom-in">
                    <img src="uploads/file_award/${item.certificate}" class="w-full h-10 object-cover">
                </button>` : 
                `<span class="text-[10px] text-gray-300 italic">no proof</span>`
            ]);
        });
        recordTable.draw();
    }

    function updateStats(data) {
        let n = 0, r = 0, l = 0;
        data.forEach(item => {
            if (item.level == '4' || item.level == '3') n++;
            else if (item.level == '2') r++;
            else l++;
        });
        $('#stat_total').text(data.length);
        $('#stat_national').text(n);
        $('#stat_regional').text(r);
        $('#stat_local').text(l);
    }

    function getLevelBadgeClass(level) {
        switch (level) {
            case '4': return 'bg-rose-100 text-rose-800 dark:bg-rose-500/20 dark:text-rose-400';
            case '3': return 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400';
            case '2': return 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-400';
            default: return 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400';
        }
    }

    function getAwardLevelText(level) {
        switch (level) {
            case '1': return 'เขต/จังหวัด';
            case '2': return 'ระดับภาค';
            case '3': return 'ระดับชาติ';
            case '4': return 'นานาชาติ';
            default: return 'ไม่ระบุ';
        }
    }

    window.viewImage = function(src) {
        $('#modalImage').attr('src', src);
        $('#imageModal').removeClass('hidden').addClass('flex');
        $('body').addClass('overflow-hidden');
    }

    window.closeImageModal = function() {
        $('#imageModal').addClass('hidden').removeClass('flex');
        $('body').removeClass('overflow-hidden');
    }

    // Close on background click
    $('#imageModal').on('click', function(e) {
        if (e.target === this) closeImageModal();
    });

    $('#filterBtn').on('click', fetchData);
    fetchData();
});
</script>

<style>
/* Mobile Responsive Table - Card Style */
@media screen and (max-width: 768px) {
    #record_table thead { display: none; }
    #record_table tbody tr {
        display: flex;
        flex-direction: column;
        background: var(--card-bg, #ffffff);
        border-radius: 1.5rem;
        margin-bottom: 1rem;
        padding: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
    }
    .dark #record_table tbody tr {
        --card-bg: #1e293b;
        border-color: rgba(255, 255, 255, 0.1);
    }
    #record_table tbody td {
        display: flex;
        align-items: flex-start;
        padding: 0.5rem 0;
        border: none !important;
        text-align: left !important;
    }
    /* Row number badge */
    #record_table tbody td:first-child {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: bold;
    }
    /* Teacher info - full width */
    #record_table tbody td:nth-child(2) {
        padding-right: 3rem;
        flex-direction: column;
    }
    /* Award info */
    #record_table tbody td:nth-child(3) {
        padding-top: 0.75rem;
        border-top: 1px dashed rgba(0, 0, 0, 0.1) !important;
    }
    .dark #record_table tbody td:nth-child(3) {
        border-top-color: rgba(255, 255, 255, 0.1) !important;
    }
    #record_table tbody td:nth-child(3)::before {
        content: "🏆 รางวัล: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        font-size: 10px;
    }
    /* Level badge */
    #record_table tbody td:nth-child(4)::before {
        content: "📊 ระดับ: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        font-size: 10px;
    }
    /* Year/Term */
    #record_table tbody td:nth-child(5)::before {
        content: "📅 ปี/เทอม: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        font-size: 10px;
    }
    /* Certificate */
    #record_table tbody td:nth-child(6) {
        justify-content: flex-start;
    }
    #record_table tbody td:nth-child(6)::before {
        content: "📄 หลักฐาน: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        font-size: 10px;
    }
}

/* Print Styles */
@media print {
    #sidebar, nav, #filterBtn, select, .dataTables_paginate, .dataTables_info, .dataTables_length { display: none !important; }
    body { background: white !important; }
    .glass-morphism { box-shadow: none !important; border: none !important; background: transparent !important; }
    #record_table thead { display: table-header-group !important; }
    #record_table tbody tr { display: table-row !important; background: white !important; }
    #record_table tbody td { display: table-cell !important; border: 1px solid #d1d5db !important; padding: 8px !important; }
    #record_table tbody td::before { content: none !important; }
    table { width: 100% !important; border: 1px solid black !important; border-collapse: collapse !important; }
    th, td { border: 1px solid black !important; padding: 10px !important; color: black !important; font-size: 10pt !important; }
    th { background: #f0f0f0 !important; font-weight: bold !important; }
    @page { size: portrait; margin: 1cm; }
}
</style>
