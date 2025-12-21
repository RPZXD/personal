<?php 

    class Bootstrap {
        public function displayAlert($message, $type) {
            echo '<div class="alert alert-'. $type .'" role="alert">';
            echo ''. $message .'';
            echo '</div>';
        }
    }

    class SweetAlert2 {
        private $type;
        private $message;
        private $redirectUrl;
    
        // Constructor to initialize the type, message, and redirect URL
        public function __construct($message, $type = 'info', $redirectUrl = '') {
            $this->message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
            $this->type = $this->validateType($type);
            $this->redirectUrl = htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8');
        }
    
        // Validate the alert type
        private function validateType($type) {
            $validTypes = ['success', 'error', 'warning', 'info'];
            return in_array($type, $validTypes) ? $type : 'info';
        }
    
        // Generate the JavaScript for SweetAlert2 with optional redirect
        public function renderAlert() {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "' . ucfirst($this->type) . '",
                        text: "' . $this->message . '",
                        icon: "' . $this->type . '",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed && "' . $this->redirectUrl . '" !== "") {
                            window.location.href = "' . $this->redirectUrl . '";
                        }
                    });
                });
            </script>';
        }
    }

    class Utils {
        public static function convertToThaiDate($date) {
            if (empty($date) || $date == '0000-00-00') return "ไม่ระบุ";
            $months = [
                "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม",
                "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน",
                "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน",
                "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม"
            ];
    
            $year = substr($date, 0, 4);
            $month_idx = substr($date, 5, 2);
            $month = isset($months[$month_idx]) ? $months[$month_idx] : "ไม่ระบุ";
            $day = (int)substr($date, 8, 2);
    
            return "{$day} {$month} " . ($year > 2500 ? $year : $year + 543);
        }

        public static function convertToThaiDatePlus($date) {
            $months = [
                "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม",
                "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน",
                "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน",
                "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม"
            ];
    
            $year = substr($date, 0, 4) + 543;
            $month = $months[substr($date, 5, 2)];
            $day = (int)substr($date, 8, 2);
    
            return "{$day} {$month} {$year}";
        }
    }

?>