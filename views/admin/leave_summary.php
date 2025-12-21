<!-- Admin Leave Summary View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">สรุปการมาปฏิบัติงาน</h2>
                    <p class="text-indigo-100/80 mt-1 font-medium italic text-xs md:text-base">
                        ของข้าราชการครูและบุคคลากรทางการศึกษา
                    </p>
                </div>
            </div>
            <div class="flex justify-center gap-3 w-full md:w-auto">
                <button onclick="printPage()" class="px-6 py-2.5 md:py-3 rounded-2xl bg-white text-indigo-600 text-sm md:text-base font-bold hover:bg-indigo-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="glass-morphism rounded-3xl p-6 border border-white/20 shadow-xl space-y-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-indigo-500/5 p-4 rounded-2xl border border-indigo-500/10">
           <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <label class="text-sm font-black text-gray-500 uppercase tracking-widest whitespace-nowrap">เลือกวันที่:</label>
                <input type="date" id="select_date" value="<?php echo date('Y-m-d'); ?>" class="w-full md:w-auto px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-bold text-center">
                <button id="filterBtn" class="px-6 py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20">ค้นหา</button>
                <button id="resetBtn" class="px-6 py-2 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-widest hover:bg-slate-300 transition-all">วันนี้</button>
           </div>
           
           <div class="text-slate-500 text-sm font-bold bg-white/50 px-4 py-2 rounded-xl border border-slate-100 shadow-sm">
                วันที่: <span id="displayDate" class="text-indigo-600"><?php echo date('d/m/Y'); ?></span>
           </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="glass-morphism rounded-3xl p-6 overflow-hidden border border-white/20 shadow-xl bg-white">
        <!-- Print Header (Hidden on screen) -->
        <div id="printHeader" class="hidden mb-6 text-center">
             <img src="../dist/img/logo-phicha.png" alt="Logo" class="w-20 h-20 mx-auto mb-2 opacity-80 mix-blend-multiply">
             <h3 class="text-xl font-black text-black">สรุปการมาปฏิบัติงานของข้าราชการครูและบุคคลากรทางการศึกษาโรงเรียนพิชัย</h3>
             <p class="text-black font-bold mt-1">ประจำวันที่ <span id="printDateSpan"></span></p>
        </div>

        <div class="table-responsive">
            <table class="w-full border-collapse border border-slate-300 text-sm" id="record_table">
                <thead>
                    <tr class="bg-indigo-50/50 dark:bg-slate-800/50 text-slate-800 dark:text-slate-200">
                        <th rowspan="2" class="p-2 border border-slate-300 text-center font-black w-10">#</th>
                        <th rowspan="2" class="p-2 border border-slate-300 text-left font-black w-64">ชื่อ - สกุล</th>
                        <th colspan="6" class="p-2 border border-slate-300 text-center font-black bg-indigo-100/30">ตำแหน่ง</th>
                        <th colspan="7" class="p-2 border border-slate-300 text-center font-black bg-rose-100/30">สาเหตุ</th>
                        <th rowspan="2" class="p-2 border border-slate-300 text-center font-black w-24">หมายเหตุ</th>
                    </tr>
                    <tr class="bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 text-[10px] md:text-xs">
                         <!-- Roles -->
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-indigo-50/20">ผู้บริหาร</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-indigo-50/20">ครู</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-indigo-50/20">พนักงานราชการ</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-indigo-50/20">ลูกจ้างประจำ</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-indigo-50/20">ลูกจ้างชั่วคราว (สพฐ.)</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-indigo-50/20">ลูกจ้างชั่วคราว (บกศ.)</th>
                        <!-- Reasons -->
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-rose-50/20 font-bold text-rose-600">ไปราชการ</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-rose-50/20 font-bold text-rose-600">ลากิจ</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-rose-50/20 font-bold text-rose-600">ลาป่วย</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-rose-50/20 font-bold text-rose-600">ลาคลอดบุตร</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-rose-50/20 font-bold text-rose-600">ลาบวช</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-rose-50/20 font-bold text-rose-600">มาสาย</th>
                        <th class="p-2 border border-slate-300 text-center vertical-text h-32 w-8 bg-rose-50/20 font-bold text-rose-600">ขาด</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700 dark:text-slate-300 font-medium text-xs">
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.vertical-text {
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    white-space: nowrap;
}
@media print {
    @page { size: portrait; margin: 0.5cm; }
    body { background: white !important; color: black !important; }
    .no-print, nav, aside, footer, .glass-morphism > div:first-child, button, input { display: none !important; }
    #printHeader { display: block !important; }
    table { width: 100% !important; border: 1px solid black !important; font-size: 10px !important; }
    th, td { border: 1px solid black !important; color: black !important; padding: 4px !important; }
    .bg-indigo-100\/30, .bg-rose-100\/30, .bg-indigo-50\/20, .bg-rose-50\/20 { background-color: transparent !important; }
    .text-white { color: black !important; }
    .glass-morphism { box-shadow: none !important; border: none !important; }
    * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
}
</style>

