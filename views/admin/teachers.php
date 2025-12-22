<!-- Admin Teachers Management View -->
<div class="space-y-4 sm:space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-gradient-to-br from-purple-600 to-indigo-700 p-4 sm:p-6 md:p-8 shadow-2xl text-white">
        <div class="absolute top-0 right-0 w-32 sm:w-64 h-32 sm:h-64 bg-white/10 rounded-full blur-3xl -mr-16 sm:-mr-32 -mt-16 sm:-mt-32"></div>
        <div class="relative space-y-4">
            <!-- Title Row -->
            <div class="flex items-center gap-3 sm:gap-4 md:gap-6">
                <div class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 rounded-xl sm:rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-xl sm:text-3xl md:text-4xl shadow-inner border border-white/30 shrink-0">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="text-lg sm:text-2xl md:text-3xl font-black tracking-tight leading-tight truncate">จัดการข้อมูลครู</h2>
                    <p class="text-purple-100/80 mt-0.5 sm:mt-1 font-medium text-[10px] sm:text-xs md:text-base truncate">
                        รายชื่อบุคลากรทั้งหมดในระบบ
                    </p>
                </div>
            </div>
            <!-- Buttons Row -->
            <div class="flex gap-2 sm:gap-3">
                <button onclick="openAddModal()" class="flex-1 px-3 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 rounded-xl sm:rounded-2xl bg-white text-purple-600 text-xs sm:text-sm md:text-base font-bold hover:bg-purple-50 transition-all shadow-lg flex items-center justify-center gap-1.5 sm:gap-2">
                    <i class="fas fa-plus-circle"></i> 
                    <span class="hidden xs:inline">เพิ่มข้อมูล</span>
                    <span class="xs:hidden">เพิ่ม</span>
                </button>
                <button onclick="openUploadModal()" class="flex-1 px-3 sm:px-4 md:px-6 py-2 sm:py-2.5 md:py-3 rounded-xl sm:rounded-2xl bg-white/20 backdrop-blur text-white text-xs sm:text-sm md:text-base font-bold hover:bg-white/30 transition-all border border-white/30 flex items-center justify-center gap-1.5 sm:gap-2">
                    <i class="fas fa-file-excel"></i> 
                    <span class="hidden sm:inline">นำเข้า Excel</span>
                    <span class="sm:hidden">Excel</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="glass-morphism rounded-2xl sm:rounded-3xl p-2 sm:p-4 md:p-6 overflow-hidden border border-white/20 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm" id="record_table">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase text-center w-8">#</th>
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase w-12 sm:w-16">ID</th>
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase">ชื่อ-สกุล</th>
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase hidden sm:table-cell">กลุ่มสาระ</th>
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase hidden lg:table-cell">ตำแหน่ง</th>
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase text-center hidden md:table-cell">สถานะ</th>
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase text-center hidden xl:table-cell">รูป</th>
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase text-center hidden md:table-cell">บทบาท</th>
                        <th class="px-1 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-xs font-bold text-gray-500 uppercase text-center w-20 sm:w-28">จัดการ</th>
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
            <div class="glass-morphism rounded-2xl sm:rounded-3xl w-full max-w-2xl mx-2 sm:mx-4 overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
                <div class="p-6 bg-gradient-to-r from-purple-600 to-indigo-600 flex justify-between items-center text-white">
                    <h3 id="modalTitle" class="text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        แก้ไขข้อมูลครู
                    </h3>
                    <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="teacherForm" class="p-4 sm:p-6 md:p-8 space-y-4 sm:space-y-6 max-h-[65vh] sm:max-h-[70vh] overflow-y-auto scrollbar-thin">
                    <input type="hidden" name="teach_id_old" id="teach_id_old">
                    
                    <!-- Section: ข้อมูลบัญชี -->
                    <div class="pb-4 border-b border-gray-100 dark:border-gray-700">
                        <h4 class="text-[10px] sm:text-xs font-black text-purple-500 uppercase tracking-widest mb-3 sm:mb-4">ข้อมูลบัญชี</h4>
                        <div class="grid grid-cols-1 gap-4 sm:gap-6">
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">Username (5 หลัก)</label>
                                <input type="text" name="teach_id" id="teach_id" maxlength="5" required class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all font-mono text-sm sm:text-base">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">รหัสผ่าน</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" maxlength="50" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 pr-11 sm:pr-12 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all text-sm sm:text-base">
                                    <button type="button" id="togglePassword" class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-500 hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                                        <i class="fas fa-eye" id="passwordIcon"></i>
                                    </button>
                                </div>
                                <p class="text-[10px] text-gray-400 ml-1" id="passwordHint">สำหรับเพิ่มใหม่: รหัสผ่านจะถูกเข้ารหัสอัตโนมัติ</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: ข้อมูลส่วนตัว -->
                    <div class="pb-4 border-b border-gray-100 dark:border-gray-700">
                        <h4 class="text-[10px] sm:text-xs font-black text-indigo-500 uppercase tracking-widest mb-3 sm:mb-4">ข้อมูลส่วนตัว</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div class="sm:col-span-2 space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ชื่อ - นามสกุล <span class="text-purple-500 text-[9px] sm:text-[10px]">(ต้องระบุคำนำหน้า)</span></label>
                                <input type="text" name="teach_name" id="teach_name" maxlength="200" required placeholder="เช่น นายสมชาย ใจดี" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all font-bold text-sm sm:text-base">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เพศ</label>
                                <select name="teach_sex" id="teach_sex" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none text-sm sm:text-base">
                                    <option value="">-- โปรดเลือก --</option>
                                    <option value="ชาย">ชาย</option>
                                    <option value="หญิง">หญิง</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วันเกิด</label>
                                <input type="date" name="teach_birthday" id="teach_birthday" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all text-sm sm:text-base">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เบอร์โทรศัพท์</label>
                                <input type="text" name="teach_phone" id="teach_phone" maxlength="10" pattern="\d{10}" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all text-sm sm:text-base" placeholder="0812345678">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">อีเมล</label>
                                <input type="email" name="teach_email" id="teach_email" maxlength="100" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all text-sm sm:text-base" placeholder="email@example.com">
                            </div>
                            <div class="sm:col-span-2 space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ที่อยู่</label>
                                <input type="text" name="teach_addr" id="teach_addr" maxlength="500" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all text-sm sm:text-base" placeholder="ที่อยู่ตามทะเบียนบ้าน">
                            </div>
                        </div>
                    </div>

                    <!-- Section: ข้อมูลตำแหน่งและการศึกษา -->
                    <div class="pb-4 border-b border-gray-100 dark:border-gray-700">
                        <h4 class="text-[10px] sm:text-xs font-black text-emerald-500 uppercase tracking-widest mb-3 sm:mb-4">ข้อมูลตำแหน่งและการศึกษา</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">กลุ่มสาระ</label>
                                <select name="teach_major" id="teach_major" required class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none text-sm sm:text-base">
                                    <option value="">-- โปรดเลือกกลุ่มสาระ --</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ตำแหน่ง</label>
                                <select name="teach_position2" id="teach_position2" required class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none text-sm sm:text-base">
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
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">วุฒิการศึกษาสูงสุด</label>
                                <input type="text" name="teach_hidegree" id="teach_hidegree" maxlength="200" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none transition-all text-sm sm:text-base" placeholder="เช่น ปริญญาโท">
                            </div>
                        </div>
                    </div>

                    <!-- Section: ข้อมูลที่ปรึกษา -->
                    <div class="pb-4">
                        <h4 class="text-[10px] sm:text-xs font-black text-amber-500 uppercase tracking-widest mb-3 sm:mb-4">ข้อมูลที่ปรึกษาและระบบ</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-2 gap-3 sm:gap-6">
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ที่ปรึกษาชั้น</label>
                                <select name="teach_class" id="teach_class" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none text-sm sm:text-base">
                                    <?php for($i=0;$i<=6;$i++) echo "<option value='$i'>$i</option>"; ?>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">ห้อง</label>
                                <select name="teach_room" id="teach_room" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none text-sm sm:text-base">
                                    <?php for($i=0;$i<=12;$i++) echo "<option value='$i'>$i</option>"; ?>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">สถานะ</label>
                                <select name="teach_status" id="teach_status" required class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none text-sm sm:text-base">
                                    <option value="1">ปกติ</option>
                                    <option value="2">ย้าย รร.</option>
                                    <option value="3">เกษียณอายุราชการ</option>
                                    <option value="4">ลาออก</option>
                                    <option value="9">เสียชีวิต</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">บทบาทระบบ</label>
                                <select name="role_person" id="role_person" required class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800 focus:ring-2 focus:ring-purple-500 outline-none text-sm sm:text-base">
                                    <option value="T">ครู</option>
                                    <option value="OF">เจ้าหน้าที่</option>
                                    <option value="VP">รองผู้อำนวยการ</option>
                                    <option value="DIR">ผู้อำนวยการ</option>
                                    <option value="ADM">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="p-4 sm:p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                    <button onclick="closeModal()" class="w-full sm:w-auto px-6 py-2.5 rounded-xl sm:rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all text-sm sm:text-base">ยกเลิก</button>
                    <button id="saveBtn" class="w-full sm:w-auto px-8 py-2.5 rounded-xl sm:rounded-2xl bg-purple-600 text-white font-bold hover:bg-purple-700 transition-all shadow-lg flex items-center justify-center gap-2 text-sm sm:text-base">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Upload Excel -->
    <div id="uploadModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 backdrop-blur-sm animate-fade-in">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="glass-morphism rounded-2xl sm:rounded-3xl w-full max-w-lg mx-2 sm:mx-4 overflow-hidden shadow-2xl animate-slide-up bg-white dark:bg-slate-900 border border-white/20">
                <div class="p-4 sm:p-6 bg-gradient-to-r from-emerald-600 to-teal-600 flex justify-between items-center text-white">
                    <h3 class="text-lg sm:text-xl font-black tracking-tight flex items-center gap-2">
                        <i class="fas fa-file-excel"></i>
                        อัพโหลดไฟล์ Excel
                    </h3>
                    <button onclick="closeUploadModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="p-4 sm:p-6 md:p-8 space-y-4 sm:space-y-6">
                    <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20">
                        <div class="flex gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-amber-500 flex items-center justify-center text-white shrink-0 shadow-lg">
                                <i class="fas fa-cloud-download-alt text-lg sm:text-xl"></i>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs sm:text-sm font-black text-amber-800 dark:text-amber-400">ต้องการแม่แบบไฟล์หรือไม่?</p>
                                <p class="text-[10px] sm:text-xs text-amber-700 dark:text-amber-300/80 leading-relaxed font-medium">กรุณาใช้ไฟล์ตามรูปแบบที่เรากำหนด</p>
                                <a href="template/teacher_template.xlsx" class="inline-block mt-2 text-[10px] sm:text-xs font-black text-amber-600 dark:text-amber-400 hover:underline">ดาวน์โหลดไฟล์ตัวอย่าง .xlsx</a>
                            </div>
                        </div>
                    </div>

                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="space-y-3 sm:space-y-4">
                            <label class="block text-xs sm:text-sm font-black text-gray-700 dark:text-gray-300 ml-1 uppercase">เลือกไฟล์บุคลากร (.xlsx)</label>
                            <label class="group relative flex flex-col items-center justify-center w-full h-32 sm:h-40 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl sm:rounded-3xl cursor-pointer hover:border-emerald-500 dark:hover:border-emerald-400 hover:bg-emerald-50/50 dark:hover:bg-emerald-500/5 transition-all">
                                <div class="flex flex-col items-center justify-center pt-4 pb-5 sm:pt-5 sm:pb-6">
                                    <i class="fas fa-file-import text-2xl sm:text-3xl text-gray-400 group-hover:text-emerald-500 mb-2 transition-colors"></i>
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-bold text-center px-4" id="fileName">คลิกเพื่อเลือกไฟล์ หรือลากมาวาง</p>
                                </div>
                                <input type="file" name="excelFile" id="excelFile" accept=".xlsx" class="hidden" onchange="updateFileName(this)">
                            </label>
                        </div>
                    </form>
                </div>
                
                <div class="p-4 sm:p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-slate-800/50 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                    <button onclick="closeUploadModal()" class="w-full sm:w-auto px-6 py-2.5 rounded-xl sm:rounded-2xl bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-300 transition-all text-sm sm:text-base">ยกเลิก</button>
                    <button id="uploadBtn" class="w-full sm:w-auto px-8 py-2.5 rounded-xl sm:rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-all shadow-lg flex items-center justify-center gap-2 text-sm sm:text-base">
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
    // Initialize Table - simpler config, let CSS handle responsive
    const recordTable = $('#record_table').DataTable({
        "pageLength": 25,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
        "scrollX": false,
        "language": {
            "emptyTable": "ไม่พบข้อมูลบุคลากร",
            "search": "",
            "searchPlaceholder": "ค้นหา...",
            "lengthMenu": "แสดง _MENU_",
            "info": "_START_-_END_ / _TOTAL_",
            "infoEmpty": "0 รายการ",
            "paginate": { "next": "»", "previous": "«" }
        },
        "columnDefs": [
            { "className": "text-center align-middle", "targets": [0, 5, 6, 7, 8] },
            { "className": "align-middle", "targets": "_all" },
            { "orderable": false, "targets": [6, 8] }
        ],
        "dom": '<"flex flex-col sm:flex-row justify-between items-center gap-2 mb-3"<"w-full sm:flex-1"f><"text-xs"l>>rtip'
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
                        `<span class="text-xs text-gray-400">${index + 1}</span>`,
                        `<span class="font-mono text-[10px] sm:text-xs font-bold text-slate-500">${item.Teach_id}</span>`,
                        `<span class="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200 line-clamp-2">${item.Teach_name}</span>`,
                        `<span class="text-[10px] sm:text-xs font-medium text-slate-600 dark:text-slate-400 line-clamp-1">${item.Teach_major}</span>`,
                        `<span class="px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-400 whitespace-nowrap">${item.Teach_Position2}</span>`,
                        getStatusBadge(item.Teach_status),
                        `<div class="flex justify-center">
                            <div onclick="openImageModal('https://std.phichai.ac.th/teacher/uploads/phototeach/${item.Teach_photo}')" class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm bg-slate-100 dark:bg-slate-800 cursor-pointer group">
                                <img src="https://std.phichai.ac.th/teacher/uploads/phototeach/${item.Teach_photo}" class="w-full h-full object-cover group-hover:scale-110 transition-transform" onerror="this.src='../dist/img/no-image.png'">
                            </div>
                         </div>`,
                        getRoleBadge(item.role_person),
                        `<div class="flex gap-1 sm:gap-2 justify-center flex-nowrap">
                            <button onclick="editTeacher('${item.Teach_id}')" class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-purple-500 text-white hover:bg-purple-600 transition-all flex items-center justify-center shadow-lg shadow-purple-500/20" title="แก้ไข"><i class="fas fa-edit text-[10px] sm:text-xs"></i></button>
                            <button onclick="resetPassword('${item.Teach_id}', '${item.Teach_name}')" class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition-all flex items-center justify-center shadow-lg shadow-amber-500/20" title="รีเซ็ท"><i class="fas fa-key text-[10px] sm:text-xs"></i></button>
                            <button onclick="deleteTeacher('${item.Teach_id}')" class="w-6 h-6 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-rose-500 text-white hover:bg-rose-600 transition-all flex items-center justify-center shadow-lg shadow-rose-500/20" title="ลบ"><i class="fas fa-trash text-[10px] sm:text-xs"></i></button>
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
        $('#password').val('').attr('placeholder', '');
        // Reset hint for add mode
        $('#passwordHint').html('สำหรับเพิ่มใหม่: รหัสผ่านจะถูกเข้ารหัสอัตโนมัติ');
        $('#teacherModal').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    };

    window.editTeacher = function(id) {
        Swal.fire({ title: 'กำลังโหลด...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        $.getJSON('api/get_teacher.php', { teacher_id: id }, function(data) {
            // console.log(data);
            Swal.close();
            if (data) {
                $('#modalTitle').html('<i class="fas fa-edit"></i> แก้ไขข้อมูลครู');
                $('#teach_id_old').val(data.Teach_id);
                $('#teach_id').val(data.Teach_id);
                
                // Check if password is hashed (bcrypt starts with $2y$)
                const currentPassword = data.password || '';
                if (currentPassword.startsWith('$2y$') || currentPassword.startsWith('$2a$') || currentPassword.startsWith('$2b$')) {
                    // Password is hashed - cannot show original
                    $('#password').val('').attr('placeholder', '');
                    $('#passwordHint').html('<span class="text-emerald-600"><i class="fas fa-lock mr-1"></i>รหัสผ่านถูกเข้ารหัสแล้ว (ปลอดภัย) - เว้นว่างถ้าไม่ต้องการเปลี่ยน หรือใช้ปุ่ม <i class="fas fa-key"></i> รีเซ็ท</span>');
                } else if (currentPassword) {
                    // Plain text password - can show
                    $('#password').val(currentPassword);
                    $('#passwordHint').html('<span class="text-amber-500"><i class="fas fa-exclamation-triangle mr-1"></i>รหัสผ่านยังไม่ได้เข้ารหัส - หากต้องการเปลี่ยนให้พิมพ์รหัสใหม่ (จะถูกเข้ารหัสอัตโนมัติ)</span>');
                } else {
                    // No password set
                    $('#password').val('').attr('placeholder', '');
                    $('#passwordHint').html('<span class="text-rose-500"><i class="fas fa-times-circle mr-1"></i>ยังไม่มีรหัสผ่าน - กรุณาตั้งรหัสผ่านใหม่</span>');
                }
                
                $('#teach_name').val(data.Teach_name);
                $('#teach_sex').val(data.Teach_sex || '');
                $('#teach_birthday').val(data.Teach_birth || '');
                $('#teach_phone').val(data.Teach_phone || '');
                $('#teach_email').val(data.Teach_email || '');
                $('#teach_addr').val(data.Teach_addr || '');
                $('#teach_major').val(data.Teach_major);
                $('#teach_position2').val(data.Teach_Position2);
                $('#teach_hidegree').val(data.Teach_HiDegree || '');
                $('#teach_status').val(data.Teach_status);
                $('#role_person').val(data.role_person);
                $('#teach_class').val(data.Teach_class);
                $('#teach_room').val(data.Teach_room);
                
                $('#teacherModal').removeClass('hidden');
                $('body').addClass('overflow-hidden');
            }
        });
    };

    // Toggle password visibility
    $('#togglePassword').on('click', function() {
        const passwordInput = $('#password');
        const icon = $('#passwordIcon');
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Reset Password Function
    window.resetPassword = function(id, name) {
        Swal.fire({
            title: 'รีเซ็ทรหัสผ่าน',
            html: `
                <p class="text-gray-600 mb-4">รีเซ็ทรหัสผ่านสำหรับ <strong>${name}</strong></p>
                <div class="space-y-4">
                    <div class="text-left">
                        <label class="block text-sm font-medium text-gray-700 mb-1">รหัสผ่านใหม่</label>
                        <div class="relative">
                            <input type="password" id="swal_new_password" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none" placeholder="ระบุรหัสผ่านใหม่">
                            <button type="button" onclick="toggleSwalPassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <i class="fas fa-eye" id="swalPasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-left">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ยืนยันรหัสผ่านใหม่</label>
                        <input type="password" id="swal_confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none" placeholder="ยืนยันรหัสผ่านใหม่">
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#7c3aed',
            confirmButtonText: '<i class="fas fa-key mr-2"></i> รีเซ็ทรหัสผ่าน',
            cancelButtonText: 'ยกเลิก',
            preConfirm: () => {
                const newPassword = document.getElementById('swal_new_password').value;
                const confirmPassword = document.getElementById('swal_confirm_password').value;
                if (!newPassword || newPassword.length < 4) {
                    Swal.showValidationMessage('รหัสผ่านต้องมีอย่างน้อย 4 ตัวอักษร');
                    return false;
                }
                if (newPassword !== confirmPassword) {
                    Swal.showValidationMessage('รหัสผ่านไม่ตรงกัน');
                    return false;
                }
                return newPassword;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.ajax({
                    url: 'api/reset_teacher_password.php',
                    method: 'POST',
                    data: { teacher_id: id, new_password: result.value },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('สำเร็จ!', 'รีเซ็ทรหัสผ่านเรียบร้อยแล้ว', 'success');
                        } else {
                            Swal.fire('ผิดพลาด', res.message || 'ไม่สามารถรีเซ็ทรหัสผ่านได้', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('ผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    };

    window.toggleSwalPassword = function() {
        const input = document.getElementById('swal_new_password');
        const icon = document.getElementById('swalPasswordIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
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
                if (key === 'password') key = 'editPassword';
                if (key === 'teach_name') key = 'editTeach_name';
                if (key === 'teach_sex') key = 'editTeach_sex';
                if (key === 'teach_birthday') key = 'editTeach_birth';
                if (key === 'teach_phone') key = 'editTeach_phone';
                if (key === 'teach_email') key = 'editTeach_email';
                if (key === 'teach_addr') key = 'editTeach_addr';
                if (key === 'teach_major') key = 'editTeach_major';
                if (key === 'teach_position2') key = 'editTeach_position2';
                if (key === 'teach_hidegree') key = 'editTeach_HiDegree';
                if (key === 'teach_status') key = 'editTeach_status';
                if (key === 'role_person') key = 'editrole_person';
                if (key === 'teach_class') key = 'editTeach_class';
                if (key === 'teach_room') key = 'editTeach_room';
            } else {
                if (key === 'teach_id') key = 'addTeach_id';
                if (key === 'password') key = 'addPassword';
                if (key === 'teach_name') key = 'addTeach_name';
                if (key === 'teach_sex') key = 'addTeach_sex';
                if (key === 'teach_birthday') key = 'addTeach_birth';
                if (key === 'teach_phone') key = 'addTeach_phone';
                if (key === 'teach_email') key = 'addTeach_email';
                if (key === 'teach_addr') key = 'addTeach_addr';
                if (key === 'teach_major') key = 'addTeach_major';
                if (key === 'teach_position2') key = 'addTeach_position2';
                if (key === 'teach_hidegree') key = 'addTeach_HiDegree';
                if (key === 'teach_status') key = 'addTeach_status';
                if (key === 'role_person') key = 'addrole_std';
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
    @apply text-xs border border-gray-200 dark:border-gray-700 rounded-lg px-2 py-1 outline-none mr-1 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300;
}
#record_table_wrapper .dataTables_filter input {
    @apply w-full text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 outline-none bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300;
}
#record_table_wrapper .dataTables_filter {
    @apply w-full sm:w-auto;
}
#record_table_wrapper .dataTables_filter label {
    @apply flex items-center gap-2 w-full;
}
#record_table_wrapper .dataTables_paginate .paginate_button {
    @apply rounded-lg border-none font-bold text-xs px-2 py-1 !important;
}
#record_table_wrapper .dataTables_paginate .paginate_button.current {
    @apply bg-purple-600 text-white !important;
}
#record_table_wrapper .dataTables_info {
    @apply text-[10px] text-gray-500 dark:text-gray-400 mt-2;
}
#record_table_wrapper .dataTables_paginate {
    @apply mt-2;
}

/* Table cell padding */
#record_table td, #record_table th {
    @apply px-1 sm:px-3 py-2;
}

