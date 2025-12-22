<!-- Admin Leave View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="no-print relative overflow-hidden rounded-3xl bg-gradient-to-br from-rose-500 to-orange-600 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    📅
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">ระบบการลาบุคลากร</h2>
                    <p class="text-rose-100/80 mt-1 font-medium italic text-xs md:text-base">
                        <span id="selected_teacher_display">ทังหมด</span> | <span id="selected_date_display">ทั้งหมด</span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button id="addLeave" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-rose-600 text-sm md:text-base font-bold hover:bg-rose-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle"></i> เพิ่มการแจ้งลา
                </button>
                <button onclick="printPage()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white/20 backdrop-blur text-white text-sm md:text-base font-bold hover:bg-white/30 transition-all border border-white/30 flex items-center justify-center gap-2">
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
        <h2 class="text-2xl font-bold text-slate-900 border-b-2 border-slate-900 pb-2 inline-block">รายงานข้อมูลการลาของบุคลากร</h2>
        <div class="text-lg text-slate-700 font-semibold space-y-1">
            <p>ชื่อ-นามสกุล: <span id="selected_teacher_print">-</span></p>
            <p>ข้อมูลประจำช่วงวันที่ <span id="selected_date_print">-</span></p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <!-- Card 1: Total -->
        <div class="glass-morphism rounded-2xl p-4 border border-blue-500/10">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">รวมวันลา</p>
            <h3 id="card_total_leave_days" class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1">-</h3>
        </div>
        <!-- Card 2: Sick -->
        <div class="glass-morphism rounded-2xl p-4 border border-rose-500/10">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ลาป่วย</p>
            <h3 id="card_total_sick_leave_days" class="text-2xl font-black text-rose-500 mt-1">-</h3>
        </div>
        <!-- Card 3: Personal -->
        <div class="glass-morphism rounded-2xl p-4 border border-amber-500/10">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ลากิจ</p>
            <h3 id="card_total_personal_leave_days" class="text-2xl font-black text-amber-500 mt-1">-</h3>
        </div>
        <!-- Card 4: Official -->
        <div class="glass-morphism rounded-2xl p-4 border border-emerald-500/10">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ไปราชการ</p>
            <h3 id="card_total_official_leave_days" class="text-2xl font-black text-emerald-500 mt-1">-</h3>
        </div>
        <!-- Card 5: Other -->
        <div class="glass-morphism rounded-2xl p-4 border border-gray-500/10">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ลาอื่นๆ</p>
            <h3 id="card_total_other_leave_days" class="text-2xl font-black text-gray-600 dark:text-gray-400 mt-1">-</h3>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass-morphism rounded-3xl p-6 no-print">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">กลุ่มสาระ</label>
                <select id="select_department" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($majors as $m): ?>
                        <option value="<?= $m['Teach_major'] ?>"><?= $m['Teach_major'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">เลือกครู</label>
                <select id="select_teacher" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                    <option value="">เลือกครู</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">วันที่เริ่มต้น</label>
                <input type="date" id="select_date_start" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-rose-500 outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">วันที่สิ้นสุด</label>
                <input type="date" id="select_date_end" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-rose-500 outline-none transition-all">
            </div>
            <div class="sm:col-span-2 lg:col-span-4 flex justify-end gap-3 pt-2">
                <button id="reset" class="px-8 py-3 rounded-2xl bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-200 transition-all">
                    ล้างค่า
                </button>
                <button id="filter" class="px-8 py-3 rounded-2xl bg-rose-600 text-white font-bold hover:bg-rose-700 transition-all shadow-lg">
                    ค้นหา
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
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ประเภทการลา</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">วันที่เริ่มต้น</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">วันที่สิ้นสุด</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">รวม (วัน)</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">เหตุผล/รายละเอียด</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    <!-- Loaded by AJAX -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal: Add/Edit Leave -->
    <div id="leaveModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 backdrop-blur-sm animate-fade-in">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="glass-morphism rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
                <div class="p-6 bg-gradient-to-r from-rose-600 to-orange-600 flex justify-between items-center text-white">
                    <h3 id="modalTitle" class="text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        เพิ่มการแจ้งลา / ไปราชการ
                    </h3>
                    <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4 bg-rose-50 dark:bg-rose-500/10 border-b border-rose-100 dark:border-rose-500/20">
                    <p class="text-xs text-rose-700 dark:text-rose-400 font-bold flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i> ข้อมูลนี้จะถูกบันทึกเพื่อใช้สำหรับจัดพิมพ์ใบลาในภายหลัง
                    </p>
                </div>
                <form id="leaveForm" class="p-8 space-y-6">
                    <input type="hidden" name="id" id="editId">
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">กลุ่มสาระ</label>
                                <select id="modalDept" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($majors as $m): ?>
                                        <option value="<?= $m['Teach_major'] ?>"><?= $m['Teach_major'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ชื่อบุคลากร</label>
                                <select name="teacher" id="modalTeacher" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                                    <option value="">เลือกครู</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ประเภทการลา</label>
                            <select name="status" id="addStatus" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                                <option value="">เลือกประเภทการลา</option>
                                <option value="1">ลาป่วย</option>
                                <option value="2">ลากิจ</option>
                                <option value="3">ไปราชการ</option>
                                <option value="4">ลาคลอด</option>
                                <option value="9">อื่นๆ</option>
                            </select>
                        </div>

                        <div id="otherLeaveTypeGroup" class="hidden space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ระบุประเภทการลา</label>
                            <input type="text" name="other_leave_type" id="other_leave_type" placeholder="เช่น ลาอุปสมบท, ลาศึกษาต่อ" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 outline-none focus:ring-2 focus:ring-rose-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่เริ่มต้น</label>
                                <input type="date" name="date_start" id="date_start" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่สิ้นสุด</label>
                                <input type="date" name="date_end" id="date_end" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center ml-1">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 uppercase">เหตุผลการลา</label>
                                <span id="charCount" class="text-[10px] font-bold text-gray-400">0 / 100</span>
                            </div>
                            <textarea name="detail" id="detail" required maxlength="100" rows="3" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none transition-all"></textarea>
                        </div>
                    </div>
                </form>
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end gap-3">
                    <button onclick="closeModal()" class="px-6 py-2.5 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">ยกเลิก</button>
                    <button id="saveBtn" class="px-8 py-2.5 rounded-2xl bg-rose-600 text-white font-bold hover:bg-rose-700 transition-all shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize Table
    const recordTable = $('#record_table').DataTable({
        "pageLength": 25,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "language": {
            "emptyTable": "ไม่พบข้อมูลการลา",
            "search": "ค้นหา:",
            "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
        },
        "columnDefs": [
            { "className": "text-center", "targets": [0, 2, 3, 4, 6] },
            { "orderable": false, "targets": [6] }
        ]
    });

    // Load initial data
    fetchLeaveData();

    // Event Handlers
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

    $('#filter').on('click', fetchLeaveData);
    $('#reset').on('click', function() {
        $('#select_department').val('');
        $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
        $('#select_date_start').val('');
        $('#select_date_end').val('');
        updateHeaderDisplay();
        fetchLeaveData();
    });

    // Modal Handlers
    window.closeModal = function() {
        $('#leaveModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#leaveForm')[0].reset();
        $('#editId').val('');
        $('#modalTitle').html('<i class="fas fa-plus-circle"></i> เพิ่มการแจ้งลา / ไปราชการ');
        $('#otherLeaveTypeGroup').addClass('hidden');
        $('#charCount').text('0 / 100');
    };

    $('#addLeave').on('click', function() {
        // Pre-select teacher if one is selected in filter
        const currentTid = $('#select_teacher').val();
        closeModal(); // Reset form
        $('#leaveModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
        if (currentTid) $('#modalTeacher').val(currentTid);
    });

    $('#addStatus').on('change', function() {
        if ($(this).val() == '9') $('#otherLeaveTypeGroup').removeClass('hidden');
        else $('#otherLeaveTypeGroup').addClass('hidden');
    });

    $('#detail').on('input', function() {
        $('#charCount').text($(this).val().length + ' / 100');
    });

    $('#saveBtn').on('click', function() {
        const form = document.getElementById('leaveForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const isEdit = $('#editId').val() !== '';
        const formData = new FormData(form);
        
        Swal.fire({ title: isEdit ? 'กำลังอัปเดต...' : 'กำลังบันทึก...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        
        if (isEdit) {
            // update_leave.php expects JSON
            const data = {};
            formData.forEach((value, key) => data[key] = value);
            $.ajax({
                url: 'api/update_leave.php',
                method: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function(res) {
                    const r = typeof res === 'string' ? JSON.parse(res) : res;
                    if (r.success) {
                        Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: 'อัปเดตข้อมูลเรียบร้อย', timer: 1500, showConfirmButton: false });
                        closeModal();
                        fetchLeaveData();
                    } else {
                        Swal.fire('ผิดพลาด', r.message || 'ไม่สามารถอัปเดตข้อมูลได้', 'error');
                    }
                }
            });
        } else {
            // insert_leave.php expects FormData/POST
            $.ajax({
                url: 'api/insert_leave.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    const r = typeof res === 'string' ? JSON.parse(res) : res;
                    if (r.success) {
                        Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: r.message, timer: 1500, showConfirmButton: false });
                        closeModal();
                        fetchLeaveData();
                    } else {
                        Swal.fire('ข้อผิดพลาด', r.message, 'error');
                    }
                }
            });
        }
    });

    $(document).on('click', '.edit-leave', function() {
        const id = $(this).data('id');
        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        
        $.ajax({
            url: 'api/get_leave.php',
            method: 'GET',
            data: { id: id },
            success: function(res) {
                const r = typeof res === 'string' ? JSON.parse(res) : res;
                if (r.success) {
                    const d = r.data;
                    $('#editId').val(d.id);
                    
                    // Set department and populate teachers before selecting the teacher
                    $('#modalDept').val(d.Teach_major);
                    
                    const populatePromise = new Promise((resolve) => {
                        if (!d.Teach_major) { resolve(); return; }
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
                                }
                                resolve();
                            },
                            error: () => resolve()
                        });
                        // Safety timeout
                        setTimeout(resolve, 3000);
                    });

                    populatePromise.then(() => {
                        Swal.close();
                        $('#modalTeacher').val(d.Teach_id);
                        $('#addStatus').val(d.status);
                        $('#date_start').val(d.date_start);
                        $('#date_end').val(d.date_end);
                        $('#detail').val(d.detail);
                        $('#modalTitle').html('<i class="fas fa-edit"></i> แก้ไขข้อมูลการลา');
                        
                        if (d.status == '9') {
                            $('#otherLeaveTypeGroup').removeClass('hidden');
                            $('#other_leave_type').val(d.other_leave_type);
                        } else {
                            $('#otherLeaveTypeGroup').addClass('hidden');
                        }
                        
                        $('#charCount').text(d.detail.length + ' / 100');
                        $('#leaveModal').removeClass('hidden');
                        $('body').addClass('overflow-hidden');
                    });
                } else {
                    Swal.fire('ผิดพลาด', r.message || 'ไม่สามารถโหลดข้อมูลได้', 'error');
                }
            },
            error: function() {
                Swal.fire('ผิดพลาด', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
            }
        });
    });

    $(document).on('click', '.del-leave', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลการลาชุดนี้จะถูกลบอย่างถาวร!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/del_leave.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(res) {
                        const r = typeof res === 'string' ? JSON.parse(res) : res;
                        if (r.success) {
                            Swal.fire('สำเร็จ!', 'ลบข้อมูลเรียบร้อยแล้ว.', 'success');
                            fetchLeaveData();
                        } else {
                            Swal.fire('ผิดพลาด', r.message, 'error');
                        }
                    }
                });
            }
        });
    });

    function updateHeaderDisplay() {
        const teacherName = $('#select_teacher option:selected').val() ? $('#select_teacher option:selected').text() : 'ทั้งหมด';
        let ds = $('#select_date_start').val();
        let de = $('#select_date_end').val();
        const dateRangeText = ds && de ? `${convertToThaiDate(ds)} - ${convertToThaiDate(de)}` : 'ทั้งหมด';

        $('#selected_teacher_display, #selected_teacher_print').text(teacherName);
        $('#selected_date_display, #selected_date_print').text(dateRangeText);
    }

    function fetchLeaveData() {
        const tid = $('#select_teacher').val() || '';
        const date_start = $('#select_date_start').val() || '';
        const date_end = $('#select_date_end').val() || '';
        updateHeaderDisplay();

        $.ajax({
            url: 'api/fetch_leave.php',
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
        let totals = { all: 0, 1: 0, 2: 0, 3: 0, 9: 0 };

        data.forEach((item, index) => {
            let days = calculateWeekDays(item.date_start, item.date_end);
            totals.all += days;
            if (totals[item.status] !== undefined) totals[item.status] += days;
            else totals[9] += days;

            recordTable.row.add([
                index + 1,
                `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold ${getLeaveStatusClass(item.status)}">${getLeaveStatusText(item.status)}</span>`,
                `<span class="text-sm font-medium text-slate-700 dark:text-slate-300">${convertToThaiDate(item.date_start)}</span>`,
                `<span class="text-sm font-medium text-slate-700 dark:text-slate-300">${convertToThaiDate(item.date_end)}</span>`,
                `<span class="font-bold text-rose-600 dark:text-rose-400">${days}</span>`,
                `<div class="text-sm text-gray-600 dark:text-gray-400">${item.detail}</div>`,
                `<div class="no-print flex gap-2 justify-center">
                    <a href="print_leave.php?id=${item.id}" target="_blank" class="w-8 h-8 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-all flex items-center justify-center"><i class="fas fa-print text-xs"></i></a>
                    <button class="w-8 h-8 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition-all flex items-center justify-center edit-leave" data-id="${item.id}"><i class="fas fa-edit text-xs"></i></button>
                    <button class="w-8 h-8 rounded-xl bg-rose-500 text-white hover:bg-rose-600 transition-all flex items-center justify-center del-leave" data-id="${item.id}"><i class="fas fa-trash text-xs"></i></button>
                </div>`
            ]);
        });
        recordTable.draw();
        updateSummaryCards(totals);
    }

    function calculateWeekDays(start, end) {
        const s = new Date(start);
        const e = new Date(end);
        let count = 0;
        let cur = new Date(s);
        while (cur <= e) {
            if (cur.getDay() !== 0 && cur.getDay() !== 6) count++;
            cur.setDate(cur.getDate() + 1);
        }
        return count;
    }

    function getLeaveStatusText(s) {
        switch (s) {
            case '1': return 'ลาป่วย';
            case '2': return 'ลากิจ';
            case '3': return 'ไปราชการ';
            case '4': return 'ลาคลอด';
            case '9': return 'อื่นๆ';
            default: return 'ไม่ระบุ';
        }
    }

    function getLeaveStatusClass(s) {
        switch (s) {
            case '1': return 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400';
            case '2': return 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400';
            case '3': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400';
            case '4': return 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400';
            default: return 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-400';
        }
    }

    function updateSummaryCards(t) {
        $('#card_total_leave_days').text(t.all);
        $('#card_total_sick_leave_days').text(t[1]);
        $('#card_total_personal_leave_days').text(t[2]);
        $('#card_total_official_leave_days').text(t[3]);
        $('#card_total_other_leave_days').text(t[9]);
    }

    function convertToThaiDate(d) {
        if (!d) return '-';
        const m = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        const date = new Date(d);
        return `${date.getDate()} ${m[date.getMonth()]} ${date.getFullYear() + 543}`;
    }

    window.printPage = function() { window.print(); };
});
</script>

