<?php

  // Frontend purpose data - Đường dẫn dùng để hiển thị ảnh trên trình duyệt
  define('SITE_URL', 'http://localhost/Quanly_khachsan/');
  define('ABOUT_IMG_PATH', SITE_URL . 'images/about/');
  define('CAROUSEL_IMG_PATH', SITE_URL . 'images/carousel/');
  define('FACILITIES_IMG_PATH', SITE_URL . 'images/facilities/');
  define('ROOMS_IMG_PATH', SITE_URL . 'images/rooms/');
  define('USERS_IMG_PATH', SITE_URL . 'images/users/');

// Backend upload process needs this data - Đường dẫn vật lý để lưu file vào ổ cứng
  define('UPLOAD_IMAGE_PATH', __DIR__ . '/../../images/');
  define('ABOUT_FOLDER', 'about/');
  define('CAROUSEL_FOLDER', 'carousel/');
  define('FACILITIES_FOLDER', 'facilities/');
  define('ROOMS_FOLDER', 'rooms/');
  define('USERS_FOLDER', 'users/');

  function adminLogin() {
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
      echo "<script>window.location.href='index.php'</script>";
      exit;
    }
  }

  function redirect($url) {
    echo "<script>window.location.href='$url'</script>";
    exit;
  }


  function alert($type, $msg) {
    $css_class = ($type == 'success') ? 'alert-success' : 'alert-danger';
    echo <<<alert
      <div class="custom-alert $css_class shadow" role="alert">
        <span class="me-3">$msg</span>
        <button type="button" class="btn-close btn-close-white shadow-none" onclick="this.parentElement.remove()"></button>
      </div>
    alert;
  }

  function uploadImage($image, $folder) {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
      return 'inv_img';
    } else if (($image['size'] / (1024 * 1024)) > 2) {
      return 'inv_size';
    } else {
      $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
      $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
      $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
      
      if (move_uploaded_file($image['tmp_name'], $img_path)) {
        return $rname;
      } else {
        return 'upd_failed';
      }
    }
  }

  function deleteImage($image, $folder) {
    $img_path = UPLOAD_IMAGE_PATH . $folder . $image;

    if (!file_exists($img_path)) {
      return true;
    }

    if (unlink($img_path)) {
      return true;
    } else {
      return false;
    }
  }

  function imagePathWithVersion($base_path, $folder, $image) {
    $img_path = UPLOAD_IMAGE_PATH . $folder . $image;
    $version = file_exists($img_path) ? filemtime($img_path) : time();

    return $base_path . $image . '?v=' . $version;
  }

  function roomImagePath($image) {
    return imagePathWithVersion(ROOMS_IMG_PATH, ROOMS_FOLDER, $image);
  }

  function uploadSVGImage($image, $folder) {
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
      return 'inv_img';
    } else if (($image['size'] / (1024 * 1024)) > 1) {
      return 'inv_size';
    } else {
      $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
      $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
      $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
      if (move_uploaded_file($image['tmp_name'], $img_path)) {
        return $rname;
      } else {
        return 'upd_failed';
      }
    }
  }

  function uploadUserImage($image) {
      $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
      $img_mime = $image['type'];

      // 1. Kiểm tra định dạng ảnh
      if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
      } 
      // 2. Kiểm tra dung lượng ảnh (Giới hạn 2MB)
      else if (($image['size'] / (1024 * 1024)) > 2) {
        return 'inv_size';
      } 
      // 3. Xử lý lưu file cơ bản (Không dùng thư viện GD để tránh lỗi XAMPP)
      else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
        $img_path = UPLOAD_IMAGE_PATH . USERS_FOLDER . $rname;

        if (move_uploaded_file($image['tmp_name'], $img_path)) {
          return $rname;
        } else {
          return 'upd_failed';
        }
      }
  }
?>

<style>
.custom-alert {
    position: fixed;
    top: 80px;
    right: 25px;
    padding: 15px 20px;
    border-radius: 8px;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 1100;
    min-width: 250px;
    animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.alert-success {
    background-color: #198754;
}

.alert-danger {
    background-color: #dc3545;
}
</style>