<!-- Teacher Training View -->
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-teal-700 p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 text-center md:text-left">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    📚
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight">รายงานการอบรม/สัมมนา</h2>
                    <p class="text-emerald-100/80 mt-1 font-medium italic text-xs md:text-base">
                        <?php echo $userData['Teach_name']; ?> | <span id="selected_term_display">-</span> ปีการศึกษา <span id="selected_year_display">-</span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto">
                <button id="addTraining" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-white text-emerald-700 text-sm md:text-base font-bold hover:bg-emerald-50 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> เพิ่มข้อมูล
                </button>
                <button onclick="printPage()" class="flex-1 md:flex-none px-4 md:px-6 py-2.5 md:py-3 rounded-2xl bg-emerald-500/30 backdrop-blur text-white text-sm md:text-base font-bold hover:bg-emerald-500/50 transition-all border border-white/30 flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-emerald-500/10">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-3 md:gap-4 text-center md:text-left">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl shrink-0">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] md:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider truncate">ชั่วโมงรวม</p>
                    <h3 id="total_hours" class="text-lg md:text-2xl font-black text-gray-900 dark:text-white mt-1">-</h3>
                </div>
            </div>
        </div>
        <div class="glass-morphism rounded-3xl p-4 md:p-6 border border-blue-500/10">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-3 md:gap-4 text-center md:text-left">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl shrink-0">
                    <i class="fas fa-list-ol"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] md:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider truncate">รายการ</p>
                    <h3 id="total_count" class="text-lg md:text-2xl font-black text-gray-900 dark:text-white mt-1">-</h3>
                </div>
            </div>
        </div>
        <div class="col-span-2 lg:col-span-1 glass-morphism rounded-3xl p-4 md:p-6 border border-amber-500/10">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-3 md:gap-4 text-center md:text-left">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl shrink-0">
                    <i class="fas fa-baht-sign"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] md:text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider truncate">งบประมาณ</p>
                    <h3 id="total_budget_display" class="text-lg md:text-2xl font-black text-gray-900 dark:text-white mt-1">-</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass-morphism rounded-3xl p-6">
        <div class="flex flex-col lg:flex-row gap-6 items-stretch lg:items-end">
            <div class="flex-1 space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                    <i class="fas fa-calendar-alt text-emerald-500 mr-2"></i>เลือกภาคเรียน
                </label>
                <select id="select_term" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                    <option value="">ทั้งหมด</option>
                    <option value="1">ภาคเรียนที่ 1</option>
                    <option value="2">ภาคเรียนที่ 2</option>
                </select>
            </div>
            <div class="flex-1 space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                    <i class="fas fa-calendar-check text-emerald-500 mr-2"></i>เลือกปีการศึกษา
                </label>
                <select id="select_year" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($years as $year): ?>
                    <option value="<?= $year['year'] ?>" <?= $year['year'] == $pee ? 'selected' : '' ?>><?= $year['year'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex gap-3 mt-2 lg:mt-0">
                <button id="filter" class="flex-1 lg:flex-none px-8 py-3 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-all shadow-lg order-2 lg:order-1">
                    <i class="fas fa-search mr-2"></i>ค้นหา
                </button>
                <button id="reset" class="flex-1 lg:flex-none px-8 py-3 rounded-2xl bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-200 transition-all order-1 lg:order-2">
                    <i class="fas fa-redo mr-2"></i>ล้าง
                </button>
            </div>
        </div>
    </div>

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
            <h2 class="text-xl font-black text-black mb-2">รายงานการอบรม/สัมมนา</h2>
            <p class="text-base font-bold text-black mb-4">
                <?php echo $userData['Teach_name']; ?> | <span id="print_year_display">ปีการศึกษา <?php echo $pee; ?></span>
            </p>
        </div>

        <div class="table-responsive">
            <table class="w-full text-left" id="record_table">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">#</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ชื่อเรื่องการอบรม/สัมมนา</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">วันที่</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">จำนวนชั่วโมง</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">เทอม/ปี</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">หลักฐาน</th>
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

<!-- Modal: Add/Edit Training -->
<div id="trainingModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm animate-fade-in">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-morphism rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
            <div class="p-6 bg-gradient-to-r from-emerald-600 to-teal-600 flex justify-between items-center text-white">
                <h3 id="modalTitle" class="text-xl font-black tracking-tight flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    เพิ่มข้อมูลการอบรม/สัมมนา
                </h3>
                <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="trainingForm" enctype="multipart/form-data" class="p-8 space-y-6 max-h-[75vh] overflow-y-auto scrollbar-thin">
                <input type="hidden" id="training_id" name="semid">
                <input type="hidden" name="tid" value="<?= $teacher_id ?>">

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">หัวข้อเรื่องการอบรม</label>
                        <input type="text" name="topic" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เริ่มวันที่</label>
                            <input type="date" name="dstart" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">สิ้นสุดวันที่</label>
                            <input type="date" name="dend" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เทอม</label>
                            <select name="term" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="1">เทอม 1</option>
                                <option value="2">เทอม 2</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ปีการศึกษา</label>
                            <input type="text" name="year" value="<?= $pee ?>" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">จำนวนชั่วโมง</label>
                            <input type="number" name="hours" min="0" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">นาที</label>
                            <input type="number" name="mn" min="0" max="59" value="0" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">หน่วยงานที่จัด</label>
                        <input type="text" name="supports" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">สถานที่จัด</label>
                        <input type="text" name="place" required placeholder='เช่น "โรงเรียนพิชัย" หรือ "Online"' class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ประเภท</label>
                            <select name="types" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="1">ภายใน (In-house)</option>
                                <option value="2">ภายนอก (External)</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">งบประมาณ</label>
                            <input type="number" name="budget" value="0" min="0" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">สรุปความรู้ที่ได้รับ</label>
                        <textarea name="know" required rows="3" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">การนำไปขยายผล (Dissemination)</label>
                        <textarea name="way" required rows="3" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ข้อเสนอแนะเพิ่มเติม</label>
                        <textarea name="suggest" rows="2" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เกียรติบัตร (ไฟล์รูปภาพ)</label>
                        <div class="relative group">
                            <input type="file" name="sdoc" accept="image/*" class="hidden" id="file_input">
                            <label for="file_input" class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-3xl p-6 hover:border-emerald-500 transition-all cursor-pointer group-hover:bg-emerald-50/50 dark:group-hover:bg-emerald-500/5">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-emerald-500 mb-2"></i>
                                <span class="text-sm text-gray-500 group-hover:text-emerald-600 font-medium">คลิกเพื่ออัปโหลดเกียรติบัตร</span>
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
                <button id="saveBtn" class="px-8 py-2.5 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-all shadow-lg flex items-center gap-2">
                    <i class="fas fa-save"></i> บันทึกข้อมูล
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: View Training -->
<div id="viewModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/60 backdrop-blur-sm animate-fade-in">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-morphism rounded-3xl w-full max-w-4xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 flex justify-between items-center text-white">
                <h3 class="text-xl font-black tracking-tight flex items-center gap-2 uppercase">
                    <i class="fas fa-info-circle"></i> รายละเอียดการอบรม
                </h3>
                <button onclick="closeViewModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="viewDetails" class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-8 max-h-[80vh] overflow-y-auto scrollbar-thin">
                <!-- Loaded by AJAX -->
            </div>
            <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between gap-3">
                <button id="printSingleBtn" class="px-6 py-2.5 rounded-2xl bg-blue-100 text-blue-700 font-bold hover:bg-blue-200 transition-all">
                    <i class="fas fa-print mr-2"></i>พิมพ์ฉบับนี้
                </button>
                <button onclick="closeViewModal()" class="px-8 py-2.5 rounded-2xl bg-gray-800 text-white font-bold hover:bg-black transition-all">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const tid = <?= json_encode($teacher_id); ?>;
    let current_term = '';
    let current_year = '<?= $pee ?>';

    // Set initial display values immediately
    $('#selected_term_display').text('ทั้งหมด');
    $('#selected_year_display').text(current_year || 'ทั้งหมด');

    // Initialize Table
    const recordTable = $('#record_table').DataTable({
        "pageLength": 25,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "language": {
            "emptyTable": "ไม่พบข้อมูลการอบรม",
            "search": "ค้นหา:",
            "paginate": { "next": "ถัดไป", "previous": "ก่อนหน้า" }
        },
        "columnDefs": [
            { "className": "text-center", "targets": [0, 2, 3, 4, 5, 6] },
            { "orderable": false, "targets": [5, 6] }
        ]
    });

    function fetchTrainingData() {
        $.ajax({
            url: 'api/fetch_training.php',
            method: 'GET',
            dataType: 'json',
            data: {
                tid: tid,
                term: $('#select_term').val() || 'all',
                year: $('#select_year').val() || 'all'
            },
            success: function(res) {
                if (res.success) {
                    populateTable(res.data);
                    updateStats(res.data);
                    
                    $('#selected_term_display').text($('#select_term').val() ? 'เทอม ' + $('#select_term').val() : 'ทั้งหมด');
                    $('#selected_year_display').text($('#select_year').val() || 'ทั้งหมด');
                }
            }
        });
    }

    function populateTable(data) {
        recordTable.clear();
        data.forEach((item, index) => {
            recordTable.row.add([
                index + 1,
                `<div class="font-bold text-gray-900 dark:text-white">${item.topic}</div><div class="text-xs text-gray-500 mt-1"><i class="fas fa-building mr-1"></i> ${item.supports}</div>`,
                `<span class="text-sm font-medium">${convertToThaiDate(item.dstart)}</span>`,
                `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">${item.hours} ชม. ${item.mn} น.</span>`,
                `<span class="text-xs font-bold">${item.term}/${item.year}</span>`,
                item.sdoc ? 
                `<a href="../dist/img/training/${item.sdoc}" target="_blank" class="block w-20 mx-auto rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all shadow-emerald-500/10">
                    <img src="../dist/img/training/${item.sdoc}" class="w-full h-12 object-cover border border-gray-100 dark:border-gray-700">
                </a>` : 
                `<div class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest bg-gray-50 dark:bg-slate-800/50 py-2 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">no img</div>`,
                `<div class="flex gap-2 justify-center">
                    <button class="w-8 h-8 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-all flex items-center justify-center btn-view" data-id="${item.semid}"><i class="fas fa-eye text-xs"></i></button>
                    <button class="w-8 h-8 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition-all flex items-center justify-center btn-edit" data-id="${item.semid}"><i class="fas fa-edit text-xs"></i></button>
                    <button class="w-8 h-8 rounded-xl bg-rose-500 text-white hover:bg-rose-600 transition-all flex items-center justify-center btn-del" data-id="${item.semid}"><i class="fas fa-trash text-xs"></i></button>
                </div>`
            ]);
        });
        recordTable.draw();
        
        // Add events
        attachActionEvents();
    }

    function updateStats(data) {
        let h = 0, m = 0, budget = 0;
        data.forEach(item => { h += parseInt(item.hours); m += parseInt(item.mn); budget += parseFloat(item.budget || 0); });
        h += Math.floor(m / 60); m %= 60;
        $('#total_hours').text(`${h} ชม. ${m} น.`);
        $('#total_count').text(`${data.length} รายการ`);
        $('#total_budget_display').text(`฿${new Intl.NumberFormat().format(budget)}`);
    }

    function convertToThaiDate(d) {
        if (!d) return '-';
        const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        const date = new Date(d);
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
    }

    function attachActionEvents() {
        $('.btn-view').on('click', function() {
            const id = $(this).data('id');
            showViewModal(id);
        });

        $('.btn-edit').on('click', function() {
            const id = $(this).data('id');
            showEditModal(id);
        });

        $('.btn-del').on('click', function() {
            const id = $(this).data('id');
            confirmDelete(id);
        });
    }

    function showViewModal(id) {
        $.ajax({
            url: 'api/fetch_training_details.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function(res) {
                if (res.success) {
                    const d = res.details;
                    const html = `
                        <div class="space-y-6">
                            <div class="p-6 rounded-3xl bg-blue-50 dark:bg-blue-500/5 border border-blue-100 dark:border-blue-500/20">
                                <h4 class="text-blue-700 dark:text-blue-400 text-sm font-black uppercase mb-4">ข้อมูลพื้นฐาน</h4>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500 uppercase">หัวข้อ</span>
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">${d.topic}</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div><span class="text-xs text-gray-500">วันที่เริ่ม</span><p class="font-bold">${convertToThaiDate(d.dstart)}</p></div>
                                        <div><span class="text-xs text-gray-500">วันที่สิ้นสุด</span><p class="font-bold">${convertToThaiDate(d.dend)}</p></div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div><span class="text-xs text-gray-500">รวมเวลา</span><p class="font-bold">${d.hours} ชม. ${d.mn} น.</p></div>
                                        <div><span class="text-xs text-gray-500">งบประมาณ</span><p class="font-bold">฿${new Intl.NumberFormat().format(d.budget)}</p></div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <h4 class="text-gray-900 dark:text-white text-sm font-black uppercase">สรุปเนื้อหาและการขยายผล</h4>
                                <div><span class="text-xs text-blue-500 font-bold uppercase">ความรู้ที่ได้รับ:</span><p class="text-sm mt-1 text-gray-600 dark:text-gray-400">${d.know}</p></div>
                                <div><span class="text-xs text-blue-500 font-bold uppercase">การขยายผล:</span><p class="text-sm mt-1 text-gray-600 dark:text-gray-400">${d.way}</p></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4">
                            <h4 class="text-gray-900 dark:text-white text-sm font-black uppercase text-center md:text-left">เกียรติบัตร / หลักฐาน</h4>
                            <div class="group relative rounded-3xl overflow-hidden shadow-2xl border border-gray-100 dark:border-gray-700">
                                <img src="../dist/img/training/${d.sdoc}" class="w-full object-contain max-h-[500px]">
                                <a href="../dist/img/training/${d.sdoc}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center text-white">
                                    <div class="px-6 py-2 rounded-full border-2 border-white font-bold">ดูรูปเต็ม</div>
                                </a>
                            </div>
                        </div>
                    `;
                    $('#viewDetails').html(html);
                    $('#printSingleBtn').on('click', () => window.open(`print_training.php?id=${id}`, '_blank'));
                    $('#viewModal').removeClass('hidden');
                    $('body').addClass('overflow-hidden');
                }
            }
        });
    }

    function showEditModal(id) {
        $.ajax({
            url: 'api/fetch_training_details.php',
            method: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function(res) {
                if (res.success) {
                    const d = res.details;
                    $('#modalTitle').html('<i class="fas fa-edit"></i> แก้ไขข้อมูลการอบรม');
                    $('#training_id').val(d.semid);
                    $('[name="topic"]').val(d.topic);
                    $('[name="dstart"]').val(d.dstart);
                    $('[name="dend"]').val(d.dend);
                    $('[name="term"]').val(d.term);
                    $('[name="year"]').val(d.year);
                    $('[name="hours"]').val(d.hours);
                    $('[name="mn"]').val(d.mn);
                    $('[name="supports"]').val(d.supports);
                    $('[name="place"]').val(d.place);
                    $('[name="types"]').val(d.types);
                    $('[name="budget"]').val(d.budget);
                    $('[name="know"]').val(d.know);
                    $('[name="way"]').val(d.way);
                    $('[name="suggest"]').val(d.suggest);
                    
                    if (d.sdoc) {
                        $('#file_preview').attr('src', '../dist/img/training/' + d.sdoc);
                        $('#preview_container').removeClass('hidden');
                    }
                    
                    $('#trainingModal').removeClass('hidden');
                    $('body').addClass('overflow-hidden');
                }
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "คุณกำลังจะลบข้อมูลชุดนี้อย่างถาวร!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'ใช่, ฉันต้องการลบ!',
            cancelButtonText: 'ยกเลิก',
            background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#000000',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/del_training.php',
                    method: 'POST',
                    dataType: 'json',
                    data: { id: id },
                    success: function(res) {
                        Swal.fire('สำเร็จ!', 'ลบข้อมูลเรียบร้อยแล้ว.', 'success');
                        fetchTrainingData();
                    }
                });
            }
        });
    }

    // Modal Controls
    window.closeModal = function() {
        $('#trainingModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#trainingForm')[0].reset();
        $('#preview_container').addClass('hidden');
    }

    window.closeViewModal = function() {
        $('#viewModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    }

    $('#addTraining').on('click', function() {
        $('#modalTitle').html('<i class="fas fa-plus-circle"></i> เพิ่มข้อมูลการอบรม/สัมมนา');
        $('#trainingForm')[0].reset();
        $('#training_id').val('');
        $('#preview_container').addClass('hidden');
        $('#trainingModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });

    // Save Data
    $('#saveBtn').on('click', function() {
        const form = document.getElementById('trainingForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const data = new FormData(form);
        const url = $('#training_id').val() ? 'api/update_training.php' : 'api/insert_training.php';
        
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
                    Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: 'บันทึกข้อมูลเรียบร้อยแล้ว', timer: 1500, showConfirmButton: false });
                    closeModal();
                    fetchTrainingData();
                } else {
                    Swal.fire('เกิดข้อผิดพลาด', res.message, 'error');
                }
            }
        });
    });

    // File Preview
    $('#file_input').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = (re) => { $('#file_preview').attr('src', re.target.result); $('#preview_container').removeClass('hidden'); };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Filter Controls
    $('#filter').on('click', fetchTrainingData);
    
    // Update header display when dropdown changes
    $('#select_term, #select_year').on('change', function() {
        $('#selected_term_display').text($('#select_term').val() ? 'เทอม ' + $('#select_term').val() : 'ทั้งหมด');
        $('#selected_year_display').text($('#select_year').val() || 'ทั้งหมด');
    });
    
    $('#reset').on('click', function() {
        $('#select_term').val('');
        $('#select_year').val('<?= $pee ?>');
        $('#selected_term_display').text('ทั้งหมด');
        $('#selected_year_display').text('<?= $pee ?>');
        fetchTrainingData();
    });

    // Printing
    window.printPage = function() {
        const currentContent = recordTable.rows({ filter: 'applied' }).data().toArray();
        // Since custom print needs a specific layout, we'll suggest using the built-in print or a custom route
        // For simplicity with existing functionality, we use window.print logic but prettier
        window.print();
    };

    // Initial Load
    fetchTrainingData();
});
</script>

