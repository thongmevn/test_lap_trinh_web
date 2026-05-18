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
  <title>Trang quản lý - Cài đặt trang</title>
  <?php require('inc/links.php'); ?>
  <style>
    #main-content {
      min-height: 100vh;
      padding: 24px;
      background: #f4f6f8;
    }

    #main-content > .row {
      display: block;
      margin: 0;
    }

    #main-content .col-lg-10 {
      width: 100%;
      max-width: none;
      margin: 0 auto;
      padding: 0;
      overflow: visible;
    }

    #main-content h3 {
      margin: 0 0 22px;
      font-size: 1.65rem;
      line-height: 1.25;
      color: #152536;
    }

    #main-content .card {
      margin-bottom: 20px;
      background: #fff;
      border: 1px solid #e5eaf0 !important;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(21, 37, 54, 0.08) !important;
    }

    #main-content .card-body {
      padding: 22px 24px;
    }

    #main-content .d-flex {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }

    #main-content .card-title {
      margin: 0;
      color: #172432;
      font-size: 1.08rem;
      line-height: 1.3;
    }

    #main-content .card-subtitle {
      margin: 0 0 6px;
      color: #1e2d3b;
      font-size: 0.92rem;
      font-weight: 700;
    }

    #main-content .card-text {
      margin: 0 0 16px;
      color: #4b5b68;
      line-height: 1.55;
      overflow-wrap: anywhere;
    }

    #main-content .card .row {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 18px 28px;
      margin: 0;
    }

    #main-content .card [class*="col-"] {
      width: auto;
      max-width: none;
      padding: 0;
    }

    #main-content iframe#iframe {
      display: block;
      width: 100%;
      min-height: 220px;
      border: 1px solid #dce3ea;
      border-radius: 10px;
      background: #f8fafc;
    }

    #main-content .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      min-height: 36px;
      padding: 8px 13px;
      border: 1px solid transparent;
      border-radius: 8px;
      font-size: 0.92rem;
      font-weight: 700;
      line-height: 1.2;
      cursor: pointer;
      text-decoration: none;
    }

    #main-content .btn-dark {
      color: #fff;
      background: #152536;
      border-color: #152536;
    }

    #main-content .btn-dark:hover {
      background: #24384d;
      border-color: #24384d;
    }

    #main-content .custom-bg,
    #general-s .custom-bg,
    #contacts-s .custom-bg,
    #team-s .custom-bg {
      color: #fff;
      background: #2d6a4f;
      border-color: #2d6a4f;
    }

    #main-content .form-check {
      margin: 0;
    }

    #main-content .form-switch {
      min-width: 54px;
    }

    #shutdown-toggle {
      position: relative;
      width: 48px;
      height: 26px;
      margin: 0;
      appearance: none;
      border: 0;
      border-radius: 999px;
      background: #c7d0d9;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    #shutdown-toggle::before {
      content: "";
      position: absolute;
      top: 3px;
      left: 3px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #fff;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
      transition: transform 0.2s ease;
    }

    #shutdown-toggle:checked {
      background: #2d6a4f;
    }

    #shutdown-toggle:checked::before {
      transform: translateX(22px);
    }

    #team-data {
      grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
      gap: 20px;
    }

    #team-data img {
      width: 100%;
      height: 260px;
      object-fit: contain;
      object-position: center;
      display: block;
      background: #f8fafc;
      border-radius: 10px;
    }

    #team-data .card {
      height: 100%;
      overflow: hidden;
    }

    #general-s .modal-dialog,
    #team-s .modal-dialog {
      width: min(560px, calc(100vw - 32px));
      max-width: 560px;
      margin: 40px auto;
    }

    #contacts-s .modal-dialog {
      width: min(900px, calc(100vw - 32px));
      max-width: 900px;
      margin: 32px auto;
    }

    #general-s .modal-content,
    #contacts-s .modal-content,
    #team-s .modal-content {
      overflow: hidden;
      border: 0;
      border-radius: 12px;
      background: #fff;
      box-shadow: 0 20px 70px rgba(0, 0, 0, 0.24);
    }

    #general-s .modal-header,
    #contacts-s .modal-header,
    #team-s .modal-header {
      padding: 18px 22px;
      border-bottom: 1px solid #e8edf2;
      background: #fff;
    }

    #general-s .modal-title,
    #contacts-s .modal-title,
    #team-s .modal-title {
      margin: 0;
      color: #172432;
      font-size: 1.08rem;
      line-height: 1.3;
    }

    #general-s .modal-body,
    #contacts-s .modal-body,
    #team-s .modal-body {
      max-height: calc(100vh - 210px);
      overflow-y: auto;
      padding: 22px;
      background: #fbfcfd;
    }

    #general-s .mb-3,
    #contacts-s .mb-3,
    #team-s .mb-3 {
      margin-bottom: 16px;
    }

    #contacts-s .container-fluid,
    #contacts-s .row {
      width: 100%;
      margin: 0;
      padding: 0;
    }

    #contacts-s .row {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 20px;
    }

    #contacts-s [class*="col-"] {
      width: auto;
      max-width: none;
      padding: 0;
    }

    #general-s .form-label,
    #contacts-s .form-label,
    #team-s .form-label {
      display: block;
      margin-bottom: 8px;
      color: #243442;
      font-size: 0.93rem;
      font-weight: 700;
    }

    #general-s .form-control,
    #contacts-s .form-control,
    #team-s .form-control {
      display: block;
      width: 100%;
      min-height: 44px;
      padding: 10px 12px;
      border: 1px solid #d6dde5;
      border-radius: 8px;
      background: #fff;
      color: #1d2b38;
      font-size: 0.95rem;
      line-height: 1.4;
    }

    #general-s textarea.form-control {
      min-height: 150px;
      resize: vertical;
    }

    #general-s .form-control:focus,
    #contacts-s .form-control:focus,
    #team-s .form-control:focus {
      border-color: #2d6a4f;
      outline: 0;
      box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.14);
    }

    #contacts-s .input-group {
      display: flex;
      align-items: stretch;
      width: 100%;
    }

    #contacts-s .input-group-text {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 46px;
      padding: 0 12px;
      border: 1px solid #d6dde5;
      border-right: 0;
      border-radius: 8px 0 0 8px;
      background: #eef3f6;
      color: #3a4a58;
      font-weight: 700;
    }

    #contacts-s .input-group .form-control {
      border-radius: 0 8px 8px 0;
    }

    #general-s .modal-footer,
    #contacts-s .modal-footer,
    #team-s .modal-footer {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      padding: 16px 22px;
      border-top: 1px solid #e8edf2;
      background: #fff;
    }

    #general-s .modal-footer .btn,
    #contacts-s .modal-footer .btn,
    #team-s .modal-footer .btn {
      min-width: 94px;
      border-radius: 8px;
      font-weight: 700;
    }

    #general-s .text-secondary,
    #contacts-s .text-secondary,
    #team-s .text-secondary {
      color: #617080;
      background: #eef2f5;
      border-color: #eef2f5;
    }

    @media (max-width: 991px) {
      #main-content {
        padding: 18px;
      }

      #main-content .row,
      #contacts-s .row {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 575px) {
      #general-s .modal-dialog,
      #contacts-s .modal-dialog,
      #team-s .modal-dialog {
        width: calc(100vw - 20px);
        margin: 20px auto;
      }

      #general-s .modal-body,
      #contacts-s .modal-body,
      #team-s .modal-body {
        max-height: calc(100vh - 170px);
        padding: 18px;
      }
    }
  </style>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 p-4 overflow-hidden">
        <h3 class="mb-4">Cài đặt trang</h3>

        <!-- General settings section -->

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Thiết lập chung</h5>
              <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                <i class="bi bi-pencil-square"></i> Sửa
              </button>
            </div>
            <h6 class="card-subtitle mb-1 fw-bold">Tiêu đề trang</h6>
            <p class="card-text" id="site_title"></p>
            <h6 class="card-subtitle mb-1 fw-bold">Về chúng tôi</h6>
            <p class="card-text" id="site_about"></p>
          </div>
        </div>

        <!-- General settings modal -->

        <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="general_s_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Thiết lập chung</h5>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Tiêu đề trang</label>
                    <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold">Về chúng tôi</label>
                    <textarea name="site_about" id="site_about_inp" class="form-control shadow-none" rows="6" required></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="site_title.value = general_data.site_title, site_about.value = general_data.site_about" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Huỷ</button>
                  <button type="submit" class="btn custom-bg text-white shadow-none">Cập nhật</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Shutdown section -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Bảo trì hệ thống</h5>
              <div class="form-check form-switch">
                <form>
                  <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggle">
                </form>
              </div>
            </div>
            <p class="card-text">
              Người dùng sẽ không thể đặt phòng khi hệ thống đang trong trạng thái bảo trì.
            </p>
          </div>
        </div>

        <!-- Contact details section -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Thiết lập liên hệ</h5>
              <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contacts-s">
                <i class="bi bi-pencil-square"></i> Sửa
              </button>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1 fw-bold">Địa chỉ</h6>
                  <p class="card-text" id="address"></p>
                </div>
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                  <p class="card-text" id="gmap"></p>
                </div>
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1 fw-bold">Số tổng đài</h6>
                  <p class="card-text mb-1">
                    <i class="bi bi-telephone-fill"></i>
                    <span id="pn1"></span>
                  </p>
                </div>
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1 fw-bold">E-mail</h6>
                  <p class="card-text" id="email"></p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1 fw-bold">Mạng xã hội</h6>
                  <p class="card-text mb-1">
                    <i class="bi bi-facebook me-1"></i>
                    <span id="fb"></span>
                  </p>
                  <p class="card-text mb-1">
                    <i class="bi bi-instagram me-1"></i>
                    <span id="insta"></span>
                  </p>
                  <p class="card-text">
                    <i class="bi bi-twitter me-1"></i>
                    <span id="tw"></span>
                  </p>
                </div>
                <div class="mb-4">
                  <h6 class="card-subtitle mb-1 fw-bold">iFrame</h6>
                  <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Contacts details modal -->

        <div class="modal fade" id="contacts-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <form id="contacts_s_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Thiết lập liên hệ</h5>
                </div>
                <div class="modal-body">
                  <div class="container-fluid p-0">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label fw-bold">Địa chỉ</label>
                          <input type="text" name="address" id="address_inp" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-bold">Google Map Link</label>
                          <input type="text" name="gmap" id="gmap_inp" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-bold">Số tổng đài (kèm mã vùng quốc gia)</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="number" name="pn1" id="pn1_inp" class="form-control shadow-none" required>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-bold">Email</label>
                          <input type="email" name="email" id="email_inp" class="form-control shadow-none" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label fw-bold">Mạng xã hội</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                            <input type="text" name="fb" id="fb_inp" class="form-control shadow-none" required>
                          </div>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                            <input type="text" name="insta" id="insta_inp" class="form-control shadow-none" required>
                          </div>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-twitter"></i></span>
                            <input type="text" name="tw" id="tw_inp" class="form-control shadow-none">
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label fw-bold">iFrame Src</label>
                          <input type="text" name="iframe" id="iframe_inp" class="form-control shadow-none" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="contacts_inp(contacts_data)" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Huỷ</button>
                  <button type="submit" class="btn custom-bg text-white shadow-none">Cập nhật</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Management Team section -->

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Đội ngũ quản lý</h5>
              <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-s">
                <i class="bi bi-plus-square"></i> Thêm
              </button>
            </div>

            <div class="row" id="team-data">
            </div>

          </div>
        </div>

        <!-- Management Team modal -->

        <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="team_s_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Thên thành viên</h5>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Tên</label>
                    <input type="text" name="member_name" id="member_name_inp" class="form-control shadow-none" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold">Hình ảnh</label>
                    <input type="file" name="member_picture" id="member_picture_inp" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="member_name.value='', member_picture.value=''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Huỷ</button>
                  <button type="submit" class="btn custom-bg text-white shadow-none">Cập nhật</button>
                </div>
              </div>
            </form>
          </div>
        </div>


      </div>
    </div>
  </div>
  

  <?php require('inc/scripts.php'); ?>
  <script src="scripts/settings.js?v=20260515-2"></script>

</body>
</html>
