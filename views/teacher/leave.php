<!-- Teacher Leave View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-rose-600 to-orange-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    📅
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">รายงานการลา / ไปราชการ</h2>
                    <p class="text-rose-100/80 mt-1 font-medium italic text-xs md:text-base">
                        <?php echo $userData['Teach_name']; ?> | รายงานสรุปการลารายปี
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button id="addLeave" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-rose-700 text-sm md:text-base font-bold hover:bg-rose-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> แจ้งการลา
                </button>
                <button onclick="printPage()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-rose-500/30 backdrop-blur text-white text-sm md:text-base font-bold hover:bg-rose-500/50 transition-all border border-white/30 flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="glass-morphism rounded-3xl p-4 border border-rose-500/10 hover-scale">
            <div class="flex flex-col items-center text-center space-y-2">
                <div class="w-10 h-10 bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <p class="text-[10px] md:text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest truncate w-full">รวมวันลา</p>
                <h3 id="stat_total" class="text-xl md:text-2xl font-black text-gray-900 dark:text-white">0</h3>
            </div>
        </div>
        <div class="glass-morphism rounded-3xl p-4 border border-blue-500/10 hover-scale text-center">
            <div class="flex flex-col items-center space-y-2">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-thermometer-half"></i>
                </div>
                <p class="text-[10px] md:text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest truncate w-full">ลาป่วย</p>
                <h3 id="stat_sick" class="text-xl md:text-2xl font-black text-gray-900 dark:text-white">0</h3>
            </div>
        </div>
        <div class="glass-morphism rounded-3xl p-4 border border-amber-500/10 hover-scale text-center">
            <div class="flex flex-col items-center space-y-2">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-user-clock"></i>
                </div>
                <p class="text-[10px] md:text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest truncate w-full">ลากิจ</p>
                <h3 id="stat_personal" class="text-xl md:text-2xl font-black text-gray-900 dark:text-white">0</h3>
            </div>
        </div>
        <div class="glass-morphism rounded-3xl p-4 border border-emerald-500/10 hover-scale text-center">
            <div class="flex flex-col items-center space-y-2">
                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-briefcase"></i>
                </div>
                <p class="text-[10px] md:text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest truncate w-full">ไปราชการ</p>
                <h3 id="stat_official" class="text-xl md:text-2xl font-black text-gray-900 dark:text-white">0</h3>
            </div>
        </div>
        <div class="col-span-2 sm:col-span-1 glass-morphism rounded-3xl p-4 border border-gray-500/10 hover-scale text-center">
            <div class="flex flex-col items-center space-y-2">
                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-500/20 text-gray-600 dark:text-gray-400 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-ellipsis-h"></i>
                </div>
                <p class="text-[10px] md:text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest truncate w-full">ลาอื่นๆ</p>
                <h3 id="stat_other" class="text-xl md:text-2xl font-black text-gray-900 dark:text-white">0</h3>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass-morphism rounded-3xl p-6 border border-white/20 shadow-xl">
        <div class="flex flex-col space-y-6">
            <div class="flex flex-wrap gap-2 justify-center" id="dateRangeSelector">
                <button data-range="range1" class="btn-range flex-1 sm:flex-none px-4 py-2 rounded-xl border border-rose-200 dark:border-rose-900/30 text-rose-600 dark:text-rose-400 text-xs md:text-sm font-bold hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-all">ครึ่งปีแรก</button>
                <button data-range="range2" class="btn-range flex-1 sm:flex-none px-4 py-2 rounded-xl border border-rose-200 dark:border-rose-900/30 text-rose-600 dark:text-rose-400 text-xs md:text-sm font-bold hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-all">ครึ่งปีหลัง</button>
                <button data-range="custom" class="btn-range active flex-1 sm:flex-none px-4 py-2 rounded-xl bg-rose-600 text-white text-xs md:text-sm font-bold shadow-lg">กำหนดเอง</button>
            </div>
            
            <div class="flex flex-col md:flex-row gap-6 items-stretch md:items-end">
                <div class="flex-1 space-y-2">
                    <label class="block text-sm font-black text-gray-700 dark:text-gray-300 ml-1">
                        <i class="fas fa-calendar-alt text-rose-500 mr-2"></i>เริ่มวันที่
                    </label>
                    <input type="date" id="select_date_start" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                </div>
                <div class="flex-1 space-y-2">
                    <label class="block text-sm font-black text-gray-700 dark:text-gray-300 ml-1">
                        <i class="fas fa-calendar-check text-rose-500 mr-2"></i>ถึงวันที่
                    </label>
                    <input type="date" id="select_date_end" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                </div>
                <div class="flex gap-3">
                    <button id="filter" class="flex-1 md:flex-none px-8 py-3 rounded-2xl bg-rose-600 text-white font-bold hover:bg-rose-700 transition-all shadow-lg order-2 md:order-1">
                        <i class="fas fa-search mr-2"></i>ค้นหา
                    </button>
                    <button id="reset" class="flex-1 md:flex-none px-8 py-3 rounded-2xl bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-200 transition-all order-1 md:order-2">
                        <i class="fas fa-trash-alt mr-2"></i>ล้าง
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <!-- Table Section -->
    <div class="glass-morphism rounded-3xl p-6 overflow-hidden border border-white/20 shadow-xl">
        <!-- Print Header -->
        <div id="print_header" class="hidden text-center mb-6">
            <div class="flex items-center justify-center gap-4 mb-4">
                <img src="../dist/img/logo-phicha.png" class="w-16 h-16 object-contain">
                <div class="text-left">
                    <h1 class="text-2xl font-black text-black">โรงเรียนพิชัย</h1>
                    <p class="text-sm font-bold text-black">สำนักงานเขตพื้นที่การศึกษามัธยมศึกษาพิษณุโลก อุตรดิตถ์</p>
                </div>
            </div>
            <h2 class="text-xl font-black text-black mb-2">รายงานการลา / ไปราชการ</h2>
            <p class="text-base font-bold text-black mb-4">ประจำปีงบประมาณ <?php echo $pee; ?></p>
        </div>

        <div class="table-responsive">
            <table class="w-full text-left" id="record_table">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">#</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ประเภทการลา</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">เริ่มวันที่</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">ถึงวันที่</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">จำนวนวัน</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">เหตุผล</th>
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

