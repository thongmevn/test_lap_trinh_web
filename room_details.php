<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Chi tiết phòng</title>

    <style>
    body {
        background-color: #f8f9fa;
        color: #212529;
    }

    .details-container {
        width: min(1200px, calc(100% - 40px));
        margin: 40px auto;
    }

    .breadcrumb-area {
        margin-bottom: 25px;
    }

    .breadcrumb-title {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 10px;
        color: #333;
    }

    .breadcrumb-link {
        font-size: 15px;
        color: #6c757d;
        text-decoration: none;
        transition: 0.2s;
    }

    .breadcrumb-link:hover {
        color: #27724b;
    }

    .breadcrumb-separator {
        color: #6c757d;
        margin: 0 8px;
    }

    .details-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        align-items: flex-start;
    }

    .slider-wrap {
        flex: 0 0 60%;
        max-width: 60%;
        min-width: 0; 
        overflow: hidden;
    }

    .info-card {
        flex: 1;
        min-width: 0;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .room-swiper {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        width: 100%;
        background-color: #000;
    }

    .swiper-slide img {
        width: 100%;
        height: 450px; 
        object-fit: cover; 
        display: block;
    }

    .swiper-button-next, .swiper-button-prev {
        color: #fff;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    .info-price {
        font-size: 26px;
        color: #27724b;
        font-weight: 700;
        margin: 0 0 20px;
    }

    .info-block {
        margin-bottom: 20px;
    }

    .info-block-title {
        margin: 0 0 8px;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .room-tag {
        display: inline-block;
        margin: 0 6px 6px 0;
        padding: 6px 12px;
        border-radius: 20px;
        background: #f8f9fa;
        color: #333;
        font-size: 14px;
        border: 1px solid #eee;
    }

    .star-icon {
        color: #ffc107;
        font-size: 16px;
    }

    .btn-dat-ngay-large {
        width: 100%;
        background-color: #27724b;
        color: #ffffff !important;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s ease;
        margin-top: 10px;
    }

    .btn-dat-ngay-large:hover {
        background-color: #1e5a3a;
    }

    .btn-dat-ngay-large:disabled {
        background-color: #888;
        cursor: not-allowed;
    }
    
    .bottom-section {
        margin-top: 40px;
    }

    .section-title-sm {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 15px;
        color: #333;
    }

    .description-text {
        font-size: 16px;
        line-height: 1.6;
        color: #555;
    }

    .review-item {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    .profile-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .profile-row img {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-row h6 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .review-text {
        margin: 0 0 10px;
        color: #555;
        line-height: 1.5;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-box {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        width: min(400px, calc(100% - 40px));
        position: relative;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .modal-close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        cursor: pointer;
        color: #6c757d;
    }

    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background-color: #ff3333;
        color: white;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        font-weight: 600;
        display: none;
    }

    @media screen and (max-width: 991px) {
        .slider-wrap {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .swiper-slide img {
            height: 300px;
        }
    }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <div id="toastAlert" class="custom-alert"></div>

    <?php 
    if(!isset($_GET['id'])){
      redirect('rooms.php');
    }

    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

    if(mysqli_num_rows($room_res)==0){
      redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);
    ?>

    <div class="details-container">
        
        <div class="breadcrumb-area">
            <h2 class="breadcrumb-title"><?php echo $room_data['name'] ?></h2>
            <div>
                <a href="index.php" class="breadcrumb-link">Trang chủ</a>
                <span class="breadcrumb-separator">></span>
                <a href="rooms.php" class="breadcrumb-link">Danh sách phòng</a>
            </div>
        </div>

        <div class="details-flex">
            
            <div class="slider-wrap">
                <div class="swiper room-swiper">
                    <div class="swiper-wrapper">
                        <?php 
                        $img_q = mysqli_query($con,"SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]'");
                        if(mysqli_num_rows($img_q)>0) {
                            while($img_res = mysqli_fetch_assoc($img_q)) {
                                $room_img = ROOMS_IMG_PATH."thumbnail.jpg";
                                if(file_exists(UPLOAD_IMAGE_PATH.ROOMS_FOLDER.$img_res['image'])){
                                    $room_img = roomImagePath($img_res['image']);
                                }
                                echo "
                                <div class='swiper-slide'>
                                    <img src='$room_img'>
                                </div>";
                            }
                        } else {
                            $room_img = ROOMS_IMG_PATH."thumbnail.jpg";
                            echo "<div class='swiper-slide'><img src='$room_img'></div>";
                        }
                        ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            <div class="info-card">
                <?php 
                $price = number_format($room_data['price'], 0, ',', '.');
                echo "<h4 class='info-price'>$price VND / đêm</h4>";

                $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
                $rating_res = mysqli_query($con,$rating_q);
                $rating_fetch = mysqli_fetch_assoc($rating_res);
                $rating_data = "";

                if($rating_fetch['avg_rating']!=NULL) {
                    for($i=0; $i < $rating_fetch['avg_rating']; $i++){
                        $rating_data .="<i class='bi bi-star-fill star-icon'></i> ";
                    }
                    echo "<div class='info-block'>$rating_data</div>";
                }

                $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");
                $features_data = "";
                while($fea_row = mysqli_fetch_assoc($fea_q)){
                    $features_data .="<span class='room-tag'>$fea_row[name]</span>";
                }
                echo "<div class='info-block'><h6 class='info-block-title'>Không gian</h6>$features_data</div>";

                $fac_q = mysqli_query($con,"SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
                $facilities_data = "";
                while($fac_row = mysqli_fetch_assoc($fac_q)){
                    $facilities_data .="<span class='room-tag'>$fac_row[name]</span>";
                }
                echo "<div class='info-block'><h6 class='info-block-title'>Facilities</h6>$facilities_data</div>";

                echo "
                <div class='info-block'>
                    <h6 class='info-block-title'>Guests</h6>
                    <span class='room-tag'>$room_data[adult] Người lớn</span>
                    <span class='room-tag'>$room_data[children] Trẻ em</span>
                </div>";

                echo "
                <div class='info-block'>
                    <h6 class='info-block-title'>Area</h6>
                    <span class='room-tag'>$room_data[area] m²</span>
                </div>";

                if(!$settings_r['shutdown']){
                    $login=0;
                    if(isset($_SESSION['login']) && $_SESSION['login']==true){
                        $login=1;
                    }
                    echo "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn-dat-ngay-large'>Đặt ngay</button>";
                } else {
                    echo "<button class='btn-dat-ngay-large' disabled>Đang bảo trì</button>";
                }
                ?>
            </div>
        </div>

        <div class="bottom-section">
            <div style="margin-bottom: 40px;">
                <h5 class="section-title-sm">Mô tả</h5>
                <p class="description-text">
                    <?php echo $room_data['description'] ?>
                </p>
            </div>

            <div>
                <h5 class="section-title-sm mb-3">Trải nghiệm khách hàng</h5>
                <?php
                $review_q = "SELECT rr.*,uc.name AS uname, uc.profile, r.name AS rname FROM `rating_review` rr INNER JOIN `user_cred` uc ON rr.user_id = uc.id INNER JOIN `rooms` r ON rr.room_id = r.id WHERE rr.room_id = '$room_data[id]' ORDER BY `sr_no` DESC LIMIT 15";
                $review_res = mysqli_query($con,$review_q);
                $img_path = USERS_IMG_PATH;

                if(mysqli_num_rows($review_res)==0){
                    echo '<p style="color:#555;">Chưa có đánh giá nào!</p>';
                } else {
                    while($row = mysqli_fetch_assoc($review_res)) {
                        $stars = "";
                        for($i=0; $i<$row['rating']; $i++){
                            $stars .= "<i class='bi bi-star-fill star-icon'></i> ";
                        }
                        echo <<<reviews
                        <div class="review-item">
                            <div class="profile-row">
                                <img src="$img_path$row[profile]">
                                <h6>$row[uname]</h6>
                            </div>
                            <p class="review-text">$row[review]</p>
                            <div>$stars</div>
                        </div>
                        reviews;
                    }
                }
                ?>
            </div>
        </div>

    </div>

    <div id="loginAlertModal" class="modal-overlay">
        <div class="modal-box">
            <span class="modal-close-btn" onclick="closeLoginModal()">&times;</span>
            <h5 class="section-title-sm" style="margin-bottom: 10px;">Thông báo</h5>
            <p style="margin-bottom: 20px; color: #555;">Vui lòng đăng nhập hệ thống để thực hiện đặt phòng.</p>
            <button onclick="closeLoginModal()" class="btn-dat-ngay-large" style="margin: 0; width: auto; padding: 8px 20px;">Đóng</button>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>
    
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".room-swiper", {
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        function showAlert(msg) {
            var toast = document.getElementById('toastAlert');
            toast.innerText = msg;
            toast.style.display = 'block';
            setTimeout(function() {
                toast.style.display = 'none';
            }, 3000);
        }

        function checkLoginToBook(loginStatus, roomId) {
            if (loginStatus === 1) {
                window.location.href = 'confirm_booking.php?id=' + roomId;
            } else {
                var loginModal = document.getElementById('loginModal');
                if (loginModal) {
                    loginModal.style.display = 'flex';
                    
                    var loginForm = loginModal.querySelector('form');
                    if (loginForm && !loginForm.dataset.hooked) {
                        loginForm.dataset.hooked = 'true';
                        loginForm.addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            var formData = new FormData(loginForm);
                            formData.append('login', '');

                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'ajax/login_register.php', true);
                            
                            xhr.onload = function() {
                                if (this.responseText.trim() == 'inv_email_mob') {
                                    showAlert('Email hoặc số điện thoại không chính xác!');
                                } else if (this.responseText.trim() == 'not_verified') {
                                    showAlert('Tài khoản chưa được xác thực!');
                                } else if (this.responseText.trim() == 'inactive') {
                                    showAlert('Tài khoản đã bị khóa!');
                                } else if (this.responseText.trim() == 'invalid_pass') {
                                    showAlert('Sai mật khẩu!');
                                } else if (this.responseText.trim() == 'status_failed') {
                                    showAlert('Đăng nhập thất bại do lỗi hệ thống!');
                                } else {
                                    window.location.href = window.location.href;
                                }
                            };
                            xhr.send(formData);
                        });
                    }
                } else {
                    document.getElementById('loginAlertModal').style.display = 'flex';
                }
            }
        }

        function closeLoginModal() {
            document.getElementById('loginAlertModal').style.display = 'none';
        }
    </script>
</body>
</html>