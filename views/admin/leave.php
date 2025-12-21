<!-- Admin Leave Management View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-teal-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">ระบบจัดการการลา</h2>
                    <p class="text-emerald-100/80 mt-1 font-medium italic text-xs md:text-base">
                        ตรวจสอบและพิมพ์รายงานการลาของบุคลากร
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button onclick="openAddModal()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-emerald-600 text-sm md:text-base font-bold hover:bg-emerald-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> เพิ่มการแจ้งลา
                </button>
                <button onclick="printPage()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white/20 backdrop-blur text-white text-sm md:text-base font-bold hover:bg-white/30 transition-all border border-white/30 flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="glass-morphism rounded-3xl p-6 border border-white/20 shadow-xl space-y-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-emerald-500/5 p-4 rounded-2xl border border-emerald-500/10">
            <div class="inline-flex rounded-xl p-1 bg-white/50 dark:bg-slate-800/50 backdrop-blur shadow-inner w-full md:w-auto overflow-x-auto no-scrollbar">
                <button onclick="setQuickRange('range1')" class="range-btn whitespace-nowrap px-4 py-2 rounded-lg text-xs font-bold transition-all hover:bg-white dark:hover:bg-slate-700" id="range1Btn">ครึ่งปีแรก (1 เม.ย. - 30 ก.ย.)</button>
                <button onclick="setQuickRange('range2')" class="range-btn whitespace-nowrap px-4 py-2 rounded-lg text-xs font-bold transition-all hover:bg-white dark:hover:bg-slate-700" id="range2Btn">ครึ่งปีหลัง (1 ต.ค. - 31 มี.ค.)</button>
                <button onclick="setQuickRange('custom')" class="range-btn whitespace-nowrap px-4 py-2 rounded-lg text-xs font-bold transition-all hover:bg-white dark:hover:bg-slate-700" id="customRangeBtn">กำหนดเอง</button>
            </div>
            
            <div class="flex gap-2 w-full md:w-auto">
                <button id="filterBtn" class="flex-1 md:flex-none px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all">ค้นหา</button>
                <button id="resetBtn" class="px-6 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-widest hover:bg-slate-300 transition-all">ล้างค่า</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">กลุ่มสาระ</label>
                <select id="select_department" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold text-sm">
                    <option value="">เลือกกลุ่ม</option>
                    <?php foreach ($majors as $major): ?>
                        <option value="<?= $major['Teach_major'] ?>"><?= $major['Teach_major'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">เลือกครู</label>
                <select id="select_teacher" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold text-sm">
                    <option value="">เลือกครู</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">วันที่เริ่มต้น</label>
                <input type="date" id="select_date_start" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold text-sm">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">วันที่สิ้นสุด</label>
                <input type="date" id="select_date_end" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold text-sm">
            </div>
        </div>
    </div>

    <!-- Summary Stats Section -->
    <div id="statsSection" class="grid grid-cols-2 md:grid-cols-5 gap-4 hidden animate-fade-in">
        <div class="glass-morphism rounded-2xl p-4 border border-white/20 text-center">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">รวมวันลาทั้งหมด</p>
            <p id="total_leave_days" class="text-2xl font-black text-slate-800 dark:text-white">-</p>
        </div>
        <div class="glass-morphism rounded-2xl p-4 border border-white/20 text-center border-l-4 border-l-rose-500">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">ลาป่วย</p>
            <p id="total_sick_leave_days" class="text-2xl font-black text-rose-600">-</p>
        </div>
        <div class="glass-morphism rounded-2xl p-4 border border-white/20 text-center border-l-4 border-l-amber-500">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">ลากิจ</p>
            <p id="total_personal_leave_days" class="text-2xl font-black text-amber-600">-</p>
        </div>
        <div class="glass-morphism rounded-2xl p-4 border border-white/20 text-center border-l-4 border-l-sky-500">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">ไปราชการ</p>
            <p id="total_official_leave_days" class="text-2xl font-black text-sky-600">-</p>
        </div>
        <div class="glass-morphism rounded-2xl p-4 border border-white/20 text-center border-l-4 border-l-slate-500">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">ลาอื่นๆ</p>
            <p id="total_other_leave_days" class="text-2xl font-black text-slate-600">-</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="glass-morphism rounded-3xl p-6 overflow-hidden border border-white/20 shadow-xl">
        <div class="mb-6 flex justify-between items-center">
            <div id="printHeaderInfo" class="hidden">
                 <h4 class="text-lg font-black text-slate-800">รายงานการลา: <span id="display_name" class="text-emerald-600"></span></h4>
                 <p class="text-sm text-slate-500">กลุ่มสาระ: <span id="display_dept"></span></p>
            </div>
        </div>
        <div class="table-responsive">
            <table class="w-full text-left" id="record_table">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">#</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">ประเภทการลา</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">เริ่มต้น</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">สิ้นสุด</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">จำนวนวัน</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">เหตุผล</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center no-print">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Add Leave -->
    <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 backdrop-blur-sm animate-fade-in">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="glass-morphism rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
                <div class="p-6 bg-gradient-to-r from-emerald-600 to-teal-600 flex justify-between items-center text-white">
                    <h3 class="text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-plus"></i>
                        แจ้งการลาใหม่
                    </h3>
                    <button onclick="closeAddModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="addForm" class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">กลุ่มสาระ</label>
                            <select name="department" id="addDepartment" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold">
                                <option value="">เลือกกลุ่ม</option>
                                <?php foreach ($majors as $major): ?>
                                    <option value="<?= $major['Teach_major'] ?>"><?= $major['Teach_major'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เลือกครู</label>
                            <select name="teacher" id="addTeacher" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold">
                                <option value="">เลือกครู</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ประเภทการลา</label>
                            <select name="status" id="addStatus" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold text-center">
                                <option value="">-- โปรดเลือกประเภทการลา --</option>
                                <option value="1">ลาป่วย</option>
                                <option value="2">ลากิจ</option>
                                <option value="3">ไปราชการ</option>
                                <option value="4">ลาคลอด</option>
                                <option value="9">อื่นๆ</option>
                            </select>
                        </div>

                        <div id="otherLeaveTypeGroup" class="md:col-span-2 space-y-2 hidden">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ระบุประเภทการลาอื่นๆ</label>
                            <input type="text" name="other_leave_type" id="otherLeaveType" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่เริ่มต้น</label>
                            <input type="date" name="date_start" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่สิ้นสุด</label>
                            <input type="date" name="date_end" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เหตุผล / รายละเอียด</label>
                            <textarea name="detail" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-bold min-h-[100px]"></textarea>
                        </div>
                    </div>
                </form>
                
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end gap-3">
                    <button onclick="closeAddModal()" class="px-6 py-2.5 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">ยกเลิก</button>
                    <button id="saveAdd" class="px-8 py-2.5 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-all shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Leave -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 backdrop-blur-sm animate-fade-in">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="glass-morphism rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 flex justify-between items-center text-white">
                    <h3 class="text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        แก้ไขข้อมูลการลา
                    </h3>
                    <button onclick="closeEditModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="editForm" class="p-8 space-y-6">
                    <input type="hidden" name="id" id="editLeaveId">
                    <input type="hidden" name="tid" id="editTeacherId">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ประเภทการลา</label>
                            <select name="status" id="editStatus" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 outline-none transition-all font-bold text-center">
                                <option value="1">ลาป่วย</option>
                                <option value="2">ลากิจ</option>
                                <option value="3">ไปราชการ</option>
                                <option value="4">ลาคลอด</option>
                                <option value="9">อื่นๆ</option>
                            </select>
                        </div>

                        <div id="editOtherLeaveTypeGroup" class="md:col-span-2 space-y-2 hidden">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ระบุประเภทการลาอื่นๆ</label>
                            <input type="text" name="other_leave_type" id="editOtherLeaveType" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 outline-none transition-all font-bold">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่เริ่มต้น</label>
                            <input type="date" name="date_start" id="editStartDate" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 outline-none transition-all font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่สิ้นสุด</label>
                            <input type="date" name="date_end" id="editEndDate" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 outline-none transition-all font-bold">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เหตุผล / รายละเอียด</label>
                            <textarea name="detail" id="editDetail" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-blue-500 outline-none transition-all font-bold min-h-[100px]"></textarea>
                        </div>
                    </div>
                </form>
                
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end gap-3">
                    <button onclick="closeEditModal()" class="px-6 py-2.5 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">ยกเลิก</button>
                    <button id="saveEdit" class="px-8 py-2.5 rounded-2xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition-all shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> บันทึกการแก้ไข
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
        "pageLength": 50,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "language": {
            "emptyTable": "กรุณาเลือกครูและระบุช่วงวันที่เพื่อดูข้อมูลการลา",
            "search": "ค้นหา:",
            "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
        },
        "columnDefs": [
            { "className": "text-center", "targets": [0, 1, 2, 3, 4, 6] },
            { "orderable": false, "targets": [0, 6] }
        ]
    });

    // Quick Range Handler
    window.setQuickRange = function(range) {
        $('.range-btn').removeClass('bg-white shadow text-emerald-600 dark:bg-slate-700 dark:text-white');
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        
        if (range === 'range1') {
            $('#range1Btn').addClass('bg-white shadow text-emerald-600 dark:bg-slate-700 dark:text-white');
            $('#select_date_start').val(`${currentYear}-04-01`);
            $('#select_date_end').val(`${currentYear}-09-30`);
        } else if (range === 'range2') {
            $('#range2Btn').addClass('bg-white shadow text-emerald-600 dark:bg-slate-700 dark:text-white');
            $('#select_date_start').val(`${currentYear}-10-01`);
            $('#select_date_end').val(`${currentYear+1}-03-31`);
        } else {
            $('#customRangeBtn').addClass('bg-white shadow text-emerald-600 dark:bg-slate-700 dark:text-white');
            $('#select_date_start').val('');
            $('#select_date_end').val('');
        }
    };

    // Filter Handlers
    $('#select_department').on('change', function() {
        const dept = $(this).val();
        if (dept) {
            $.getJSON('api/fetch_teachers.php', { department: dept }, function(res) {
                if (res.success) {
                    const select = $('#select_teacher');
                    select.empty().append('<option value="">เลือกครู</option>');
                    res.data.forEach(t => select.append(`<option value="${t.Teach_id}">${t.Teach_name}</option>`));
                }
            });
        }
    });

    $('#addDepartment').on('change', function() {
        const dept = $(this).val();
        if (dept) {
            $.getJSON('api/fetch_teachers.php', { department: dept }, function(res) {
                if (res.success) {
                    const select = $('#addTeacher');
                    select.empty().append('<option value="">เลือกครู</option>');
                    res.data.forEach(t => select.append(`<option value="${t.Teach_id}">${t.Teach_name}</option>`));
                }
            });
        }
    });

    $('#filterBtn').on('click', fetchLeaveData);
    $('#resetBtn').on('click', function() {
        $('#select_department').val('');
        $('#select_teacher').empty().append('<option value="">เลือกครู</option>');
        $('#select_date_start, #select_date_end').val('');
        recordTable.clear().draw();
        $('#statsSection').addClass('hidden');
    });

    function fetchLeaveData() {
        const tid = $('#select_teacher').val();
        const start = $('#select_date_start').val();
        const end = $('#select_date_end').val();
        
        if (!tid) { Swal.fire('โปรดเลือกครู', 'กรุณาระบุชื่อบุคลากรที่ต้องการตรวจสอบ', 'warning'); return; }

        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        
        $.ajax({
            url: 'api/fetch_leave.php',
            method: 'GET',
            data: { tid, date_start: start, date_end: end },
            dataType: 'json',
            success: function(res) {
                Swal.close();
                if (res.success) {
                    populateTable(res.data);
                    $('#display_name').text($('#select_teacher option:selected').text());
                    $('#display_dept').text($('#select_department option:selected').text());
                    $('#statsSection').removeClass('hidden');
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            }
        });
    }

    function populateTable(leaves) {
        recordTable.clear();
        let sums = { total: 0, 1: 0, 2: 0, 3: 0, 9: 0 };
        
        leaves.forEach((leave, idx) => {
            const start = new Date(leave.date_start);
            const end = new Date(leave.date_end);
            const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
            
            sums.total += diff;
            if (sums[leave.status] !== undefined) sums[leave.status] += diff;

            recordTable.row.add([
                idx + 1,
                getStatusLabel(leave.status),
                formatThaiDate(leave.date_start),
                formatThaiDate(leave.date_end),
                `<span class="font-black text-slate-800">${diff}</span>`,
                `<div class="max-w-md text-slate-500 font-medium">${leave.detail}</div>`,
                `<div class="flex gap-2 justify-center no-print">
                    <a href="print_leave.php?id=${leave.id}" target="_blank" class="w-8 h-8 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition-all flex items-center justify-center shadow-lg shadow-amber-500/20"><i class="fas fa-print text-xs"></i></a>
                    <button onclick="editLeave('${leave.id}')" class="w-8 h-8 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-all flex items-center justify-center shadow-lg shadow-blue-500/20"><i class="fas fa-edit text-xs"></i></button>
                 </div>`
            ]);
        });
        
        recordTable.draw();
        
        // Update stats
        $('#total_leave_days').text(sums.total);
        $('#total_sick_leave_days').text(sums[1]);
        $('#total_personal_leave_days').text(sums[2]);
        $('#total_official_leave_days').text(sums[3]);
        $('#total_other_leave_days').text(sums[9]);
    }

    function getStatusLabel(s) {
        const labels = {
            '1': { text: 'ลาป่วย', bg: 'bg-rose-100 text-rose-700' },
            '2': { text: 'ลากิจ', bg: 'bg-amber-100 text-amber-700' },
            '3': { text: 'ไปราชการ', bg: 'bg-sky-100 text-sky-700' },
            '4': { text: 'ลาคลอด', bg: 'bg-pink-100 text-pink-700' },
            '9': { text: 'อื่นๆ', bg: 'bg-slate-100 text-slate-700' }
        };
        const l = labels[s] || { text: 'ไม่ทราบ', bg: 'bg-gray-100' };
        return `<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black ${l.bg}">${l.text}</span>`;
    }

    function formatThaiDate(dateStr) {
        const d = new Date(dateStr);
        const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear() + 543}`;
    }

    // Modal Handlers
    window.openAddModal = () => { $('#addModal').removeClass('hidden'); $('body').addClass('overflow-hidden'); };
    window.closeAddModal = () => { $('#addModal').addClass('hidden'); $('body').removeClass('overflow-hidden'); $('#addForm')[0].reset(); };
    
    $('#addStatus').on('change', function() { $(this).val() === '9' ? $('#otherLeaveTypeGroup').show() : $('#otherLeaveTypeGroup').hide(); });
    $('#editStatus').on('change', function() { $(this).val() === '9' ? $('#editOtherLeaveTypeGroup').show() : $('#editOtherLeaveTypeGroup').hide(); });

    $('#saveAdd').on('click', function() {
        const form = document.getElementById('addForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        Swal.fire({ title: 'กำลังบันทึก...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        $.ajax({
            url: 'api/insert_leave.php',
            method: 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    Swal.fire('สำเร็จ', 'บันทึกข้อมูลเรียบร้อย', 'success');
                    closeAddModal();
                    if ($('#select_teacher').val()) fetchLeaveData();
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            }
        });
    });

    window.editLeave = (id) => {
        $.getJSON('api/get_leave.php', { id }, function(res) {
            if (res.success) {
                const l = res.data;
                $('#editLeaveId').val(l.id);
                $('#editTeacherId').val(l.Teach_id);
                $('#editStatus').val(l.status).trigger('change');
                $('#editOtherLeaveType').val(l.other_leave_type);
                $('#editStartDate').val(l.date_start);
                $('#editEndDate').val(l.date_end);
                $('#editDetail').val(l.detail);
                
                $('#editModal').removeClass('hidden');
                $('body').addClass('overflow-hidden');
            }
        });
    };

    window.closeEditModal = () => { $('#editModal').addClass('hidden'); $('body').removeClass('overflow-hidden'); };

    $('#saveEdit').on('click', function() {
        const form = document.getElementById('editForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const data = Object.fromEntries(new FormData(form).entries());
        $.ajax({
            url: 'api/update_leave.php',
            method: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    Swal.fire('สำเร็จ', 'แก้ไขข้อมูลเรียบร้อย', 'success');
                    closeEditModal();
                    fetchLeaveData();
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            }
        });
    });

    window.printPage = function() {
        window.print();
    };
});
</script>

<style>
@media print {
    .no-print { display: none !important; }
    #record_table { width: 100% !important; border-collapse: collapse !important; }
    #record_table td, #record_table th { border: 1px solid #e2e8f0 !important; padding: 8px !important; }
    @page { size: landscape; margin: 1cm; }
}
/* DataTables overrides same as teachers view */
#record_table_wrapper .dataTables_filter input {
    @apply border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-2 outline-none ml-2 bg-gray-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300;
}
</style>
