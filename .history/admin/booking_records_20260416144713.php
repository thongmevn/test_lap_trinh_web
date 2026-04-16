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
    <?php require('inc/links.php'); ?>

    <style>
    body {
        background-color: #f8f9fa;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    #main-content {
        width: 100%;
    }

    .row {
        display: flex;
    }

    .col-lg-10 {
        width: 83.3333%;
        margin-left: auto;
        padding: 24px;
        overflow: hidden;
    }

    h3 {
        margin-bottom: 16px;
    }

    .card {
        background: #fff;
        border-radius: 8px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .text-end {
        text-align: right;
        margin-bottom: 16px;
    }

    .form-control {
        padding: 8px 10px;
        width: 25%;
        margin-left: auto;
        display: block;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
    }

    .form-control:focus {
        border-color: #007bff;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1200px;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    thead tr {
        background-color: #343a40;
        color: #fff;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding-left: 0;
        margin-top: 16px;
        gap: 5px;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination li a {
        display: block;
        padding: 6px 12px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #007bff;
        border-radius: 4px;
    }

    .pagination li a:hover {
        background-color: #007bff;
        color: #fff;
    }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <div id="main-content">
        <div class="row">
            <div class="col-lg-10">
                <h3>Thống kê</h3>

                <div class="card">
                    <div class="card-body">

                        <div class="text-end">
                            <input type="text" id="search_input" oninput="get_bookings(this.value)" class="form-control"
                                placeholder="Type to search...">
                        </div>

                        <div class="table-responsive">
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
                                <tbody id="table-data">
                                </tbody>
                            </table>
                        </div>

                        <nav>
                            <ul class="pagination" id="table-pagination">
                            </ul>
                        </nav>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/booking_records.js"></script>

</body>

</html>