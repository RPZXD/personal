<!-- Login View -->
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-primary-500 to-indigo-600 rounded-2xl shadow-xl shadow-primary-500/30 mb-6 animate-bounce-slow">
                <i class="fas fa-user-shield text-4xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold gradient-text">เข้าสู่ระบบ</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400"><?php echo $global['nameschool']; ?></p>
        </div>

        <!-- Login Form Card -->
        <div class="glass rounded-2xl p-8">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="space-y-6">
                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user mr-2 text-primary-500"></i>ชื่อผู้ใช้งาน
                    </label>
                    <input type="text" name="username" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           placeholder="กรุณากรอกชื่อผู้ใช้งาน" autocomplete="username">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-2 text-primary-500"></i>รหัสผ่าน
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                               placeholder="กรุณากรอกรหัสผ่าน" autocomplete="current-password">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-id-badge mr-2 text-primary-500"></i>เลือกบทบาท
                    </label>
                    <select name="role" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        <option value="">-- เลือกบทบาท --</option>
                        <option value="Teacher" selected>👨‍🏫 ครู</option>
                        <option value="Officer">🧑‍💼 เจ้าหน้าที่</option>
                        <option value="Admin">🛠️ Admin</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="signin"
                        class="w-full py-4 px-6 bg-gradient-to-r from-primary-500 to-indigo-600 hover:from-primary-600 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-primary-500/50 transition-all transform hover:-translate-y-1">
                    <i class="fas fa-sign-in-alt mr-2"></i>เข้าสู่ระบบ
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white dark:bg-slate-800 text-gray-500 dark:text-gray-400">หรือ</span>
                </div>
            </div>

            <!-- Help Text -->
            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                <p>ยังไม่มีบัญชี? <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">ติดต่อผู้ดูแลระบบ</a></p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="index.php" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-500 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>กลับหน้าหลัก</span>
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-400 text-xs">
            <span class="mr-1">🤝</span> Personnel Management System <span class="ml-1">🎉</span>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    var passwordInput = document.getElementById('password');
    var toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
