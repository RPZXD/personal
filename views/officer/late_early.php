<!-- Officer Late/Early Arrival View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="no-print relative overflow-hidden rounded-3xl bg-gradient-to-br from-violet-600 to-indigo-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    <i class="fas fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">บันทึกเข้าสาย / กลับก่อนเวลา</h2>
                    <p class="text-violet-100/80 mt-1 font-medium italic text-xs md:text-base">
                        <span id="selected_teacher_display">ทั้งหมด</span> | <span id="selected_date_display">ทั้งหมด</span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button id="addRecord" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-violet-600 text-sm md:text-base font-bold hover:bg-violet-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle"></i> เพิ่มบันทึก
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-3 gap-2 md:gap-4">
        <div class="rounded-2xl p-3 md:p-4 border border-violet-500/10 bg-white dark:bg-slate-900 shadow-sm">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-3 text-center md:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-violet-100 dark:bg-violet-500/20 text-violet-600 dark:text-violet-400 flex items-center justify-center text-sm md:text-base">
                    <i class="fas fa-list-check"></i>
                </div>
                <div>
                    <p class="text-[8px] md:text-[10px] font-bold text-gray-400 uppercase tracking-wider">ทั้งหมด</p>
                    <h3 id="card_total_records" class="text-xl md:text-2xl font-black text-slate-900 dark:text-white">-</h3>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-3 md:p-4 border border-amber-500/10 bg-white dark:bg-slate-900 shadow-sm">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-3 text-center md:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center text-sm md:text-base">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-[8px] md:text-[10px] font-bold text-gray-400 uppercase tracking-wider">เข้าสาย</p>
                    <h3 id="card_total_late" class="text-xl md:text-2xl font-black text-amber-500">-</h3>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-3 md:p-4 border border-rose-500/10 bg-white dark:bg-slate-900 shadow-sm">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-3 text-center md:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-center text-sm md:text-base">
                    <i class="fas fa-door-open"></i>
                </div>
                <div>
                    <p class="text-[8px] md:text-[10px] font-bold text-gray-400 uppercase tracking-wider">กลับก่อน</p>
                    <h3 id="card_total_early" class="text-xl md:text-2xl font-black text-rose-500">-</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 no-print">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">กลุ่มสาระ</label>
                <select id="select_department" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-violet-500 outline-none transition-all appearance-none">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($majors as $m): ?>
                        <option value="<?= $m['Teach_major'] ?>"><?= $m['Teach_major'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">เลือกครู</label>
                <select id="select_teacher" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-violet-500 outline-none transition-all appearance-none">
                    <option value="">เลือกครู</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">วันที่เริ่มต้น</label>
                <input type="date" id="select_date_start" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-violet-500 outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">วันที่สิ้นสุด</label>
                <input type="date" id="select_date_end" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-violet-500 outline-none transition-all">
            </div>
            <div class="sm:col-span-2 lg:col-span-4 flex justify-end gap-3 pt-2">
                <button id="reset" class="px-8 py-3 rounded-2xl bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-200 transition-all">
                    <i class="fas fa-undo mr-2"></i>ล้างค่า
                </button>
                <button id="filter" class="px-8 py-3 rounded-2xl bg-violet-600 text-white font-bold hover:bg-violet-700 transition-all shadow-lg">
                    <i class="fas fa-search mr-2"></i>ค้นหา
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="record_table">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center border-b border-slate-100 dark:border-slate-800">#</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800">วันที่</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800">ประเภท</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center border-b border-slate-100 dark:border-slate-800">เวลา</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800">ชื่อ - สกุล</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800">รายละเอียด</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center border-b border-slate-100 dark:border-slate-800">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Data will be populated by JS -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Add/Edit Record -->
    <div id="recordModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 backdrop-blur-sm animate-fade-in shadow-2xl">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl animate-slide-up border border-slate-200 dark:border-slate-800">
                <div class="p-6 bg-gradient-to-r from-violet-600 to-indigo-600 flex justify-between items-center text-white">
                    <h3 id="modalTitle" class="text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        เพิ่มบันทึกเข้าสาย / กลับก่อน
                    </h3>
                    <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="recordForm" class="p-8 space-y-6">
                    <input type="hidden" name="id" id="editId">
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1">กลุ่มสาระ</label>
                                <select id="modalDept" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-violet-500 outline-none">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($majors as $m): ?>
                                        <option value="<?= $m['Teach_major'] ?>"><?= $m['Teach_major'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1">ชื่อบุคลากร</label>
                                <select name="tid" id="modalTeacher" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-violet-500 outline-none">
                                    <option value="">เลือกครู</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1">วันที่</label>
                                <input type="date" name="date_record" id="date_record" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-violet-500 outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1">เวลา</label>
                                <input type="time" name="time_record" id="time_record" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-violet-500 outline-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1">ประเภท</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 cursor-pointer hover:bg-white dark:hover:bg-slate-800 transition-all group has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 dark:has-[:checked]:bg-amber-500/10">
                                    <input type="radio" name="type" value="1" required class="w-4 h-4 text-amber-500 focus:ring-amber-500 focus:ring-offset-0 border-slate-300">
                                    <span class="font-bold text-slate-700 dark:text-slate-300 group-has-[:checked]:text-amber-600">เข้าสาย</span>
                                </label>
                                <label class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 cursor-pointer hover:bg-white dark:hover:bg-slate-800 transition-all group has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-500/10">
                                    <input type="radio" name="type" value="2" required class="w-4 h-4 text-rose-500 focus:ring-rose-500 focus:ring-offset-0 border-slate-300">
                                    <span class="font-bold text-slate-700 dark:text-slate-300 group-has-[:checked]:text-rose-600">กลับก่อนเวลา</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1">รายละเอียด/เหตุผล</label>
                            <textarea name="detail" id="detail" rows="2" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-violet-500 outline-none transition-all"></textarea>
                        </div>
                    </div>
                    
                    <input type="hidden" name="term" value="<?= $term ?>">
                    <input type="hidden" name="year" value="<?= $pee ?>">
                </form>
                <div class="p-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                    <button onclick="closeModal()" class="px-6 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-200 transition-all">ยกเลิก</button>
                    <button id="saveBtn" class="px-8 py-2.5 rounded-2xl bg-violet-600 text-white font-bold hover:bg-violet-700 transition-all shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const recordTable = $('#record_table').DataTable({
        "pageLength": 25,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "language": {
            "emptyTable": "ไม่พบข้อมูลการบันทึก",
            "search": "ค้นหา:",
            "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
        },
        "columnDefs": [
            { "className": "text-center", "targets": [0, 3, 6] },
            { "orderable": false, "targets": [6] }
        ]
    });

    fetchData();

    $('#select_department').change(function() {
        populateTeachers($(this).val(), '#select_teacher');
    });

    $('#modalDept').change(function() {
        populateTeachers($(this).val(), '#modalTeacher');
    });

    function populateTeachers(dept, target) {
        if (!dept) {
            $(target).empty().append('<option value="">เลือกครู</option>');
            return;
        }
        $.ajax({
            url: 'api/fetch_teachers.php',
            method: 'GET',
            data: { department: dept },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    $(target).empty().append('<option value="">เลือกครู</option>');
                    res.data.forEach(t => { 
                        $(target).append(`<option value="${t.Teach_id}">${t.Teach_name}</option>`);
                    });
                }
            }
        });
    }

    $('#filter').on('click', fetchData);
    $('#reset').on('click', function() {
        $('#select_department').val('');
        $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
        $('#select_date_start').val('');
        $('#select_date_end').val('');
        fetchData();
    });

    window.closeModal = function() {
        $('#recordModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#recordForm')[0].reset();
        $('#editId').val('');
        $('#modalTitle').html('<i class="fas fa-plus-circle"></i> เพิ่มบันทึกเข้าสาย / กลับก่อน');
    };

    $('#addRecord').on('click', function() {
        const currentTid = $('#select_teacher').val();
        closeModal();
        
        // Set current date and time
        const now = new Date();
        const dateStr = now.toISOString().split('T')[0];
        const timeStr = now.toTimeString().slice(0, 5);
        $('#date_record').val(dateStr);
        $('#time_record').val(timeStr);
        
        $('#recordModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
        if (currentTid) $('#modalTeacher').val(currentTid);
    });


    $('#saveBtn').on('click', function() {
        const form = document.getElementById('recordForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const isEdit = $('#editId').val() !== '';
        const formData = new FormData(form);
        const url = isEdit ? 'api/update_late_early.php' : 'api/insert_late_early.php';
        
        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                const r = typeof res === 'string' ? JSON.parse(res) : res;
                if (r.success) {
                    Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: r.message, timer: 1500, showConfirmButton: false });
                    closeModal();
                    fetchData();
                } else {
                    Swal.fire('ข้อผิดพลาด', r.message, 'error');
                }
            }
        });
    });

    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        
        $.ajax({
            url: 'api/get_late_early.php',
            method: 'GET',
            data: { id: id },
            success: function(res) {
                const r = typeof res === 'string' ? JSON.parse(res) : res;
                if (r.success) {
                    const d = r.data;
                    $('#editId').val(d.id);
                    $('#modalDept').val(d.Teach_major);
                    
                    // Re-populate teachers for the modal
                    $.ajax({
                        url: 'api/fetch_teachers.php',
                        method: 'GET',
                        data: { department: d.Teach_major },
                        dataType: 'json',
                        success: function(teacherRes) {
                            if (teacherRes.success) {
                                $('#modalTeacher').empty().append('<option value="">เลือกครู</option>');
                                teacherRes.data.forEach(t => { 
                                    $('#modalTeacher').append(`<option value="${t.Teach_id}">${t.Teach_name}</option>`);
                                });
                                $('#modalTeacher').val(d.tid);
                            }
                            $('#date_record').val(d.date_record);
                            $('#time_record').val(d.time_record);
                            $(`input[name="type"][value="${d.type}"]`).prop('checked', true);
                            $('#detail').val(d.detail);
                            $('#modalTitle').html('<i class="fas fa-edit"></i> แก้ไขการบันทึก');
                            Swal.close();
                            $('#recordModal').removeClass('hidden');
                        }
                    });
                }
            }
        });
    });

    $(document).on('click', '.del-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลนี้จะถูกลบอย่างถาวร!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/del_late_early.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(res) {
                        const r = typeof res === 'string' ? JSON.parse(res) : res;
                        if (r.success) {
                            Swal.fire('สำเร็จ!', 'ลบข้อมูลเรียบร้อยแล้ว.', 'success');
                            fetchData();
                        }
                    }
                });
            }
        });
    });

    function fetchData() {
        const tid = $('#select_teacher').val() || '';
        const date_start = $('#select_date_start').val() || '';
        const date_end = $('#select_date_end').val() || '';
        
        const teacherName = $('#select_teacher option:selected').val() ? $('#select_teacher option:selected').text() : 'ทั้งหมด';
        $('#selected_teacher_display').text(teacherName);
        $('#selected_date_display').text(date_start && date_end ? `${date_start} - ${date_end}` : 'ทั้งหมด');

        $.ajax({
            url: 'api/fetch_late_early.php',
            method: 'GET',
            dataType: 'json',
            data: { tid, date_start, date_end },
            success: function(res) {
                if (res.success) {
                    populateTable(res.data);
                }
            }
        });
    }

    function populateTable(data) {
        recordTable.clear();
        let stats = { total: data.length, late: 0, early: 0 };

        data.forEach((item, index) => {
            if (item.type == 1) stats.late++; else stats.early++;

            recordTable.row.add([
                index + 1,
                `<span class="text-sm font-medium text-slate-700 dark:text-slate-300">${convertToThaiDate(item.date_record)}</span>`,
                item.type == 1 
                    ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">เข้าสาย</span>`
                    : `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400">กลับก่อนเวลา</span>`,
                `<span class="font-bold text-slate-900 dark:text-white">${item.time_record.substring(0, 5)} น.</span>`,
                `<div><div class="font-bold text-slate-900 dark:text-white text-sm">${item.Teach_name}</div><div class="text-[10px] text-slate-500">${item.Teach_major}</div></div>`,
                `<div class="text-xs text-slate-500 dark:text-slate-400 truncate max-w-[200px]" title="${item.detail}">${item.detail || '-'}</div>`,
                `<div class="flex gap-2 justify-center">
                    <button class="w-8 h-8 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition-all flex items-center justify-center edit-btn" data-id="${item.id}"><i class="fas fa-edit text-xs"></i></button>
                    <button class="w-8 h-8 rounded-xl bg-rose-500 text-white hover:bg-rose-600 transition-all flex items-center justify-center del-btn" data-id="${item.id}"><i class="fas fa-trash text-xs"></i></button>
                </div>`
            ]);
        });
        recordTable.draw();
        $('#card_total_records').text(stats.total);
        $('#card_total_late').text(stats.late);
        $('#card_total_early').text(stats.early);
    }

    function convertToThaiDate(d) {
        if (!d) return '-';
        const m = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        const date = new Date(d);
        return `${date.getDate()} ${m[date.getMonth()]} ${date.getFullYear() + 543}`;
    }
});
</script>

