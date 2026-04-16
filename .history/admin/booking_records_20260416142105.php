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
    <title>Trang quản lý - Thống kê đặt phòng</title>

    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
    }

    .container-custom {
        width: 100%;
        display: flex;
    }

    .content {
        width: 100%;
        padding: 20px;
    }

    h3 {
        margin-bottom: 20px;
    }

    .card {
        background: #fff;
        border-radius: 6px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .search-box {
        text-align: right;
        margin-bottom: 20px;
    }

    .search-box input {
        width: 250px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1200px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
    }

    th {
        background: #333;
        color: #fff;
    }

    tr:hover {
        background: #f1f1f1;
    }

    .pagination {
        margin-top: 15px;
        display: flex;
        list-style: none;
        gap: 5px;
        padding: 0;
    }

    .pagination li {
        padding: 6px 10px;
        border: 1px solid #ccc;
        cursor: pointer;
        background: #fff;
    }

    .pagination li:hover {
        background: #ddd;
    }
    </style>

</head>

<body>

    <?php require('inc/header.php'); ?>

    <div class="container-custom" id="main-content">
        <div class="content">
            <h3>Thống kê</h3>

            <div class="card">

                <div class="search-box">
                    <input type="text" id="search_input" oninput="get_bookings(this.value)"
                        placeholder="Type to search...">
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Details</th>
                                <th>Room Details</th>
                                <th>Bookings Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-data"></tbody>
                    </table>
                </div>

                <ul class="pagination" id="table-pagination"></ul>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/booking_records.js"></script>

</body>

</html>