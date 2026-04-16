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
    <title>Trang quản lý - Không gian và Tiện ích</title>
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

    .table-responsive-md {
        max-height: 350px;
        overflow-y: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
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
                <h3>Không Gian và Tiện ích</h3>

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5>Không gian</h5>
                            <button type="button" class="btn btn-dark btn-sm" onclick="openModal('feature-s')">+
                                Thêm</button>
                        </div>

                        <div class="table-responsive-md">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="features-data"></tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5>Tiện ích</h5>
                            <button type="button" class="btn btn-dark btn-sm" onclick="openModal('facility-s')">+
                                Thêm</button>
                        </div>

                        <div class="table-responsive-md">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th style="width:40%">Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="facilities-data"></tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Feature modal -->
    <div class="modal" id="feature-s">
        <div class="modal-dialog">
            <form id="feature_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Thêm Không Gian</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-bold">Tên</label>
                            <input type="text" name="feature_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary" onclick="closeModal('feature-s')">Huỷ</button>
                        <button type="submit" class="btn custom-bg text-white">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Facility modal -->
    <div class="modal" id="facility-s">
        <div class="modal-dialog">
            <form id="facility_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Thêm Tiện Ích</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-bold">Tên</label>
                            <input type="text" name="facility_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Icon</label>
                            <input type="file" name="facility_icon" accept=".svg" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Mô tả</label>
                            <textarea name="facility_desc" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary" onclick="closeModal('facility-s')">Huỷ</button>
                        <button type="submit" class="btn custom-bg text-white">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/features_facilities.js"></script>

    <script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }
    </script>

</body>

</html>