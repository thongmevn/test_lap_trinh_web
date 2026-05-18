<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Hồ sơ cá nhân</title>
    <style>
    .profile-wrap {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 16px 60px;
    }

    .profile-header {
        padding: 40px 0 24px;
    }

    .profile-header h2 {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .profile-header .breadcrumb {
        font-size: 14px;
        color: #666;
    }

    .profile-header .breadcrumb a {
        color: #666;
        text-decoration: none;
    }

    .profile-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
        padding: 24px;
        margin-bottom: 24px;
    }

    .profile-card h5 {
        font-weight: 700;
        margin-bottom: 16px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .form-grid-4-8 {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 14px;
    }

    .profile-bottom-row {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .profile-avatar-card {
        flex: 1 1 280px;
    }

    .profile-pass-card {
        flex: 2 1 420px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 4px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .form-group input,
    .form-group textarea,
    .form-group input[type="file"] {
        padding: 9px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: var(--primary-color);
    }

    .form-group input[type="file"] {
        padding: 6px 10px;
        cursor: pointer;
    }

    .avatar-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
        margin-bottom: 16px;
    }

    .btn-save {
        margin-top: 16px;
        padding: 10px 24px;
        background: var(--primary-color);
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-save:hover {
        background: var(--primary-hover);
    }

    @media (max-width: 768px) {
        .form-grid-3 { grid-template-columns: 1fr 1fr; }
        .form-grid-4-8 { grid-template-columns: 1fr; }
        .form-grid-2 { grid-template-columns: 1fr; }
        .profile-bottom-row { flex-direction: column; }
    }

    @media (max-width: 480px) {
        .form-grid-3 { grid-template-columns: 1fr; }
    }
    </style>
</head>

<body class="bg-light">

    <?php 
    require('inc/header.php'); 
    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
        redirect('index.php');
    }
    $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 's');
    if(mysqli_num_rows($u_exist)==0){
        redirect('index.php');
    }
    $u_fetch = mysqli_fetch_assoc($u_exist);
    ?>

    <div class="profile-wrap">

        <div class="profile-header">
            <h2>Thông tin của tôi</h2>
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a>
                <span> > </span>
                <a href="#">Hồ sơ cá nhân</a>
            </div>
        </div>

        <!-- Thông tin cơ bản -->
        <div class="profile-card">
            <form id="info-form">
                <h5>Thông tin cơ bản</h5>
                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Tên</label>
                        <input name="name" type="text" value="<?php echo $u_fetch['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input name="phonenum" type="number" value="<?php echo $u_fetch['phonenum'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Ngày tháng năm sinh</label>
                        <input name="dob" type="date" value="<?php echo $u_fetch['dob'] ?>" required>
                    </div>
                </div>
                <div class="form-grid-4-8" style="margin-top:14px;">
                    <div class="form-group">
                        <label>Mã định danh</label>
                        <input name="pincode" type="number" value="<?php echo $u_fetch['pincode'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <textarea name="address" rows="1" required><?php echo $u_fetch['address'] ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn-save">Lưu thay đổi</button>
            </form>
        </div>

        <!-- Ảnh đại diện + Đổi mật khẩu -->
        <div class="profile-bottom-row">

            <div class="profile-avatar-card">
                <div class="profile-card" style="margin-bottom:0;">
                    <form id="profile-form">
                        <h5>Ảnh đại diện</h5>
                        <img src="<?php echo USERS_IMG_PATH.$u_fetch['profile'] ?>" class="avatar-img">
                        <div class="form-group">
                            <label>Cập nhật ảnh mới</label>
                            <input name="profile" type="file" accept=".jpg,.jpeg,.png,.webp" required>
                        </div>
                        <button type="submit" class="btn-save">Lưu thay đổi</button>
                    </form>
                </div>
            </div>

            <div class="profile-pass-card">
                <div class="profile-card" style="margin-bottom:0;">
                    <form id="pass-form">
                        <h5>Đổi mật khẩu</h5>
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label>Mật khẩu mới</label>
                                <input name="new_pass" type="password" required>
                            </div>
                            <div class="form-group">
                                <label>Xác nhận mật khẩu mới</label>
                                <input name="confirm_pass" type="password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-save">Lưu thay đổi</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <?php require('inc/footer.php'); ?>

    <script>
    let info_form = document.getElementById('info-form');

    info_form.addEventListener('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append('info_form', '');
        data.append('name',     info_form.elements['name'].value);
        data.append('phonenum', info_form.elements['phonenum'].value);
        data.append('address',  info_form.elements['address'].value);
        data.append('pincode',  info_form.elements['pincode'].value);
        data.append('dob',      info_form.elements['dob'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);

        xhr.onload = function() {
            if (this.responseText == 'phone_already') {
                alert('error', "Số điện thoại này đã được đăng ký!");
            } else if (this.responseText == 0) {
                alert('error', "Không có thay đổi ghi nhận!");
            } else {
                alert('success', 'Cập nhật thành công!');
            }
        }

        xhr.send(data);
    });

    let profile_form = document.getElementById('profile-form');

    profile_form.addEventListener('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append('profile_form', '');
        data.append('profile', profile_form.elements['profile'].files[0]);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);

        xhr.onload = function() {
            if (this.responseText == 'inv_img') {
                alert('error', "Chỉ hỗ trợ định dạng JPG, WEBP & PNG!");
            } else if (this.responseText == 'upd_failed') {
                alert('error', "Tải hình ảnh thất bại!");
            } else if (this.responseText == 0) {
                alert('error', "Cập nhật thất bại!");
            } else {
                window.location.href = window.location.pathname;
            }
        }

        xhr.send(data);
    });

    let pass_form = document.getElementById('pass-form');

    pass_form.addEventListener('submit', function(e) {
        e.preventDefault();

        let new_pass     = pass_form.elements['new_pass'].value;
        let confirm_pass = pass_form.elements['confirm_pass'].value;

        if (new_pass != confirm_pass) {
            alert('error', 'Mật khẩu không trùng khớp!');
            return false;
        }

        let data = new FormData();
        data.append('pass_form',     '');
        data.append('new_pass',      new_pass);
        data.append('confirm_pass',  confirm_pass);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);

        xhr.onload = function() {
            if (this.responseText == 'mismatch') {
                alert('error', "Mật khẩu không trùng khớp!");
            } else if (this.responseText == 0) {
                alert('error', "Cập nhật thất bại!");
            } else {
                alert('success', 'Cập nhật thành công!');
                pass_form.reset();
            }
        }

        xhr.send(data);
    });
    </script>

</body>

</html>
