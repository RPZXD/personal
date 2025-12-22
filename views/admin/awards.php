<!-- Admin Awards View -->
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
                        <span id="selected_teacher_display">ทั้งหมด</span> | <span id="selected_term_display">ทั้งหมด</span> ปีการศึกษา <span id="selected_year_display">ทั้งหมด</span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button id="addAward" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-indigo-500/30 backdrop-blur text-white text-sm md:text-base font-bold hover:bg-indigo-500/50 transition-all border border-white/30 flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> เพิ่มข้อมูล
                </button>
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
                    <?php foreach ($years as $index => $y): ?>
                        <option value="<?= $y['year'] ?>" <?= $index === 0 ? 'selected' : '' ?>><?= $y['year'] ?></option>
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

<!-- Modal: Add/Edit Award -->
<div id="awardModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm animate-fade-in">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-morphism rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
            <div class="p-6 bg-gradient-to-r from-indigo-600 to-violet-600 flex justify-between items-center text-white">
                <h3 id="modalTitle" class="text-xl font-black tracking-tight flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    เพิ่มข้อมูลรางวัล
                </h3>
                <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="awardForm" enctype="multipart/form-data" class="p-8 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
                <input type="hidden" id="award_id" name="awardid">
                <input type="hidden" id="award_tid" name="tid">

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ชื่อรางวัล / ผลงาน</label>
                        <input type="text" name="award" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ระดับรางวัล</label>
                            <select name="level" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="">เลือกระดับรางวัล</option>
                                <option value="1">เขต/จังหวัด</option>
                                <option value="2">ระดับภาค</option>
                                <option value="3">ระดับชาติ</option>
                                <option value="4">ระดับนานาชาติ</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่ได้รับ</label>
                            <input type="date" name="date1" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เทอม</label>
                            <select name="term" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="1">เทอม 1</option>
                                <option value="2">เทอม 2</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ปีการศึกษา</label>
                            <input type="text" name="year" value="<?= $pee ?>" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">หน่วยงานที่มอบรางวัล</label>
                        <input type="text" name="department" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">หลักฐาน / เกียรติบัตร (ไฟล์รูปภาพ)</label>
                        <div class="relative group">
                            <input type="file" name="certificate" accept="image/*" class="hidden" id="file_input">
                            <label for="file_input" class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-3xl p-6 hover:border-indigo-500 transition-all cursor-pointer group-hover:bg-indigo-50/50 dark:group-hover:bg-indigo-500/5">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-indigo-500 mb-2"></i>
                                <span class="text-sm text-gray-500 group-hover:text-indigo-600 font-medium">คลิกเพื่ออัปโหลดเกียรติบัตร</span>
                            </label>
                        </div>
                        <div id="preview_container" class="hidden mt-4 text-center">
                            <img id="file_preview" src="#" class="mx-auto rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 max-h-48 object-cover">
                        </div>
                    </div>
                </div>
            </form>
            <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end gap-3">
                <button onclick="closeModal()" class="px-6 py-2.5 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">ยกเลิก</button>
                <button id="saveBtn" class="px-8 py-2.5 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-all shadow-lg flex items-center gap-2">
                    <i class="fas fa-save"></i> บันทึกข้อมูล
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: View Award -->
<div id="viewModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/60 backdrop-blur-sm animate-fade-in">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-morphism rounded-3xl w-full max-w-4xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
            <div class="p-6 bg-gradient-to-r from-indigo-600 to-violet-600 flex justify-between items-center text-white">
                <h3 class="text-xl font-black tracking-tight flex items-center gap-2 uppercase">
                    <i class="fas fa-info-circle"></i> รายละเอียดรางวัล
                </h3>
                <button onclick="closeViewModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="viewDetails" class="p-8">
                <!-- Loaded by AJAX -->
            </div>
            <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end">
                <button onclick="closeViewModal()" class="px-8 py-2.5 rounded-2xl bg-gray-800 text-white font-bold hover:bg-black transition-all">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Image Preview -->
