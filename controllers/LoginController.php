<?php

require_once __DIR__ . '/../classes/DatabaseUsers.php';

class LoginController
{
    private $allowedUserRoles = [
        'Teacher' => ['T', 'ADM', 'VP', 'OF', 'DIR', 'HOD'],
        'Officer' => ['ADM', 'OF'],
        'Admin' => ['ADM']
    ];

    public function login($username, $password, $role)
    {
        $db = new DatabaseUsers();
        
        $user = $db->getTeacherByUsername($username);

        if (!$user) {
            return "ไม่พบผู้ใช้งานนี้ในระบบ 🚫";
        }

        // ตรวจสอบรหัสผ่านแบบ hash (password column)
        $storedPassword = $user['password'] ?? '';
        
        if (!password_verify($password, $storedPassword)) {
            return "รหัสผ่านไม่ถูกต้อง 🚫";
        }
        
        // ตรวจสอบ role (ใช้ role_person ตามระบบเดิม)
        $userRole = $user['role_person'] ?? 'T';
        if (!$this->roleMatch($userRole, $role)) {
            return "บทบาทผู้ใช้ไม่ถูกต้อง 🚫";
        }

        // ตั้งค่า session
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['user'] = $user['Teach_id'];
        $_SESSION[$role . '_login'] = [
            'Teach_id' => $user['Teach_id'],
            'Teach_name' => $user['Teach_name'] ?? '',
            'role_person' => $userRole,
            'Teach_photo' => $user['Teach_photo'] ?? ''
        ];
        
        return 'success';
    }

    private function roleMatch($role_person, $role)
    {
        if (!isset($this->allowedUserRoles[$role])) {
            return false;
        }
        return in_array($role_person, $this->allowedUserRoles[$role]);
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
