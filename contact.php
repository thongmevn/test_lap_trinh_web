<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('inc/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> - Liên hệ</title>
  <style>
  .contact-wrap {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 16px 60px;
  }

  .contact-title {
    text-align: center;
    margin: 50px 0 30px;
    padding: 0 16px;
  }

  .contact-title p {
    margin-top: 12px;
    line-height: 1.8;
  }

  .contact-row {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
  }

  .contact-left,
  .contact-right {
    flex: 1 1 420px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    padding: 24px;
  }

  .contact-left iframe {
    width: 100%;
    height: 280px;
    border: none;
    border-radius: 8px;
    display: block;
    margin-bottom: 20px;
  }

  .contact-left h5 {
    margin: 16px 0 6px;
    font-weight: 600;
  }

  .contact-left h5:first-of-type {
    margin-top: 0;
  }

  .contact-left a {
    display: inline-block;
    text-decoration: none;
    color: #222;
    margin-bottom: 6px;
    font-size: 15px;
  }

  .social-icons a {
    font-size: 22px;
    color: #222;
    margin-right: 12px;
    text-decoration: none;
  }

  .social-icons a:hover {
    color: var(--primary-color);
  }

  /* Form */
  .form-group {
    display: flex;
    flex-direction: column;
    margin-top: 14px;
  }

  .form-group label {
    font-weight: 500;
    margin-bottom: 6px;
    font-size: 14px;
  }

  .form-group input,
  .form-group textarea {
    padding: 9px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s;
  }

  .form-group input:focus,
  .form-group textarea:focus {
    border-color: var(--primary-color);
  }

  .form-group textarea {
    resize: none;
  }

  .btn-submit {
    margin-top: 16px;
    padding: 10px 24px;
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.2s;
  }

  .btn-submit:hover {
    background: var(--primary-hover);
  }
  </style>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <div class="contact-title">
    <h2 class="fw-bold h-font">LIÊN HỆ</h2>
    <div class="h-line"></div>
    <p>
      Chúng tôi luôn sẵn sàng hỗ trợ bạn! <br>
      Liên hệ ngay qua hotline, email, hoặc biểu mẫu trực tuyến để được tư vấn và giải đáp thắc mắc. <br>
      Đội ngũ của chúng tôi sẽ phản hồi nhanh chóng, đảm bảo mang đến sự hài lòng cho quý khách.
    </p>
  </div>

  <div class="contact-wrap">
    <div class="contact-row">

      <!-- Thông tin liên hệ -->
      <div class="contact-left">
        <iframe src="<?php echo $contact_r['iframe'] ?>" loading="lazy"></iframe>

        <h5>Địa chỉ</h5>
        <a href="<?php echo $contact_r['gmap'] ?>" target="_blank">
          <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?>
        </a>

        <h5>Tổng đài viên</h5>
        <a href="tel:+<?php echo $contact_r['pn1'] ?>">
          <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
        </a>

        <h5>Email</h5>
        <a href="mailto:<?php echo $contact_r['email'] ?>">
          <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email'] ?>
        </a>

        <h5>Theo dõi chúng tôi</h5>
        <div class="social-icons">
          <?php if($contact_r['tw']!=''): ?>
            <a href="<?php echo $contact_r['tw'] ?>"><i class="bi bi-twitter"></i></a>
          <?php endif; ?>
          <a href="<?php echo $contact_r['fb'] ?>"><i class="bi bi-facebook"></i></a>
          <a href="<?php echo $contact_r['insta'] ?>"><i class="bi bi-instagram"></i></a>
        </div>
      </div>

      <!-- Form liên hệ -->
      <div class="contact-right">
        <form method="POST">
          <h5 class="fw-bold h-font" style="margin:0 0 8px;">Để lại lời nhắn</h5>

          <div class="form-group">
            <label>Tên</label>
            <input name="name" type="text" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" required>
          </div>
          <div class="form-group">
            <label>Tiêu đề</label>
            <input name="subject" type="text" required>
          </div>
          <div class="form-group">
            <label>Nội dung</label>
            <textarea name="message" rows="5" required></textarea>
          </div>

          <button type="submit" name="send" class="btn-submit">Gửi</button>
        </form>
      </div>

    </div>
  </div>

  <?php 
    if(isset($_POST['send'])) {
      $frm_data = filteration($_POST);
      $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
      $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];
      $res = insert($q, $values, 'ssss');
      if($res == 1){
        alert('success', 'Email đã được gửi đi!');
      } else {
        alert('error', 'Hệ thống đang được bảo trì! Hãy thử lại sau ít phút.');
      }
    }
  ?>

  <?php require('inc/footer.php'); ?>

</body>
</html>