<!-- Modal: Add Leave -->
<div id="leaveModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm animate-fade-in">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-morphism rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
            <div class="p-6 bg-gradient-to-r from-rose-600 to-orange-600 flex justify-between items-center text-white">
                <h3 class="text-xl font-black tracking-tight flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    แจ้งการลา / ไปราชการ
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
                <input type="hidden" name="tid" value="<?= $teacher_id ?>">

                <div class="space-y-4">
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
                        <input type="text" name="other_leave_type" placeholder="เช่น ลาอุปสมบท, ลาศึกษาต่อ" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 outline-none focus:ring-2 focus:ring-rose-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่เริ่มต้น</label>
                            <input type="date" name="date_start" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่สิ้นสุด</label>
                            <input type="date" name="date_end" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 uppercase">เหตุผลการลา</label>
                            <span id="charCount" class="text-[10px] font-bold text-gray-400">0 / 100</span>
                        </div>
                        <textarea name="detail" required maxlength="100" rows="3" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500 outline-none transition-all"></textarea>
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

<script>
$(document).ready(function() {
    const tid = <?= json_encode($teacher_id); ?>;
    const currentPee = <?= json_encode($pee); ?>;
    
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

    function fetchLeaveData() {
        $.ajax({
            url: 'api/fetch_leave.php',
            method: 'GET',
            dataType: 'json',
            data: {
                tid: tid,
                date_start: $('#select_date_start').val(),
                date_end: $('#select_date_end').val()
            },
            success: function(res) {
                if (res.success) {
                    populateTable(res.data);
                } else {
                    recordTable.clear().draw();
                    updateStats([]);
                }
            }
        });
    }

    function populateTable(data) {
        recordTable.clear();
        data.forEach((item, index) => {
            const count = countWeekdays(item.date_start, item.date_end);
            recordTable.row.add([
                index + 1,
                `<div class="font-bold text-gray-900 dark:text-white uppercase">${getLeaveStatusText(item.status)}</div>`,
                `<span class="text-sm font-medium text-gray-600 dark:text-gray-400">${convertToThaiDate(item.date_start)}</span>`,
                `<span class="text-sm font-medium text-gray-600 dark:text-gray-400">${convertToThaiDate(item.date_end)}</span>`,
                `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 dark:bg-rose-500/20 dark:text-rose-400">${count} วัน</span>`,
                `<div class="text-xs text-gray-500 max-w-xs truncate" title="${item.detail}">${item.detail}</div>`,
                `<div class="flex gap-2 justify-center">
                    ${(['1', '2', '4', '9'].includes(item.status)) ? `<a href="print_leave.php?id=${item.id}" target="_blank" class="w-8 h-8 rounded-xl bg-indigo-500 text-white hover:bg-indigo-600 transition-all flex items-center justify-center" title="พิมพ์ใบลา"><i class="fas fa-print text-xs"></i></a>` : ''}
                    
                </div>`
                // <button class="w-8 h-8 rounded-xl bg-rose-500 text-white hover:bg-rose-600 transition-all flex items-center justify-center btn-del" data-id="${item.id}"><i class="fas fa-trash text-xs"></i></button>
            ]);
        });
        recordTable.draw();
        updateStats(data);
        attachActionEvents();
    }

    function updateStats(data) {
        let total = 0, sick = 0, personal = 0, official = 0, other = 0;
        data.forEach(item => {
            const days = countWeekdays(item.date_start, item.date_end);
            total += days;
            if (item.status == '1') sick += days;
            else if (item.status == '2') personal += days;
            else if (item.status == '3') official += days;
            else other += days;
        });
        $('#stat_total').text(total);
        $('#stat_sick').text(sick);
        $('#stat_personal').text(personal);
        $('#stat_official').text(official);
        $('#stat_other').text(other);
    }

    function getLeaveStatusText(status) {
        switch (status) {
            case '1': return 'ลาป่วย';
            case '2': return 'ลากิจ';
            case '3': return 'ไปราชการ';
            case '4': return 'ลาคลอด';
            case '9': return 'อื่นๆ';
            default: return 'ไม่ระบุ';
        }
    }

    function convertToThaiDate(d) {
        if (!d) return '-';
        const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        const date = new Date(d);
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
    }

    function countWeekdays(startDate, endDate) {
        let count = 0;
        let current = new Date(startDate);
        let last = new Date(endDate);
        while (current <= last) {
            const day = current.getDay();
            if (day !== 0 && day !== 6) count++;
            current.setDate(current.getDate() + 1);
        }
        return count;
    }

    function attachActionEvents() {
        $('.btn-del').off('click').on('click', function() { confirmDelete($(this).data('id')); });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลการลาชุดนี้จะถูกลบอย่างถาวร!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก',
            background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#000000',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/del_leave.php',
                    method: 'POST',
                    dataType: 'json',
                    data: { id: id },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('สำเร็จ!', 'ลบข้อมูลการลาเรียบร้อยแล้ว.', 'success');
                            fetchLeaveData();
                        } else {
                            Swal.fire('ผิดพลาด', res.message, 'error');
                        }
                    }
                });
            }
        });
    }

    window.closeModal = function() {
        $('#leaveModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#leaveForm')[0].reset();
        $('#otherLeaveTypeGroup').addClass('hidden');
    }

    $('#addLeave').on('click', function() {
        $('#leaveModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });

    $('#addStatus').on('change', function() {
        if ($(this).val() == '9') $('#otherLeaveTypeGroup').removeClass('hidden');
        else $('#otherLeaveTypeGroup').addClass('hidden');
    });

    $('[name="detail"]').on('input', function() {
        $('#charCount').text($(this).val().length + ' / 100');
    });

    $('#saveBtn').on('click', function() {
        const form = document.getElementById('leaveForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const data = new FormData(form);
        Swal.fire({ title: 'กำลังบันทึก...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        
        $.ajax({
            url: 'api/insert_leave.php',
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
                    fetchLeaveData();
                } else {
                    Swal.fire('ข้อผิดพลาด', res.message, 'error');
                }
            }
        });
    });

    $('.btn-range').on('click', function() {
        $('.btn-range').removeClass('bg-rose-600 text-white shadow-lg').addClass('border border-rose-200 dark:border-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10');
        $(this).removeClass('border border-rose-200 dark:border-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10').addClass('bg-rose-600 text-white shadow-lg');
        
        const range = $(this).data('range');
        const peeInt = parseInt(currentPee) - 543;
        
        if (range === 'range1') {
            $('#select_date_start').val(`${peeInt - 1}-10-01`);
            $('#select_date_end').val(`${peeInt}-03-31`);
            fetchLeaveData();
        } else if (range === 'range2') {
            $('#select_date_start').val(`${peeInt}-04-01`);
            $('#select_date_end').val(`${peeInt}-09-30`);
            fetchLeaveData();
        }
    });

    $('#filter').on('click', fetchLeaveData);
    $('#reset').on('click', function() {
        $('#select_date_start, #select_date_end').val('');
        fetchLeaveData();
        $('.btn-range').removeClass('active bg-rose-600 text-white shadow-lg');
        $('[data-range="custom"]').addClass('bg-rose-600 text-white shadow-lg');
    });

    window.printPage = function() { window.print(); };

    fetchLeaveData();
});
</script>

<style>
.hover-scale { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
.hover-scale:hover { transform: translateY(-5px); }

#record_table_wrapper .dataTables_length, 
#record_table_wrapper .dataTables_filter {
    margin-bottom: 1.5rem;
}
#record_table_wrapper .dataTables_filter input {
    border-radius: 1rem;
    padding-left: 1rem;
    padding-right: 1rem;
    border-color: rgba(226, 232, 240, 0.8);
    background: transparent;
}
.dark #record_table_wrapper .dataTables_filter input {
    border-color: #334155;
    color: white;
}
#record_table thead th { border-bottom: none; }

