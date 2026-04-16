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
        background: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    #main-content {
        padding: 20px;
    }

    .container-custom {
        display: flex;
    }

    .content {
        flex: 1;
        padding: 20px;
    }

    h3 {
        margin-bottom: 20px;
    }

    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-body {
        padding: 20px;
    }

    .text-end {
        text-align: right;
    }

    .btn {
        padding: 6px 12px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-dark {
        background: #212529;
        color: #fff;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
    }

    .custom-bg {
        background: #0d6efd;
    }

    .table-container {
        max-height: 450px;
        overflow-y: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    thead {
        background: #212529;
        color: #fff;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .col-6 {
        width: calc(50% - 10px);
    }

    .col-12 {
        width: 100%;
    }

    .col-3 {
        width: calc(25% - 10px);
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    textarea.form-control {
        resize: vertical;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 999;
    }

    .modal.show {
        display: flex;
    }

    .modal-dialog {
        background: #fff;
        border-radius: 8px;
        width: 90%;
        max-width: 800px;
        overflow: hidden;
    }

    .modal-header,
    .modal-footer {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .modal-footer {
        border-top: 1px solid #eee;
        text-align: right;
    }

    .modal-body {
        padding: 15px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .btn-close {
        float: right;
        cursor: pointer;
    }
    </style>

</head>

<body>

    <?php require('inc/header.php'); ?>

    <div id="main-content">
        <div class="container-custom">
            <div class="content">
                <h3>Danh sách phòng</h3>

                <div class="card">
                    <div class="card-body">

                        <div class="text-end">
                            <button class="btn btn-dark"
                                onclick="document.getElementById('add-room').classList.add('show')">
                                + Thêm
                            </button>
                        </div>

                        <div class="table-container">
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
            <form id="add_room_form">
                <div class="modal-header">
                    <h5>Thêm Phòng</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label>Tên phòng</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label>Diện tích</label>
                            <input type="number" name="area" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label>Giá</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label>Số lượng</label>
                            <input type="number" name="quantity" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label>Người lớn</label>
                            <input type="number" name="adult" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label>Trẻ em</label>
                            <input type="number" name="children" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label>Không gian</label>
                            <div class="row">
                                <?php 
                $res = selectAll('features');
                while($opt = mysqli_fetch_assoc($res)){
                  echo "
                  <div class='col-3'>
                    <label>
                      <input type='checkbox' name='features' value='$opt[id]'>
                      $opt[name]
                    </label>
                  </div>";
                }
              ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <label>Tiện ích</label>
                            <div class="row">
                                <?php 
                $res = selectAll('facilities');
                while($opt = mysqli_fetch_assoc($res)){
                  echo "
                  <div class='col-3'>
                    <label>
                      <input type='checkbox' name='facilities' value='$opt[id]'>
                      $opt[name]
                    </label>
                  </div>";
                }
              ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <label>Mô tả</label>
                            <textarea name="desc" class="form-control"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="document.getElementById('add-room').classList.remove('show')">Huỷ</button>
                    <button type="submit" class="btn custom-bg">Tiếp tục</button>
                </div>
            </form>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/rooms.js"></script>

</body>

</html>