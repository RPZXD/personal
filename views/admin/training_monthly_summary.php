<?php
/**
 * View: Monthly Training Summary Report for Admin
 * Path: views/admin/training_monthly_summary.php
 */
?>

<div class="space-y-6">
    <!-- Header Section -->
    <div class="no-print bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-teal-500/20">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">รายงานสรุปการอบรมรายเดือน</h1>
                    <p class="text-slate-500 dark:text-slate-400">สรุปรายละเอียดการอบรม/สัมมนาของบุคลากรรายเดือน</p>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label for="select_month" class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1">เลือกเดือน</label>
                <div class="relative">
                    <input type="month" id="select_month" value="<?= date('Y-m') ?>" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition-all">
                </div>
            </div>
            <div class="flex items-end">
                <button id="filter" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2.5 rounded-xl transition-all shadow-lg shadow-teal-500/20 active:scale-95">
                    <i class="fas fa-search mr-2"></i>ดึงข้อมูล
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 no-print" id="stats-container">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 flex items-center space-x-4">
            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-file-signature"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">จำนวนรายการทั้งหมด</p>
                <h3 id="stat-total-records" class="text-2xl font-black text-slate-900 dark:text-white">0</h3>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 flex items-center space-x-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-users text-teal-600 dark:text-teal-400"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">จำนวนบุคลากรที่อบรม</p>
                <h3 id="stat-total-teachers" class="text-2xl font-black text-slate-900 dark:text-white">0</h3>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 flex items-center space-x-4">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">งบประมาณรวม</p>
                <h3 id="stat-total-budget" class="text-2xl font-black text-slate-900 dark:text-white">0 <span class="text-sm font-medium">บาท</span></h3>
            </div>
        </div>
    </div>

    <!-- Summary Header for Print -->
    <div id="print-header" class="hidden print:block text-center space-y-4 mb-4">
        <div class="flex justify-center mb-0">
             <!-- Optional Logo -->
        </div>
        <h2 class="text-xl font-bold text-black pb-1 inline-block">สรุปการ อบรม/สัมมนา ในรอบเดือน <span id="txt-selected-month-thai"></span></h2>
        <p class="text-lg text-black font-semibold mt-0">
            จำนวน <span id="txt-record-count">0</span> ราย
        </p>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left border-collapse" id="monthly_record_table">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-3 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-center border-b border-slate-200 dark:border-slate-700 w-12">ที่</th>
                        <th class="px-4 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700 w-48">ชื่อ-สกุล</th>
                        <th class="px-4 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700 w-40">กลุ่มสาระฯ</th>
                        <th class="px-4 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">เรื่อง</th>
                        <th class="px-4 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-center border-b border-slate-200 dark:border-slate-700 w-32">ว/ด/ป</th>
                        <th class="px-4 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700 w-32">สถานที่</th>
                        <th class="px-4 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-right border-b border-slate-200 dark:border-slate-700 w-28">งบประมาณ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Data will be populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<style type="text/css" media="print">
    @page { size: A4 landscape; margin: 10mm; }
    body { background: white !important; font-size: 14px !important; }
    .no-print { display: none !important; }
    #print-header { display: block !important; margin-bottom: 10px !important; color: black !important; }
    #monthly_record_table { border: 1px solid black !important; border-collapse: collapse !important; width: 100% !important; color: black !important; }
    #monthly_record_table th, #monthly_record_table td { border: 1px solid black !important; padding: 6px !important; color: black !important; vertical-align: top !important; }
    #monthly_record_table th { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; }
</style>

<script>
$(document).ready(function() {
    var table = $('#monthly_record_table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "search": "ค้นหา...",
            "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
            "info": "แสดงทั้งหมด _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูล",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)"
        },
        "columnDefs": [
            { "className": "text-center", "targets": [0, 4] },
            { "className": "text-right", "targets": [6] },
            { "orderable": false, "targets": [0] }
        ]
    });

    window.printPage = function () {
         $('thead').css('display', 'table-header-group');
        window.print();
    };

    $('#filter').click(function() {
        fetchMonthlySummary();
    });

    $('#select_month').change(function() {
        fetchMonthlySummary();
    });

    function fetchMonthlySummary() {
        const monthFilter = $('#select_month').val();
        if(!monthFilter) return;

        Swal.fire({
            title: 'กำลังดึงข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: 'api/fetch_training_monthly.php',
            method: 'GET',
            dataType: 'json',
            data: { month: monthFilter },
            success: function(data) {
                Swal.close();
                if (data.success) {
                    populateTable(data.data);
                    updateStatsAndHeader(data.data, monthFilter);
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function() {
                Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
            }
        });
    }

    function thaiDate(dateStr) {
        if(!dateStr) return "-";
        const d = new Date(dateStr);
        const day = d.getDate();
        const month = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."][d.getMonth()];
        const year = d.getFullYear() + 543;
        return `${day} ${month} ${year}`;
    }

    function thaiMonthYear(monthStr) {
        const [year, month] = monthStr.split('-');
        const monthName = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"][parseInt(month)-1];
        return `${monthName} ${parseInt(year)+543}`;
    }

    function populateTable(data) {
        table.clear();
        if (data && data.length > 0) {
            data.forEach((record, index) => {
                const dateRange = `
                    <div class="whitespace-nowrap">${thaiDate(record.dstart)} -</div>
                    <div class="whitespace-nowrap">${thaiDate(record.dend)}</div>
                `;
                
                const budget = record.budget && record.budget != 0 
                    ? parseFloat(record.budget).toLocaleString() 
                    : "-";

                table.row.add([
                    index + 1,
                    `<div class="font-medium text-slate-900 dark:text-slate-100">${record.teacher_name}</div>`,
                    `<span class="text-xs text-slate-600 dark:text-slate-400 font-medium">${record.teacher_department}</span>`,
                    `<div class="text-[11px] leading-relaxed max-w-sm whitespace-normal text-slate-700 dark:text-slate-300">${record.topic}</div>`,
                    `<div class="text-[11px]">${dateRange}</div>`,
                    `<div class="text-[11px]">${record.place || "-"}</div>`,
                    `<div class="font-bold text-slate-700 dark:text-slate-200">${budget}</div>`
                ]);
            });
        }
        table.draw();
    }

    function updateStatsAndHeader(data, monthFilter) {
        const totalRecords = data.length;
        const totalTeachers = new Set(data.map(r => r.tid)).size;
        const totalBudget = data.reduce((sum, r) => sum + (parseFloat(r.budget) || 0), 0);
        
        $('#stat-total-records').text(totalRecords);
        $('#stat-total-teachers').text(totalTeachers);
        $('#stat-total-budget').html(`${totalBudget.toLocaleString()} <span class="text-sm font-medium">บาท</span>`);
        
        const monthThai = thaiMonthYear(monthFilter);
        $('#txt-selected-month-thai').text(monthThai);
        $('#txt-record-count').text(totalRecords);
        
        if (totalRecords > 0) {
            $('#stats-container').removeClass('hidden');
        } else {
            // Keep stats visible but zeroed
        }
    }

    // Initial load
    fetchMonthlySummary();
});
</script>
