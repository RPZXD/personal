<?php

class Person {
    private $conn;
    private $table_position = "tb_position2";
    private $table_academic = "tb_academic";
    private $table_seminar = "tb_seminar";
    private $table_award = "tb_award";
    private $table_leave = "tb_leave";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPositionById($position_id) {
        $query = "SELECT namep2 FROM {$this->table_position} WHERE pid2 = :position_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':position_id', $position_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAcademicById($academic_id) {
        $query = "SELECT namec FROM {$this->table_academic} WHERE cid = :academic_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':academic_id', $academic_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAllPositions() {
        $query = "SELECT pid2, namep2 FROM {$this->table_position}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAcademics() {
        $query = "SELECT cid, namec FROM {$this->table_academic}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrainingByTeacherId($tid, $term = '', $year = '') {
        $query = "SELECT * FROM {$this->table_seminar} WHERE tid = :tid";
        if (!empty($term)) {
            $query .= " AND term = :term";
        }
        if (!empty($year)) {
            $query .= " AND year = :year";
        }
        $query .= " ORDER BY dstart DESC, semid DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        if (!empty($term)) {
            $stmt->bindParam(':term', $term);
        }
        if (!empty($year)) {
            $stmt->bindParam(':year', $year);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChartTrainingByTeacherId($tid, $term = '', $year = '') {
        $query = "SELECT 
                    semid, 
                    tid, 
                    topic, 
                    dstart, 
                    dend, 
                    term, 
                    year, 
                    supports, 
                    place, 
                    (hours + (mn / 60)) AS total_hours, 
                    numday, 
                    types, 
                    CASE 
                        WHEN types = 1 THEN 'ภายใน' 
                        WHEN types = 2 THEN 'ภายนอก' 
                        ELSE 'ไม่ระบุ' 
                    END AS type_name, 
                    budget, 
                    sdoc, 
                    know, 
                    way, 
                    suggest 
                  FROM {$this->table_seminar} 
                  WHERE tid = :tid";
    
        if (!empty($term)) {
            $query .= " AND term = :term";
        }
        if (!empty($year)) {
            $query .= " AND year = :year";
        }
        
        $query .= " ORDER BY dstart DESC, semid DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        if (!empty($term)) {
            $stmt->bindParam(':term', $term);
        }
        if (!empty($year)) {
            $stmt->bindParam(':year', $year);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    



    public function getDistinctYears() {
        $query = "SELECT DISTINCT year FROM {$this->table_seminar} ORDER BY year DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function fetchResults($stmt, $singleRow = false) {
        $stmt->execute();
        if ($singleRow) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTotalHoursAndMinutes($tid, $term, $year) {
        $query = "SELECT
                    FLOOR(SUM(hours) + SUM(mn) / 60) AS total_hours,
                    MOD(SUM(mn), 60) AS total_minutes
                  FROM {$this->table_seminar}
                  WHERE tid = :tid AND term = :term AND year = :year
                  GROUP BY tid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalHoursAndMinutesByTermAndYear($term, $year) {
        $query = "SELECT
                    tid,
                    FLOOR(SUM(hours) + SUM(mn) / 60) AS total_hours,
                    MOD(SUM(mn), 60) AS total_minutes
                  FROM {$this->table_seminar}
                  WHERE term = :term AND year = :year
                  GROUP BY tid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrainingByMonth($month) {
        $query = "SELECT
                        tid,
                        topic,
                        dstart,
                        dend,
                        place,
                        budget
                  FROM {$this->table_seminar}
                  WHERE DATE_FORMAT(dstart, '%Y-%m') = :month
                  GROUP BY tid
                    ORDER BY tid ASC, dstart ASC
                    ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrainingById($semid) {
        $query = "SELECT * FROM {$this->table_seminar} WHERE semid = :semid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':semid', $semid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTraining($semid, $data) {
        $query = "UPDATE {$this->table_seminar} SET 
                    tid = :tid,
                    term = :term,
                    year = :year,
                    dstart = :dstart,
                    dend = :dend,
                    hours = :hours,
                    mn = :mn
                  WHERE semid = :semid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $data['tid']);
        $stmt->bindParam(':term', $data['term']);
        $stmt->bindParam(':year', $data['year']);
        $stmt->bindParam(':dstart', $data['dstart']);
        $stmt->bindParam(':dend', $data['dend']);
        $stmt->bindParam(':hours', $data['hours']);
        $stmt->bindParam(':mn', $data['mn']);
        $stmt->bindParam(':semid', $semid);
        return $stmt->execute();
    }

    public function getTrainingDetailsById($semid) {
        $query = "SELECT * FROM {$this->table_seminar} WHERE semid = :semid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':semid', $semid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTrainingDetails($semid, $tid, $topic, $dstart, $dend, $term, $year, $supports, $place, $hours, $mn, $numday, $types, $budget, $sdoc, $know, $way, $suggest) {
        $query = "UPDATE {$this->table_seminar} SET 
                    tid = :tid,
                    topic = :topic,
                    dstart = :dstart,
                    dend = :dend,
                    term = :term,
                    year = :year,
                    supports = :supports,
                    place = :place,
                    hours = :hours,
                    mn = :mn,
                    numday = :numday,
                    types = :types,
                    budget = :budget,
                    know = :know,
                    way = :way,
                    suggest = :suggest";
        if (!empty($sdoc)) {
            $query .= ", sdoc = :sdoc";
        }
        $query .= " WHERE semid = :semid";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        $stmt->bindParam(':topic', $topic);
        $stmt->bindParam(':dstart', $dstart);
        $stmt->bindParam(':dend', $dend);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':supports', $supports);
        $stmt->bindParam(':place', $place);
        $stmt->bindParam(':hours', $hours);
        $stmt->bindParam(':mn', $mn);
        $stmt->bindParam(':numday', $numday);
        $stmt->bindParam(':types', $types);
        $stmt->bindParam(':budget', $budget);
        if (!empty($sdoc)) {
            $stmt->bindParam(':sdoc', $sdoc);
        }
        $stmt->bindParam(':know', $know);
        $stmt->bindParam(':way', $way);
        $stmt->bindParam(':suggest', $suggest);
        $stmt->bindParam(':semid', $semid);
        return $stmt->execute();
    }

    public function insertTrainingDetails($tid, $topic, $dstart, $dend, $term, $year, $supports, $place, $hours, $mn, $numday, $types, $budget, $sdoc, $know, $way, $suggest) {
        $query = "INSERT INTO {$this->table_seminar} (tid, topic, dstart, dend, term, year, supports, place, hours, mn, numday, types, budget, sdoc, know, way, suggest) 
                  VALUES (:tid, :topic, :dstart, :dend, :term, :year, :supports, :place, :hours, :mn, :numday, :types, :budget, :sdoc, :know, :way, :suggest)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        $stmt->bindParam(':topic', $topic);
        $stmt->bindParam(':dstart', $dstart);
        $stmt->bindParam(':dend', $dend);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':supports', $supports);
        $stmt->bindParam(':place', $place);
        $stmt->bindParam(':hours', $hours);
        $stmt->bindParam(':mn', $mn);
        $stmt->bindParam(':numday', $numday);
        $stmt->bindParam(':types', $types);
        $stmt->bindParam(':budget', $budget);
        $stmt->bindParam(':sdoc', $sdoc);
        $stmt->bindParam(':know', $know);
        $stmt->bindParam(':way', $way);
        $stmt->bindParam(':suggest', $suggest);
        return $stmt->execute();
    }

    public function deleteTrainingById($semid) {
        $query = "DELETE FROM {$this->table_seminar} WHERE semid = :semid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':semid', $semid);
        return $stmt->execute();
    }

    public function getAwardsByTeacherId($tid, $term = '', $year = '') {
        $query = "SELECT * FROM {$this->table_award} WHERE tid = :tid";
        if (!empty($term)) {
            $query .= " AND term = :term";
        }
        if (!empty($year)) {
            $query .= " AND year = :year";
        }
        $query .= " ORDER BY date1 DESC, awid DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        if (!empty($term)) {
            $stmt->bindParam(':term', $term);
        }
        if (!empty($year)) {
            $stmt->bindParam(':year', $year);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChartAwardsByTeacherId($tid, $term = '', $year = '') {
        $query = "SELECT 
                    level, 
                    CASE 
                        WHEN level = '1' THEN 'เขต/จังหวัด'
                        WHEN level = '2' THEN 'ภาค'
                        WHEN level = '3' THEN 'ชาติ'
                        WHEN level = '4' THEN 'นานาชาติ'
                        ELSE 'ไม่ระบุ'
                    END AS level_name, 
                    COUNT(*) AS total_awards
                  FROM {$this->table_award} 
                  WHERE tid = :tid";
    
        if (!empty($term)) {
            $query .= " AND term = :term";
        }
        if (!empty($year)) {
            $query .= " AND year = :year";
        }
    
        $query .= " GROUP BY level ORDER BY level ASC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        if (!empty($term)) {
            $stmt->bindParam(':term', $term);
        }
        if (!empty($year)) {
            $stmt->bindParam(':year', $year);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getDistinctYearsFromAwards() {
        $query = "SELECT DISTINCT year FROM {$this->table_award} ORDER BY year DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAwardDetailsById($awid) {
        $query = "SELECT * FROM {$this->table_award} WHERE awid = :awid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':awid', $awid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertAwardDetails($tid, $award, $level, $date1, $term, $year, $department, $certificate) {
        $query = "INSERT INTO {$this->table_award} (tid, award, level, date1, term, year, department, certificate) 
                  VALUES (:tid, :award, :level, :date1, :term, :year, :department, :certificate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        $stmt->bindParam(':award', $award);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':date1', $date1);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':certificate', $certificate);
        return $stmt->execute();
    }

    public function updateAwardDetails($awid, $tid, $award, $level, $date1, $term, $year, $department, $certificate) {
        $query = "UPDATE {$this->table_award} SET 
                    tid = :tid,
                    award = :award,
                    level = :level,
                    date1 = :date1,
                    term = :term,
                    year = :year,
                    department = :department";
        if (!empty($certificate)) {
            $query .= ", certificate = :certificate";
        }
        $query .= " WHERE awid = :awid";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        $stmt->bindParam(':award', $award);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':date1', $date1);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':department', $department);
        if (!empty($certificate)) {
            $stmt->bindParam(':certificate', $certificate);
        }
        $stmt->bindParam(':awid', $awid);
        return $stmt->execute();
    }

    public function deleteAwardById($awid) {
        $query = "DELETE FROM {$this->table_award} WHERE awid = :awid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':awid', $awid);
        return $stmt->execute();
    }

    public function getLeavesByTeacherId($tid, $term = '', $year = '') {
        $query = "SELECT * FROM {$this->table_leave} WHERE Teach_id = :tid";
        if (!empty($term)) {
            $query .= " AND term = :term";
        }
        if (!empty($year)) {
            $query .= " AND year = :year";
        }
        $query .= " ORDER BY date_start DESC, id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        if (!empty($term)) {
            $stmt->bindParam(':term', $term);
        }
        if (!empty($year)) {
            $stmt->bindParam(':year', $year);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLeaveDetailsById($id) {
        $query = "SELECT * FROM {$this->table_leave} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLeaveById($id) {
        $query = "SELECT * FROM {$this->table_leave} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertLeaveDetails($data) {
        $query = "INSERT INTO {$this->table_leave} (Teach_id, status, date_start, date_end, detail, other_leave_type) 
                  VALUES (:tid, :status, :date_start, :date_end, :detail, :other_leave_type)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $data['tid']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':date_start', $data['date_start']);
        $stmt->bindParam(':date_end', $data['date_end']);
        $stmt->bindParam(':detail', $data['detail']);
        $stmt->bindParam(':other_leave_type', $data['other_leave_type']);
        return $stmt->execute();
    }

    public function updateLeaveDetails($data) {
        $query = "UPDATE {$this->table_leave} SET 
                    Teach_id = :tid,
                    status = :status,
                    date_start = :date_start,
                    date_end = :date_end,
                    detail = :detail,
                    other_leave_type = :other_leave_type
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $data['tid']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':date_start', $data['date_start']);
        $stmt->bindParam(':date_end', $data['date_end']);
        $stmt->bindParam(':detail', $data['detail']);
        $stmt->bindParam(':other_leave_type', $data['other_leave_type']);
        $stmt->bindParam(':id', $data['id']);
        return $stmt->execute();
    }

    public function deleteLeaveById($id) {
        $query = "DELETE FROM {$this->table_leave} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getLeavesByTeacherIdAndDateRange($tid, $date_start = '', $date_end = '') {
        $query = "SELECT * FROM {$this->table_leave} WHERE Teach_id = :tid";
        if (!empty($date_start)) {
            $query .= " AND create_at >= :date_start";
        }
        if (!empty($date_end)) {
            $query .= " AND create_at <= :date_end";
        }
        $query .= " ORDER BY create_at DESC, id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        if (!empty($date_start)) {
            $stmt->bindParam(':date_start', $date_start);
        }
        if (!empty($date_end)) {
            $stmt->bindParam(':date_end', $date_end);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChartLeavesByTeacherIdAndDateRange($tid, $date_start = '', $date_end = '') {
        $query = "SELECT 
                    status, 
                    CASE 
                        WHEN status = '1' THEN 'ลาป่วย'
                        WHEN status = '2' THEN 'ลากิจ'
                        WHEN status = '3' THEN 'ไปราชการ'
                        WHEN status = '4' THEN 'ลาคลอด'
                        WHEN status = '9' THEN 'อื่นๆ'
                        ELSE 'ไม่ระบุ'
                    END AS status_name, 
                    SUM(DATEDIFF(date_end, date_start) + 1) AS total_days
                  FROM {$this->table_leave}
                  WHERE Teach_id = :tid";
    
        if (!empty($date_start)) {
            $query .= " AND create_at >= :date_start";
        }
        if (!empty($date_end)) {
            $query .= " AND create_at <= :date_end";
        }
    
        $query .= " GROUP BY status ORDER BY status ASC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
    
        if (!empty($date_start)) {
            $stmt->bindParam(':date_start', $date_start);
        }
        if (!empty($date_end)) {
            $stmt->bindParam(':date_end', $date_end);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function update_person($Teach_id, $Teach_name, $Teach_major, $Teach_phone, $Teach_addr, $Teach_email, $Teach_Position, $Teach_Academic, $Teach_HiDegree, $Teach_photo = null) {
        $query = "UPDATE tb_teacher SET 
                    Teach_name = :Teach_name,
                    Teach_major = :Teach_major,
                    Teach_phone = :Teach_phone,
                    Teach_addr = :Teach_addr,
                    Teach_email = :Teach_email,
                    Teach_Position = :Teach_Position,
                    Teach_Academic = :Teach_Academic,
                    Teach_HiDegree = :Teach_HiDegree";
        if ($Teach_photo) {
            $query .= ", Teach_photo = :Teach_photo";
        }
        $query .= " WHERE Teach_id = :Teach_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':Teach_name', $Teach_name);
        $stmt->bindParam(':Teach_major', $Teach_major);
        $stmt->bindParam(':Teach_phone', $Teach_phone);
        $stmt->bindParam(':Teach_addr', $Teach_addr);
        $stmt->bindParam(':Teach_email', $Teach_email);
        $stmt->bindParam(':Teach_Position', $Teach_Position);
        $stmt->bindParam(':Teach_Academic', $Teach_Academic);
        $stmt->bindParam(':Teach_HiDegree', $Teach_HiDegree);
        if ($Teach_photo) {
            $stmt->bindParam(':Teach_photo', $Teach_photo);
        }
        $stmt->bindParam(':Teach_id', $Teach_id);
        return $stmt->execute();
    }

    public function getLeaveSummaryByDate($date) {
        $query = "SELECT *
                  FROM {$this->table_leave}
                  WHERE date_start <= :date AND date_end >= :date";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isLeavePeriodOverlapping($tid, $date_start, $date_end) {
        $query = "SELECT COUNT(*) FROM {$this->table_leave} 
                  WHERE Teach_id = :tid 
                  AND ((date_start <= :date_end AND date_end >= :date_start))";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tid', $tid);
        $stmt->bindParam(':date_start', $date_start);
        $stmt->bindParam(':date_end', $date_end);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function getDashboardStats($tid, $year) {
        // Training stats
        $query_training = "SELECT 
                            SUM(hours + (mn / 60)) as total_hours,
                            COUNT(*) as total_trainings,
                            SUM(budget) as total_budget
                           FROM {$this->table_seminar} 
                           WHERE tid = :tid AND year = :year";
        $stmt_t = $this->conn->prepare($query_training);
        $stmt_t->execute([':tid' => $tid, ':year' => $year]);
        $training = $stmt_t->fetch(PDO::FETCH_ASSOC);

        // Awards stats
        $query_awards = "SELECT COUNT(*) as count FROM {$this->table_award} WHERE tid = :tid AND year = :year";
        $stmt_a = $this->conn->prepare($query_awards);
        $stmt_a->execute([':tid' => $tid, ':year' => $year]);
        $awards = $stmt_a->fetch(PDO::FETCH_ASSOC)['count'];

        // Leave stats
        $query_leave = "SELECT 
                            SUM(CASE WHEN status = '1' THEN (DATEDIFF(date_end, date_start) + 1) ELSE 0 END) as sick_days,
                            SUM(CASE WHEN status = '2' THEN (DATEDIFF(date_end, date_start) + 1) ELSE 0 END) as personal_days,
                            SUM(DATEDIFF(date_end, date_start) + 1) as total_days
                         FROM {$this->table_leave} 
                         WHERE Teach_id = :tid 
                         AND (YEAR(date_start) = :year_eng OR YEAR(date_end) = :year_eng)";
        
        // Convert Thai year to Gregorian for DATE functions
        $year_eng = intval($year) - 543;
        $stmt_l = $this->conn->prepare($query_leave);
        $stmt_l->execute([':tid' => $tid, ':year_eng' => $year_eng]);
        $leave = $stmt_l->fetch(PDO::FETCH_ASSOC);

        return [
            'training' => $training,
            'awards' => $awards,
            'leave' => $leave
        ];
    }
}
