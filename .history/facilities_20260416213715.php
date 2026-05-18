<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Tiện ích</title>

    <style>
    body {
        background: #f8f9fa;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: auto;
        padding: 0 15px;
    }

    .text-center {
        text-align: center;
    }

    .fw-bold {
        font-weight: bold;
    }

    .my-5 {
        margin: 50px 0;
    }

    .mt-3 {
        margin-top: 15px;
    }

    .mb-5 {
        margin-bottom: 30px;
    }

    .px-4 {
        padding: 0 20px;
    }

    /* title line */
    .h-line {
        width: 80px;
        height: 3px;
        background: #000;
        margin: 10px auto;
    }

    /* row */
    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col {
        width: 33.33%;
        box-sizing: border-box;
        padding: 10px;
    }

    @media (max-width: 992px) {
        .col {
            width: 50%;
        }
    }

    @media (max-width: 600px) {
        .col {
            width: 100%;
        }
    }

    /* card */
    .card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-top: 4px solid #000;
        transition: 0.3s;
    }

    .card:hover {
        border-top-color: #20c997;
        transform: scale(1.03);
    }

    .flex {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .icon {
        width: 40px;
    }

    p {
        margin: 10px 0 0;
    }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4 text-center">
        <h2 class="fw-bold">TIỆN ÍCH</h2>
        <div class="h-line"></div>
        <p class="mt-3">
            Khách sạn cung cấp đầy đủ tiện nghi hiện đại như Wi-Fi tốc độ cao, máy lạnh, truyền hình, và máy nước nóng.
            <br>
            Quý khách có thể thư giãn tại spa, tận hưởng không gian ban công thoáng mát, hoặc sử dụng khu bếp tiện nghi
            và ghế sofa êm ái. <br>
            Chúng tôi cam kết mang đến trải nghiệm nghỉ dưỡng thoải mái và trọn vẹn.
        </p>
    </div>

    <div class="container">
        <div class="row">
            <?php 
        $res = selectAll('facilities');
        $path = FACILITIES_IMG_PATH;

        while($row = mysqli_fetch_assoc($res)){
          echo<<<data
            <div class="col">
              <div class="card">
                <div class="flex">
                  <img src="$path$row[icon]" class="icon">
                  <h5>$row[name]</h5>
                </div>
                <p>$row[description]</p>
              </div>
            </div>
          data;
        }
      ?>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

</body>

</html>