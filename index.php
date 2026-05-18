<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Trang chủ</title>
    
    <style>
    .home-page {
        background-color: #f8f9fa;
        color: #212529;
    }

    .home-container {
        width: min(1200px, calc(100% - 40px));
        margin: 0 auto;
    }

    .section-title {
        text-align: center;
        margin: 60px 0 30px;
        font-size: 28px;
        font-weight: 700;
        color: #333;
    }

    .hero-slider-section {
        max-width: 1400px;
        margin: 20px auto 0;
        padding: 0 20px;
    }

    .hero-slide-img {
        display: block;
        width: 100%;
        height: clamp(250px, 40vw, 550px);
        object-fit: cover;
        border-radius: 12px;
    }

    .availability-form {
        margin-top: -50px;
        position: relative;
        z-index: 10;
    }

    .booking-panel {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .booking-title {
        margin: 0 0 20px;
        font-size: 20px;
        font-weight: 700;
    }

    .booking-grid {
        display: grid;
        grid-template-columns: 2fr 2fr 1.5fr 1.5fr 1fr;
        gap: 15px;
        align-items: end;
    }

    .field-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        font-size: 15px;
    }

    .room-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
    }

    .room-card {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .room-card:hover {
        transform: translateY(-5px);
    }

    .room-img {
        display: block;
        width: 100%;
        height: 230px;
        object-fit: cover;
    }

    .room-body {
        padding: 20px;
    }

    .room-name {
        margin: 0 0 10px;
        font-size: 20px;
        font-weight: 700;
    }

    .room-price {
        margin: 0 0 20px;
        font-size: 18px; 
        font-weight: 700;
        color: #27724b; 
    }

    .room-block {
        margin-bottom: 20px;
    }

    .room-block-title {
        margin: 0 0 8px;
        font-size: 15px;
        font-weight: 600;
    }

    .room-tag {
        display: inline-block;
        margin: 0 5px 5px 0;
        padding: 6px 12px;
        border-radius: 20px;
        background: #f8f9fa;
        color: #333;
        font-size: 13px;
        border: 1px solid #eee;
    }

    .rating {
        margin-bottom: 20px;
    }

    .star-icon {
        color: #ffc107;
        font-size: 14px;
    }

    .room-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
    }

    .facility-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 25px;
    }

    .facility-card {
        background: #ffffff;
        padding: 25px 20px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        text-align: center;
        min-width: 160px;
    }

    .facility-card img {
        width: 60px;
        height: 60px;
        object-fit: contain;
    }

    .facility-card h5 {
        margin: 15px 0 0;
        font-size: 17px;
    }

    .review-card {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .profile-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .profile-row img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-row h6 {
        margin: 0;
        font-size: 16px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    .contact-panel {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .contact-panel iframe {
        width: 100%;
        height: 350px;
        border: none;
        border-radius: 8px;
    }

    .contact-info-card {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .contact-link, .social-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #212529;
        text-decoration: none;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .more-link-wrap {
        text-align: center;
        margin-top: 35px;
    }

    @media screen and (max-width: 991px) {
        .booking-grid {
            grid-template-columns: 1fr 1fr;
        }
        .booking-submit {
            grid-column: span 2;
        }
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }

    @media screen and (max-width: 575px) {
        .booking-grid {
            grid-template-columns: 1fr;
        }
        .booking-submit {
            grid-column: span 1;
        }
        .hero-slider-section {
            padding: 0 10px;
        }
        .availability-form {
            margin-top: 20px;
        }
    }
    .btn-dat-ngay {
        background-color: #27724b;
        color: #ffffff !important;
        border: 1px solid #27724b;
        padding: 8px 20px;
        border-radius: 5px; 
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none; 
        transition: 0.3s ease;
        display: inline-block;
    }

    .btn-dat-ngay:hover {
        background-color: #1e5a3a;
        border-color: #1e5a3a;
    }

    .btn-outline {
        color: #212529;
        background: transparent;
        border: 1px solid #212529;
        padding: 8px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: 0.3s ease;
        display: inline-block;
    }

    .btn-outline:hover {
        color: #ffffff;
        background: #212529;
    }
    
    .room-actions {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        margin-top: 15px;
    }
    </style>
</head>

<body class="home-page">

    <?php require('inc/header.php'); ?>

    <div class="hero-slider-section">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php 
          $res = selectAll('carousel');
          while($row = mysqli_fetch_assoc($res))
          {
            $path = CAROUSEL_IMG_PATH;
            echo <<<data
              <div class="swiper-slide">
                <img src="$path$row[image]" class="hero-slide-img">
              </div>
            data;
          }
        ?>
            </div>
        </div>
    </div>

    <div class="home-container availability-form">
        <div class="booking-panel">
            <h5 class="booking-title">Tiến hành đặt phòng</h5>
            <form action="rooms.php">
                <div class="booking-grid">
                    <div class="booking-field">
                        <label class="field-label">Nhận phòng</label>
                        <input type="date" class="custom-input" name="checkin" required>
                    </div>
                    <div class="booking-field">
                        <label class="field-label">Trả phòng</label>
                        <input type="date" class="custom-input" name="checkout" required>
                    </div>
                    <div class="booking-field">
                        <label class="field-label">Người lớn</label>
                        <select class="custom-input" name="adult">
                            <?php 
                  $guests_q = mysqli_query($con,"SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children` FROM `rooms` WHERE `status`='1' AND `removed`='0'");  
                  $guests_res = mysqli_fetch_assoc($guests_q);
                  for($i=1; $i<=$guests_res['max_adult']; $i++){
                    echo"<option value='$i'>$i</option>";
                  }
                ?>
                        </select>
                    </div>
                    <div class="booking-field">
                        <label class="field-label">Trẻ em</label>
                        <select class="custom-input" name="children">
                            <?php 
                  for($i=1; $i<=$guests_res['max_children']; $i++){
                    echo"<option value='$i'>$i</option>";
                  }
                ?>
                        </select>
                    </div>
                    <input type="hidden" name="check_availability">
                    <div class="booking-submit">
                        <button type="submit" class="btn-dat-ngay" style="width: 100%; padding: 11px;">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h2 class="section-title">Danh sách phòng</h2>
    <div class="home-container">
        <div class="room-grid">
            <?php 
        $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3",[1,0],'ii');

        while($room_data = mysqli_fetch_assoc($room_res))
        {
          $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");
          $features_data = "";
          while($fea_row = mysqli_fetch_assoc($fea_q)){
            $features_data .="<span class='room-tag'>$fea_row[name]</span>";
          }

          $fac_q = mysqli_query($con,"SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
          $facilities_data = "";
          while($fac_row = mysqli_fetch_assoc($fac_q)){
            $facilities_data .="<span class='room-tag'>$fac_row[name]</span>";
          }

          $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
          $thumb_q = mysqli_query($con,"SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");
          if(mysqli_num_rows($thumb_q)>0){
            $thumb_res = mysqli_fetch_assoc($thumb_q);
            if(file_exists(UPLOAD_IMAGE_PATH.ROOMS_FOLDER.$thumb_res['image'])){
              $room_thumb = roomImagePath($thumb_res['image']);
            }
          }

          $book_btn = "";
          $login = 0;
          if(isset($_SESSION['login']) && $_SESSION['login']==true){
            $login = 1;
          }

          if(!$settings_r['shutdown']){
            $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn-dat-ngay'>Đặt ngay</button>";
          } else {
            $book_btn = "<button class='btn-dat-ngay' style='background-color: #888; border-color: #888; cursor: not-allowed;' disabled>Đang bảo trì</button>";
          }

          $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
          $rating_res = mysqli_query($con,$rating_q);
          $rating_fetch = mysqli_fetch_assoc($rating_res);
          $rating_data = "";

          if($rating_fetch['avg_rating']!=NULL) {
            $rating_data = "<div class='rating'><h6 class='room-block-title'>Rating</h6>";
            for($i=0; $i<$rating_fetch['avg_rating']; $i++){
              $rating_data .="<i class='bi bi-star-fill star-icon'></i> ";
            }
            $rating_data .= "</div>";
          }

          $price = number_format($room_data['price'], 0, ',', '.');

          echo <<<data
            <div class="room-card">
                <img src="$room_thumb" class="room-img">
                <div class="room-body">
                  <h5 class="room-name">$room_data[name]</h5>
                  <h6 class="room-price">$price VND / đêm</h6>
                  
                  <div class="room-block">
                    <h6 class="room-block-title">Không gian</h6>
                    $features_data
                  </div>
                  <div class="room-block">
                    <h6 class="room-block-title">Facilities</h6>
                    $facilities_data
                  </div>
                  <div class="room-block">
                    <h6 class="room-block-title">Guests</h6>
                    <span class="room-tag">$room_data[adult] Người lớn</span>
                    <span class="room-tag">$room_data[children] Trẻ em</span>
                  </div>
                  $rating_data
                  <div class="room-actions">
                    $book_btn
                    <a href="room_details.php?id=$room_data[id]" class="btn-outline">Chi tiết</a>
                  </div>
                </div>
            </div>
          data;
        }
      ?>
        </div>
        <div class="more-link-wrap">
            <a href="rooms.php" class="btn-outline">Tìm hiểu thêm >>></a>
        </div>
    </div>

    <h2 class="section-title">Các tiện tích</h2>
    <div class="home-container">
        <div class="facility-grid">
            <?php 
        $res = mysqli_query($con,"SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
        $path = FACILITIES_IMG_PATH;
        while($row = mysqli_fetch_assoc($res)){
          echo<<<data
            <div class="facility-card">
              <img src="$path$row[icon]">
              <h5>$row[name]</h5>
            </div>
          data;
        }
      ?>
        </div>
        <div class="more-link-wrap">
            <a href="facilities.php" class="btn-outline">Tìm hiểu thêm >>></a>
        </div>
    </div>

    <h2 class="section-title">Đánh giá dịch vụ</h2>
    <div class="home-container testimonial-section">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper" style="margin-bottom: 40px;">
                <?php
          $review_q = "SELECT rr.*,uc.name AS uname, uc.profile, r.name AS rname FROM `rating_review` rr INNER JOIN `user_cred` uc ON rr.user_id = uc.id INNER JOIN `rooms` r ON rr.room_id = r.id ORDER BY `sr_no` DESC LIMIT 6";
          $review_res = mysqli_query($con,$review_q);
          $img_path = USERS_IMG_PATH;

          if(mysqli_num_rows($review_res)==0){
            echo '<p style="text-align:center;">Chưa có đánh giá nào!</p>';
          } else {
            while($row = mysqli_fetch_assoc($review_res)) {
              $stars = "";
              for($i=0; $i<$row['rating']; $i++){
                $stars .= "<i class='bi bi-star-fill star-icon'></i> ";
              }
              echo<<<slides
                <div class="swiper-slide review-card">
                  <div class="profile-row">
                    <img src="$img_path$row[profile]" loading="lazy">
                    <h6>$row[uname]</h6>
                  </div>
                  <p style="color:#555; font-size: 15px; line-height: 1.5;">$row[review]</p>
                  <div class="rating">$stars</div>
                </div>
              slides;
            }
          }
        ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <h2 class="section-title">Liên hệ</h2>
    <div class="home-container" style="margin-bottom: 60px;">
        <div class="contact-grid">
            <div class="contact-panel">
                <iframe src="<?php echo $contact_r['iframe'] ?>" loading="lazy"></iframe>
            </div>
            <div>
                <div class="contact-info-card">
                    <h5 style="margin-top:0;">Tổng đài viên</h5>
                    <a href="tel:+<?php echo $contact_r['pn1'] ?>" class="contact-link">
                        <i class="bi bi-telephone-fill" style="color:#27724b;"></i> +<?php echo $contact_r['pn1'] ?>
                    </a>
                </div>
                <div class="contact-info-card">
                    <h5 style="margin-top:0;">Theo dõi chúng tôi</h5>
                    <?php 
            if($contact_r['tw']!=''){
              echo<<<data
                <a href="$contact_r[tw]" class="room-tag" style="text-decoration:none;"><i class="bi bi-twitter" style="color:#1da1f2;"></i> Twitter</a><br>
              data;
            }
          ?>
                    <a href="<?php echo $contact_r['fb'] ?>" class="room-tag" style="text-decoration:none;"><i class="bi bi-facebook" style="color:#1877f2;"></i> Facebook</a><br>
                    <a href="<?php echo $contact_r['insta'] ?>" class="room-tag" style="text-decoration:none;"><i class="bi bi-instagram" style="color:#e1306c;"></i> Instagram</a>
                </div>
                <div class="contact-info-card" style="text-align: center;">
                    <a href="about.php" class="btn-outline">Tìm hiểu thêm về chúng tôi</a>
                </div>
            </div>
        </div>
    </div>

    <div id="recoveryModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="modal-header-custom">
                <h3><i class="bi bi-shield-lock"></i> Tạo mật khẩu mới</h3>
                <span class="close-modal" onclick="closeModal('recoveryModal')">&times;</span>
            </div>
            <form id="recovery-form">
                <div class="form-group">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password" name="pass" class="custom-input" required oninput="hideRecoveryError()">
                    <input type="hidden" name="email">
                    <input type="hidden" name="token">
                    <div id="recovery-error" style="color: #dc3545; font-size: 13px; display: none; margin-top: 8px; font-weight: 500;"></div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-custom btn-outline" onclick="closeModal('recoveryModal')">Huỷ</button>
                    <button type="submit" class="btn-custom btn-primary-custom">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    <div id="loginAlertModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="modal-header-custom">
                <h3 style="color: #dc3545;"><i class="bi bi-exclamation-triangle-fill"></i> Thông báo</h3>
                <span class="close-modal" onclick="closeModal('loginAlertModal')">&times;</span>
            </div>
            <p style="font-size: 16px; margin-bottom: 24px; color: #333;">Bạn cần phải đăng nhập trước khi thực hiện đặt phòng!</p>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn-custom btn-outline" onclick="closeModal('loginAlertModal')">Đóng</button>
                <button type="button" class="btn-custom btn-primary-custom" onclick="closeModal('loginAlertModal'); openModal('loginModal');">Đăng nhập ngay</button>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <?php
    if(isset($_GET['account_recovery']))
    {
      $data = filteration($_GET);
      $t_date = date("Y-m-d");
      $query = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? AND `t_expire`=? LIMIT 1", [$data['email'],$data['token'],$t_date],'sss');

      if(mysqli_num_rows($query)==1)
      {
        echo<<<showModal
          <script>
            var myModal = document.getElementById('recoveryModal');
            myModal.querySelector("input[name='email']").value = '$data[email]';
            myModal.querySelector("input[name='token']").value = '$data[token]';
            openModal('recoveryModal');
          </script>
        showModal;
      }
      else{
        echo "<script>alert('Lỗi: Liên kết khôi phục không hợp lệ hoặc đã hết hạn!');</script>";
      }
    }
  ?>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script>
    var swiper = new Swiper(".swiper-container", {
        spaceBetween: 30,
        effect: "fade",
        loop: true,
        autoplay: { delay: 3500, disableOnInteraction: false, }
    });

    var swiperTestimonials = new Swiper(".swiper-testimonials", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        loop: true,
        coverflowEffect: { rotate: 50, stretch: 0, depth: 100, modifier: 1, slideShadows: false, },
        pagination: { el: ".swiper-pagination", },
        breakpoints: {
            320: { slidesPerView: 1, },
            768: { slidesPerView: 2, },
            1024: { slidesPerView: 3, },
        }
    });

    function hideRecoveryError() {
        document.getElementById('recovery-error').style.display = 'none';
    }

    let recovery_form = document.getElementById('recovery-form');
    recovery_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();
        data.append('email', recovery_form.elements['email'].value);
        data.append('token', recovery_form.elements['token'].value);
        data.append('pass', recovery_form.elements['pass'].value);
        data.append('recover_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function() {
            let recError = document.getElementById('recovery-error');
            if (this.responseText == 'failed') {
                recError.innerHTML = "Lỗi hệ thống: Không thể cập nhật mật khẩu lúc này!";
                recError.style.display = 'block';
            } else {
                alert("Thành công: Đã đặt lại mật khẩu! Vui lòng đăng nhập bằng mật khẩu mới.");
                recovery_form.reset();
                closeModal('recoveryModal');
            }
        }
        xhr.send(data);
    });

    function checkLoginToBook(status, room_id) {
        if (status) {
            window.location.href = 'confirm_booking.php?id=' + room_id;
        } else {
            openModal('loginAlertModal'); 
        }
    }
    </script>
</body>
</html>