<!-- Officer Awards View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="no-print relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    🏆
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">รายงานรางวัลบุคลากร</h2>
                    <p class="text-indigo-100/80 mt-1 font-medium italic text-xs md:text-base">
                        <span id="selected_teacher_display">ทังหมด</span> | <span id="selected_term_display">ทั้งหมด</span> ปีการศึกษา <span id="selected_year_display">ทั้งหมด</span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button onclick="printPage()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-indigo-700 text-sm md:text-base font-bold hover:bg-indigo-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Formal Header for Print (Hidden in screen) -->
    <div id="print_header" class="hidden print:block text-center space-y-4 mb-8">
        <div class="flex justify-center mb-2">
            <img src="../dist/img/logo-phicha.png" alt="Logo" class="w-24 h-24">
        </div>
        <h2 class="text-2xl font-bold text-slate-900 border-b-2 border-slate-900 pb-2 inline-block">รายงานข้อมูลรางวัลบุคลากร</h2>
        <div class="text-lg text-slate-700 font-semibold space-y-1">
            <p>ชื่อ-นามสกุล: <span id="selected_teacher_print">-</span></p>
            <p>ข้อมูลประจำภาคเรียนที่ <span id="selected_term_print">-</span> ปีการศึกษา <span id="selected_year_print">-</span></p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass-morphism rounded-3xl p-6 no-print">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                    <i class="fas fa-users text-indigo-500 mr-2"></i>เลือกกลุ่มสาระ
                </label>
                <select id="select_department" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($majors as $major): ?>
                        <option value="<?= $major['Teach_major'] ?>"><?= $major['Teach_major'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                    <i class="fas fa-user-tie text-indigo-500 mr-2"></i>เลือกครู
                </label>
                <select id="select_teacher" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    <option value="">เลือกครู</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                    <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>เลือกภาคเรียน
                </label>
                <select id="select_term" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    <option value="">ทั้งหมด</option>
                    <option value="1">ภาคเรียนที่ 1</option>
                    <option value="2">ภาคเรียนที่ 2</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                    <i class="fas fa-calendar-check text-indigo-500 mr-2"></i>เลือกปีการศึกษา
                </label>
                <select id="select_year" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($years as $y): ?>
                        <option value="<?= $y['year'] ?>" <?= $y['year'] == $pee ? 'selected' : '' ?>><?= $y['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="sm:col-span-2 lg:col-span-4 flex justify-end gap-3 pt-2">
                <button id="reset" class="px-8 py-3 rounded-2xl bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-200 transition-all">
                    <i class="fas fa-redo mr-2"></i>ล้างค่า
                </button>
                <button id="filter" class="px-8 py-3 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-all shadow-lg">
                    <i class="fas fa-search mr-2"></i>ค้นหา
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="glass-morphism rounded-3xl p-6 overflow-hidden border border-white/20 shadow-xl">
        <div class="table-responsive">
            <table class="w-full text-left" id="record_table">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">#</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">รางวัลที่ได้รับ</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">ระดับ</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">วันที่ได้รับ</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">ปีการศึกษา</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">เอกสาร/รูปภาพ</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">จัดการ</th>
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
    let current_year = '<?= $pee ?>';

    // Set initial display
    $('#selected_year_display').text(current_year);

    // Initialize Table
    const recordTable = $('#record_table').DataTable({
        "pageLength": 25,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "language": {
            "emptyTable": "ไม่พบข้อมูลรางวัล",
            "search": "ค้นหา:",
            "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
        },
        "columnDefs": [
            { "className": "text-center", "targets": [0, 2, 3, 4, 5, 6] },
            { "orderable": false, "targets": [5, 6] }
        ]
    });

    // Load initial data
    fetchAwardData();

    // Event Handlers
    $('#select_department').change(function() {
        const selectedDepartment = $(this).val();
        if (selectedDepartment) {
            $.ajax({
                url: 'api/fetch_teachers.php',
                method: 'GET',
                data: { department: selectedDepartment },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
                        res.data.forEach(t => {
                            $('#select_teacher').append(`<option value="${t.Teach_id}">${t.Teach_name}</option>`);
                        });
                    }
                }
            });
        } else {
            $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
        }
    });

    $('#filter').on('click', fetchAwardData);

    $('#reset').on('click', function() {
        $('#select_department').val('');
        $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
        $('#select_term').val('');
        $('#select_year').val(current_year);
        updateHeaderDisplay();
        fetchAwardData();
    });

    $('#select_term, #select_year, #select_teacher').on('change', function() {
        updateHeaderDisplay();
    });

    function updateHeaderDisplay() {
        const teacherName = $('#select_teacher option:selected').val() ? $('#select_teacher option:selected').text() : 'ทั้งหมด';
        const termText = $('#select_term').val() ? 'เทอม ' + $('#select_term').val() : 'ทั้งหมด';
        const yearText = $('#select_year').val() || 'ทั้งหมด';

        $('#selected_teacher_display, #selected_teacher_print').text(teacherName);
        $('#selected_term_display, #selected_term_print').text(termText);
        $('#selected_year_display, #selected_year_print').text(yearText);
    }

    function fetchAwardData() {
        const tid = $('#select_teacher').val() || '';
        const term = $('#select_term').val() || '';
        const year = $('#select_year').val() || '';

        $.ajax({
            url: 'api/fetch_award.php',
            method: 'GET',
            dataType: 'json',
            data: { tid, term, year },
            success: function(res) {
                if (res.success) {
                    populateTable(res.data);
                }
            }
        });
    }

    function populateTable(data) {
        recordTable.clear();
        data.forEach((item, index) => {
            recordTable.row.add([
                index + 1,
                `<div class="font-bold text-gray-900 dark:text-white">${item.award}</div><div class="text-xs text-gray-500 mt-1"><i class="fas fa-university mr-1"></i> ${item.department}</div>`,
                `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold leading-none ${getAwardLevelClass(item.level)}">${getAwardLevelText(item.level)}</span>`,
                `<span class="text-sm font-medium text-slate-700 dark:text-slate-300">${convertToThaiDate(item.date1)}</span>`,
                `<span class="text-xs font-bold text-slate-600 dark:text-slate-400">${item.term}/${item.year}</span>`,
                item.certificate ? 
                `<a href="../teacher/uploads/file_award/${item.certificate}" target="_blank" class="block w-20 mx-auto rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
                    <img src="../teacher/uploads/file_award/${item.certificate}" class="w-full h-12 object-cover border border-gray-100 dark:border-gray-700" onerror="this.parentElement.style.display='none'">
                </a>` : 
                `<div class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest bg-gray-50 dark:bg-slate-800/50 py-2 rounded-lg no-print">no img</div>`,
                `<div class="no-print flex gap-2 justify-center">
                    <button class="w-8 h-8 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition-all flex items-center justify-center edit-award" data-id="${item.awid}"><i class="fas fa-edit text-xs"></i></button>
                </div>`
            ]);
        });
        recordTable.draw();
    }

    function getAwardLevelText(level) {
        switch (level) {
            case '1': return 'เขต/จังหวัด';
            case '2': return 'ภาค';
            case '3': return 'ชาติ';
            case '4': return 'นานาชาติ';
            default: return 'ไม่ระบุ';
        }
    }

    function getAwardLevelClass(level) {
        switch (level) {
            case '1': return 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400';
            case '2': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400';
            case '3': return 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400';
            case '4': return 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400';
            default: return 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-400';
        }
    }

    function convertToThaiDate(dateString) {
        if (!dateString) return '-';
        const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        const date = new Date(dateString);
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
    }

    window.printPage = function() {
        window.print();
    };
});
</script>

