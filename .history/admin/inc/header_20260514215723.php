<div class="topbar">
    <h5>DawnChill</h5>
    <a href="logout.php" class="btn-logout">Đăng xuất</a>
</div>

<div id="dashboard-menu">
    <div class="menu-container">
        <h4>Trang quản lý</h4>

        <button class="menu-toggle" onclick="toggleMenu()">☰</button>

        <div class="menu-content" id="adminDropdown">
            <ul class="menu-list">
                <li><a href="dashboard.php">Bảng theo dõi</a></li>

                <li>
                    <button class="collapse-btn" onclick="toggleCollapse('bookingLinks')">
                        <span>Bookings</span>
                        <span>▼</span>
                    </button>

                    <div class="collapse show" id="bookingLinks">
                        <ul class="sub-menu">
                            <li><a href="new_bookings.php">Lượt đặt phòng mới</a></li>
                            <li><a href="refund_bookings.php">Yêu cầu hoàn tiền</a></li>
                            <li><a href="booking_records.php">Thống kê đặt phòng</a></li>
                        </ul>
                    </div>
                </li>

                <li><a href="users.php">Người dùng</a></li>
                <li><a href="user_queries.php">Tin nhắn</a></li>
                <li><a href="rate_review.php">Đánh giá</a></li>
                <li><a href="rooms.php">Danh sách phòng</a></li>
                <li><a href="features_facilities.php">Không Gian và Tiện Nghi</a></li>
                <li><a href="carousel.php">Trình chiếu</a></li>
                <li><a href="settings.php">Cài đặt trang</a></li>
            </ul>
        </div>
    </div>
</div>

<style>
/* topbar */
.topbar {
    background: #212529;
    color: #fff;
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.topbar h5 {
    margin: 0;
    font-weight: 800;
    color: var(--primary-color);
    font-size: 20px;
}

.btn-logout {
    background: #fff;
    color: #000;
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
}

/* sidebar */
#dashboard-menu {
    width: 220px;
    background: #212529;
    color: #fff;
    min-height: 100vh;
    border-top: 3px solid #6c757d;
}

.menu-container {
    padding: 15px;
}

.menu-container h4 {
    margin: 10px 0;
}

.menu-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-list li {
    margin-bottom: 5px;
}

.menu-list a {
    display: block;
    padding: 8px 10px;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
}

.menu-list a:hover {
    background: #343a40;
}

/* collapse */
.collapse-btn {
    width: 100%;
    background: none;
    border: none;
    color: #fff;
    text-align: left;
    padding: 8px 10px;
    display: flex;
    justify-content: space-between;
    cursor: pointer;
}

.collapse {
    display: none;
}

.collapse.show {
    display: block;
}

.sub-menu {
    list-style: none;
    padding: 5px;
    border: 1px solid #6c757d;
    border-radius: 4px;
    margin-top: 5px;
}

.sub-menu li a {
    font-size: 14px;
}

/* mobile toggle */
.menu-toggle {
    display: none;
    background: none;
    border: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
}

@media (max-width: 992px) {
    #dashboard-menu {
        width: 100%;
    }

    .menu-toggle {
        display: block;
    }

    .menu-content {
        display: none;
    }

    .menu-content.show {
        display: block;
    }
}
</style>

<script>
function toggleCollapse(id) {
    let el = document.getElementById(id);
    el.classList.toggle("show");
}

function toggleMenu() {
    let el = document.getElementById("adminDropdown");
    el.classList.toggle("show");
}

// Ensure main content is shifted right of the fixed sidebar.
// This uses JS to set inline styles so it works even if CSS is cached or overridden.
function adjustMainContent() {
    var mc = document.getElementById('main-content');
    var menu = document.getElementById('dashboard-menu');
    if (!mc) return;
    // Mobile: no left margin
    if (window.innerWidth <= 991) {
        mc.style.marginLeft = '0';
        mc.style.width = '100%';
        return;
    }
    var menuWidth = 220;
    if (menu && menu.offsetWidth) menuWidth = menu.offsetWidth;
    mc.style.marginLeft = menuWidth + 'px';
    mc.style.width = 'calc(100% - ' + menuWidth + 'px)';
}

document.addEventListener('DOMContentLoaded', adjustMainContent);
window.addEventListener('resize', adjustMainContent);
</script>