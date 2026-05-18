<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Về chúng tôi</title>
    <style>
    .about-title {
        text-align: center;
        margin: 50px 0 20px;
        padding: 0 16px;
    }

    .about-intro {
        text-align: center;
        margin-top: 12px;
    }

    .about-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 16px;
    }

    .about-text {
        flex: 1 1 400px;
        order: 1;
    }

    .about-img {
        flex: 1 1 300px;
        order: 2;
    }

    .about-img img {
        width: 100%;
    }

    .stats-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        max-width: 1140px;
        margin: 40px auto 0;
        padding: 0 16px;
    }

    .stat-box {
        flex: 1 1 200px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
        padding: 24px 16px;
        text-align: center;
        border-top: 4px solid var(--primary-color);
    }

    .stat-box img {
        width: 70px;
    }

    .stat-box h4 {
        margin-top: 12px;
        margin-bottom: 0;
    }

    .team-wrap {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 16px 40px;
    }

    .team-wrap .swiper-slide img {
        width: 100%;
        height: auto;
        max-height: 300px;
        object-fit: contain;
        background: #f8f8f8;
    }

    .team-wrap .swiper-slide {
        background: #fff;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
    }

    @media (max-width: 767px) {
        .about-text { order: 2; }
        .about-img  { order: 1; }
        .stat-box   { flex: 1 1 140px; }
    }
    </style>
</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="about-title">
        <h2 class="fw-bold h-font">VỀ CHÚNG TÔI</h2>
        <div class="h-line bg-dark"></div>
        <p class="about-intro">
            Sinh viên K47 - Trường Đại Quy Nhơn - Khoa Công nghệ Thông tin <br>
            Nhóm 2
        </p>
    </div>

    <div class="about-row">
        <div class="about-text">
            <h3 style="margin-bottom:12px;">Lời cảm ơn</h3>
            <p>
                Chúng em xin được bày tỏ lòng biết ơn đến các thầy, cô trường Đại học Quy Nhơn - Khoa Công
                Nghệ Thông Tin đã giúp đỡ, hỗ trợ nhiệt tình trong suốt quá trình học. <br><br>
                Đặc biệt gửi lời cảm ơn đến cô Võ Thị Mỹ đã trực tiếp giúp đỡ, hỗ trợ, hướng dẫn em hoàn
                thành khóa luận này.
            </p>
        </div>
        <div class="about-img">
            <img src="images/about/about.jpg">
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-box">
            <img src="images/about/hotel.svg">
            <h4>100+ PHÒNG</h4>
        </div>
        <div class="stat-box">
            <img src="images/about/customers.svg">
            <h4>200+ KHÁCH HÀNG</h4>
        </div>
        <div class="stat-box">
            <img src="images/about/rating.svg">
            <h4>150+ ĐÁNH GIÁ</h4>
        </div>
        <div class="stat-box">
            <img src="images/about/staff.svg">
            <h4>50+ NHÂN SỰ</h4>
        </div>
    </div>

    <h3 style="margin:50px 0 24px;text-align:center;font-weight:700;" class="h-font">CÁC THÀNH VIÊN TRONG NHÓM</h3>

    <div class="team-wrap">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper" style="margin-bottom:30px;">
                <?php 
          $about_r = selectAll('team_details');
          $path = ABOUT_IMG_PATH;
          while($row = mysqli_fetch_assoc($about_r)){
            echo<<<data
              <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                <img src="$path$row[picture]" class="w-100">
                <h5 class="mt-2">$row[name]</h5>
              </div>
            data;
          }
        ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 40,
        slidesPerView: 3,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            640: { slidesPerView: 1 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 3 },
        }
    });
    </script>

</body>

</html>
