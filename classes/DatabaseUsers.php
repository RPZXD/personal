<?php

class DatabaseUsers
{
    private $pdo;

    public function __construct()
    {
        // ใช้การเชื่อมต่อ database เดิม
        require_once __DIR__ . '/../config/Database.php';
        $db = new Database_User();
        $this->pdo = $db->getConnection();
    }

    public function getTeacherByUsername($username)
    {
        try {
            // ใช้ Teach_id เป็น username ตามโครงสร้างเดิม
            $sql = "SELECT * FROM teacher WHERE Teach_id = :username LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getTeacherById($id)
    {
        try {
            $sql = "SELECT * FROM teacher WHERE Teach_id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
