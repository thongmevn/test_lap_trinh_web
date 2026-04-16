<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Trang chủ</title>

    <style>
    body {
        background: #f8f9fa;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        width: 90%;
        margin: auto;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .text-center {
        text-align: center;
    }

    .bg-white {
        background: #fff;
    }

    .rounded {
        border-radius: 10px;
    }

    .shadow {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .p-4 {
        padding: 20px;
    }

    .mt-4 {
        margin-top: 20px;
    }

    .mt-5 {
        margin-top: 40px;
    }

    .mb-4 {
        margin-bottom: 20px;
    }

    .mb-3 {
        margin-bottom: 15px;
    }

    .my-3 {
        margin: 15px 0;
    }

    .availability-form {
        margin-top: -50px;
        position: relative;
        z-index: 2;
    }

    @media (max-width: 575px) {
        .availability-form {
            margin-top: 25px;
            padding: 0 20px;
        }
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn {
        padding: 8px 12px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-dark {
        background: #000;
        color: #fff;
    }

    .btn-outline-dark {
        border: 1px solid #000;
        color: #000;
        background: transparent;
    }

    .custom-bg {
        background: #0d6efd;
        color: #fff;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    .card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 15px;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background: #eee;
        font-size: 12px;
        margin: 2px;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-evenly {
        justify-content: space-evenly;
    }

    .align-items-center {
        align-items: center;
    }

    .col-lg-4,
    .col-md-6 {
        width: 33.33%;
    }

    @media (max-width: 768px) {

        .col-lg-4,
        .col-md-6 {
            width: 100%;
        }
    }

    .profile img {
        border-radius: 50%;
    }

    iframe {
        border: none;
    }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <!-- Carousel -->
    <div class="container mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php 
        $res = selectAll('carousel');
        while($row = mysqli_fetch_assoc($res))
        {
          $path = CAROUSEL_IMG_PATH;
          echo <<<data
            <div class="swiper-slide">
              <img src="$path$row[image]">
            </div>
          data;
        }
      ?>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="container availability-form">
        <div class="row">
            <div class="bg-white shadow p-4 rounded" style="width:100%;">
                <h5 class="mb-4">Tiến hành đặt phòng</h5>
                <form action="rooms.php">
                    <div class="row">
                        <div style="flex:1;" class="mb-3">
                            <label>Nhận phòng</label>
                            <input type="date" class="form-control" name="checkin" required>
                        </div>
                        <div style="flex:1;" class="mb-3">
                            <label>Trả phòng</label>
                            <input type="date" class="form-control" name="checkout" required>
                        </div>
                        <div style="flex:1;" class="mb-3">
                            <label>Người lớn</label>
                            <select class="form-select" name="adult">
                                <?php 
                $guests_q = mysqli_query($con,"SELECT MAX(adult) AS max_adult, MAX(children) AS max_children FROM rooms");  
                $guests_res = mysqli_fetch_assoc($guests_q);
                for($i=1;$i<=$guests_res['max_adult'];$i++){
                  echo "<option>$i</option>";
                }
              ?>
                            </select>
                        </div>
                        <div style="flex:1;" class="mb-3">
                            <label>Trẻ em</label>
                            <select class="form-select" name="children">
                                <?php 
                for($i=1;$i<=$guests_res['max_children'];$i++){
                  echo "<option>$i</option>";
                }
              ?>
                            </select>
                        </div>
                        <div style="flex:1;" class="mb-3">
                            <button class="btn custom-bg">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Rooms -->
    <h2 class="text-center mt-5">Danh sách phòng</h2>

    <div class="container">
        <div class="row">

            <?php 
$room_res = select("SELECT * FROM rooms WHERE status=? AND removed=? LIMIT 3",[1,0],'ii');

while($room_data = mysqli_fetch_assoc($room_res))
{
  $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";

  echo <<<data
    <div class="col-lg-4 col-md-6 my-3">
      <div class="card shadow">
        <img src="$room_thumb">
        <div class="card-body">
          <h5>$room_data[name]</h5>
          <h6>$room_data[price] VND / đêm</h6>
          <div class="d-flex justify-content-evenly">
            <button class="btn custom-bg">Đặt ngay</button>
            <a href="room_details.php?id=$room_data[id]" class="btn btn-outline-dark">Chi tiết</a>
          </div>
        </div>
      </div>
    </div>
  data;
}
?>

        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <script>
    var swiper = new Swiper(".swiper-container", {
        loop: true,
        autoplay: {
            delay: 3000,
        }
    });
    </script>

</body>

</html>