<style>
/* Custom Table Styles */
#record_table_wrapper .dataTables_length, 
#record_table_wrapper .dataTables_filter {
    margin-bottom: 1.5rem;
}
#record_table_wrapper .dataTables_filter input {
    border-radius: 1rem;
    padding-left: 1rem;
    padding-right: 1rem;
    border-color: rgba(226, 232, 240, 0.8);
}
.dark #record_table_wrapper .dataTables_filter input {
    background-color: #1e293b;
    border-color: #334155;
    color: white;
}
#record_table thead th {
    border-bottom: none;
}

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
        background: linear-gradient(135deg, #10b981, #14b8a6);
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
        content: "📅 วันที่: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        flex-shrink: 0;
    }
    
    #record_table tbody td:nth-child(4)::before {
        content: "⏱️ ชั่วโมง: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        flex-shrink: 0;
    }
    
    #record_table tbody td:nth-child(5)::before {
        content: "📚 เทอม/ปี: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        flex-shrink: 0;
    }
    
    #record_table tbody td:nth-child(6) {
        justify-content: flex-start;
    }
    
    #record_table tbody td:nth-child(6)::before {
        content: "📄 หลักฐาน: ";
        font-weight: 600;
        color: #64748b;
        margin-right: 0.5rem;
        flex-shrink: 0;
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
    
    #record_table tbody td:last-child button {
        flex: 1;
        max-width: 80px;
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
}

