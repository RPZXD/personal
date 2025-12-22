<?php
/**
 * View: Leave Summary Report for Admin
 * Path: views/admin/leave_summary.php
 * Style: Card-based mobile responsive (like general/leave.php)
 */
?>

<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="no-print relative overflow-hidden rounded-3xl bg-gradient-to-br from-rose-600 to-orange-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    🍃
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">สรุปการมาปฏิบัติงาน</h2>
                    <p class="text-rose-100/80 mt-1 font-medium italic text-xs md:text-base">
                        รายงานประจำวัน | <span id="current_date_display"><?php echo date('d/m/Y'); ?></span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button onclick="window.print()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-rose-700 text-sm md:text-base font-bold hover:bg-rose-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Daily Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 no-print">
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-rose-500/10">
            <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest">ลาป่วย</p>
            <h3 id="stat_sick" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-amber-500/10">
            <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">ลากิจ</p>
            <h3 id="stat_personal" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-blue-500/10">
            <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest">ไปราชการ</p>
            <h3 id="stat_business" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-emerald-500/10">
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">รวมทั้งหมด</p>
            <h3 id="stat_total" class="text-2xl font-black text-gray-900 dark:text-white mt-1">0</h3>
        </div>
    </div>

    <!-- Date Selection -->
    <div class="glass-morphism rounded-3xl p-6 border border-white/20 shadow-xl max-w-xl mx-auto no-print">
        <div class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1 space-y-2 w-full">
                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">เลือกวันที่</label>
                <input type="date" id="select_date" value="<?php echo date('Y-m-d'); ?>" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-rose-500 outline-none transition-all font-bold">
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <button id="filterBtn" class="flex-1 sm:flex-none px-6 py-3 rounded-2xl bg-rose-600 text-white font-bold hover:bg-rose-700 transition-all shadow-lg">
                    <i class="fas fa-search mr-2"></i>ค้นหา
                </button>
                <button id="resetBtn" class="flex-1 sm:flex-none px-6 py-3 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">
                    <i class="fas fa-undo mr-2"></i>วันนี้
                </button>
            </div>
        </div>
    </div>

    <!-- Print Header -->
    <div id="print_header" class="hidden print:block text-center space-y-4 mb-8">
        <div class="flex justify-center mb-2">
            <img src="../dist/img/logo-phicha.png" alt="Logo" class="w-20 h-20">
        </div>
        <h2 class="text-2xl font-bold text-black border-black border-b-2 pb-2 inline-block">สรุปการมาปฏิบัติงานของข้าราชการครูและบุคลากร</h2>
        <p class="text-lg text-black font-semibold">ประจำวันที่ <span id="print_date"></span></p>
    </div>

    <!-- Summary Table -->
    <div class="glass-morphism rounded-[2rem] p-4 sm:p-6 border border-white/20 shadow-xl bg-white/50 backdrop-blur-xl">
        <div class="flex items-center justify-between mb-6 px-2">
            <h3 class="text-lg sm:text-xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-2 h-8 bg-rose-500 rounded-full"></div>
                รายชื่อบุคลากรที่ลา <span id="table_date_display" class="text-rose-600"><?php echo date('d/m/Y'); ?></span>
            </h3>
        </div>
        <div class="table-responsive">
            <table class="w-full" id="leave_table">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center w-12">#</th>
                        <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">ชื่อ - สกุล</th>
                        <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">ตำแหน่ง</th>
                        <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">ประเภทการลา</th>
                        <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    <!-- Loaded by AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const table = $('#leave_table').DataTable({
        "dom": 't',
        "paging": false,
        "ordering": false,
        "info": false,
        "language": { "emptyTable": "วันนี้ไม่มีบุคลากรลา" },
        "columnDefs": [
            { "className": "text-center font-bold text-gray-400", "targets": [0] },
            { "className": "text-center", "targets": [2, 3] }
        ]
    });

    function fetchData() {
        const date = $('#select_date').val();
        const displayDate = new Date(date).toLocaleDateString('th-TH');
        
        $('#current_date_display, #table_date_display, #print_date').text(displayDate);
        
        Swal.fire({ title: 'กำลังโหลดข้อมูล...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.ajax({
            url: 'api/fetch_leave_summary.php',
            method: 'GET',
            data: { date: date },
            dataType: 'json',
            success: function(res) {
                Swal.close();
                if (res.success) {
                    populateTable(res.data);
                    updateStats(res.data);
                }
            },
            error: function() {
                Swal.close();
                table.clear().draw();
                updateStats([]);
            }
        });
    }

    function populateTable(data) {
        table.clear();
        data.forEach((item, index) => {
            const t = item.teacher_details && item.teacher_details[0] ? item.teacher_details[0] : { Teach_name: 'Unknown', Teach_Position2: '-' };
            table.row.add([
                index + 1,
                `<div class="font-bold text-gray-900 dark:text-white">${t.Teach_name}</div>`,
                `<span class="text-xs text-gray-500">${t.Teach_Position2 || '-'}</span>`,
                `<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black ${getLeaveBadgeClass(item.status)}">${getLeaveTypeText(item.status, item.other_leave_type)}</span>`,
                `<p class="text-xs text-gray-600 dark:text-gray-400 max-w-xs truncate">${item.detail || '-'}</p>`
            ]);
        });
        table.draw();
    }

    function updateStats(data) {
        let sick = 0, personal = 0, business = 0;
        data.forEach(item => {
            const s = String(item.status);
            if (s == '1') sick++;
            else if (s == '2') personal++;
            else if (s == '3') business++;
        });
        $('#stat_sick').text(sick);
        $('#stat_personal').text(personal);
        $('#stat_business').text(business);
        $('#stat_total').text(data.length);
    }

    function getLeaveTypeText(status, otherType) {
        const s = String(status);
        switch (s) {
            case '1': return 'ลาป่วย';
            case '2': return 'ลากิจ';
            case '3': return 'ไปราชการ';
            case '4': return 'ลาคลอด';
            case '6': return 'มาสาย';
            case '7': return 'ขาด/ไม่ทราบสาเหตุ';
            case '9': return otherType || 'อื่นๆ';
            default: return 'ไม่ระบุ';
        }
    }

    function getLeaveBadgeClass(status) {
        const s = String(status);
        switch (s) {
            case '1': return 'bg-rose-100 text-rose-800 dark:bg-rose-500/20 dark:text-rose-400';
            case '2': return 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400';
            case '3': return 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400';
            case '4': return 'bg-pink-100 text-pink-800 dark:bg-pink-500/20 dark:text-pink-400';
            case '6': return 'bg-orange-100 text-orange-800 dark:bg-orange-500/20 dark:text-orange-400';
            case '7': return 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400';
            default: return 'bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-gray-300';
        }
    }

    $('#filterBtn').on('click', fetchData);
    $('#resetBtn').on('click', function() {
        $('#select_date').val('<?php echo date('Y-m-d'); ?>');
        fetchData();
    });
    
    // Initial load
    fetchData();
});
</script>

