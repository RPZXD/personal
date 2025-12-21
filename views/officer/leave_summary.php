<?php
/**
 * View: Leave Summary Report for Officer
 * Path: views/officer/leave_summary.php
 */
?>

<div class="space-y-6">
    <!-- Header Section -->
    <div class="no-print bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg shadow-rose-500/20">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">สรุปการมาปฏิบัติงาน</h1>
                    <p class="text-slate-500 dark:text-slate-400">รายงานสรุปการลาของบุคลากรรายวัน</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.printPage()" class="flex items-center px-4 py-2 bg-slate-800 dark:bg-slate-700 text-white rounded-xl hover:bg-slate-700 dark:hover:bg-slate-600 transition-all shadow-md group">
                    <i class="fas fa-print mr-2 group-hover:scale-110 transition-transform"></i>
                    พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 no-print">
        <div class="flex flex-wrap items-end gap-6 justify-center">
            <div class="w-full md:w-64 space-y-2">
                <label for="select_date" class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1">เลือกวันที่</label>
                <div class="relative">
                    <input type="date" id="select_date" value="<?= date('Y-m-d') ?>" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:ring-2 focus:ring-rose-500 transition-all">
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button id="filter" class="px-8 bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-xl transition-all shadow-lg shadow-rose-500/20 active:scale-95">
                    <i class="fas fa-search mr-2"></i>ค้นหา
                </button>
                <button id="reset" class="px-8 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold py-2.5 rounded-xl transition-all active:scale-95">
                    <i class="fas fa-undo mr-2"></i>ล้างค่า
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Info Tooltip (Hidden in screen, shown in print) -->
    <div id="summary-header" class="hidden print:block text-center space-y-4 mb-8">
        <div class="flex justify-center mb-2">
            <img src="../dist/img/logo-phicha.png" alt="Logo" class="w-20 h-20">
        </div>
        <h2 class="text-2xl font-bold text-black border-black border-b-2 pb-2 inline-block">สรุปการมาปฏิบัติงานของข้าราชการครูและบุคลากรทางการศึกษา</h2>
        <p class="text-lg text-black font-semibold">ประจำวันที่ <span id="txt-selected-date"></span></p>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="record_table">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th rowspan="2" class="px-4 py-3 text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-center border-b border-r border-slate-200 dark:border-slate-700">ลำดับ</th>
                        <th rowspan="2" class="px-4 py-3 text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b border-r border-slate-200 dark:border-slate-700">ชื่อ - สกุล</th>
                        <th colspan="6" class="px-4 py-2 text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-center border-b border-r border-slate-200 dark:border-slate-700 bg-slate-100/50 dark:bg-slate-800">ตำแหน่ง</th>
                        <th colspan="7" class="px-4 py-2 text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-center border-b border-slate-200 dark:border-slate-700 bg-slate-100/50 dark:bg-slate-800">สาเหตุ</th>
                    </tr>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <!-- Positions -->
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ผู้บริหาร</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ครู</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">พนักงานราชการ</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ลูกจ้างประจำ</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ชั่วคราว (สพฐ.)</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ชั่วคราว (บกศ.)</th>
                        <!-- Regular statuses -->
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ไปราชการ</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ลากิจ</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ลาป่วย</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ลาคลอด</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">ลาบวช</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-r border-slate-200 dark:border-slate-700">มาสาย</th>
                        <th class="px-2 py-3 text-[10px] font-bold vertical-text text-center border-b border-slate-200 dark:border-slate-700">ไม่ทราบสาเหตุ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Data populated via AJAX -->
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
    @page { size: A4 portrait; margin: 15mm; }
    body { background: white !important; -webkit-print-color-adjust: exact; }
    nav, aside, header, footer, button, .no-print, #sidebar, #navbar, #summary-sidebar { display: none !important; }
    .content-wrapper { margin-left: 0 !important; padding: 0 !important; }
    #summary-header { display: block !important; }
    #record_table { border: 1.5px solid black !important; width: 100% !important; border-collapse: collapse !important; color: black !important; }
    #record_table th, #record_table td { border: 1px solid black !important; padding: 4px !important; text-align: center !important; font-size: 11px !important; color: black !important; }
    #record_table td:nth-child(2) { text-align: left !important; }
    .vertical-text { font-size: 9px !important; line-height: 1 !important; }
}
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#record_table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "search": "ค้นหา:",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดงทั้งหมด _TOTAL_ รายการ"
        },
        "columnDefs": [
            { "className": "text-center", "targets": "_all" },
            { "orderable": false, "targets": [0] },
            { "targets": [1], "className": "text-left font-medium" }
        ],
        "dom": 'rtp' // Exclude search box from being rendered twice if you don't want it.
    });

    window.printPage = function() {
        $('thead').css('display', 'table-header-group');
        window.print();
    };

    $('#filter').click(function() {
        fetchLeaveSummary();
    });

    $('#reset').click(function() {
        $('#select_date').val('<?= date('Y-m-d') ?>');
        fetchLeaveSummary();
    });

    $('#select_date').change(function() {
        fetchLeaveSummary();
    });

    function convertToThaiDate(dateString) {
        const months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        const date = new Date(dateString);
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
    }

    function fetchLeaveSummary() {
        const date = $('#select_date').val();

        Swal.fire({
            title: 'กำลังดึงข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: 'api/fetch_leave_summary.php',
            method: 'GET',
            dataType: 'json',
            data: { date: date },
            success: function(data) {
                Swal.close();
                if (data.success) {
                    populateTable(data.data);
                    $('#txt-selected-date').text(convertToThaiDate(date));
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function() {
                Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
            }
        });
    }

    function populateTable(data) {
        table.clear();
        if (data && data.length > 0) {
            data.forEach((leave, index) => {
                const teach = leave.teacher_details[0];
                table.row.add([
                    index + 1,
                    teach.Teach_name,
                    teach.Teach_Position2 === 'ผู้บริหาร' ? '✔' : '',
                    teach.Teach_Position2 === 'ครู' ? '✔' : '',
                    teach.Teach_Position2 === 'พนักงานราชการ' ? '✔' : '',
                    teach.Teach_Position2 === 'ลูกจ้างประจำ' ? '✔' : '',
                    teach.Teach_Position2 === 'ลูกจ้างชั่วคราว (สพฐ.)' ? '✔' : '',
                    teach.Teach_Position2 === 'ลูกจ้างชั่วคราว (บกศ.)' ? '✔' : '',
                    leave.status == 3 ? '✔' : '',
                    leave.status == 2 ? '✔' : '',
                    leave.status == 1 ? '✔' : '',
                    leave.status == 4 ? '✔' : '',
                    leave.other_leave_type === 'ลาอุปสมบท' ? '✔' : '',
                    leave.status == 6 ? '✔' : '',
                    leave.status == 7 ? '✔' : ''
                ]);
            });
        }
        table.draw();
    }

    // Initial load
    fetchLeaveSummary();
});
</script>
