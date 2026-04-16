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
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: #f8f9fa;
        font-family: sans-serif;
        font-size: 14px;
        color: #212529;
    }

    /* Layout */
    #main-content {
        padding: 1.5rem;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-lg-10 {
        width: 100%;
        margin-left: auto;
        padding: 1.5rem;
        overflow: hidden;
    }

    @media (min-width: 992px) {
        .col-lg-10 {
            width: 83.333%;
        }
    }

    h3 {
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
    }

    /* Card */
    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, .1);
        margin-bottom: 1.5rem;
    }

    .card-body {
        padding: 1.25rem;
    }

    /* Button */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: .35rem .75rem;
        font-size: .85rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-dark {
        background: #212529;
        color: #fff;
    }

    .btn-dark:hover {
        background: #343a40;
    }

    .btn-cancel {
        background: transparent;
        color: #6c757d;
    }

    .btn-cancel:hover {
        background: #f1f1f1;
    }

    .custom-btn {
        background: #0d6efd;
        color: #fff;
    }

    .custom-btn:hover {
        background: #0b5ed7;
    }

    .btn-sm {
        font-size: .8rem;
        padding: .25rem .6rem;
    }

    .btn-icon {
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .btn-icon:hover {
        background: #e9ecef;
    }

    .text-end {
        text-align: right;
        margin-bottom: 1rem;
    }

    /* Table */
    .table-responsive-lg {
        height: 450px;
        overflow-y: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    thead tr {
        background: #212529;
        color: #fff;
    }

    th,
    td {
        padding: .6rem .8rem;
        border: 1px solid #dee2e6;
        font-size: .85rem;
    }

    tbody tr:hover {
        background: #f1f1f1;
    }

    /* Modal overlay */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 1000;
        overflow-y: auto;
        padding: 2rem 1rem;
    }

    .modal-overlay.show {
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }

    .modal-dialog {
        background: #fff;
        border-radius: 8px;
        width: 100%;
        max-width: 700px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .2);
        margin: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .9rem 1.25rem;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-header h5 {
        font-size: 1rem;
        font-weight: 600;
    }

    .modal-body {
        padding: 1.25rem;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: .5rem;
        padding: .9rem 1.25rem;
        border-top: 1px solid #dee2e6;
    }

    .btn-close {
        background: transparent;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: #666;
    }

    .btn-close:hover {
        color: #000;
    }

    /* Form grid */
    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0 1rem;
    }

    .col-md-6 {
        width: calc(50% - .5rem);
        margin-bottom: 1rem;
    }

    .col-12 {
        width: 100%;
        margin-bottom: 1rem;
    }

    @media (max-width: 640px) {
        .col-md-6 {
            width: 100%;
        }
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: .35rem;
        font-size: .85rem;
    }

    .form-control {
        width: 100%;
        padding: .45rem .7rem;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: .9rem;
        outline: none;
    }

    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, .2);
    }

    textarea.form-control {
        resize: vertical;
    }

    /* Checkbox grid */
    .check-grid {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem 0;
    }

    .check-col {
        width: 25%;
        padding-right: .5rem;
    }

    @media (max-width: 640px) {
        .check-col {
            width: 50%;
        }
    }

    .check-col label {
        font-weight: normal;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }

    .form-check-input {
        width: 15px;
        height: 15px;
        cursor: pointer;
    }

    /* Alert */
    #image-alert {
        margin-bottom: .75rem;
    }

    .alert {
        padding: .6rem 1rem;
        border-radius: 4px;
        font-size: .85rem;
    }

    .alert-success {
        background: #d1e7dd;
        color: #0f5132;
    }

    .alert-danger {
        background: #f8d7da;
        color: #842029;
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
                            <button type="button" class="btn btn-dark btn-sm" onclick="openModal('add-room')">
                                + Thêm
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
    <div class="modal-overlay" id="add-room">
        <div class="modal-dialog">
            <form id="add_room_form" autocomplete="off">
                <div class="modal-header">
                    <h5>Thêm Phòng</h5>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label>Tên phòng</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Diện tích</label>
                            <input type="number" min="1" name="area" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Giá</label>
                            <input type="number" min="1" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Số lượng</label>
                            <input type="number" min="1" name="quantity" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Người lớn (Tối đa.)</label>
                            <input type="number" min="1" name="adult" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Trẻ em (Tối đa.)</label>
                            <input type="number" min="1" name="children" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label>Không gian</label>
                            <div class="check-grid">
                                <?php 
                                $res = selectAll('features');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo"
                                    <div class='check-col'>
                                        <label>
                                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input'>
                                            $opt[name]
                                        </label>
                                    </div>
                                    ";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Tiện ích</label>
                            <div class="check-grid">
                                <?php 
                                $res = selectAll('facilities');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo"
                                    <div class='check-col'>
                                        <label>
                                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input'>
                                            $opt[name]
                                        </label>
                                    </div>
                                    ";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Mô tả</label>
                            <textarea name="desc" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-cancel" onclick="closeModal('add-room')">Huỷ</button>
                    <button type="submit" class="btn custom-btn">Tiếp tục</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit room modal -->
    <div class="modal-overlay" id="edit-room">
        <div class="modal-dialog">
            <form id="edit_room_form" autocomplete="off">
                <div class="modal-header">
                    <h5>Cập nhật danh sách phòng</h5>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label>Tên phòng</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Diện tích</label>
                            <input type="number" min="1" name="area" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Giá phòng</label>
                            <input type="number" min="1" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Số lượng</label>
                            <input type="number" min="1" name="quantity" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Người lớn (Tối đa.)</label>
                            <input type="number" min="1" name="adult" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Trẻ em (Tối đa.)</label>
                            <input type="number" min="1" name="children" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label>Không gian</label>
                            <div class="check-grid">
                                <?php 
                                $res = selectAll('features');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo"
                                    <div class='check-col'>
                                        <label>
                                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input'>
                                            $opt[name]
                                        </label>
                                    </div>
                                    ";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Facilities</label>
                            <div class="check-grid">
                                <?php 
                                $res = selectAll('facilities');
                                while($opt = mysqli_fetch_assoc($res)){
                                    echo"
                                    <div class='check-col'>
                                        <label>
                                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input'>
                                            $opt[name]
                                        </label>
                                    </div>
                                    ";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Description</label>
                            <textarea name="desc" rows="4" class="form-control" required></textarea>
                        </div>
                        <input type="hidden" name="room_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-cancel" onclick="closeModal('edit-room')">CANCEL</button>
                    <button type="submit" class="btn custom-btn">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Manage room images modal -->
    <div class="modal-overlay" id="room-images">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Room Name</h5>
                <button type="button" class="btn-close" onclick="closeModal('room-images')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="image-alert"></div>
                <div style="border-bottom: 3px solid #dee2e6; padding-bottom: 1rem; margin-bottom: 1rem;">
                    <form id="add_image_form">
                        <label>Add Image</label>
                        <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg" class="form-control"
                            style="margin-bottom:.75rem;" required>
                        <button class="btn custom-btn">ADD</button>
                        <input type="hidden" name="room_id">
                    </form>
                </div>
                <div class="table-responsive-lg" style="height: 350px;">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:60%">Image</th>
                                <th>Thumb</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="room-image-data"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>

    <script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }
    // Close on overlay click
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeModal(overlay.id);
        });
    });

    // Patch Bootstrap modal API so rooms.js still works
    window.bootstrap = window.bootstrap || {};
    window.bootstrap.Modal = function(el) {
        this.el = typeof el === 'string' ? document.querySelector(el) : el;
    };
    window.bootstrap.Modal.prototype.show = function() {
        if (this.el) this.el.classList.add('show');
    };
    window.bootstrap.Modal.prototype.hide = function() {
        if (this.el) this.el.classList.remove('show');
    };
    window.bootstrap.Modal.getInstance = function(el) {
        return new window.bootstrap.Modal(el);
    };
    // data-bs-target button support
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var target = btn.getAttribute('data-bs-target');
            if (target) openModal(target.replace('#', ''));
        });
    });
    // data-bs-dismiss support
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var overlay = btn.closest('.modal-overlay');
            if (overlay) closeModal(overlay.id);
        });
    });
    </script>
    <script src="scripts/rooms.js"></script>

</body>

</html>