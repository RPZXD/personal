<?php

require_once __DIR__ . '/../models/User.php';

class LoginController
{
    public function login($username, $password, $role)
    {
        $user = User::authenticate($username, $password, $role);
        
        if ($user === 'change_password') {
            $_SESSION['change_password_user'] = $username;
            header('Location: change_password.php');
            exit;
        }

        if ($user) {
            // ตั้งค่า session
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $input_role ?? $role;
            $_SESSION['user'] = $user['Teach_id'];
            $_SESSION[$role . '_login'] = [
                'Teach_id' => $user['Teach_id'],
                'Teach_name' => $user['Teach_name'] ?? '',
                'role_person' => $user['role_person'] ?? 'T',
                'Teach_photo' => $user['Teach_photo'] ?? ''
            ];
            
            return 'success';
        }
        
        return "ชื่อผู้ใช้, รหัสผ่าน หรือบทบาทไม่ถูกต้อง 🚫";
    }

    public function getRedirectUrl($role)
    {
        $redirects = [
            'Teacher' => 'teacher/index.php',
            'Officer' => 'officer/index.php',
            'Admin' => 'admin/index.php'
        ];
        
        return $redirects[$role] ?? 'index.php';
    }
}
