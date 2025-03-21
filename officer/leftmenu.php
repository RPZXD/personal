<?php
function createNavItem($href, $iconClass, $text) {
    return '
    <li class="nav-item">
        <a href="' . htmlspecialchars($href) . '" class="nav-link">
            <i class="nav-icon fas ' . htmlspecialchars($iconClass) . '"></i>
            <p>' . htmlspecialchars($text) . '</p>
        </a>
    </li>';
}

function createNavItemName($avatar, $text) {
    return '
    <li class="nav-item">
        <div class="nav-link text-center">
            <img src="' . $avatar .'" alt="User Avatar" class="user-avatar rounded-full w-28 h-28 mx-auto">
        </div>
        <div class="nav-link text-center">
            <p class="text-white font-bold">'. $text . '</p>
        </div>
        <div class="nav-link text-center">
            <p class="text-white font-bold">ตำแหน่ง : เจ้าหน้าที่</p>
        </div>
    </li>';
}

function createNavSubMenu($href, $iconClass, $text) {
    return '
    <li class="nav-item ml-2">
        <a href="' . htmlspecialchars($href) . '" class="nav-link">
            <i class="nav-icon fas ' . htmlspecialchars($iconClass) . '"></i>
            <p>' . htmlspecialchars($text) . '</p>
        </a>
    </li>';
}

echo createNavItemName(htmlspecialchars($setting->getImgProfile().$userData['Teach_photo']), htmlspecialchars($userData['Teach_name']));
// echo "<hr style='border: 1px solid #ffffff;'>";
echo "<br>";

echo createNavItem('index.php', 'fas fa-home', 'หน้าหลัก');
// echo createNavItem('training.php', 'fas fa-book', 'การอบรมครู');
echo '
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        <p>
            การอบรมครู
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        ' . createNavSubMenu('training.php', 'fas fa-user', 'รายบุคคล') . '
        ' . createNavSubMenu('training_month.php', 'fas fa-calendar-alt', 'รายเดือน') . '
        ' . createNavSubMenu('training_summary.php', 'fas fa-chart-bar', 'สรุป') . '
    </ul>
</li>';

echo createNavItem('awards.php', 'fas fa-trophy', 'รางวัลครู');

echo '
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>
            การของลาครู
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        ' . createNavSubMenu('leave.php', 'fas fa-user', 'รายบุคคล') . '
        ' . createNavSubMenu('leave_summary.php', 'fas fa-chart-bar', 'สรุปรายวัน') . '
    </ul>
</li>';

echo createNavItem('../logout.php', 'fas fa-sign-out-alt', 'ออกจากระบบ');
?>