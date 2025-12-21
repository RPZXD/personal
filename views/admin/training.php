<!-- Admin Training View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-500 to-orange-600 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">รายงานการฝึกอบรม</h2>
                    <p class="text-amber-100/80 mt-1 font-medium italic text-xs md:text-base">
                        ติดตามการพัฒนาตนเองของบุคลากร
                    </p>
                </div>
            </div>
            <div class="flex justify-center gap-3 w-full md:w-auto">
                 <button onclick="printPage()" class="px-6 py-2.5 md:py-3 rounded-2xl bg-white text-orange-600 text-sm md:text-base font-bold hover:bg-orange-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์รายงาน
                </button>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="glass-morphism rounded-3xl p-6 border border-white/20 shadow-xl space-y-6 text-sm">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">กลุ่มสาระ</label>
                <select id="select_department" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                    <option value="">เลือกกลุ่ม</option>
                    <?php foreach ($majors as $major): ?>
                        <option value="<?= $major['Teach_major'] ?>"><?= $major['Teach_major'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">เลือกครู</label>
                <select id="select_teacher" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                    <option value="">เลือกครู</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">ภาคเรียน</label>
                <select id="select_term" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                    <option value="">ทั้งหมด</option>
                    <option value="1">ภาคเรียนที่ 1</option>
                    <option value="2">ภาคเรียนที่ 2</option>
                </select>
            </div>
             <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">ปีการศึกษา</label>
                <select id="select_year" class="w-full px-4 py-3 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($years as $year): ?>
                        <option value="<?= $year['year'] ?>"><?= $year['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
             <button id="resetBtn" class="px-6 py-2.5 rounded-xl bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-200 transition-all uppercase tracking-wider text-xs">ล้างค่า</button>
             <button id="filterBtn" class="px-8 py-2.5 rounded-xl bg-amber-500 text-white font-bold hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20 uppercase tracking-wider text-xs">ค้นหา</button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="glass-morphism rounded-3xl p-6 overflow-hidden border border-white/20 shadow-xl">
        <div class="mb-6 hidden" id="printHeader">
            <h4 class="text-lg font-black text-slate-800 text-center">รายงานการฝึกอบรม</h4>
            <div class="flex justify-between text-sm mt-4">
                <p>ชื่อ-สกุล: <span id="display_name" class="font-bold underline dotted"></span></p>
                <p>กลุ่มสาระ: <span id="display_dept" class="font-bold underline dotted"></span></p>
            </div>
            <div class="flex justify-between text-sm mt-2">
                <p>ปีการศึกษา: <span id="display_year" class="font-bold"></span></p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="w-full text-left border-collapse" id="record_table">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700 text-slate-500 dark:text-slate-400">
                        <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-center w-10">#</th>
                        <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest w-1/3">หัวข้อการอบรม</th>
                        <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-center">วันที่</th>
                        <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-center">จำนวนชั่วโมง</th>
                        <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-center">ภาคเรียน/ปี</th>
                        <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-center">หน่วยงาน/สถานที่</th>
                        <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-center">หลักฐาน</th>
                        <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-center no-print w-24">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                </tbody>
                <tfoot class="border-t-2 border-amber-500/20 bg-amber-50/50 dark:bg-amber-900/10 text-amber-900 dark:text-amber-100">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-black text-xs uppercase tracking-widest">รวมชั่วโมงทั้งหมด</td>
                        <td id="total_hours_footer" class="px-4 py-3 text-center font-black text-lg">-</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 backdrop-blur-sm animate-fade-in">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="glass-morphism rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
                <div class="p-6 bg-gradient-to-r from-amber-500 to-orange-500 flex justify-between items-center text-white">
                    <h3 class="text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        แก้ไขข้อมูลการอบรม
                    </h3>
                    <button onclick="closeEditModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="editForm" class="p-8 space-y-6">
                    <input type="hidden" name="id" id="editTrainingId">
                    <input type="hidden" name="tid" id="editTeacherId">
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                           <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">หัวข้อการอบรม</label>
                           <input type="text" name="training_name" id="editTrainingName" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                             <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่เริ่มต้น</label>
                                <input type="date" name="start_date" id="editStartDate" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                             </div>
                             <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันที่สิ้นสุด</label>
                                <input type="date" name="end_date" id="editEndDate" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                             </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                             <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ภาคเรียน</label>
                                <select name="term" id="editTerm" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                             </div>
                             <div class="space-y-2">
                                <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ปีการศึกษา</label>
                                <input type="text" name="year" id="editYear" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                             </div>
                        </div>
                        
                        <div class="space-y-2">
                           <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">สถานที่</label>
                           <input type="text" name="location" id="editLocation" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-amber-500 outline-none transition-all font-bold">
                        </div>
                    </div>
                </form>
                
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end gap-3">
                    <button onclick="closeEditModal()" class="px-6 py-2.5 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">ยกเลิก</button>
                    <button id="saveEdit" class="px-8 py-2.5 rounded-2xl bg-amber-600 text-white font-bold hover:bg-amber-700 transition-all shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> บันทึกการแก้ไข
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
    // Initialize DataTables
    const table = $('#record_table').DataTable({
        pageLength: 50,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        language: {
             emptyTable: "กรุณาเลือกครูเพื่อค้นหาข้อมูล",
             search: "ค้นหา:",
             paginate: { next: "ถัดไป", previous: "ก่อนหน้า" }
        },
        columnDefs: [
            { className: "text-center align-middle", targets: [0, 2, 3, 5, 6] },
            { className: "align-middle", targets: [1, 4] },
            { orderable: false, targets: [6] }
        ]
    });

    // Filters
    $('#select_department').change(function() {
        const dept = $(this).val();
        if (dept) {
            $.getJSON('api/fetch_teachers.php', { department: dept }, function(res) {
                 if (res.success) {
                     const sel = $('#select_teacher');
                     sel.empty().append('<option value="">เลือกครู</option>');
                     res.data.forEach(t => sel.append(`<option value="${t.Teach_id}">${t.Teach_name}</option>`));
                 }
            });
        }
    });

    $('#filterBtn').click(fetchData);
    $('#resetBtn').click(function() {
        $('#select_department, #select_teacher, #select_term, #select_year').val('');
        table.clear().draw();
        $('#total_hours_footer').text('-');
        $('#display_name, #display_dept, #display_year').text('');
    });

    function fetchData() {
        const tid = $('#select_teacher').val();
        const term = $('#select_term').val();
        const year = $('#select_year').val();

        if (!tid) { Swal.fire('โปรดเลือกครู', 'กรุณาระบุครูที่ต้องการค้นหา', 'warning'); return; }

        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.when(
             $.getJSON('api/fetch_training.php', { tid, term, year }),
             $.getJSON('api/fetch_training_hours.php', { tid, term, year })
        ).done(function(trainingRes, hoursRes) {
             Swal.close();
             if (trainingRes[0].success) {
                 populateTable(trainingRes[0].data);
                 // Update header infos
                 $('#display_name').text($('#select_teacher option:selected').text());
                 $('#display_dept').text($('#select_department option:selected').text());
                 $('#display_year').text($('#select_year option:selected').val() || 'ทั้งหมด');
             } else {
                 Swal.fire('ผิดพลาด', trainingRes[0].message, 'error');
             }
             
             if (hoursRes[0].success) {
                 $('#total_hours_footer').text(`${hoursRes[0].total_hours} ชม. ${hoursRes[0].total_minutes} นาที`);
             } else {
                 $('#total_hours_footer').text('-');
             }
        }).fail(function() {
             Swal.fire('ผิดพลาด', 'ไม่สามารถดึงข้อมูลได้', 'error');
        });
    }

    function populateTable(data) {
        table.clear();
        data.forEach((row, idx) => {
            let certImg = '';
            if (row.sdoc) {
                const basePath = 'uploads/file_seminar/';
                certImg = `<div onclick="openImageModal('${basePath}${row.sdoc}')" class="cursor-pointer block w-20 mx-auto rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all group border border-gray-100 dark:border-gray-700">
                    <img src="${basePath}${row.sdoc}" class="w-full h-12 object-cover group-hover:scale-110 transition-transform" onerror="this.parentElement.style.display='none'">
                </div>`;
            } else {
                certImg = '<span class="text-xs text-gray-400">-</span>';
            }

            table.row.add([
                idx + 1,
                `<p class="font-bold text-slate-700 dark:text-slate-200">${row.topic}</p>`,
                 formatDate(row.dstart) + ' - ' + formatDate(row.dend),
                `<span class="badge bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-xs font-bold">${row.hours} ชม. ${row.mn} น.</span>`,
                row.term + '/' + row.year,
                row.supports,
                certImg,
                `<button onclick="editTraining(${row.semid})" class="text-blue-500 hover:text-blue-700 no-print transition-colors p-2 rounded-full hover:bg-blue-50"><i class="fas fa-edit"></i></button>`
            ]);
        });
        table.draw();
    }

    function formatDate(dateStr) {
        const d = new Date(dateStr);
        const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear() + 543}`;
    }

    window.editTraining = (id) => {
        $.getJSON('api/get_training.php', { id }, function(res) {
            if (res.success) {
                const d = res.data;
                $('#editTrainingId').val(d.training_id || d.semid); // Handle potential ID naming mismatch
                $('#editTeacherId').val(d.tid);
                $('#editTrainingName').val(d.topic || d.training_name);
                $('#editStartDate').val(d.dstart || d.start_date);
                $('#editEndDate').val(d.dend || d.end_date);
                $('#editTerm').val(d.term);
                $('#editYear').val(d.year);
                $('#editLocation').val(d.location);
                
                $('#editModal').removeClass('hidden');
            }
        });
    };
    
    window.closeEditModal = () => $('#editModal').addClass('hidden');

    window.openImageModal = function(src) {
        $('#modal_image_src').attr('src', src);
        $('#imageModal').removeClass('hidden').addClass('flex');
        $('body').addClass('overflow-hidden');
    }

    window.closeImageModal = function() {
        $('#imageModal').addClass('hidden').removeClass('flex');
        if (!$('#editModal').is(':visible')) {
            $('body').removeClass('overflow-hidden');
        }
    }
    
    $('#saveEdit').click(function() {
        const form = document.getElementById('editForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const data = Object.fromEntries(new FormData(form).entries());
        $.post('api/update_training.php', JSON.stringify(data), function(res) {
             if (res && (res.success || res === true)) { // Handle weak API responses
                 Swal.fire('สำเร็จ', 'บันทึกเรียบร้อย', 'success');
                 closeEditModal();
                 fetchData();
             } else {
                 Swal.fire('ผิดพลาด', res.message || 'บันทึกไม่สำเร็จ', 'error');
             }
        }, 'json');
    });

    window.printPage = () => window.print();
});
</script>

<style>
@media print {
    #printHeader { display: block !important; }
    .no-print, nav, aside { display: none !important; }
    table { width: 100% !important; border-collapse: collapse !important; font-size: 10pt !important; }
    th, td { border: 1px solid black !important; padding: 5px !important; color: black !important; }
    @page { size: landscape; margin: 1cm; }
}

@keyframes zoom-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-zoom-in { animation: zoom-in 0.3s ease-out; }
</style>
