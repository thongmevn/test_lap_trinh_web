<?php
  require('inc/essentials.php');
  adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý - Trình chiếu</title>
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

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .mb-3 {
        margin-bottom: 16px;
    }

    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-dark {
        background-color: #343a40;
        color: #fff;
    }

    .btn-dark:hover {
        background-color: #23272b;
    }

    .btn-sm {
        font-size: 12px;
        padding: 4px 8px;
    }

    .text-secondary {
        color: #6c757d;
        background: none;
    }

    .custom-bg {
        background-color: #007bff;
    }

    .custom-bg:hover {
        background-color: #0056b3;
    }

    .text-white {
        color: #fff;
    }

    .row-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal.show {
        display: block;
    }

    .modal-dialog {
        background: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        max-width: 90%;
    }

    .modal-header {
        margin-bottom: 10px;
    }

    .modal-body {
        margin-bottom: 10px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .fw-bold {
        font-weight: bold;
    }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <div id="main-content">
        <div class="row">
            <div class="col-lg-10">
                <h3>Hình ảnh trình chiếu</h3>

                <!-- Carousel section -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title">Hình ảnh</h5>
                            <button type="button" class="btn btn-dark btn-sm" onclick="openModal()">
                                + Thêm
                            </button>
                        </div>

                        <div class="row-images" id="carousel-data">
                        </div>

                    </div>
                </div>

                <!-- Modal -->
                <div class="modal" id="carousel-s">
                    <div class="modal-dialog">
                        <form id="carousel_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm hình ảnh</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="fw-bold">Ảnh</label>
                                        <input type="file" name="carousel_picture" id="carousel_picture_inp"
                                            accept=".jpg, .png, .webp, .jpeg" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="closeModal(); carousel_picture.value=''"
                                        class="btn text-secondary">Huỷ</button>
                                    <button type="submit" class="btn custom-bg text-white">Tải lên</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/carousel.js"></script>

    <script>
    function openModal() {
        document.getElementById('carousel-s').classList.add('show');
    }

    function closeModal() {
        document.getElementById('carousel-s').classList.remove('show');
    }
    </script>

</body>

</html>