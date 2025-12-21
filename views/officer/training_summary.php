<?php
/**
 * View: Training Summary Report for Officer
 * Path: views/officer/training_summary.php
 */
?>

<div class="space-y-6">
    <!-- Header Section -->
    <div class="no-print bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-list-check text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">รายงานสรุปการอบรมครู</h1>
                    <p class="text-slate-500 dark:text-slate-400">สรุปจำนวนชั่วโมงการอบรมของบุคลากรรายภาคเรียน</p>
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
                <label for="select_term" class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1">ภาคเรียนที่</label>
                <div class="relative">
                    <select id="select_term" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 transition-all appearance-none">
                        <option value="">เลือกภาคเรียน</option>
                        <option value="1">ภาคเรียนที่ 1</option>
                        <option value="2">ภาคเรียนที่ 2</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label for="select_year" class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1">ปีการศึกษา</label>
                <div class="relative">
                    <select id="select_year" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 transition-all appearance-none">
                        <option value="">ทั้งหมด</option>
                        <?php foreach ($years as $year): ?>
                        <option value="<?= $year['year'] ?>"><?= $year['year'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                </div>
            </div>
            <div class="flex items-end space-x-3">
                <button id="filter" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                    <i class="fas fa-search mr-2"></i>ค้นหา
                </button>
                <button id="reset" class="flex-1 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold py-2.5 rounded-xl transition-all active:scale-95">
                    <i class="fas fa-undo mr-2"></i>ล้างค่า
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Info Tooltip (Hidden in screen, shown in print) -->
    <div id="summary-header" class="hidden print:block text-center space-y-4 mb-8">
        <div class="flex justify-center mb-2">
            <img src="../dist/img/logo-phicha.png" alt="Logo" class="w-24 h-24">
        </div>
        <h2 class="text-2xl font-bold text-slate-900 border-b-2 border-slate-900 pb-2 inline-block">รายงานสรุปการอบรมบุคลากร ประจำภาคเรียน</h2>
        <p class="text-lg text-slate-700 font-semibold mt-2">
            <span id="txt-selected-term"></span> ปีการศึกษา <span id="txt-selected-year"></span>
        </p>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="record_table">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-center border-b border-slate-200 dark:border-slate-700">ลำดับ</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">ชื่อ - สกุล</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">กลุ่มสาระ</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-center border-b border-slate-200 dark:border-slate-700">ชั่วโมงการอบรม</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Data will be populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style type="text/css" media="print">
    @page { size: A4 portrait; margin: 20mm; }
    body { background: white !important; -webkit-print-color-adjust: exact; }
    nav, aside, header, footer, button, .no-print, #sidebar, #navbar, #summary-sidebar { display: none !important; }
    .content-wrapper { margin-left: 0 !important; padding: 0 !important; }
    #record_table { border: 1px solid #e2e8f0 !important; width: 100% !important; border-collapse: collapse !important; }
    #record_table th, #record_table td { border: 1px solid #e2e8f0 !important; padding: 8px !important; color: black !important; }
    #summary-header { display: block !important; margin-bottom: 20px !important; }
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
            "search": "ค้นหาในตาราง:",
            "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
            "info": "แสดงทั้งหมด _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูล",
            "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)"
        },
        "columnDefs": [
            { "className": "text-center", "targets": [0, 3] },
            { "orderable": false, "targets": [0] }
        ]
    });

    // Function to handle printing
    window.printPage = function () {
        $('thead').css('display', 'table-header-group');
        window.print();
    };

    $('#filter').click(function() {
        fetchTrainingSummary();
    });

    $('#select_term, #select_year').change(function() {
        let term = $('#select_term').val();
        let year = $('#select_year').val();
        if (term && year) {
            fetchTrainingSummary();
        }
    });

    $('#reset').click(function() {
        $('#select_term').val('');
        $('#select_year').val('');
        fetchTrainingSummary();
    });

    function fetchTrainingSummary() {
        const term = $('#select_term').val();
        const year = $('#select_year').val();

        // Show loading state
        Swal.fire({
            title: 'กำลังดึงข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: 'api/fetch_training_summary.php',
            method: 'GET',
            dataType: 'json',
            data: { term: term, year: year },
            success: function(data) {
                Swal.close();
                if (data.success) {
                    populateTrainingTable(data.data);
                    $('#txt-selected-term').text($('#select_term option:selected').text());
                    $('#txt-selected-year').text($('#select_year option:selected').val());
                    $('#summary-header').removeClass('hidden');
                } else {
                    Swal.fire('ข้อผิดพลาด', data.message, 'error');
                }
            },
            error: function() {
                Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการดึงข้อมูล', 'error');
            }
        });
    }

    function populateTrainingTable(data) {
        table.clear();

        if (data && data.length > 0) {
            data.forEach((record, index) => {
                table.row.add([
                    index + 1,
                    `<div class="font-medium text-slate-900 dark:text-slate-100">${record.teacher_name}</div>`,
                    `<span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-medium">${record.teacher_department}</span>`,
                    `<div class="font-bold text-emerald-600">${record.total_hours} <span class="text-xs font-normal text-slate-500 ml-0.5">ชม.</span> ${record.total_minutes} <span class="text-xs font-normal text-slate-500 ml-0.5">น.</span></div>`
                ]);
            });
        }
        table.draw();
    }

    // Initial fetch
    fetchTrainingSummary();
});
</script>