/* Mobile Responsive Table - Card Style */
@media screen and (max-width: 768px) {
    /* Hide table header and show card layout */
    #record_table thead {
        display: none;
    }
    
    #record_table tbody tr {
        display: flex;
        flex-direction: column;
        background: var(--card-bg, #ffffff);
        border-radius: 1.5rem;
        margin-bottom: 1rem;
        padding: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
    }
    
    .dark #record_table tbody tr {
        --card-bg: #1e293b;
        border-color: rgba(255, 255, 255, 0.1);
    }
    
    #record_table tbody td {
        display: flex;
        align-items: flex-start;
        padding: 0.5rem 0;
        border: none !important;
        text-align: left !important;
    }
    
    #record_table tbody td:first-child {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: linear-gradient(135deg, #e11d48, #ea580c);
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
    }
    
    #record_table tbody td:nth-child(2) {
        padding-right: 3rem;
        padding-top: 0;
        flex-direction: column;
    }
    
    #record_table tbody td:nth-child(3)::before {
        content: "📅 เริ่ม: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        flex-shrink: 0;
    }
    
    #record_table tbody td:nth-child(4)::before {
        content: "📅 ถึง: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        flex-shrink: 0;
    }
    
    #record_table tbody td:nth-child(5)::before {
        content: "⏱️ จำนวน: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        flex-shrink: 0;
    }
    
    #record_table tbody td:nth-child(6) {
        flex-direction: column;
    }
    
    #record_table tbody td:nth-child(6)::before {
        content: "📝 เหตุผล:";
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0.25rem;
        flex-shrink: 0;
    }
    
    #record_table tbody td:nth-child(6) > div {
        max-width: 100%;
        white-space: normal;
    }
    
    /* Actions - full width at bottom */
    #record_table tbody td:last-child {
        border-top: 1px dashed rgba(0, 0, 0, 0.1) !important;
        padding-top: 1rem;
        margin-top: 0.5rem;
        justify-content: center;
    }
    
    .dark #record_table tbody td:last-child {
        border-top-color: rgba(255, 255, 255, 0.1) !important;
    }
    
    #record_table tbody td:last-child > div {
        gap: 0.75rem;
        width: 100%;
        display: flex;
        justify-content: center;
    }
    
    #record_table tbody td:last-child a,
    #record_table tbody td:last-child button {
        flex: 1;
        max-width: 100px;
        height: 36px;
        border-radius: 0.75rem;
    }
    
    /* DataTables pagination and info */
    #record_table_wrapper .dataTables_length,
    #record_table_wrapper .dataTables_filter {
        width: 100%;
        margin-bottom: 1rem;
    }
    
    #record_table_wrapper .dataTables_filter input {
        width: 100%;
        margin-top: 0.5rem;
    }
    
    #record_table_wrapper .dataTables_paginate {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.25rem;
        margin-top: 1rem;
    }
    
    #record_table_wrapper .dataTables_info {
        text-align: center;
        font-size: 0.75rem;
        padding: 0.5rem 0;
    }
    
    /* Table section padding */
    .table-responsive {
        padding: 0.5rem;
    }
    
    /* Date range buttons on mobile */
    #dateRangeSelector {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    
    #dateRangeSelector button {
        white-space: nowrap;
        min-width: auto;
    }
}

