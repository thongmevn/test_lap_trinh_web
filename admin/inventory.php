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
  <title>Trang quản lý - Đồ dùng & bồi thường</title>
  <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">
  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 p-4 overflow-hidden">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h3 class="m-0">Đồ dùng & bồi thường</h3>
        </div>

        <div class="row">
          <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
              <div class="card-body">
                <h5 class="mb-3">Danh mục đồ dùng</h5>
                <form id="item-form">
                  <input type="hidden" name="item_id">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Tên đồ dùng</label>
                    <input type="text" name="name" class="form-control shadow-none" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold">Nhóm/loại</label>
                    <input type="text" name="category" class="form-control shadow-none" placeholder="VD: Phòng tắm, phòng ngủ">
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold">Phí bồi thường mặc định</label>
                    <input type="number" min="0" name="default_charge" class="form-control shadow-none" required>
                  </div>
                  <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-dark" onclick="reset_item_form()">Làm mới</button>
                    <button type="submit" class="btn custom-bg text-white">Lưu đồ dùng</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
              <div class="card-body">
                <h5 class="mb-3">Danh sách đồ dùng</h5>
                <div class="table-responsive">
                  <table class="table table-hover text-center">
                    <thead>
                      <tr class="bg-dark text-light">
                        <th>#</th>
                        <th>Tên</th>
                        <th>Nhóm</th>
                        <th>Phí mặc định</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                      </tr>
                    </thead>
                    <tbody id="items-data"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <h5 class="mb-3">Ghi nhận mất/hư hại theo booking</h5>
            <form id="charge-form">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-bold">Tìm booking</label>
                  <input type="text" id="booking-search" class="form-control shadow-none" placeholder="Order, tên, SĐT, số phòng">
                </div>
                <div class="col-md-8 mb-3">
                  <label class="form-label fw-bold">Booking đã nhận phòng</label>
                  <select name="booking_id" id="booking-select" class="form-select shadow-none" required></select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-bold">Đồ dùng</label>
                  <select name="item_id" id="item-select" class="form-select shadow-none" required></select>
                </div>
                <div class="col-md-2 mb-3">
                  <label class="form-label fw-bold">Tình trạng</label>
                  <select name="damage_type" class="form-select shadow-none">
                    <option value="damaged">Hư hại</option>
                    <option value="lost">Mất</option>
                  </select>
                </div>
                <div class="col-md-2 mb-3">
                  <label class="form-label fw-bold">Số lượng</label>
                  <input type="number" min="1" name="quantity" value="1" class="form-control shadow-none" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-bold">Đơn giá bồi thường</label>
                  <input type="number" min="0" name="unit_charge" class="form-control shadow-none" required>
                </div>
                <div class="col-12 mb-3">
                  <label class="form-label fw-bold">Ghi chú</label>
                  <textarea name="note" rows="2" class="form-control shadow-none" placeholder="Mô tả tình trạng, vị trí, biên bản..."></textarea>
                </div>
              </div>
              <div class="text-end">
                <button type="submit" class="btn custom-bg text-white">Thêm bồi thường</button>
              </div>
            </form>
          </div>
        </div>

        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="m-0">Các khoản bồi thường</h5>
              <input type="text" id="charge-search" class="form-control shadow-none" style="max-width: 320px;" placeholder="Tìm theo order, khách, phòng, đồ dùng">
            </div>
            <div class="table-responsive">
              <table class="table table-hover text-center">
                <thead>
                  <tr class="bg-dark text-light">
                    <th>#</th>
                    <th>Khách</th>
                    <th>Phòng</th>
                    <th>Đồ dùng</th>
                    <th>SL</th>
                    <th>Đơn giá</th>
                    <th>Tổng</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody id="charges-data"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require('inc/scripts.php'); ?>
  <script src="scripts/inventory.js"></script>
</body>

</html>