<style>
/* Same responsive and print styles but with rose colors */
@media screen and (max-width: 768px) {
    #record_table thead { display: none; }
    #record_table tbody tr {
        display: flex; flex-direction: column; background: var(--card-bg, #ffffff); border-radius: 1.5rem;
        margin-bottom: 1rem; padding: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid rgba(0, 0, 0, 0.05); position: relative;
    }
    .dark #record_table tbody tr { --card-bg: #1e293b; border-color: rgba(255, 255, 255, 0.1); }
    #record_table tbody td { display: flex; align-items: flex-start; padding: 0.5rem 0; border: none !important; text-align: left !important; }
    #record_table tbody td:first-child {
        position: absolute; top: 0.75rem; right: 0.75rem; background: linear-gradient(135deg, #f43f5e, #fb923c);
        color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;
    }
    #record_table tbody td:nth-child(2) { padding-right: 3rem; flex-direction: column; }
    #record_table tbody td:nth-child(3)::before { content: "📅 เริ่ม: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; }
    #record_table tbody td:nth-child(4)::before { content: "📅 สิ้นสุด: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; }
    #record_table tbody td:nth-child(5)::before { content: "⏱️ รวม: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; }
    #record_table tbody td:nth-child(6)::before { content: "ℹ️ เหตุผล: "; font-weight: 600; color: #64748b; margin-right: 0.5rem; }
    #record_table tbody td:last-child { border-top: 1px dashed rgba(0, 0, 0, 0.1) !important; padding-top: 1rem; margin-top: 0.5rem; justify-content: center; }
}

@media print {
    * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    body { background: white !important; }
    button, nav, aside, .sidebar, #select_department, #select_teacher, #select_date_start, #select_date_end, #filter, #reset { display: none !important; }
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