/* Modal Mobile Styles */
@media screen and (max-width: 640px) {
    #trainingModal > div,
    #viewModal > div {
        padding: 0.5rem;
    }
    
    #trainingModal .max-w-2xl,
    #viewModal .max-w-4xl {
        max-width: 100%;
        margin: 0;
        border-radius: 1.5rem;
    }
    
    #trainingModal form,
    #viewModal #viewDetails {
        padding: 1rem;
    }
    
    #viewModal #viewDetails {
        grid-template-columns: 1fr;
    }
    
    #trainingModal .p-6.bg-gradient-to-r,
    #viewModal .p-6.bg-gradient-to-r {
        padding: 1rem;
    }
    
    #trainingModal .p-6.border-t,
    #viewModal .p-6.border-t {
        padding: 1rem;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    #trainingModal .p-6.border-t button,
    #viewModal .p-6.border-t button {
        width: 100%;
    }
    
    /* Grid adjustments in form */
    #trainingModal .grid.grid-cols-1.md\\:grid-cols-2 {
        grid-template-columns: 1fr;
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
    
    #record_table tbody td:nth-child(6) img {
        max-width: 60px;
        height: auto;
    }
}

@media print {
    /* Layout Reset */
    .glass-morphism { background: white !important; box-shadow: none !important; border: none !important; padding: 0 !important; }
    .animate-fade-in { animation: none !important; }
    
    /* Hide Elements */
    button, #trainingModal, #viewModal, .dataTables_length, .dataTables_filter, .dataTables_paginate, .dataTables_info, .no-print, nav, aside, .sidebar, #addTraining, #filter, #reset, [onclick="printPage()"] { display: none !important; }
    
    /* Hide Filter Section specifically */
    .glass-morphism:has(#select_term) { display: none !important; }
    /* Hide Stats Section */
    .grid.grid-cols-2.lg\:grid-cols-3 { display: none !important; }

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
    @page { margin: 1.5cm; size: A4 landscape; } /* Training often has more cols, landscape might be safer, but Portrait is standard. Let's stick to Portrait unless wide. */
    
    /* Reveal Hidden Elements for Print */
    #record_table thead { display: table-header-group !important; }
    #record_table tbody tr { display: table-row !important; page-break-inside: avoid; border: 1px solid black !important; }
    #record_table tbody td { display: table-cell !important; border: 1px solid black !important; }
    
    /* Mobile Card overrides */
    #record_table tbody td::before { display: none !important; }
    #record_table tbody td:first-child { width: 40px !important; text-align: center !important; background: none !important; color: black !important; position: static !important; height: auto !important; border-radius: 0 !important; }
    #record_table tbody td:nth-child(2) { text-align: left !important; padding-right: 8px !important; }
    
    /* Hide Action Columns */
    #record_table thead th:last-child { display: none !important; }
    #record_table tbody td:last-child { display: none !important; }
    
    /* Hide Evidence Column if problematic, or just icon */
    #record_table tbody td:nth-child(6) img { max-width: 50px !important; height: auto !important; }
    
    /* Icons */
    i { display: none !important; }
}
</style>
