<?php
class Setting {
    private $school = "โรงเรียนพิชัย";
    private $titlesystem = "ระบบจัดการข้อมูลบุคลากร";
    private $pageTitle;
    private $pageTitleShort = "PERSONEL";
    private $logoImage = "/dist/img/logo-phicha.png";
    private $imgProfile = "https://std.phichai.ac.th/teacher/uploads/phototeach/";
    private $imgAwards = "https://person.phichai.ac.th/teacher/uploads/file_award/";
    // private $imgAwards = "uploads/file_award/";
    private $imgTraining = "https://person.phichai.ac.th/teacher/uploads/file_seminar/";
    // private $imgTraining = "uploads/seminar/";
    private $uploadDir_seminar = "../uploads/file_seminar/";
    private $uploadDir_award = "../uploads/file_award/";
    private $uploadDir_profile = "../../std.phichai.ac.th/teacher/uploads/phototeach/";

    public function getPageTitle() {
        $this->pageTitle = $this->titlesystem . " | " . $this->school;
        return $this->pageTitle;
    }

    public function getPageTitleShort() {
        return $this->pageTitleShort;
    }

    public function getLogoImage() {
        return $this->logoImage;
    }

    public function getImgProfile() {
        return $this->imgProfile;
    }

    public function getImgAwards() {
        return $this->imgAwards;
    }
    public function getImgTraining() {
        return $this->imgTraining;
    }
    public function getUploadDir_seminar() {
        return $this->uploadDir_seminar;
    }
    public function getUploadDir_award() {
        return $this->uploadDir_award;
    }
    public function getUploadDir_profile() {
        return $this->uploadDir_profile;
    }

}
?>
