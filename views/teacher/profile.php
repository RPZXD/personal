<!-- Teacher Profile View -->
<div class="space-y-8 animate-fade-in max-w-4xl mx-auto">
    <!-- Profile Card -->
    <div class="glass-morphism rounded-[2.5rem] overflow-hidden border border-white/20 shadow-2xl relative">
        <div class="h-48 md:h-64 bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600 relative">
            <div class="absolute inset-0 bg-white/10 backdrop-blur-[2px]"></div>
            
            <!-- Edit Button: Absolute on mobile top-right, bottom-right on desktop -->
            <div class="absolute top-6 right-6 md:top-auto md:bottom-6 md:right-10 z-10">
                <button data-modal-target="editModal" class="p-3 md:px-6 md:py-2.5 rounded-2xl bg-white/20 backdrop-blur-md text-white border border-white/30 font-bold hover:bg-white/30 transition-all flex items-center gap-2 shadow-lg">
                    <i class="fas fa-edit"></i> <span class="hidden md:inline">แก้ไขข้อมูลส่วนตัว</span>
                </button>
            </div>

            <!-- Profile Image: Centered on mobile, left-aligned on desktop -->
            <div class="absolute -bottom-16 left-1/2 -translate-x-1/2 md:left-10 md:translate-x-0 transition-all duration-500">
                <div class="relative group">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-[2rem] md:rounded-[2.5rem] border-4 border-white dark:border-slate-900 shadow-2xl overflow-hidden bg-white dark:bg-slate-800">
                        <img src="<?= $setting->getImgProfile().$userData['Teach_photo']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="pt-20 md:pt-24 pb-10 px-6 md:px-12">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6 text-center md:text-left">
                <div class="space-y-3">
                    <h1 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight leading-tight"><?= $userData['Teach_name']; ?></h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 md:gap-3">
                        <span class="px-3 py-1 rounded-full bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-400 text-[10px] md:text-xs font-black uppercase tracking-widest border border-indigo-200 dark:border-indigo-500/20"><?= $userData['Teach_major']; ?></span>
                        <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[10px] md:text-xs font-black uppercase tracking-widest border border-emerald-200 dark:border-emerald-500/20"><?= $position; ?></span>
                        <span class="px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-[10px] md:text-xs font-black uppercase tracking-widest border border-amber-200 dark:border-amber-500/20"><?= $academic; ?></span>
                    </div>
                </div>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <h3 class="text-xs font-black text-indigo-500 uppercase tracking-[0.2em] ml-1">ข้อมูลพื้นฐาน</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center text-xl text-gray-400">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">รหัสประจำตัว</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white"><?= $userData['Teach_id']; ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center text-xl text-gray-400">
                                    <i class="fas fa-venus-mars"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">เพศ</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white"><?= $userData['Teach_sex']; ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center text-xl text-gray-400">
                                    <i class="fas fa-birthday-cake"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">วัน/เดือน/ปีเกิด</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white"><?= $thaiBirthDate; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="space-y-4">
                        <h3 class="text-xs font-black text-violet-500 uppercase tracking-[0.2em] ml-1">ช่องทางติดต่อ</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center text-xl text-gray-400">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">เบอร์โทรศัพท์</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white"><?= $userData['Teach_phone']; ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center text-xl text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">อีเมล</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white truncate max-w-[200px]"><?= $userData['Teach_email']; ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center text-xl text-gray-400">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">ที่อยู่</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white"><?= $userData['Teach_addr']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 p-8 rounded-[2rem] bg-gray-50 dark:bg-slate-800/50 border border-gray-100 dark:border-gray-700">
                <h3 class="text-xs font-black text-fuchsia-500 uppercase tracking-[0.2em] mb-6">วุฒิการศึกษาล่าสุด</h3>
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-3xl bg-white dark:bg-slate-900 shadow-lg flex items-center justify-center text-3xl text-fuchsia-500">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <p class="text-xl font-black text-gray-900 dark:text-white"><?= $userData['Teach_HiDegree']; ?></p>
                        <p class="text-sm text-gray-500 font-medium">วุฒิการศึกษาสูงสุดที่ได้รับ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit Profile -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/60 backdrop-blur-sm animate-fade-in">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-morphism rounded-[2.5rem] w-full max-w-2xl overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
            <div class="p-8 bg-black text-white flex justify-between items-center">
                <h3 class="text-2xl font-black tracking-tight uppercase flex items-center gap-3">
                    <i class="fas fa-user-edit text-indigo-500"></i>
                    แก้ไขข้อมูลส่วนตัว
                </h3>
                <button onclick="closeModal()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editTeacherForm" enctype="multipart/form-data" class="p-10 space-y-8 max-h-[70vh] overflow-y-auto scrollbar-thin">
                <input type="hidden" name="teachId" value="<?= $userData['Teach_id']; ?>">
                
                <div class="flex flex-col items-center gap-6 pb-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="relative group cursor-pointer">
                        <div class="w-32 h-32 rounded-[2rem] overflow-hidden border-4 border-gray-50 dark:border-slate-800 shadow-xl bg-gray-100 dark:bg-slate-800">
                            <img id="currentPhoto" src="<?= $setting->getImgProfile().$userData['Teach_photo']; ?>" class="w-full h-full object-cover group-hover:opacity-50 transition-all">
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                            <i class="fas fa-camera text-2xl text-white"></i>
                        </div>
                        <input type="file" id="teachPhoto" name="teachPhoto" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">คลิกที่รูปเพื่อเปลี่ยนรูปประจำตัว</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">ชื่อ-นามสกุล</label>
                        <input type="text" name="teachName" value="<?= $userData['Teach_name']; ?>" required class="w-full px-5 py-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">กลุ่มสาระ / สาขา</label>
                        <select name="teachMajor" required class="w-full px-5 py-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none font-bold">
                            <?php foreach ($majors as $major): ?>
                                <option value="<?= $major['Teach_major']; ?>" <?= $major['Teach_major'] == $userData['Teach_major'] ? 'selected' : ''; ?>><?= $major['Teach_major']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">เบอร์โทรศัพท์ (10 หลัก)</label>
                        <input type="text" name="teachPhone" value="<?= $userData['Teach_phone']; ?>" required pattern="\d{10}" maxlength="10" class="w-full px-5 py-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">อีเมล</label>
                        <input type="email" name="teachEmail" value="<?= $userData['Teach_email']; ?>" required class="w-full px-5 py-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none font-bold">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">ที่อยู่ตามทะเบียนบ้าน</label>
                    <input type="text" name="teachAddr" value="<?= $userData['Teach_addr']; ?>" required class="w-full px-5 py-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none font-bold placeholder:font-normal" placeholder="ตัวอย่าง: 9/9 ม.3 ต.ในเมือง อ.พิชัย จ.อุตรดิตถ์">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">ตำแหน่ง</label>
                        <select name="teachPosition" required class="w-full px-5 py-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none font-bold">
                            <?php foreach ($positions as $pos): ?>
                                <option value="<?= $pos['pid2']; ?>" <?= $pos['pid2'] == $userData['Teach_Position'] ? 'selected' : ''; ?>><?= $pos['namep2']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">วิทยฐานะ</label>
                        <select name="teachAcademic" required class="w-full px-5 py-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none font-bold">
                            <?php foreach ($academics as $acad): ?>
                                <option value="<?= $acad['cid']; ?>" <?= $acad['cid'] == $userData['Teach_Academic'] ? 'selected' : ''; ?>><?= $acad['namec']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">วุฒิการศึกษาสูงสุด</label>
                    <input type="text" name="teachHiDegree" value="<?= $userData['Teach_HiDegree']; ?>" required class="w-full px-5 py-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 outline-none font-bold">
                </div>
            </form>
            <div class="p-8 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end gap-4">
                <button onclick="closeModal()" class="px-8 py-3 rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all">ยกเลิก</button>
                <button id="saveChanges" class="px-10 py-3 rounded-2xl bg-black text-white font-bold hover:bg-slate-800 transition-all shadow-xl flex items-center gap-3">
                    <i class="fas fa-save text-indigo-500"></i> บันทึกข้อมูล
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Modal toggle
    $('[data-modal-target]').on('click', function() {
        const target = $(this).data('modal-target');
        $(`#${target}`).removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });

    window.closeModal = function() {
        $('#editModal').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    };

    // Photo preview
    $('#teachPhoto').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = (re) => { $('#currentPhoto').attr('src', re.target.result); };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Save changes
    $('#saveChanges').on('click', function() {
        const form = document.getElementById('editTeacherForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        
        const data = new FormData(form);
        Swal.fire({
            title: 'กำลังบันทึกข้อมูล...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        $.ajax({
            url: 'api/update_datateacher.php',
            method: 'POST',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                Swal.close();
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('เกิดข้อผิดพลาด', res.message, 'error');
                }
            },
            error: function() {
                Swal.close();
                Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
            }
        });
    });
});
</script>

<style>
.scrollbar-thin::-webkit-scrollbar { width: 6px; }
.scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.dark .scrollbar-thin::-webkit-scrollbar-thumb { background: #334155; }

@media print {
    /* Hide UI elements */
    button, nav, aside, .sidebar, #editModal, [data-modal-target] { display: none !important; }
    
    /* Adjust Layout */
    .glass-morphism { 
        box-shadow: none !important; 
        border: none !important; 
        background: white !important;
        overflow: visible !important;
    }
    
    body { background: white !important; color: black !important; }
    
    /* Expansion */
    .max-w-4xl { max-width: 100% !important; margin: 0 !important; }
    
    /* Text Color Force */
    p, h1, h2, h3, h4, span, div { 
        color: black !important; 
        text-shadow: none !important; 
        -webkit-text-fill-color: black !important;
    }
}
</style>
