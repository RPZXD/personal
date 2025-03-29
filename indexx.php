<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแรก</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .menu-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
            max-width: 200px; /* Adjust as needed */
            height: 100%;
            min-height: 150px; /* Ensure buttons have some minimum height */
            text-align: center; /* Center text within the button */
        }

        .menu-button:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .menu-button i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .menu-button span {
            font-size: 1rem;
            font-weight: 600;
        }

        .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f7fafc; /* สีพื้นหลังอ่อนๆ */
            color: #1a202c; /* สีข้อความเข้ม */
            font-size: 24px;
            font-weight: 600;
        }
        .swiper-button-next, .swiper-button-prev {
            color: #4a5568; /* สีของปุ่ม */
            background-color: rgba(255, 255, 255, 0.7); /* พื้นหลังปุ่มแบบโปร่งใส */
            border-radius: 9999px; /* ทำให้ปุ่มกลม */
            padding: 16px; /* เพิ่มขนาดปุ่ม */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* เพิ่มเงาเล็กน้อย */
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background-color: rgba(255, 255, 255, 0.9); /* เปลี่ยนสีพื้นหลังเมื่อโฮเวอร์ */
            transform: scale(1.1); /* ขยายเล็กน้อยเมื่อโฮเวอร์ */
        }
        .swiper-pagination-bullet {
            background-color: #cbd5e0; /* สีของจุด */
            opacity: 0.8; /* ความโปร่งใสเริ่มต้น */
        }
        .swiper-pagination-bullet-active {
            background-color: #4a5568; /* สีของจุดที่ใช้งานอยู่ */
            opacity: 1; /* ความโปร่งใสเมื่อใช้งาน */
        }

    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-semibold text-gray-800 text-center mb-8">เมนูต่างๆ</h1>

        <div class="w-full rounded-lg shadow-xl overflow-hidden mb-8">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">Slide 1: ยินดีต้อนรับ</div>
                    <div class="swiper-slide">Slide 2: ข้อมูลเพิ่มเติม</div>
                    <div class="swiper-slide">Slide 3: ติดต่อเรา</div>
                    <div class="swiper-slide">Slide 4: บริการของเรา</div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-items-center">
            <a href="#" class="menu-button">
                <i class="fas fa-graduation-cap"></i>
                <span>ระบบการสอน</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-users"></i>
                <span>ระบบการดูแลช่วยเหลือนักเรียน</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-shopping-cart"></i>
                <span>ระบบจัดซื้อ-จัดจ้างพัสดุการเงิน</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-futbol"></i>
                <span>ระบบกิจกรรมนักเรียน</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-file-alt"></i>
                <span>DPA ข้อตกลงการพัฒนางาน</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-id-card"></i>
                <span>ระบบข้อมูลบุคลากร</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-file-pdf"></i>
                <span>ระบบเอกสารคำสั่ง</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-user-plus"></i>
                <span>งานรับนักเรียน</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-money-bill-wave"></i>
                <span>ชำระเงินบำรุงการศึกษา</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-book"></i>
                <span>คู่มือการจ่ายเงินบำรุงการศึกษา</span>
            </a>
             <a href="#" class="menu-button">
                <i class="fas fa-database"></i>
                <span>BIG DATA Phichai School</span>
            </a>
            <a href="#" class="menu-button">
                <i class="fas fa-laptop"></i>
                <span>ห้องเรียนออนไลน์ 2567</span>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 5000,  // ตั้งเวลาเปลี่ยนสไลด์
                disableOnInteraction: false, // ให้สไลด์อัตโนมัติต่อไปเมื่อผู้ใช้เลื่อน
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true, // ทำให้คลิกที่จุดเพื่อเปลี่ยนสไลด์ได้
            },
        });
    </script>
</body>
</html>
