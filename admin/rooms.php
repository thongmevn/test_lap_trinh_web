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
    /* ===== CẤU TRÚC VÙNG NỘI DUNG CHÍNH ===== */
    #main-content {
        padding: 40px 30px !important; /* Tạo khoảng cách đệm trên dưới và hai bên cho thoáng */
    }

    /* Đổi container thành khối tự do để tính toán kích thước chuẩn theo header */
    #main-content.container {
        max-width: none !important; 
        margin-left: 250px !important; /* Chừa khoảng trống cố định cho sidebar bên trái */
        width: calc(100% - 250px) !important; /* Chiều rộng bằng phần còn lại của màn hình */
    }

    /* Đảm bảo hàng và khối nội dung dãn vừa vặn 100% không gian được chia */
    #main-content .row,
    #main-content .content {
        width: 100% !important;
        margin: 0 !important;
    }

    /* Loại bỏ padding thừa của cột con nếu có */
    #main-content .col-lg-10 {
        width: 100% !important;
        padding: 0 !important;
    }

    /* ===== THẺ CARD CHỨA BẢNG ===== */
    .card {
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        border: none !important;
        width: 100% !important;
    }

    .card-body {
        padding: 24px !important;
    }

    /* ===== NÚT THÊM PHÒNG ===== */
    .action {
        margin-bottom: 20px !important;
    }

    /* ===== PHẦN BẢNG DANH SÁCH ===== */
    .table-wrapper {
        width: 100% !important;
        overflow-x: auto; /* Tạo thanh cuộn ngang mượt mà nếu màn hình bị thu nhỏ */
    }

    .table1 {
        border-collapse: collapse !important;
        width: 100% !important; /* Ép bảng dãn đều, vừa khít với hai cạnh của thẻ Card */
        margin: 0 !important;
    }

    .table1 th {
        background: #000 !important;
        color: #fff !important;
        text-align: center;
        padding: 14px 10px !important;
        font-size: 0.95rem;
    }

    .table1 td {
        text-align: center;
        vertical-align: middle;
        padding: 12px 10px !important;
    }

    /* Hover hàng trong bảng */
    .table-hover tbody tr:hover {
        background: #f2f2f2 !important;
    }

    /* ===== TIÊU ĐỀ TRANG ===== */
    h3.page-title {
        font-weight: 600;
        margin-bottom: 25px;
        font-size: 1.75rem;
    }

    /* ===== BUTTON THAO TÁC ===== */
    .table td button, 
    .table td a {
        margin: 2px !important;
    }

    .modal-title {
        font-weight: 600;
    }

    /* Scoped room form modals: keep existing ids/names/JS untouched */
    #add-room .modal-dialog,
    #edit-room .modal-dialog {
        width: min(960px, calc(100vw - 32px));
        max-width: 960px !important;
        margin: 32px auto !important;
    }

    #add-room .modal-content,
    #edit-room .modal-content {
        border: 0 !important;
        border-radius: 12px !important;
        overflow: hidden;
        box-shadow: 0 18px 60px rgba(0, 0, 0, 0.22) !important;
    }

    #add-room .modal-header,
    #edit-room .modal-header {
        padding: 18px 24px;
        border-bottom: 1px solid #edf0f2;
        background: #fff;
    }

    #add-room .modal-title,
    #edit-room .modal-title {
        margin: 0;
        font-size: 1.15rem;
        line-height: 1.3;
        color: #1f2d3d;
    }

    #add-room .modal-body,
    #edit-room .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
        padding: 24px;
        background: #fbfcfd;
    }

    #add-room .modal-body>.row,
    #edit-room .modal-body>.row {
        display: flex;
        flex-wrap: wrap;
        gap: 0;
        margin-left: -10px;
        margin-right: -10px;
    }

    #add-room .modal-body>.row>[class*="col-"],
    #edit-room .modal-body>.row>[class*="col-"] {
        flex-grow: 0;
        padding-left: 10px;
        padding-right: 10px;
    }

    #add-room .modal-body>.row>.col-md-6,
    #edit-room .modal-body>.row>.col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    #add-room .modal-body>.row>.col-12,
    #edit-room .modal-body>.row>.col-12 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    #add-room .form-label,
    #edit-room .form-label {
        margin-bottom: 8px;
        color: #25313d;
        font-size: 0.95rem;
    }

    #add-room .form-control,
    #edit-room .form-control {
        min-height: 44px;
        border: 1px solid #d6dde5;
        border-radius: 8px;
        background: #fff;
    }

    #add-room textarea.form-control,
    #edit-room textarea.form-control {
        min-height: 112px;
        resize: vertical;
    }

    #add-room .col-12 .row,
    #edit-room .col-12 .row {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px 16px;
        margin: 0;
    }

    #add-room .col-12 .row .col-md-3,
    #edit-room .col-12 .row .col-md-3 {
        width: auto;
        max-width: none;
        padding: 0;
    }

    #add-room .col-12 .row label,
    #edit-room .col-12 .row label {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 38px;
        margin: 0;
        padding: 8px 10px;
        border: 1px solid #e1e6ec;
        border-radius: 8px;
        background: #fff;
        color: #27313b;
        font-weight: 600;
        line-height: 1.3;
    }

    #add-room .form-check-input,
    #edit-room .form-check-input {
        flex: 0 0 auto;
        width: 16px;
        height: 16px;
        margin: 0;
    }

    #add-room .modal-footer,
    #edit-room .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 24px;
        border-top: 1px solid #edf0f2;
        background: #fff;
    }

    #add-room .modal-footer .btn,
    #edit-room .modal-footer .btn {
        min-width: 92px;
        border-radius: 8px;
        font-weight: 700;
    }

    /* Scoped image manager modal */
    #room-images .modal-dialog {
        width: min(920px, calc(100vw - 32px));
        max-width: 920px !important;
        margin: 32px auto !important;
    }

    #room-images .modal-content {
        border: 0 !important;
        border-radius: 12px !important;
        overflow: hidden;
        box-shadow: 0 18px 60px rgba(0, 0, 0, 0.22) !important;
    }

    #room-images .modal-body {
        max-height: calc(100vh - 150px);
        overflow-y: auto;
        padding: 20px 24px;
        background: #fff;
    }

    #room-images .table-responsive-lg {
        height: auto !important;
        max-height: 430px;
        overflow: auto;
        border: 1px solid #e2e6ea;
        border-radius: 10px;
    }

    #room-images table {
        width: 100%;
        table-layout: fixed;
        margin: 0;
    }

    #room-images th:nth-child(1),
    #room-images td:nth-child(1) {
        width: 56%;
    }

    #room-images th:nth-child(2),
    #room-images td:nth-child(2) {
        width: 18%;
    }

    #room-images th:nth-child(3),
    #room-images td:nth-child(3) {
        width: 26%;
    }

    #room-images td {
        vertical-align: middle;
        padding: 14px !important;
    }

    #room-images .room-image-thumb {
        display: block;
        width: 100%;
        max-width: 320px;
        height: 180px;
        margin: 0 auto;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dfe5eb;
        background: #f6f7f9;
    }

    #room-images .room-image-actions {
        text-align: center;
        white-space: normal;
    }

    #room-images .room-image-actions .btn,
    #room-images .room-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 86px;
        margin: 3px;
        padding: 8px 10px;
        border-radius: 8px;
        font-weight: 700;
        line-height: 1.2;
    }

    #room-images .room-image-actions .btn-danger i {
        display: none;
    }

    #room-images .room-image-actions .btn-danger::after {
        content: "Xóa ảnh";
    }

    #room-images .room-thumb-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 86px;
        padding: 8px 10px;
        border-radius: 8px;
        background: #198754;
        color: #fff;
        font-weight: 700;
    }

    @media (max-width: 991px) {
        #main-content.container {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 20px !important;
        }
    }

    @media (max-width: 767px) {
        #add-room .modal-dialog,
        #edit-room .modal-dialog {
            width: calc(100vw - 20px);
            margin: 20px auto !important;
        }

        #add-room .modal-body,
        #edit-room .modal-body {
            max-height: calc(100vh - 170px);
            padding: 18px;
        }

        #add-room .modal-body>.row>.col-md-6,
        #edit-room .modal-body>.row>.col-md-6 {
            flex-basis: 100%;
            max-width: 100%;
        }

        #add-room .col-12 .row,
        #edit-room .col-12 .row {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        #room-images .modal-dialog {
            width: calc(100vw - 20px);
            margin: 20px auto !important;
        }

        #room-images .modal-body {
            max-height: calc(100vh - 130px);
            padding: 16px;
        }

        #room-images table {
            min-width: 680px;
        }

        #room-images .room-image-thumb {
            max-width: 260px;
            height: 150px;
        }
    }
    </style>