<style>
/* Same responsive and print styles as training.php but with indigo colors */
@media screen and (max-width: 768px) {
    #record_table thead { display: none; }
    #record_table tbody tr {
        display: flex; flex-direction: column; background: var(--card-bg, #ffffff); border-radius: 1.5rem;
        margin-bottom: 1rem; padding: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid rgba(0, 0, 0, 0.05); position: relative;
    }
    .dark #record_table tbody tr { --card-bg: #1e293b; border-color: rgba(255, 255, 255, 0.1); }
    #record_table tbody td { display: flex; align-items: flex-start; padding: 0.5rem 0; border: none !important; text-align: left !important; }
    #record_table tbody td:first-child {
        position: absolute; top: 0.75rem; right: 0.75rem; background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;
    }
    #record_table tbody td:nth-child(2) { padding-right: 3rem; flex-direction: column; }
    #record_table tbody td:nth-child(3)::before { content: "📊 ระดับ: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; }
    #record_table tbody td:nth-child(4)::before { content: "📅 วันที่: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; }
    #record_table tbody td:nth-child(5)::before { content: "📚 ปีการศึกษา: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; }
    #record_table tbody td:nth-child(6)::before { content: "📄 เอกสาร: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; }
    #record_table tbody td:last-child { border-top: 1px dashed rgba(0, 0, 0, 0.1) !important; padding-top: 1rem; margin-top: 0.5rem; justify-content: center; }
    .dark #record_table tbody td:last-child { border-top-color: rgba(255, 255, 255, 0.1) !important; }
}

@media print {
    * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    body { background: white !important; }
    button, nav, aside, .sidebar, #selected_department, #select_department, #select_teacher, #select_term, #select_year, #filter, #reset { display: none !important; }
    .glass-morphism { background: white !important; box-shadow: none !important; border: 1px solid #ddd !important; border-radius: 0.5rem !important; }
    .bg-gradient-to-br { background: transparent !important; color: black !important; }
    #record_table { width: 100% !important; border-collapse: collapse !important; color: black !important; }
    #record_table thead { display: table-header-group !important; }
    #record_table thead th { background: #f3f4f6 !important; border: 1px solid #d1d5db !important; padding: 8px !important; }
    #record_table tbody tr { display: table-row !important; background: white !important; }
    #record_table tbody td { display: table-cell !important; border: 1px solid #d1d5db !important; padding: 8px !important; }
    #record_table thead th:last-child, #record_table tbody td:last-child { display: none !important; }
    #record_table tbody td::before { content: none !important; }
    @page { size: A4 portrait; margin: 1cm; }
}
</style>
