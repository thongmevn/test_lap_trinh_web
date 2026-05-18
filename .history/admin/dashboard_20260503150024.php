<?php
  require('inc/essentials.php');
  require('inc/db_config.php');
  adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Lý</title>
    <?php require('inc/links.php'); ?>

    <style>
    body {
        background: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    #main-content {
        padding: 20px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .col-3 {
        width: calc(25% - 15px);
    }

    .col-10 {
        width: calc(83.333% - 15px);
        margin-left: auto;
    }

    .card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    h3,
    h5 {
        margin: 0;
    }

    .mb-4 {
        margin-bottom: 20px;
    }

    .mb-3 {
        margin-bottom: 15px;
    }

    .d-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        background: red;
        font-size: 14px;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .text-success {
        color: #198754;
    }

    .text-warning {
        color: #ffc107;
    }

    .text-info {
        color: #0dcaf0;
    }

    .text-primary {
        color: #0d6efd;
    }

    .text-danger {
        color: #dc3545;
    }

    select {
        padding: 6px 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    h1 {
        margin: 10px 0 0 0;
        font-size: 28px;
    }

    h4 {
        margin: 5px 0 0 0;
        font-size: 18px;
    }

    h6 {
        margin: 0;
        font-size: 14px;
        font-weight: bold;
    }
    </style>

</head>

<body>

    <?php 
  require('inc/header.php'); 
  
  $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

  $current_bookings = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
    COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END) AS `new_bookings`,
    COUNT(CASE WHEN booking_status='cancelled' AND refund=0 THEN 1 END) AS `refund_bookings`
    FROM `booking_order`"));

  $unread_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
    FROM `user_queries` WHERE `seen`=0"));

  $unread_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
    FROM `rating_review` WHERE `seen`=0"));
  
  $current_users = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
    COUNT(id) AS `total`,
    COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`,
    COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`,
    COUNT(CASE WHEN `is_verified`=0 THEN 1 END) AS `unverified`
    FROM `user_cred`"));  
?>

    <div id="main-content">
        <div class="row">
            <div class="col-10">

                <div class="d-flex mb-4">
                    <h3>DASHBOARD</h3>
                    <?php 
          if($is_shutdown['shutdown']){
            echo "<div class='badge'>Shutdown Mode is Active!</div>";
          }
        ?>
                </div>

                <div class="row mb-4">
                    <div class="col-3">
                        <a href="new_bookings.php">
                            <div class="card text-success">
                                <h6>Lượt đặt phòng mới</h6>
                                <h1><?php echo $current_bookings['new_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-3">
                        <a href="refund_bookings.php">
                            <div class="card text-warning">
                                <h6>Lượt hoàn tiền</h6>
                                <h1><?php echo $current_bookings['refund_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-3">
                        <a href="user_queries.php">
                            <div class="card text-info">
                                <h6>Số tin nhắn</h6>
                                <h1><?php echo $unread_queries['count'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-3">
                        <a href="rate_review.php">
                            <div class="card text-info">
                                <h6>Lượt đánh giá</h6>
                                <h1><?php echo $unread_reviews['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <h5>Booking Analytics</h5>
                    <select onchange="booking_analytics(this.value)">
                        <option value="1">Past 30 Days</option>
                        <option value="2">Past 90 Days</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All time</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-3">
                        <div class="card text-primary">
                            <h6>Total Bookings</h6>
                            <h1 id="total_bookings">0</h1>
                            <h4 id="total_amt">0 VND</h4>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card text-success">
                            <h6>Active Bookings</h6>
                            <h1 id="active_bookings">0</h1>
                            <h4 id="active_amt">0 VND</h4>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card text-danger">
                            <h6>Cancelled Bookings</h6>
                            <h1 id="cancelled_bookings">0</h1>
                            <h4 id="cancelled_amt">0 VND</h4>
                        </div>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <h5>User, Queries, Reviews Analytics</h5>
                    <select onchange="user_analytics(this.value)">
                        <option value="1">Past 30 Days</option>
                        <option value="2">Past 90 Days</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All time</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-3">
                        <div class="card text-success">
                            <h6>New Registration</h6>
                            <h1 id="total_new_reg">0</h1>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card text-primary">
                            <h6>Queries</h6>
                            <h1 id="total_queries">0</h1>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card text-primary">
                            <h6>Reviews</h6>
                            <h1 id="total_reviews">0</h1>
                        </div>
                    </div>
                </div>

                <h5>Users</h5>

                <div class="row mb-3">
                    <div class="col-3">
                        <div class="card text-info">
                            <h6>Total</h6>
                            <h1><?php echo $current_users['total'] ?></h1>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card text-success">
                            <h6>Active</h6>
                            <h1><?php echo $current_users['active'] ?></h1>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card text-warning">
                            <h6>Inactive</h6>
                            <h1><?php echo $current_users['inactive'] ?></h1>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card text-danger">
                            <h6>Unverified</h6>
                            <h1><?php echo $current_users['unverified'] ?></h1>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/dashboard.js"></script>

</body>

</html>