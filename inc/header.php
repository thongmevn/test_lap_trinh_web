<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f8f9fa;
}

#nav-bar {
  background-color: #ffffff;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1300px;
  margin: 0 auto;
  padding: 15px 20px;
}

.nav-brand {
  font-size: 26px;
  font-weight: 700;
  color: #212529;
  text-decoration: none;
  letter-spacing: 0.5px;
}

.nav-menu {
  display: flex;
  list-style-type: none;
  margin: 0;
  padding: 0;
  gap: 25px;
}

.nav-menu li a {
  text-decoration: none;
  color: #555555;
  font-size: 16px;
  font-weight: 500;
  transition: color 0.3s ease;
}

.nav-menu li a:hover {
  color: #27724b; 
}

.nav-right {
  display: flex;
  align-items: center;
  gap: 15px;
}

.btn-custom {
  padding: 8px 20px;
  border-radius: 6px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 1px solid transparent;
  background: transparent;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-outline {
  color: #212529;
  border-color: #212529;
}

.btn-outline:hover {
  background-color: #212529;
  color: #ffffff;
}

.btn-primary-custom {
  background-color: #27724b; 
  color: #ffffff;
}

.btn-primary-custom:hover {
  background-color: #1e5a3a;
}

.btn-text {
  background: none;
  border: none;
  color: #6c757d;
  font-size: 14px;
  cursor: pointer;
  padding: 0;
}

.btn-text:hover {
  color: #212529;
  text-decoration: underline;
}

.user-dropdown {
  position: relative;
}

.user-dropdown-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: none;
  border: 1px solid #ddd;
  border-radius: 6px;
  cursor: pointer;
  font-size: 15px;
  font-weight: 600;
  color: #212529;
  padding: 6px 12px;
  outline: none;
  transition: 0.3s;
}

.user-dropdown-btn:hover {
  background-color: #f8f9fa;
}

.user-dropdown-btn img {
  object-fit: cover;
}

.user-dropdown-menu {
  display: none;
  position: absolute;
  top: 100%;
  right: 0;
  margin-top: 10px;
  background-color: #ffffff;
  min-width: 200px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
  z-index: 1001;
  border: 1px solid #eee;
}

.user-dropdown-menu.show {
  display: block; 
}

.user-dropdown-menu a {
  display: block;
  width: 100%;
  padding: 12px 20px;
  text-decoration: none;
  color: #212529;
  font-size: 14px;
  border-bottom: 1px solid #f8f9fa;
  transition: background-color 0.2s;
}

.user-dropdown-menu a:last-child {
  border-bottom: none;
}

.user-dropdown-menu a:hover {
  background-color: #f1f1f1;
  color: #27724b;
}

.custom-modal {
  display: none; 
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6); 
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.custom-modal.show {
  display: flex;
}

.custom-modal-content {
  background-color: #ffffff;
  padding: 30px;
  border-radius: 12px;
  width: 100%;
  max-width: 450px; 
  position: relative;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  animation: modalFadeIn 0.3s ease;
  max-height: 90vh;
  overflow-y: auto;
}

.custom-modal-content.modal-lg {
  max-width: 700px; 
}

.modal-header-custom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 25px;
  border-bottom: 1px solid #eee;
  padding-bottom: 15px;
}

.modal-header-custom h3 {
  margin: 0;
  font-size: 22px;
  display: flex;
  align-items: center;
  gap: 10px;
  color: #212529;
}

.close-modal {
  font-size: 28px;
  font-weight: bold;
  color: #888;
  cursor: pointer;
  transition: 0.3s;
  line-height: 1;
}

.close-modal:hover {
  color: #dc3545; 
}

.form-group {
  margin-bottom: 18px;
}

.form-label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #333;
  font-size: 15px;
}

.custom-input {
  width: 100%; 
  padding: 10px 15px; 
  border: 1px solid #ccc; 
  border-radius: 6px;
  font-size: 15px;
  outline: none;
  transition: 0.3s;
  font-family: inherit;
}

.custom-input:focus {
  border-color: #27724b;
  box-shadow: 0 0 0 3px rgba(39, 114, 75, 0.1);
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0 20px;
}

.full-width {
  grid-column: span 2;
}

.badge-note {
  background-color: #f8f9fa;
  color: #212529;
  padding: 10px;
  border-radius: 6px;
  font-size: 13px;
  display: block;
  margin-bottom: 20px;
  border: 1px solid #eee;
  line-height: 1.5;
}

