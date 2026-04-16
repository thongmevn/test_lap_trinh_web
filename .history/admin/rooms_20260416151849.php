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
    <title>Trang quản lý - Danh sách phòng</title>
    <?php require('inc/links.php'); ?>

    <style>
    body {
        background-color: #f8f9fa;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-lg-10 {
        width: 83.3333%;
        margin-left: auto;
        padding: 24px;
    }

    h3 {
        margin-bottom: 20px;
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

    .btn {
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-dark {
        background: #343a40;
        color: #fff;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
    }

    .custom-bg {
        background: #007bff;
    }

    .text-white {
        color: #fff;
    }

    .table-responsive-lg {
        max-height: 450px;
        overflow-y: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    thead tr {
        background: #343a40;
        color: #fff;
    }

    tbody tr:hover {
        background: #f1f1f1;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal {
        display: none;
    }

    /* simple spacing */
    .mb-3 {
        margin-bottom: 12px;
    }

    .mb-4 {
        margin-bottom: 16px;
    }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <div id="main-content">
        <div class="row">
            <div class="col-lg-10">
                <h3>Danh sách phòng</h3>

                <div class="card">
                    <div class="card-body">

                        <div class="text-end">
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                data-bs-target="#add-room">
                                Thêm
                            </button>
                        </div>

                        <div class="table-responsive-lg">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Area</th>
                                        <th>Guests</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data"></tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Add room modal -->
    <div class="modal" id="add-room">
        <div class="modal-dialog">
            <form id="add_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Thêm Phòng</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tên phòng</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Diện tích</label>
                                <input type="number" name="area" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Giá</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Số lượng</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Người lớn</label>
                                <input type="number" name="adult" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Trẻ em</label>
                                <input type="number" name="children" class="form-control" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label>Không gian</label>
                                <div class="row">
                                    <?php 
                    $res = selectAll('features');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo "<label><input type='checkbox' name='features' value='$opt[id]'> $opt[name]</label><br>";
                    }
                  ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label>Tiện ích</label>
                                <div class="row">
                                    <?php 
                    $res = selectAll('facilities');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo "<label><input type='checkbox' name='facilities' value='$opt[id]'> $opt[name]</label><br>";
                    }
                  ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label>Mô tả</label>
                                <textarea name="desc" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary">Huỷ</button>
                        <button type="submit" class="btn custom-bg text-white">Tiếp tục</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/rooms.js"></script>

</body>

</html>