<div id="imageModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 backdrop-blur-md transition-all duration-300" onclick="if(event.target === this) closeImageModal()">
    <div class="absolute top-6 right-6 z-50">
        <button onclick="closeImageModal()" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all group">
            <i class="fas fa-times text-xl group-hover:rotate-90 transition-transform duration-300"></i>
        </button>
    </div>
    <div class="relative w-full max-w-5xl p-4 animate-zoom-in" onclick="event.stopPropagation()">
        <img id="modal_image_src" src="" class="w-auto max-w-full max-h-[85vh] mx-auto rounded-xl shadow-2xl border border-white/10" onerror="this.src='../dist/img/no-image.png'">
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
                `<div onclick="openImageModal('../uploads/file_award/${item.certificate}')" class="cursor-pointer block w-20 mx-auto rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all group">
                    <img src="../uploads/file_award/${item.certificate}" class="w-full h-12 object-cover border border-gray-100 dark:border-gray-700 group-hover:scale-110 transition-transform">
                </div>` : 
                `<div class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest bg-gray-50 dark:bg-slate-800/50 py-2 rounded-lg no-print">no img</div>`,
                `<div class="no-print flex gap-2 justify-center">
                    <button class="w-8 h-8 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-all flex items-center justify-center btn-view" data-id="${item.awid}"><i class="fas fa-eye text-xs"></i></button>
                    <button class="w-8 h-8 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition-all flex items-center justify-center btn-edit" data-id="${item.awid}"><i class="fas fa-edit text-xs"></i></button>
                    <button class="w-8 h-8 rounded-xl bg-rose-500 text-white hover:bg-rose-600 transition-all flex items-center justify-center btn-del" data-id="${item.awid}"><i class="fas fa-trash text-xs"></i></button>
                </div>`
            ]);
        });
        recordTable.draw();
        attachActionEvents();
    }

    function attachActionEvents() {
        $('.btn-view').on('click', function() {
            showViewModal($(this).data('id'));
        });
        $('.btn-edit').on('click', function() {
            showEditModal($(this).data('id'));
        });
        $('.btn-del').on('click', function() {
            confirmDelete($(this).data('id'));
        });
    }

    function showViewModal(id) {
        $.ajax({
            url: 'api/fetch_award_details.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function(res) {
                if (res.success) {
                    const d = res.details;
                    const html = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div class="p-6 rounded-3xl bg-indigo-50 dark:bg-indigo-500/5 border border-indigo-100 dark:border-indigo-500/20">
                                    <h4 class="text-indigo-700 dark:text-indigo-400 text-xs font-black uppercase mb-4 tracking-widest">ข้อมูลรางวัล</h4>
                                    <div class="space-y-4">
                                        <div><span class="text-xs text-gray-400 uppercase">ชื่อรางวัล</span><p class="text-lg font-black text-gray-900 dark:text-white">${d.award}</p></div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><span class="text-xs text-gray-400 uppercase">ระดับ</span><p class="font-bold text-indigo-600">${getAwardLevelText(d.level)}</p></div>
                                            <div><span class="text-xs text-gray-400 uppercase">วันที่ได้รับ</span><p class="font-bold">${convertToThaiDate(d.date1)}</p></div>
                                        </div>
                                        <div><span class="text-xs text-gray-400 uppercase">หน่วยงานที่มอบ</span><p class="font-bold text-gray-700 dark:text-gray-300">${d.department}</p></div>
                                        <div><span class="text-xs text-gray-400 uppercase">ปีการศึกษา</span><p class="font-bold">เทอม ${d.term} / ${d.year}</p></div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <h4 class="text-gray-900 dark:text-white text-xs font-black uppercase tracking-widest">เกียรติบัตร / หลักฐาน</h4>
                                <div onclick="openImageModal('../uploads/file_award/${d.certificate}')" class="cursor-pointer group relative rounded-3xl overflow-hidden shadow-2xl border border-gray-100 dark:border-gray-700 aspect-[4/3] bg-gray-100 dark:bg-slate-800">
                                    <img src="../uploads/file_award/${d.certificate}" class="w-full h-full object-contain" onerror="this.src='../dist/img/no-image.png'">
                                    <div class="absolute inset-0 bg-indigo-600/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center text-white scale-110 group-hover:scale-100">
                                        <div class="px-6 py-2 rounded-full border-2 border-white font-bold backdrop-blur-sm"><i class="fas fa-search-plus mr-2"></i>ดูรูปขนาดเต็ม</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    `;
                    $('#viewDetails').html(html);
                    $('#viewModal').removeClass('hidden');
                    $('body').addClass('overflow-hidden');
                }
            }
        });
    }

    function showEditModal(id) {
        $.ajax({
            url: 'api/fetch_award_details.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function(res) {
                if (res.success) {
                    const d = res.details;
                    $('#modalTitle').html('<i class="fas fa-edit"></i> แก้ไขข้อมูลรางวัล');
                    $('#award_id').val(d.awid);
                    $('#award_tid').val(d.tid);
                    $('[name="award"]').val(d.award);
                    $('[name="level"]').val(d.level);
                    $('[name="date1"]').val(d.date1);
                    $('[name="term"]').val(d.term);
                    $('[name="year"]').val(d.year);
                    $('[name="department"]').val(d.department);
                    
                    if (d.certificate) {
                        $('#file_preview').attr('src', '../uploads/file_award/' + d.certificate);
                        $('#preview_container').removeClass('hidden');
                    }
                    
                    $('#awardModal').removeClass('hidden');
                    $('body').addClass('overflow-hidden');
                }
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลรางวัลนี้จะถูกลบอย่างถาวร!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'ใช่, ลบข้อมูล!',
            cancelButtonText: 'ยกเลิก',
            background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#000000',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/del_award.php',
                    method: 'POST',
                    dataType: 'json',
                    data: { id: id },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('สำเร็จ!', 'ลบข้อมูลเรียบร้อยแล้ว.', 'success');
                            fetchAwardData();
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด', res.message, 'error');
                        }
                    }
                });
            }
        });
    }

    window.closeModal = function() {
        $('#awardModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#awardForm')[0].reset();
        $('#preview_container').addClass('hidden');
    }

    window.closeViewModal = function() {
        $('#viewModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    }

    window.openImageModal = function(src) {
        // Close viewModal if open to prevent stacking
        if ($('#viewModal').is(':visible')) {
            $('#viewModal').addClass('hidden');
        }
        $('#modal_image_src').attr('src', src);
        $('#imageModal').removeClass('hidden').addClass('flex');
        $('body').addClass('overflow-hidden');
    }

    window.closeImageModal = function() {
        $('#imageModal').addClass('hidden').removeClass('flex');
        // Re-add overflow-hidden if viewModal is still open
        if ($('#awardModal').is(':visible') || $('#viewModal').is(':visible')) {
            $('body').addClass('overflow-hidden');
        } else {
            $('body').removeClass('overflow-hidden');
        }
    }


    $('#saveBtn').on('click', function() {
        const form = document.getElementById('awardForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const data = new FormData(form);
        const url = $('#award_id').val() ? 'api/update_award.php' : 'api/insert_award.php';
        
        Swal.fire({ title: 'กำลังบันทึก...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            success: function(res) {
                Swal.close();
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: res.message, timer: 1500, showConfirmButton: false });
                    closeModal();
                    fetchAwardData();
                } else {
                    Swal.fire('เกิดข้อผิดพลาด', res.message, 'error');
                }
            }
        });
    } );

    $('#file_input').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = (re) => { $('#file_preview').attr('src', re.target.result); $('#preview_container').removeClass('hidden'); };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

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

    $('#addAward').on('click', function() {
        const selectedTid = $('#select_teacher').val();
        if (!selectedTid) {
            Swal.fire('กรุณาเลือกครู', 'กรุณาเลือกครูที่ต้องการเพิ่มข้อมูลรางวัลให้ก่อน', 'warning');
            return;
        }
        $('#modalTitle').html('<i class="fas fa-plus-circle"></i> เพิ่มข้อมูลรางวัล');
        $('#awardForm')[0].reset();
        $('#award_id').val('');
        $('#award_tid').val(selectedTid);
        $('#preview_container').addClass('hidden');
        $('#awardModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });
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

@keyframes zoom-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-zoom-in { animation: zoom-in 0.3s ease-out; }
</style>