@keyframes modalFadeIn {
  from {transform: translateY(-20px); opacity: 0;}
  to {transform: translateY(0); opacity: 1;}
}

@media screen and (max-width: 768px) {
  .nav-menu { display: none; } 
  .form-grid { grid-template-columns: 1fr; }
  .full-width { grid-column: span 1; }
}
</style>

<nav id="nav-bar">
  <div class="nav-container">
    <a class="nav-brand" href="index.php">
      <?php echo $settings_r['site_title'] ?>
    </a>

    <ul class="nav-menu">
      <li><a href="index.php">Trang chủ</a></li>
      <li><a href="rooms.php">Danh sách phòng</a></li>
      <li><a href="facilities.php">Tiện ích</a></li>
      <li><a href="contact.php">Liên hệ</a></li>
      <li><a href="about.php">Về chúng tôi</a></li>
    </ul>

    <div class="nav-right">
      <?php 
      if(isset($_SESSION['login']) && $_SESSION['login']==true)
      {
        $path = USERS_IMG_PATH;
        echo<<<data
        <div class="user-dropdown">
          <button class="user-dropdown-btn" onclick="toggleUserDropdown()">
            <img src="$path$_SESSION[uPic]" style="width:28px;height:28px;border-radius:50%;">
            $_SESSION[uName]
          </button>
          <div class="user-dropdown-menu" id="userMenu">
            <a href="profile.php">Hồ sơ cá nhân</a>
            <a href="bookings.php">Lịch sử đặt phòng</a>
            <a href="logout.php">Đăng xuất</a>
          </div>
        </div>
        data;
      }
      else
      {
        echo<<<data
        <button class="btn-custom btn-outline" onclick="openModal('loginModal')">Đăng nhập</button>
        <button class="btn-custom btn-primary-custom" onclick="openModal('registerModal')">Đăng ký</button>
        data;
      }
      ?>
    </div>
  </div>
</nav>

<div id="loginModal" class="custom-modal">
  <div class="custom-modal-content">
    <div class="modal-header-custom">
      <h3><i class="bi bi-person-circle"></i> Đăng nhập</h3>
      <span class="close-modal" onclick="closeModal('loginModal')">&times;</span>
    </div>
    
    <form id="login-form">
      <div class="form-group">
        <label class="form-label">Email / Số điện thoại</label>
        <input type="text" name="email_mob" class="custom-input" required oninput="hideLoginError()">
      </div>
      <div class="form-group">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="pass" class="custom-input" required oninput="hideLoginError()">
        <div id="login-error" style="color: #dc3545; font-size: 13px; display: none; margin-top: 8px; font-weight: 500;"></div>
      </div>
      <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 25px;">
        <button type="submit" class="btn-custom btn-primary-custom">Tiếp tục</button>
        <button type="button" class="btn-text" onclick="closeModal('loginModal'); openModal('forgotModal');">Bạn quên mật khẩu?</button>
      </div>
    </form>
  </div>
</div>

<div id="registerModal" class="custom-modal">
  <div class="custom-modal-content modal-lg">
    <div class="modal-header-custom">
      <h3><i class="bi bi-person-lines-fill"></i> Đăng ký</h3>
      <span class="close-modal" onclick="closeModal('registerModal')">&times;</span>
    </div>
    
    <form id="register-form">
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Tên</label>
          <input name="name" type="text" class="custom-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input name="email" type="email" class="custom-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Số điện thoại</label>
          <input name="phonenum" type="number" class="custom-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Ảnh đại diện</label>
          <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp" class="custom-input" style="padding: 7px 15px;">
        </div>
        <div class="form-group full-width">
          <label class="form-label">Địa chỉ</label>
          <textarea name="address" class="custom-input" rows="2" required></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Mã định danh</label>
          <input name="pincode" type="number" class="custom-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Sinh nhật</label>
          <input name="dob" type="date" class="custom-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Mật khẩu</label>
          <input name="pass" type="password" class="custom-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Xác nhận mật khẩu</label>
          <input name="cpass" type="password" class="custom-input" required>
        </div>
      </div>
      <div style="text-align: center; margin-top: 15px;">
        <button type="submit" class="btn-custom btn-primary-custom" style="width: 200px;">Đăng ký</button>
      </div>
      <div id="register-error" style="color: #dc3545; font-size: 13px; display: none; margin-top: 12px; font-weight: 500; text-align: center;"></div>
    </form>
  </div>
