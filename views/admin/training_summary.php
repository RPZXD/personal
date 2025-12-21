<!-- Admin Training Summary View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">สรุปชั่วโมงการอบรม</h2>
                    <p class="text-emerald-100/80 mt-1 font-medium italic text-xs md:text-base">
                        ภาพรวมการพัฒนาศักยภาพบุคลากร
                    </p>
                </div>
            </div>
            <div class="flex justify-center gap-3 w-full md:w-auto">
                <button onclick="printPage()" class="px-6 py-2.5 md:py-3 rounded-2xl bg-white text-emerald-600 text-sm md:text-base font-bold hover:bg-emerald-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="glass-morphism rounded-3xl p-6 border border-white/20 shadow-xl space-y-6">
        <div class="flex flex-col md:flex-row gap-4 items-end bg-emerald-500/5 p-4 rounded-2xl border border-emerald-500/10">
            <div class="w-full md:w-1/3 space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">ภาคเรียน</label>
                <select id="select_term" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold text-sm">
                    <option value="">ทั้งหมด</option>
                    <option value="1">ภาคเรียนที่ 1</option>
                    <option value="2">ภาคเรียนที่ 2</option>
                </select>
            </div>
            <div class="w-full md:w-1/3 space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">ปีการศึกษา</label>
                <select id="select_year" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold text-sm">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($years as $year): ?>
                        <option value="<?= $year['year'] ?>"><?= $year['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
             <div class="flex gap-2 w-full md:w-auto">
                <button id="filterBtn" class="flex-1 md:flex-none px-6 py-3 rounded-2xl bg-emerald-500 text-white font-bold hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20 text-sm uppercase tracking-wider">
                    <i class="fas fa-search mr-2"></i>ค้นหา
                </button>
                <button id="resetBtn" class="flex-1 md:flex-none px-6 py-3 rounded-2xl bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-200 transition-all text-sm uppercase tracking-wider">
                    ล้างค่า
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="glass-morphism rounded-3xl p-6 overflow-hidden border border-white/20 shadow-xl bg-white">
        <!-- Print Header -->
        <div id="printHeader" class="hidden mb-8 text-center bg-white">
             <img src="../dist/img/logo-phicha.png" alt="Logo" class="w-20 h-20 mx-auto mb-2 opacity-80 mix-blend-multiply">
             <h3 class="text-xl font-black text-black">รายงานสรุปชั่วโมงการอบรม</h3>
             <p class="text-black font-bold mt-1">
                <span id="print_term"></span> 
                ปีการศึกษา <span id="print_year"></span>
             </p>
        </div>

        <div class="table-responsive">
            <table class="w-full border-collapse" id="record_table">
                <thead>
                    <tr class="bg-emerald-50/50 dark:bg-slate-800/50 text-slate-800 dark:text-slate-200 border-b border-emerald-100 dark:border-emerald-900/30">
                        <th class="p-4 text-center font-black text-sm w-16 uppercase tracking-wider">#</th>
                        <th class="p-4 text-left font-black text-sm uppercase tracking-wider">ชื่อ - สกุล</th>
                        <th class="p-4 text-left font-black text-sm uppercase tracking-wider">กลุ่มสาระ</th>
                        <th class="p-4 text-center font-black text-sm w-48 uppercase tracking-wider">ชั่วโมงรวม</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50 text-sm">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const table = $('#record_table').DataTable({
        pageLength: 50,
        dom: 'rtip', // Hide search box, use custom filters
        language: {
            emptyTable: "ไม่พบข้อมูล",
            info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            paginate: { next: ">", previous: "<" }
        },
        columnDefs: [
             { className: "text-center font-bold text-slate-400", targets: [0] },
             { className: "font-bold text-slate-700 dark:text-slate-200", targets: [1] },
             { className: "text-slate-500", targets: [2] },
             { className: "text-center font-bold text-emerald-600 bg-emerald-50/50 rounded-xl", targets: [3] }
        ]
    });

    // Load initial data
    fetchData();

    $('#filterBtn').click(fetchData);
    $('#select_term, #select_year').change(fetchData); // Auto-fetch on change
    $('#resetBtn').click(function() {
        $('#select_term, #select_year').val('');
        fetchData();
    });

    async function fetchData() {
        const term = $('#select_term').val();
        const year = $('#select_year').val();

        // Update print header
        $('#print_term').text(term ? `ภาคเรียนที่ ${term}` : 'ทุกภาคเรียน');
        $('#print_year').text(year ? year : 'ทั้งหมด');

        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        try {
            const res = await $.getJSON('api/fetch_training_summary.php', { term, year });
            Swal.close();
            
            if (res.success) {
                populateTable(res.data);
            } else {
                Swal.fire('ข้อผิดพลาด', res.message, 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์', 'error');
        }
    }

    function populateTable(data) {
        table.clear();
        if (data.length > 0) {
            data.forEach((row, idx) => {
                table.row.add([
                    idx + 1,
                    `<div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-black text-xs shadow-sm border border-white">
                            ${row.teacher_name.charAt(0)}
                        </div>
                        ${row.teacher_name}
                    </div>`,
                    `<span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 rounded-lg text-xs font-bold">${row.teacher_department}</span>`,
                    `${row.total_hours} ชม. ${row.total_minutes} นาที`
                ]);
            });
        }
        table.draw();
    }

    window.printPage = function() {
        window.print();
    };
});
</script>

<style>
@media print {
    @page { size: portrait; margin: 1cm; }
    body { background: white !important; color: black !important; }
    #printHeader { display: block !important; }
    .no-print, nav, aside, .glass-morphism > div:first-child { display: none !important; } /* Hide filters */
    .glass-morphism { box-shadow: none !important; border: none !important; padding: 0 !important; }
    table { width: 100% !important; border: 1px solid black !important; font-size: 11pt !important; }
    th, td { border: 1px solid black !important; padding: 8px !important; color: black !important; }
    th { background-color: #f0f0f0 !important; font-weight: bold !important; text-align: center !important; }
    
    /* Reset custom cell styles for print */
    .bg-emerald-50\/50 { background: transparent !important; }
    .text-emerald-600 { color: black !important; }
    .bg-gray-100 { background: transparent !important; border: none !important; }
    .rounded-full, .rounded-lg, .rounded-xl { border-radius: 0 !important; }
    .flex { display: inline-block !important; } /* Simplify flex layouts */
}
</style>
