<?php
$pageTitle = $title ?? 'เปลี่ยนรหัสผ่าน';
ob_start();
?>

<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 rounded-3xl">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl mb-4 animate-bounce-slow">
                <i class="fas fa-key text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-black gradient-text tracking-tight mb-2">เปลี่ยนรหัสผ่านใหม่</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">เพื่อความปลอดภัยของบัญชีผู้ใช้งาน</p>
        </div>

        <!-- Alert Notification -->
        <div class="mb-6 p-4 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 shadow-sm animate-fade-in">
            <div class="flex gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-amber-600 dark:text-amber-400"></i>
                </div>
                <div class="text-xs md:text-sm text-amber-800 dark:text-amber-200 font-medium leading-relaxed">
                    รหัสผ่านต้องมีอย่างน้อย <span class="font-bold underline">6 ตัวอักษร</span> ประกอบด้วย<span class="font-bold">ตัวอักษรและตัวเลข</span> และห้ามมีภาษาไทย
                </div>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="glass rounded-3xl p-8 border border-white/30 dark:border-slate-700/50 shadow-2xl relative overflow-hidden card-hover">
            <form id="changePasswordForm" method="POST" class="space-y-6 relative z-10">
                <!-- New Password -->
                <div class="space-y-2">
                    <label class="block text-slate-700 dark:text-slate-300 font-bold text-sm ml-1">
                        รหัสผ่านใหม่
                    </label>
                    <div class="relative group">
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            class="w-full px-5 py-4 rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none pr-12" 
                            placeholder="ระบุรหัสผ่านใหม่..."
                            required
                        >
                        <button type="button" onclick="togglePass('new_password', 'icon1')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500 transition-colors">
                            <i class="fas fa-eye" id="icon1"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label class="block text-slate-700 dark:text-slate-300 font-bold text-sm ml-1">
                        ยืนยันรหัสผ่านอีกครั้ง
                    </label>
                    <div class="relative group">
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="w-full px-5 py-4 rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none pr-12" 
                            placeholder="ยืนยันรหัสผ่าน..."
                            required
                        >
                        <button type="button" onclick="togglePass('confirm_password', 'icon2')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500 transition-colors">
                            <i class="fas fa-eye" id="icon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    name="change_pass"
                    class="w-full btn-primary text-white py-4 rounded-2xl font-black text-lg shadow-xl shadow-blue-500/20 flex items-center justify-center gap-3 active:scale-95 transition-transform"
                >
                    <i class="fas fa-save"></i>
                    บันทึกรหัสผ่านใหม่
                </button>
            </form>
        </div>

        <!-- Logout Link -->
        <div class="mt-8 text-center text-sm font-medium">
            <a href="logout.php" class="text-slate-400 hover:text-rose-500 transition-colors flex items-center justify-center gap-2 group">
                <i class="fas fa-sign-out-alt group-hover:-translate-x-1 transition-transform"></i>
                ยกเลิกและออกจากระบบ
            </a>
        </div>
    </div>
</div>

<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

<?php if (isset($swalAlert)): ?>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<?php echo $swalAlert['title']; ?>',
        text: '<?php echo $swalAlert['text']; ?>',
        icon: '<?php echo $swalAlert['icon']; ?>',
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#3b82f6',
        timer: <?php echo $swalAlert['icon'] === 'success' ? 2000 : 5000; ?>,
        timerProgressBar: true
    }).then(() => {
        <?php if (isset($swalAlert['redirect'])): ?>
        window.location.href = '<?php echo $swalAlert['redirect']; ?>';
        <?php endif; ?>
    });
});
<?php endif; ?>
</script>

<?php
$content = ob_get_clean();
// Check if htdocs/personal/views/layouts/app.php exists
require __DIR__ . '/../layouts/app.php';
?>
