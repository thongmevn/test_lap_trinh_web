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
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        background-color: #f8f9fa;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    #main-content {
        width: 100%;
    }

    .page-wrapper {
        display: flex;
    }

    .page-content {
        width: 83.3333%;
        margin-left: auto;
        padding: 24px;
        overflow: hidden;
    }

    .page-content h3 {
        margin: 0 0 16px;
        font-size: 1.3rem;
    }

    /* Card */
    .card {
        background: #fff;
        border-radius: 8px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .card-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .card-header-row h5 {
        margin: 0;
        font-size: 1rem;
    }

    /* Buttons */
    .btn {
        display: inline-block;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-sm {
        font-size: 12px;
        padding: 4px 10px;
    }

    .btn-dark {
        background-color: #343a40;
        color: #fff;
    }

    .btn-dark:hover {
        background-color: #23272b;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-cancel {
        background: none;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .btn-cancel:hover {
        background-color: #f1f1f1;
    }

    /* Image grid */
    .row-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        z-index: 999;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal-overlay.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-box {
        background: #fff;
        border-radius: 8px;
        width: 420px;
        max-width: 92%;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .modal-box h5 {
        margin: 0 0 16px;
        font-size: 1rem;
    }

    /* Form */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        font-size: 13px;
    }

    .form-control {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
    }

    .form-control:focus {
        border-color: #007bff;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 8px;
    }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <div id="main-content">
        <div class="page-wrapper">
            <div class="page-content">
                <h3>Hình ảnh trình chiếu</h3>

                <div class="card">
                    <div class="card-body">
                        <div class="card-header-row">
                            <h5>Hình ảnh</h5>
                            <button type="button" class="btn btn-dark btn-sm" onclick="openModal()">
                                + Thêm
                            </button>
                        </div>
                        <div class="row-images" id="carousel-data"></div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal-overlay" id="carousel-s">
                    <div class="modal-box">
                        <h5>Thêm hình ảnh</h5>
                        <form id="carousel_s_form">
                            <div class="form-group">
                                <label for="carousel_picture_inp">Ảnh</label>
                                <input type="file" name="carousel_picture" id="carousel_picture_inp"
                                    accept=".jpg,.png,.webp,.jpeg" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="closeModal()" class="btn btn-cancel">Huỷ</button>
                                <button type="submit" class="btn btn-primary">Tải lên</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <!-- ✅ Không còn <script> inline, openModal/closeModal đã nằm trong carousel.js -->
    <script src="scripts/carousel.js"></script>

</body>

</html>