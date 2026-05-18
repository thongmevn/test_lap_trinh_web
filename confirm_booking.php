<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('inc/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> - Xác nhận đặt phòng</title>
  <style>
  :root {
      --primary-color: #27724b;
      --primary-hover: #1e5a3a;
  }

  * {
      box-sizing: border-box;
  }

  body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .confirm-wrap {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 16px 40px;
  }

  .confirm-header {
    padding: 40px 0 24px;
  }

  .confirm-header h4 {
    font-weight: 700;
    margin-bottom: 8px;
    font-size: 26px;
    color: #333;
  }

  .confirm-header .breadcrumb {
    font-size: 15px;
    color: #666;
  }

  .confirm-header .breadcrumb a {
    color: #666;
    text-decoration: none;
    transition: 0.2s;
  }

  .confirm-header .breadcrumb a:hover {
    color: var(--primary-color);
  }

  .confirm-row {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    align-items: flex-start;
  }

  .confirm-left {
    flex: 1.5;
    min-width: 320px;
  }

  .confirm-right {
    flex: 1;
    min-width: 320px;
  }

  .room-carousel {
    position: relative;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,.05);
    overflow: hidden;
  }

  .carousel-slides {
    position: relative;
    width: 100%;
  }

  .carousel-slide {
    display: none;
  }

  .carousel-slide.active {
    display: block;
    animation: fadeEffect 0.5s ease;
  }

  @keyframes fadeEffect {
      from {opacity: 0.6;}
      to {opacity: 1;}
  }

  .carousel-slide img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    display: block;
  }

  .carousel-info {
    padding: 20px;
  }

  .carousel-info h5 { margin: 0 0 8px; font-weight: 700; font-size: 20px;}
  .carousel-info h6 { margin: 0; color: var(--primary-color); font-size: 18px; font-weight: 600;}

  .carousel-btns {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 15px;
    pointer-events: none;
  }

  .carousel-btns button {
    pointer-events: all;
    background: rgba(0,0,0,0.5);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-size: 22px;
    cursor: pointer;
    line-height: 1;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .carousel-btns button:hover {
    background: rgba(0,0,0,0.8);
  }

  .carousel-dots {
    text-align: center;
    padding: 15px 0 5px;
  }

  .carousel-dots span {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #ddd;
    margin: 0 5px;
    cursor: pointer;
    transition: background 0.3s;
  }

  .carousel-dots span.active {
    background: var(--primary-color);
  }

  .form-card {
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,.05);
  }

  .form-card h6 { font-weight: 700; margin-top: 0; margin-bottom: 20px; font-size: 18px; color: #333;}

  .form-row-2 {
    display: flex;
    gap: 15px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
    flex: 1;
  }

  .form-group.full { flex: 1 1 100%; }

  .form-group label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #444;
  }

  .form-group input,
  .form-group textarea {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    font-family: inherit;
    outline: none;
    transition: 0.3s;
  }

  .form-group input:focus,
  .form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(39, 114, 75, 0.1);
  }

  .loader {
    display: none;
    width: 30px;
    height: 30px;
    border: 3px solid #f3f3f3;
    border-top-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 0 auto 15px;
  }

  @keyframes spin { to { transform: rotate(360deg); } }

  #pay_info {
    font-size: 15px;
    color: #dc3545;
    margin-bottom: 15px;
    line-height: 1.6;
    font-weight: 500;
    text-align: center;
  }

  #pay_info.info-ok { 
      color: #333; 
      background: #f8f9fa; 
      padding: 10px; 
      border-radius: 6px; 
      border: 1px solid #eee;
  }

  .btn-pay {
    width: 100%;
    padding: 12px;
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.3s;
  }

  .btn-pay:disabled { background: #aaa; cursor: not-allowed; }
  .btn-pay:not(:disabled):hover { background: var(--primary-hover); }

  @media screen and (max-width: 575px) {
      .form-row-2 {
          flex-direction: column;
          gap: 0;
      }
      .carousel-slide img {
          height: 300px;
      }
  }
  </style>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <?php 
    if(!isset($_GET['id']) || $settings_r['shutdown']==true){
      redirect('rooms.php');
    }
    else if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
      redirect('rooms.php');
    }

    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

    if(mysqli_num_rows($room_res)==0){
      redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

    $_SESSION['room'] = [
      "id"        => $room_data['id'],
      "name"      => $room_data['name'],
      "price"     => $room_data['price'],
      "payment"   => null,
      "available" => false,
    ];

    $user_res  = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], "i");
    $user_data = mysqli_fetch_assoc($user_res);
  ?>

  <div class="confirm-wrap">

    <div class="confirm-header">
      <h4 class="h-font">XÁC NHẬN ĐẶT PHÒNG</h4>
      <div class="breadcrumb">
        <a href="index.php">Trang chủ</a> &gt;
        <a href="rooms.php">Danh sách phòng</a> &gt;
        <span>Xác nhận đặt phòng</span>
      </div>
    </div>

    <div class="confirm-row">

      <div class="confirm-left">
        <div class="room-carousel">
          <div class="carousel-slides">
            <?php
              $img_q = mysqli_query($con,"SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]'");
              $imgs = [];

              if(mysqli_num_rows($img_q) > 0){
                while($img_row = mysqli_fetch_assoc($img_q)){
                  $src = ROOMS_IMG_PATH."thumbnail.jpg";
                  if(file_exists(UPLOAD_IMAGE_PATH.ROOMS_FOLDER.$img_row['image'])){
                    $src = ROOMS_IMG_PATH.$img_row['image'];
                  }
                  $imgs[] = $src;
                }
              } else {
                $imgs[] = ROOMS_IMG_PATH."thumbnail.jpg";
              }

              foreach($imgs as $i => $src){
                $active = $i === 0 ? 'active' : '';
                echo "<div class='carousel-slide $active'><img src='$src' alt='Ảnh phòng'></div>";
              }
            ?>
          </div>

          <?php if(count($imgs) > 1): ?>
          <div class="carousel-btns">
            <button onclick="changeSlide(-1)">&#8249;</button>
            <button onclick="changeSlide(1)">&#8250;</button>
          </div>
          <div class="carousel-dots" id="carousel-dots">
            <?php foreach($imgs as $i => $src): ?>
              <span class="<?= $i===0?'active':'' ?>" onclick="goSlide(<?= $i ?>)"></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <div class="carousel-info">
            <h5><?= $room_data['name'] ?></h5>
            <?php 
                $price = number_format($room_data['price'], 0, ',', '.');
            ?>
            <h6><?= $price ?> VND / đêm</h6>
          </div>
        </div>
      </div>

      <div class="confirm-right">
        <div class="form-card">
          <form action="pay_now.php" method="POST" id="booking_form">
            <h6>Thông tin chi tiết</h6>

            <div class="form-row-2">
              <div class="form-group">
                <label>Tên</label>
                <input name="name" type="text" value="<?= $user_data['name'] ?>" required>
              </div>
              <div class="form-group">
                <label>Số điện thoại</label>
                <input name="phonenum" type="number" value="<?= $user_data['phonenum'] ?>" required>
              </div>
            </div>

            <div class="form-group full">
              <label>Địa chỉ</label>
              <textarea name="address" rows="2" required><?= $user_data['address'] ?></textarea>
            </div>

            <div class="form-row-2">
              <div class="form-group">
                <label>Nhận phòng</label>
                <input name="checkin" type="date" onchange="check_availability()" required>
              </div>
              <div class="form-group">
                <label>Trả phòng</label>
                <input name="checkout" type="date" onchange="check_availability()" required>
              </div>
            </div>

            <div class="loader" id="info_loader"></div>
            <p id="pay_info">Vui lòng chọn ngày nhận phòng và trả phòng!</p>

            <button name="pay_now" class="btn-pay" disabled>Thanh toán</button>
          </form>
        </div>
      </div>

    </div>
  </div>

  <?php require('inc/footer.php'); ?>

  <script>
  let currentSlide = 0;
  const slides = document.querySelectorAll('.carousel-slide');
  const dots   = document.querySelectorAll('#carousel-dots span');

  function goSlide(index) {
    slides[currentSlide].classList.remove('active');
    if(dots[currentSlide]) dots[currentSlide].classList.remove('active');
    currentSlide = (index + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
    if(dots[currentSlide]) dots[currentSlide].classList.add('active');
  }

  function changeSlide(dir) {
    goSlide(currentSlide + dir);
  }

  let booking_form = document.getElementById('booking_form');
  let info_loader  = document.getElementById('info_loader');
  let pay_info     = document.getElementById('pay_info');

  function check_availability() {
    let checkin_val  = booking_form.elements['checkin'].value;
    let checkout_val = booking_form.elements['checkout'].value;

    booking_form.elements['pay_now'].setAttribute('disabled', true);

    if(checkin_val != '' && checkout_val != '') {
      pay_info.style.display    = 'none';
      pay_info.className        = '';
      info_loader.style.display = 'block';

      let data = new FormData();
      data.append('check_availability', '');
      data.append('check_in',  checkin_val);
      data.append('check_out', checkout_val);

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/confirm_booking.php", true);

      xhr.onload = function() {
        let res = JSON.parse(this.responseText);

        if(res.status == 'check_in_out_equal'){
          pay_info.innerText = "Lỗi: Không thể trả phòng vào cùng ngày nhận phòng!";
        } else if(res.status == 'check_out_earlier'){
          pay_info.innerText = "Lỗi: Ngày trả phòng phải sau ngày nhận phòng!";
        } else if(res.status == 'check_in_earlier'){
          pay_info.innerText = "Lỗi: Ngày nhận phòng không thể đặt ở quá khứ!";
        } else if(res.status == 'unavailable'){
          pay_info.innerText = "Rất tiếc! Phòng không còn trống trong thời gian này!";
        } else if(res.status == 'session_expired'){
          pay_info.innerText = "Phiên giao dịch hết hạn, vui lòng chọn lại phòng!";
        } else if(res.status == 'shutdown'){
          pay_info.innerText = "Hệ thống đang bảo trì, hiện không thể đặt phòng!";
        } else {
          let formatted_payment = res.payment.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
          pay_info.innerHTML = "<b style='color:#27724b;'>Tuyệt vời! Phòng có sẵn.</b><br>Thời gian lưu trú: <b>" + res.days + " đêm</b><br>Tổng tiền: <b>" + formatted_payment + " VND</b>";
          pay_info.className = 'info-ok';
          booking_form.elements['pay_now'].removeAttribute('disabled');
        }

        pay_info.style.display    = 'block';
        info_loader.style.display = 'none';
      }

      xhr.onerror = function() {
        pay_info.innerText        = "Lỗi kết nối máy chủ, vui lòng thử lại!";
        pay_info.style.display    = 'block';
        info_loader.style.display = 'none';
      }

      xhr.send(data);
    }
  }
  </script>

</body>
</html>