<script>
$(document).ready(function() {
    const table = $('#record_table').DataTable({
        dom: 't', // Show only table, no search/paging controls
        paging: false,
        ordering: false,
        info: false,
        autoWidth: false,
        responsive: false,
        columnDefs: [
            { className: "text-center align-middle border border-slate-200 dark:border-slate-700", targets: "_all" },
            { className: "text-left align-middle pl-3 border border-slate-200 dark:border-slate-700 font-bold text-slate-800 dark:text-white", targets: [1] }
        ]
    });

    // Initial Load
    fetchLeaveData();

    // Event Listeners
    $('#filterBtn').click(fetchLeaveData);
    $('#select_date').change(fetchLeaveData);
    $('#resetBtn').click(function() {
        const today = new Date().toISOString().split('T')[0];
        $('#select_date').val(today);
        fetchLeaveData();
    });

    async function fetchLeaveData() {
        const date = $('#select_date').val();
        $('#displayDate').text(formatThaiDate(date));
        $('#printDateSpan').text(formatThaiDate(date));

        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        try {
            const res = await $.getJSON('api/fetch_leave_summary.php', { date });
            Swal.close();
            
            if (res.success) {
                populateTable(res.data);
            } else {
                Swal.fire('ข้อผิดพลาด', res.message, 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถดึงข้อมูลได้', 'error');
        }
    }

    function populateTable(data) {
        table.clear();
        
        if (!data || data.length === 0) {
            // Optional: Show empty state
        } else {
            data.forEach((row, idx) => {
                const t = row.teacher_details[0];
                const pos = t.Teach_Position2 || '';
                const st = row.status;
                const other = row.other_leave_type;

                // Helper to check mark
                const chk = (cond) => cond ? '<i class="fas fa-check text-emerald-600 font-black text-lg"></i>' : '';

                table.row.add([
                    idx + 1,
                    t.Teach_name,
                    chk(pos === 'ผู้บริหาร'),
                    chk(pos === 'ครู'),
                    chk(pos === 'พนักงานราชการ'),
                    chk(pos === 'ลูกจ้างประจำ'),
                    chk(pos === 'ลูกจ้างชั่วคราว (สพฐ.)'),
                    chk(pos === 'ลูกจ้างชั่วคราว (บกศ.)'),
                    
                    chk(st == 3), // ไปราชการ
                    chk(st == 2), // ลากิจ
                    chk(st == 1), // ลาป่วย
                    chk(st == 4), // ลาคลอด
                    chk(other === 'ลาอุปสมบท' || other === 'ลาบวช'), // ลาบวช
                    chk(st == 6), // มาสาย
                    chk(st == 7), // ขาด/ไม่ทราบสาเหตุ
                    
                    row.detail // หมายเหตุ
                ]);
            });
            table.draw();
        }
    }

    function formatThaiDate(dateStr) {
        const d = new Date(dateStr);
        const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear() + 543}`;
    }

    window.printPage = function() {
        window.print();
    };
});
</script>