/* Modal Mobile Styles */
@media screen and (max-width: 640px) {
    #leaveModal > div {
        padding: 0.5rem;
    }
    
    #leaveModal .max-w-2xl {
        max-width: 100%;
        margin: 0;
        border-radius: 1.5rem;
    }
    
    #leaveModal form {
        padding: 1rem;
    }
    
    #leaveModal .p-6.bg-gradient-to-r {
        padding: 1rem;
    }
    
    #leaveModal .p-6.border-t {
        padding: 1rem;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    #leaveModal .p-6.border-t button {
        width: 100%;
    }
    
    /* Grid adjustments in form */
    #leaveModal .grid.grid-cols-1.md\\:grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    /* Warning banner */
    #leaveModal .p-4.bg-rose-50 {
        padding: 0.75rem;
    }
    
    #leaveModal .p-4.bg-rose-50 p {
        font-size: 0.65rem;
    }
}

/* Small mobile adjustments */
@media screen and (max-width: 480px) {
    .glass-morphism.rounded-3xl.p-6 {
        padding: 1rem;
        border-radius: 1.25rem;
    }
    
    #record_table tbody td:first-child {
        top: 0.5rem;
        right: 0.5rem;
        width: 24px;
        height: 24px;
        font-size: 0.65rem;
    }
    
    /* Summary stats adjustments */
    .grid.grid-cols-2.sm\\:grid-cols-3.lg\\:grid-cols-5 {
        gap: 0.5rem;
    }
    
    .grid.grid-cols-2.sm\\:grid-cols-3.lg\\:grid-cols-5 .glass-morphism {
        padding: 0.75rem;
    }
    
    /* Reduce hover-scale effect on mobile */
    .hover-scale:hover {
        transform: translateY(-2px);
    }
}