<style>
/* Mobile Card View Styles */
@media screen and (max-width: 768px) {
    #record_table thead { display: none; }
    #record_table tbody tr {
        display: flex; flex-direction: column; background: var(--card-bg, #ffffff); border-radius: 1.5rem;
        margin-bottom: 1rem; padding: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid rgba(0, 0, 0, 0.05); position: relative;
    }
    .dark #record_table tbody tr { --card-bg: #1e293b; border-color: rgba(255, 255, 255, 0.1); }
    #record_table tbody td { display: flex; align-items: center; padding: 0.4rem 0; border: none !important; text-align: left !important; }
    #record_table tbody td:first-child {
        position: absolute; top: 0.75rem; right: 0.75rem; background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;
    }
    #record_table tbody td:nth-child(2)::before { content: "📅 "; font-weight: 600; margin-right: 0.5rem; }
    #record_table tbody td:nth-child(3):before { content: ""; }
    #record_table tbody td:nth-child(4)::before { content: "⏰ "; font-weight: 600; margin-right: 0.5rem; }
    #record_table tbody td:nth-child(5) { padding-right: 3rem; flex-direction: column; align-items: flex-start; }
    #record_table tbody td:nth-child(6)::before { content: "📝 เหตุผล: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; font-size: 0.75rem; }
    #record_table tbody td:last-child { border-top: 1px dashed rgba(0, 0, 0, 0.1) !important; padding-top: 1rem; margin-top: 0.5rem; justify-content: center; }
    
    /* Filter section adjustments */
    .no-print .grid { gap: 0.75rem; }
    .no-print button { padding: 0.75rem 1rem !important; font-size: 0.875rem !important; }
}

@media print {
    * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    body { background: white !important; }
    button, nav, aside, .sidebar, #select_department, #select_teacher, #select_date_start, #select_date_end, #filter, #reset { display: none !important; }
    .rounded-3xl { background: white !important; box-shadow: none !important; border: 1px solid #ddd !important; border-radius: 0.5rem !important; }
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