<style>
/* Mobile Responsive Table - Card Style */
@media screen and (max-width: 768px) {
    #leave_table thead { display: none; }
    #leave_table tbody tr {
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
    .dark #leave_table tbody tr {
        --card-bg: #1e293b;
        border-color: rgba(255, 255, 255, 0.1);
    }
    #leave_table tbody td {
        display: flex;
        align-items: flex-start;
        padding: 0.5rem 0;
        border: none !important;
        text-align: left !important;
    }
    /* Row number badge */
    #leave_table tbody td:first-child {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: linear-gradient(135deg, #f43f5e, #fb923c);
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
    /* Teacher name */
    #leave_table tbody td:nth-child(2) {
        padding-right: 3rem;
        flex-direction: column;
    }
    /* Position */
    #leave_table tbody td:nth-child(3)::before {
        content: "👤 ตำแหน่ง: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        font-size: 10px;
    }
    /* Leave type */
    #leave_table tbody td:nth-child(4) {
        padding-top: 0.75rem;
        border-top: 1px dashed rgba(0, 0, 0, 0.1) !important;
    }
    .dark #leave_table tbody td:nth-child(4) {
        border-top-color: rgba(255, 255, 255, 0.1) !important;
    }
    #leave_table tbody td:nth-child(4)::before {
        content: "📋 ประเภท: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        font-size: 10px;
    }
    /* Reason */
    #leave_table tbody td:nth-child(5) {
        padding-top: 0.5rem;
    }
    #leave_table tbody td:nth-child(5)::before {
        content: "📝 รายละเอียด: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        font-size: 10px;
    }
    #leave_table tbody td:nth-child(5) p {
        max-width: none !important;
        white-space: normal !important;
    }
}

/* Print Styles */
@media print {
    .no-print, #sidebar, nav, #filterBtn, #resetBtn, select, input[type="date"], .dataTables_paginate, .dataTables_info, .dataTables_length { display: none !important; }
    body { background: white !important; }
    .glass-morphism { box-shadow: none !important; border: none !important; background: transparent !important; }
    #print_header { display: block !important; }
    #leave_table thead { display: table-header-group !important; }
    #leave_table tbody tr { display: table-row !important; background: white !important; }
    #leave_table tbody td { display: table-cell !important; border: 1px solid #d1d5db !important; padding: 8px !important; }
    #leave_table tbody td::before { content: none !important; }
    table { width: 100% !important; border: 1px solid black !important; border-collapse: collapse !important; }
    th, td { border: 1px solid black !important; padding: 10px !important; color: black !important; font-size: 10pt !important; }
    th { background: #f0f0f0 !important; font-weight: bold !important; }
    @page { size: A4 portrait; margin: 1cm; }
}
</style>