</div>

<div id="forgotModal" class="custom-modal">
  <div class="custom-modal-content">
    <div class="modal-header-custom">
      <h3><i class="bi bi-person-circle"></i> Quên mật khẩu</h3>
      <span class="close-modal" onclick="closeModal('forgotModal')">&times;</span>
    </div>
    
    <form id="forgot-form">
      <span class="badge-note">
        Ghi chú: Liên kết sẽ được gửi tới địa chỉ email của bạn để tạo lại mật khẩu!
      </span>
      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="custom-input" required>
      </div>
      <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
        <button type="button" class="btn-custom btn-outline" onclick="closeModal('forgotModal'); openModal('loginModal');">Huỷ</button>
        <button type="submit" class="btn-custom btn-primary-custom">Gửi</button>
      </div>
    </form>
  </div>
</div>

<script>
function toggleUserDropdown() {
  document.getElementById("userMenu").classList.toggle("show");
}

function openModal(modalId) {
  document.getElementById(modalId).classList.add('show');
}

function closeModal(modalId) {
  document.getElementById(modalId).classList.remove('show');
}

window.onclick = function(event) {
  if (!event.target.closest('.user-dropdown-btn')) {
    var dropdowns = document.getElementsByClassName("user-dropdown-menu");
    for (var i = 0; i < dropdowns.length; i++) {
      if (dropdowns[i].classList.contains('show')) {
        dropdowns[i].classList.remove('show');
      }
    }
  }
  if (event.target.classList.contains('custom-modal')) {
    event.target.classList.remove('show');
  }
}

function hideLoginError() {
  document.getElementById('login-error').style.display = 'none';
}

let login_form = document.getElementById('login-form');

login_form.addEventListener('submit', function(e) {
  e.preventDefault(); 

  let data = new FormData();
  data.append('email_mob', login_form.elements['email_mob'].value);
  data.append('pass', login_form.elements['pass'].value);
  data.append('login', ''); 

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/login_register.php", true); 

  xhr.onload = function() {
    let errorSpan = document.getElementById('login-error');
    let res = this.responseText.trim();
    
    if (res == 'invalid_email_mob') {
      errorSpan.innerHTML = "Tài khoản hoặc số điện thoại không tồn tại!";
      errorSpan.style.display = 'block';
    } 
    else if (res == 'invalid_password') {
      errorSpan.innerHTML = "Bạn sai mật khẩu!";
      errorSpan.style.display = 'block';
    } 
    else if (res == 'inactive') {
      errorSpan.innerHTML = "Tài khoản của bạn đã bị khóa!";
      errorSpan.style.display = 'block';
    }
    else if (res == 'not_verified') {
      errorSpan.innerHTML = "Tài khoản chưa được xác thực email!";
      errorSpan.style.display = 'block';
    }
    else {
      window.location.reload();
    }
  }
  xhr.send(data);
});

let register_form = document.getElementById('register-form');

register_form.addEventListener('submit', function(e) {
  e.preventDefault();

  let errorSpan = document.getElementById('register-error');
  errorSpan.style.display = 'none';

  let data = new FormData(register_form);
  data.append('register', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/login_register.php", true);

  xhr.onload = function() {
    let res = this.responseText.trim();

    if (res == 'email_already') {
      errorSpan.innerHTML = "Email này đã được sử dụng!";
      errorSpan.style.display = 'block';
    }
    else if (res == 'phone_already') {
      errorSpan.innerHTML = "Số điện thoại này đã được sử dụng!";
      errorSpan.style.display = 'block';
    }
    else if (res == 'pass_mismatch') {
      errorSpan.innerHTML = "Mật khẩu xác nhận không khớp!";
      errorSpan.style.display = 'block';
    }
    else if (res == 'inv_img') {
      errorSpan.innerHTML = "Ảnh không hợp lệ (chỉ jpg, png, webp)!";
      errorSpan.style.display = 'block';
    }
    else if (res == 'registration_success') {
      window.location.reload();
    }
    else {
      errorSpan.innerHTML = "Đăng ký thất bại, vui lòng thử lại!";
      errorSpan.style.display = 'block';
    }
  };
  xhr.send(data);
});
</script>