<!-- Admin Teachers Management View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-600 to-indigo-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">จัดการข้อมูลครูและบุคลากร</h2>
                    <p class="text-purple-100/80 mt-1 font-medium italic text-xs md:text-base">
                        รายชื่อบุคลากรทั้งหมดในระบบโรงเรียนพิชัย
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button onclick="openAddModal()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-purple-600 text-sm md:text-base font-bold hover:bg-purple-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle"></i> เพิ่มข้อมูลครู
                </button>
                <button onclick="openUploadModal()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white/20 backdrop-blur text-white text-sm md:text-base font-bold hover:bg-white/30 transition-all border border-white/30 flex items-center justify-center gap-2">
                    <i class="fas fa-file-excel"></i> เพิ่มจาก Excel
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
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ชื่อ - นามสกุล</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">กลุ่มสาระ</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ตำแหน่ง</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">สถานะ</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">รูปภาพ</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">บทบาท</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    <!-- Loaded by AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Add/Edit Teacher -->
    <div id="teacherModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 backdrop-blur-sm animate-fade-in">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="glass-morphism rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
                <div class="p-6 bg-gradient-to-r from-purple-600 to-indigo-600 flex justify-between items-center text-white">
                    <h3 id="modalTitle" class="text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        แก้ไขข้อมูลครู
                    </h3>
                    <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="teacherForm" class="p-8 space-y-6">
                    <input type="hidden" name="teach_id_old" id="teach_id_old">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">Username (5 หลัก)</label>
                            <input type="text" name="teach_id" id="teach_id" maxlength="5" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">Password</label>
                            <input type="text" name="teach_pass" id="teach_pass" maxlength="20" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all">
                        </div>
                        
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ชื่อ - นามสกุล <span class="text-purple-500 text-[10px]">(ต้องระบุคำนำหน้า)</span></label>
                            <input type="text" name="teach_name" id="teach_name" maxlength="200" required placeholder="เช่น นายสมชาย ใจดี" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all font-bold">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">กลุ่มสาระ</label>
                            <select name="teach_major" id="teach_major" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none">
                                <option value="">-- โปรดเลือกกลุ่มสาระ --</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ตำแหน่ง</label>
                            <select name="teach_position2" id="teach_position2" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none">
                                <option value="">-- โปรดเลือกตำแหน่ง --</option>
                                <option value="ผู้บริหาร">ผู้บริหาร</option>
                                <option value="ครู">ครู</option>
                                <option value="พนักงานราชการ">พนักงานราชการ</option>
                                <option value="ลูกจ้างประจำ">ลูกจ้างประจำ</option>
                                <option value="ลูกจ้างชั่วคราว (สพฐ.)">ลูกจ้างชั่วคราว (สพฐ.)</option>
                                <option value="ลูกจ้างชั่วคราว (บกศ.)">ลูกจ้างชั่วคราว (บกศ.)</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ที่ปรึกษาระดับชั้น</label>
                            <select name="teach_class" id="teach_class" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none">
                                <?php for($i=0;$i<=6;$i++) echo "<option value='$i'>$i</option>"; ?>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ห้อง</label>
                            <select name="teach_room" id="teach_room" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none">
                                <?php for($i=0;$i<=12;$i++) echo "<option value='$i'>$i</option>"; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">สถานะ</label>
                            <select name="teach_status" id="teach_status" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none">
                                <option value="1">ปกติ</option>
                                <option value="2">ย้าย รร.</option>
                                <option value="3">เกษียณอายุราชการ</option>
                                <option value="4">ลาออก</option>
                                <option value="9">เสียชีวิต</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">บทบาทในระบบ</label>
                            <select name="role_person" id="role_person" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none">
                                <option value="T">ครู</option>
                                <option value="OF">เจ้าหน้าที่</option>
                                <option value="VP">รองผู้อำนวยการ</option>
                                <option value="DIR">ผู้อำนวยการ</option>
                                <option value="ADM">Admin</option>
                            </select>
                        </div>
                    </div>
                </form>
                
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end gap-3">
                    <button onclick="closeModal()" class="px-6 py-2.5 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">ยกเลิก</button>
                    <button id="saveBtn" class="px-8 py-2.5 rounded-2xl bg-purple-600 text-white font-bold hover:bg-purple-700 transition-all shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Upload Excel -->
    <div id="uploadModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 backdrop-blur-sm animate-fade-in">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="glass-morphism rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
                <div class="p-6 bg-gradient-to-r from-emerald-600 to-teal-600 flex justify-between items-center text-white">
                    <h3 class="text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-file-excel"></i>
                        อัพโหลดไฟล์ Excel
                    </h3>
                    <button onclick="closeUploadModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-500 flex items-center justify-center text-white shrink-0 shadow-lg">
                                <i class="fas fa-cloud-download-alt text-xl"></i>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm font-black text-amber-800 dark:text-amber-400">ต้องการแม่แบบไฟล์หรือไม่?</p>
                                <p class="text-xs text-amber-700 dark:text-amber-300/80 leading-relaxed font-medium">กรุณาใช้ไฟล์ตามรูปแบบที่เรากำหนดเพื่อให้การอัพโหลดถูกต้องสมบูรณ์</p>
                                <a href="template/teacher_template.xlsx" class="inline-block mt-2 text-xs font-black text-amber-600 dark:text-amber-400 hover:underline">ดาวน์โหลดไฟล์ตัวอย่าง .xlsx</a>
                            </div>
                        </div>
                    </div>

                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="space-y-4">
                            <label class="block text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เลือกไฟล์บุคลากร (.xlsx)</label>
                            <label class="group relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-3xl cursor-pointer hover:border-emerald-500 dark:hover:border-emerald-400 hover:bg-emerald-50/50 dark:hover:bg-emerald-500/5 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-file-import text-3xl text-gray-400 group-hover:text-emerald-500 mb-2 transition-colors"></i>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-bold" id="fileName">คลิกเพื่อเลือกไฟล์ หรือลากมาวาง</p>
                                </div>
                                <input type="file" name="excelFile" id="excelFile" accept=".xlsx" class="hidden" onchange="updateFileName(this)">
                            </label>
                        </div>
                    </form>
                </div>
                
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end gap-3">
                    <button onclick="closeUploadModal()" class="px-6 py-2.5 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">ยกเลิก</button>
                    <button id="uploadBtn" class="px-8 py-2.5 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-all shadow-lg flex items-center gap-2">
                        <i class="fas fa-cloud-upload-alt"></i> เริ่มการอัพโหลด
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Image Preview -->
<div id="imageModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 backdrop-blur-md transition-all duration-300">
    <div class="absolute top-6 right-6 z-50">
        <button onclick="closeImageModal()" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all group">
            <i class="fas fa-times text-xl group-hover:rotate-90 transition-transform duration-300"></i>
        </button>
    </div>
    <div class="relative w-full max-w-5xl p-4 animate-zoom-in">
        <img id="modal_image_src" src="" class="w-auto max-w-full max-h-[85vh] mx-auto rounded-xl shadow-2xl border border-white/10">
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
            "emptyTable": "ไม่พบข้อมูลบุคลากร",
            "search": "ค้นหา:",
            "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
        },
        "columnDefs": [
            { "className": "text-center", "targets": [0, 5, 6, 7, 8] },
            { "orderable": false, "targets": [6, 8] }
        ]
    });

    // Load initial data
    loadTableData();

    // Fetch majors for dropdowns
    $.getJSON('api/fet_major.php', function(res) {
        const select = $('#teach_major');
        select.empty().append('<option value="">-- โปรดเลือกกลุ่มสาระ --</option>');
        res.forEach(m => {
            select.append(`<option value="${m.Teach_major}">${m.Teach_major}</option>`);
        });
    });

    function loadTableData() {
        $.ajax({
            url: 'api/fet_teacher.php',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                recordTable.clear();
                res.forEach((item, index) => {
                    recordTable.row.add([
                        index + 1,
                        `<span class="font-mono text-xs font-bold text-slate-500">${item.Teach_id}</span>`,
                        `<span class="font-bold text-slate-800 dark:text-slate-200">${item.Teach_name}</span>`,
                        `<span class="text-sm font-medium text-slate-600 dark:text-slate-400">${item.Teach_major}</span>`,
                        `<span class="px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">${item.Teach_Position2}</span>`,
                        getStatusBadge(item.Teach_status),
                        `<div class="flex justify-center">
                            <div onclick="openImageModal('../dist/img/person/${item.Teach_photo}')" class="w-10 h-10 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm bg-slate-100 dark:bg-slate-800 cursor-pointer group">
                                <img src="../dist/img/person/${item.Teach_photo}" class="w-full h-full object-cover group-hover:scale-110 transition-transform" onerror="this.src='../dist/img/avatar.png'">
                            </div>
                         </div>`,
                        getRoleBadge(item.role_person),
                        `<div class="flex gap-2 justify-center">
                            <button onclick="editTeacher('${item.Teach_id}')" class="w-8 h-8 rounded-xl bg-purple-500 text-white hover:bg-purple-600 transition-all flex items-center justify-center shadow-lg shadow-purple-500/20"><i class="fas fa-edit text-xs"></i></button>
                            <button onclick="deleteTeacher('${item.Teach_id}')" class="w-8 h-8 rounded-xl bg-rose-500 text-white hover:bg-rose-600 transition-all flex items-center justify-center shadow-lg shadow-rose-500/20"><i class="fas fa-trash text-xs"></i></button>
                        </div>`
                    ]);
                });
                recordTable.draw();
            }
        });
    }

    function getStatusBadge(s) {
        const statuses = {
            '1': { text: 'ปกติ', class: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' },
            '2': { text: 'ย้าย รร.', class: 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' },
            '3': { text: 'เกษียณ', class: 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400' },
            '4': { text: 'ลาออก', class: 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400' },
            '9': { text: 'เสียชีวิต', class: 'bg-slate-100 text-slate-700 dark:bg-slate-500/20 dark:text-slate-400' }
        };
        const status = statuses[s] || { text: 'ไม่ทราบ', class: 'bg-gray-100 text-gray-700' };
        return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold ${status.class}">${status.text}</span>`;
    }

    function getRoleBadge(r) {
        const roles = {
            'DIR': { text: 'ผอ.', class: 'bg-purple-600 text-white' },
            'VP': { text: 'รองฯ', class: 'bg-indigo-600 text-white' },
            'HOD': { text: 'หน.กลุ่ม', class: 'bg-blue-600 text-white' },
            'T': { text: 'ครู', class: 'bg-emerald-600 text-white' },
            'OF': { text: 'เจ้าหน้าที่', class: 'bg-slate-600 text-white' },
            'ADM': { text: 'Admin', class: 'bg-black text-white' }
        };
        const role = roles[r] || { text: 'บุคลากร', class: 'bg-gray-600 text-white' };
        return `<span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-black uppercase shadow-sm ${role.class}">${role.text}</span>`;
    }

    // Modal Handlers
    window.closeModal = function() {
        $('#teacherModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#teacherForm')[0].reset();
        $('#teach_id_old').val('');
    };

    window.openImageModal = function(src) {
        $('#modal_image_src').attr('src', src);
        $('#imageModal').removeClass('hidden').addClass('flex');
        $('body').addClass('overflow-hidden');
    }

    window.closeImageModal = function() {
        $('#imageModal').addClass('hidden').removeClass('flex');
        if (!$('#teacherModal').is(':visible') && !$('#uploadModal').is(':visible')) {
            $('body').removeClass('overflow-hidden');
        }
    }

    window.openAddModal = function() {
        $('#modalTitle').html('<i class="fas fa-plus-circle"></i> เพิ่มข้อมูลครูใหม่');
        $('#teach_id_old').val('');
        $('#teacherModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    };

    window.editTeacher = function(id) {
        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        $.getJSON('api/get_teacher.php', { teacher_id: id }, function(data) {
            Swal.close();
            if (data) {
                $('#modalTitle').html('<i class="fas fa-edit"></i> แก้ไขข้อมูลครู');
                $('#teach_id_old').val(data.Teach_id);
                $('#teach_id').val(data.Teach_id);
                $('#teach_pass').val(data.Teach_password);
                $('#teach_name').val(data.Teach_name);
                $('#teach_major').val(data.Teach_major);
                $('#teach_position2').val(data.Teach_Position2);
                $('#teach_status').val(data.Teach_status);
                $('#role_person').val(data.role_person);
                $('#teach_class').val(data.Teach_class);
                $('#teach_room').val(data.Teach_room);
                
                $('#teacherModal').removeClass('hidden');
                $('body').addClass('overflow-hidden');
            }
        });
    };

    $('#saveBtn').on('click', function() {
        const form = document.getElementById('teacherForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const isEdit = $('#teach_id_old').val() !== '';
        // Note: Legacy APIs expect form-urlencoded or specific POST structures
        const formData = new FormData(form);
        const url = isEdit ? 'api/update_teacher.php' : 'api/insert_teacher.php';
        
        // Convert FormData to URLSearchParams for legacy API compatibility
        const params = new URLSearchParams();
        for (const pair of formData) {
            // Map new field names to legacy ones expected by API
            let key = pair[0];
            if (isEdit) {
                if (key === 'teach_id') key = 'editTeach_id';
                if (key === 'teach_id_old') key = 'editTeach_id_old';
                if (key === 'teach_pass') key = 'editTeach_pass';
                if (key === 'teach_name') key = 'editTeach_name';
                if (key === 'teach_major') key = 'editTeach_major';
                if (key === 'teach_position2') key = 'editTeach_position2';
                if (key === 'teach_status') key = 'editTeach_status';
                if (key === 'role_person') key = 'editrole_person';
                if (key === 'teach_class') key = 'editTeach_class';
                if (key === 'teach_room') key = 'editTeach_room';
            } else {
                if (key === 'teach_id') key = 'addTeach_id';
                if (key === 'teach_pass') key = 'addTeach_pass';
                if (key === 'teach_name') key = 'addTeach_name';
                if (key === 'teach_major') key = 'addTeach_major';
                if (key === 'teach_position2') key = 'addTeach_position2';
                if (key === 'teach_status') key = 'addTeach_status';
                if (key === 'role_person') key = 'addrole_std'; // Note the difference in legacy API
                if (key === 'teach_class') key = 'addTeach_class';
                if (key === 'teach_room') key = 'addTeach_room';
                if (key === 'teach_id_old') continue;
            }
            params.append(key, pair[1]);
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: params.toString(),
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: isEdit ? 'แก้ไขข้อมูลเรียบร้อย' : 'เพิ่มข้อมูลเรียบร้อย', timer: 1500, showConfirmButton: false });
                    closeModal();
                    loadTableData();
                } else {
                    Swal.fire('ผิดพลาด', res.message || 'ไม่สามารถดำเนินการได้', 'error');
                }
            }
        });
    });

    window.deleteTeacher = function(id) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลบุคลากรนี้จะถูกลบอย่างถาวร!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/delete_teacher.php',
                    method: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('สำเร็จ!', 'ลบข้อมูลเรียบร้อยแล้ว.', 'success');
                            loadTableData();
                        } else {
                            Swal.fire('ผิดพลาด', res.message, 'error');
                        }
                    }
                });
            }
        });
    };

    // Upload Handlers
    window.openUploadModal = function() {
        $('#uploadModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    };

    window.closeUploadModal = function() {
        $('#uploadModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#uploadForm')[0].reset();
        $('#fileName').text('คลิกเพื่อเลือกไฟล์ หรือลากมาวาง');
    };

    window.updateFileName = function(input) {
        if (input.files && input.files[0]) {
            $('#fileName').text(input.files[0].name);
        }
    };

    $('#uploadBtn').on('click', function() {
        const formData = new FormData($('#uploadForm')[0]);
        if (!$('#excelFile')[0].files[0]) {
            Swal.fire('โปรดเลือกไฟล์', 'กรุณาเลือกไฟล์ .xlsx ก่อนอัพโหลด', 'warning');
            return;
        }

        Swal.fire({ title: 'กำลังอัพโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        $.ajax({
            url: 'api/upload_teacher_excel.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    Swal.fire('สำเร็จ!', 'อัพโหลดข้อมูลเรียบร้อยแล้ว', 'success');
                    closeUploadModal();
                    loadTableData();
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            }
        });
    });
});
</script>

<style>
/* Custom DataTables styling for Admin */
#record_table_wrapper .dataTables_length select {
    @apply border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-1 outline-none mr-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300;
}
#record_table_wrapper .dataTables_filter input {
    @apply border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 outline-none ml-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300;
}
#record_table_wrapper .dataTables_paginate .paginate_button {
    @apply rounded-xl border-none font-bold text-xs !important;
}
#record_table_wrapper .dataTables_paginate .paginate_button.current {
    @apply bg-purple-600 text-white !important;
}

@keyframes zoom-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-zoom-in { animation: zoom-in 0.3s ease-out; }
</style>