</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="container" id="main-content">
        <div class="row">
            <div class="content">
                <h3 class="page-title">Danh sách phòng</h3>

                <div class="card">
                    <div class="card-body">

                        <div class="action">
                            <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#add-room">
                                ➕ Thêm
                            </button>
                        </div>

                        <div class="table-wrapper">
                            <table class="table1">
                                <thead>
                                    <tr class="table-header">
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
                                <tbody id="room-data">
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Phòng</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tên phòng</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Diện tích</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số lượng</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Người lớn (Tối đa.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Trẻ em (Tối đa.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Không gian</label>
                                <div class="row">
                                    <?php 
                    $res = selectAll('features');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Tiện ích</label>
                                <div class="row">
                                    <?php 
                    $res = selectAll('facilities');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Mô tả</label>
                                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Tiếp tục</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật danh sách phòng</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tên phòng</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Diện tích</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá phòng</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số lượng</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Người lớn (Tối đa.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Trẻ em (Tối đa.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Không gian</label>
                                <div class="row">
                                    <?php 
                    $res = selectAll('features');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Facilities</label>
                                <div class="row">
                                    <?php 
                    $res = selectAll('facilities');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                            <input type="hidden" name="room_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none"
                            data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Room Name</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image-alert"></div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add_image_form">
                            <label class="form-label fw-bold">Add Image</label>
                            <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg"
                                class="form-control shadow-none mb-3" required>
                            <button class="btn custom-bg text-white shadow-none">ADD</button>
                            <input type="hidden" name="room_id">
                        </form>
                    </div>
                    <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col" width="60%">Image</th>
                                    <th scope="col">Thumb</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="room-image-data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>

    <script src="scripts/rooms.js?v=<?php echo filemtime(__DIR__ . '/scripts/rooms.js'); ?>"></script>

</body>

</html>