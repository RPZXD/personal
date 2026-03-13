<?php

require_once __DIR__ . '/../classes/DatabaseUsers.php';

class User
{
    // เพิ่ม mapping สำหรับ role ที่อนุญาต
    private static $allowedUserRoles = [
        'Teacher' => ['T', 'ADM', 'VP', 'OF', 'DIR', 'HOD'],
        'Officer' => ['ADM', 'OF'],
        'Admin' => ['ADM']
    ];

    public static function authenticate($username, $password, $role)
    {
        $db = new DatabaseUsers();
        $user = $db->getTeacherByUsername($username);

        if ($user) {
            // ถ้า password ว่าง (ยังไม่ได้ตั้งรหัสผ่านใหม่) ให้เช็คกับรหัสผ่านเริ่มต้น (Teach_id)
            if (empty($user['password'])) {
                // ถ้าใส่รหัสผ่านถูก (เท่ากับ username/Teach_id หรือ Teach_password) ให้ไปหน้าเปลี่ยนรหัสผ่าน
                if ($password === $user['Teach_id'] || (isset($user['Teach_password']) && $password === $user['Teach_password'])) {
                    return 'change_password';
                }
            } else {
                // ถ้ามีรหัสผ่านแบบ hash แล้ว ให้ตรวจสอบด้วย password_verify
                if (password_verify($password, $user['password']) && self::roleMatch($user['role_person'] ?? 'T', $role)) {
                    return $user;
                }
            }
        }
        return false;
    }

    private static function roleMatch($role_person, $role)
    {
        if (!isset(self::$allowedUserRoles[$role])) {
            return false;
        }
        return in_array($role_person, self::$allowedUserRoles[$role]);
    }
}
