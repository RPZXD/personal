<?php
/**
 * View: Training Summary Report for Admin
 * Path: views/admin/training_summary.php
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
                        <option value="">ทั้งหมด</option>
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
                        <?php foreach ($years as $index => $year): ?>
                        <option value="<?= $year['year'] ?>" <?= $index === 0 ? 'selected' : '' ?>><?= $year['year'] ?></option>
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

    <!-- Stats Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 no-print">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 flex items-center space-x-4">
            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">จำนวนบุคลากรที่มีชั่วโมงอบรม</p>
                <h3 id="stat-active-teachers" class="text-2xl font-black text-slate-900 dark:text-white">0</h3>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 flex items-center space-x-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-clock"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Top 5 ที่มีชั่วโมงอบรมสูงสุด</p>
                <div id="stat-top5-list" class="space-y-1">
                    <div class="text-[10px] text-slate-400">ไม่มีข้อมูล</div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 flex items-center space-x-4">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">เฉลี่ยต่อคน</p>
                <h3 id="stat-avg-hours" class="text-2xl font-black text-slate-900 dark:text-white">0 <span class="text-sm font-medium">ชม.</span></h3>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 flex items-center space-x-4">
            <div class="w-12 h-12 bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">อบรมสูงสุด/คน</p>
                <h3 id="stat-max-hours" class="text-2xl font-black text-slate-900 dark:text-white">0 <span class="text-sm font-medium">ชม.</span></h3>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 no-print">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-emerald-500"></i>
                สรุปชั่วโมงอบรมแยกตามกลุ่มสาระ
            </h3>
            <div class="h-[300px]">
                <canvas id="deptChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-500"></i>
                สัดส่วนจำนวนบุคลากรที่เข้าอบรม
            </h3>
            <div class="h-[300px]">
                <canvas id="participationChart"></canvas>
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

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    let deptChart = null;
    let participationChart = null;

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
                    
                    // Handle display text for term
                    let selectedTermText = $('#select_term option:selected').text();
                    let selectedTermVal = $('#select_term').val();
                    let headerTermDisplay = (selectedTermVal === "") ? "ตลอดปีการศึกษา" : selectedTermText;
                    
                    $('#txt-selected-term').text(headerTermDisplay);
                    $('#txt-selected-year').text($('#select_year option:selected').val());
                    $('#summary-header').removeClass('hidden');
                    
                    // Update Charts and Stats
                    updateChartsAndStats(data.data);
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
        recordTableCheck();
    }

    function recordTableCheck() {
        if (!table.data().any()) {
            $('.no-print.grid').addClass('hidden');
        } else {
            $('.no-print.grid').removeClass('hidden');
        }
    }

    function updateChartsAndStats(data) {
        if (!data || data.length === 0) {
            $('#stat-active-teachers').text('0');
            $('#stat-top5-list').html('<div class="text-[10px] text-slate-400">ไม่มีข้อมูล</div>');
            return;
        }

        let totalTeachers = data.length;
        let activeTeachers = data.filter(i => (parseInt(i.total_hours) * 60 + parseInt(i.total_minutes)) > 0).length;
        let totalMinutes_sum = 0;
        let maxMinutes = 0;
        let deptData = {};

        // Sort for Top 5
        let sortedData = [...data].sort((a, b) => {
            let minsA = (parseInt(a.total_hours) * 60) + parseInt(a.total_minutes);
            let minsB = (parseInt(b.total_hours) * 60) + parseInt(b.total_minutes);
            return minsB - minsA;
        });

        data.forEach(item => {
            let itemMinutes = (parseInt(item.total_hours) * 60) + parseInt(item.total_minutes);
            totalMinutes_sum += itemMinutes;
            if (itemMinutes > maxMinutes) maxMinutes = itemMinutes;

            let dept = item.teacher_department || 'ไม่ระบุ';
            if (!deptData[dept]) deptData[dept] = 0;
            deptData[dept] += itemMinutes;
        });

        let totalHoursFloat = totalMinutes_sum / 60;
        let avgHours = totalHoursFloat / totalTeachers;

        $('#stat-active-teachers').text(activeTeachers);
        
        // Update Top 5 List
        let top5Html = '';
        sortedData.slice(0, 5).forEach((item, idx) => {
            let mins = (parseInt(item.total_hours) * 60) + parseInt(item.total_minutes);
            if (mins > 0) {
                top5Html += `<div class="flex items-center justify-between text-[11px] leading-tight group">
                    <span class="truncate text-slate-600 dark:text-slate-400 font-medium">${idx+1}. ${item.teacher_name}</span>
                    <span class="font-bold text-emerald-600 ml-2 whitespace-nowrap">${item.total_hours} ชม.</span>
                </div>`;
            }
        });
        $('#stat-top5-list').html(top5Html || '<div class="text-[10px] text-slate-400">ไม่มีข้อมูล</div>');

        $('#stat-avg-hours').html(`${avgHours.toFixed(1)} <span class="text-sm font-medium">ชม.</span>`);
        $('#stat-max-hours').html(`${Math.floor(maxMinutes / 60)} <span class="text-sm font-medium">ชม.</span>`);

        // Update Dept Chart
        const labels = Object.keys(deptData);
        const values = labels.map(l => (deptData[l] / 60).toFixed(1));

        if (deptChart) deptChart.destroy();
        const ctx = document.getElementById('deptChart').getContext('2d');
        deptChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'ชั่วโมงอบรมรวม',
                    data: values,
                    backgroundColor: 'rgba(16, 185, 129, 0.6)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'ชั่วโมง' } }
                }
            }
        });

        // Update Participation Chart
        let zeroHours = data.filter(i => parseInt(i.total_hours) === 0 && parseInt(i.total_minutes) === 0).length;
        let hasHours = totalTeachers - zeroHours;

        if (participationChart) participationChart.destroy();
        const ctx2 = document.getElementById('participationChart').getContext('2d');
        participationChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['ผ่านการอบรม', 'ยังไม่มีการอบรม'],
                datasets: [{
                    data: [hasHours, zeroHours],
                    backgroundColor: ['#10b981', '#f43f5e'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%'
            }
        });
    }

    // Initial fetch
    fetchTrainingSummary();
});
</script>