/* Hide columns on mobile - Column indexes:
   0: #, 1: ID, 2: Name, 3: Major, 4: Position, 5: Status, 6: Photo, 7: Role, 8: Actions */

/* Mobile (< 640px): Show only ID, Name, Actions */
@media (max-width: 639px) {
    #record_table th:nth-child(1),
    #record_table td:nth-child(1),
    #record_table th:nth-child(4),
    #record_table td:nth-child(4),
    #record_table th:nth-child(5),
    #record_table td:nth-child(5),
    #record_table th:nth-child(6),
    #record_table td:nth-child(6),
    #record_table th:nth-child(7),
    #record_table td:nth-child(7),
    #record_table th:nth-child(8),
    #record_table td:nth-child(8) {
        display: none !important;
    }
}

/* Tablet (640px - 1023px): Show ID, Name, Major, Actions */
@media (min-width: 640px) and (max-width: 1023px) {
    #record_table th:nth-child(5),
    #record_table td:nth-child(5),
    #record_table th:nth-child(6),
    #record_table td:nth-child(6),
    #record_table th:nth-child(7),
    #record_table td:nth-child(7),
    #record_table th:nth-child(8),
    #record_table td:nth-child(8) {
        display: none !important;
    }
}

/* Desktop (1024px+): Show all except Photo */
@media (min-width: 1024px) and (max-width: 1279px) {
    #record_table th:nth-child(7),
    #record_table td:nth-child(7) {
        display: none !important;
    }
}

/* Line clamp utility */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes zoom-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-zoom-in { animation: zoom-in 0.3s ease-out; }

.scrollbar-thin::-webkit-scrollbar { width: 6px; }
.scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.dark .scrollbar-thin::-webkit-scrollbar-thumb { background: #334155; }
</style>