@media print {
    /* Layout Reset */
    .glass-morphism { background: white !important; box-shadow: none !important; border: none !important; padding: 0 !important; }
    .animate-fade-in { animation: none !important; }
    
    /* Hide Elements */
    button, #leaveModal, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info, .no-print, #dateRangeSelector, #addLeave, #filter, #reset { display: none !important; }
    
    /* Force Text Color */
    body, p, span, div, td, th, h1, h2, h3, h4, h5, h6 { 
        color: black !important; 
        text-shadow: none !important;
        -webkit-text-fill-color: black !important;
    }
    
    /* Table Styling */
    #print_header { display: block !important; margin-bottom: 2rem !important; }
    #record_table { width: 100% !important; border-collapse: collapse !important; font-size: 10pt !important; }
    #record_table th, #record_table td { border: 1px solid black !important; padding: 8px !important; text-align: center !important; }
    #record_table th { background-color: #f3f4f6 !important; font-weight: bold !important; }
    
    /* Header/Footer adjustments */
    @page { margin: 1.5cm; size: A4 portrait; }
    
    /* Reveal Hidden Elements for Print */
    #record_table thead { display: table-header-group !important; }
    #record_table tbody tr { display: table-row !important; page-break-inside: avoid; border: 1px solid black !important; }
    #record_table tbody td { display: table-cell !important; border: 1px solid black !important; }
    
    /* Hide Mobile Card Elements */
    #record_table tbody td::before { display: none !important; }
    #record_table tbody td:first-child { position: static !important; background: none !important; color: black !important; width: auto !important; height: auto !important; border-radius: 0 !important; }
    #record_table tbody td:nth-child(2) { padding-right: 8px !important; }
    
    /* Hide Icons */
    i { display: none !important; }
}
</style>
