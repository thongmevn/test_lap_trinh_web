<?php

  // Frontend purpose data
  define('SITE_URL', 'http://localhost/QuanLy_KhachSan/');
  define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
  define('CAROUSEL_IMG_PATH',SITE_URL.'images/carousel/');
  define('FACILITIES_IMG_PATH',SITE_URL.'images/facilities/');
  define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');
  define('USERS_IMG_PATH',SITE_URL.'images/users/');

  // Backend upload process needs this data
  define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/QuanLy_KhachSan/images/');
  define('ABOUT_FOLDER','about/');
  define('CAROUSEL_FOLDER','carousel/');
  define('FACILITIES_FOLDER','facilities/');
  define('ROOMS_FOLDER','rooms/');
  define('USERS_FOLDER','users/');

  function adminLogin() {
    session_start();
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
      echo"<script>window.location.href='index.php'</script>";
      exit;
    }
  }

  function redirect($url) {
    echo "<script>window.location.href='$url'</script>";
    exit;
  }

  function filteration($data) {
    foreach($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $data[$key] = $value;
    }
    return $data;
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

  function uploadImage($image, $folder)
  {
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

  function deleteImage($image, $folder)
  {
    if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
      return true;
    }
    else{
      return false;
    }
  }

  function uploadSVGImage($image,$folder)
  {
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if(!in_array($img_mime,$valid_mime)){
      return 'inv_img';
    }
    else if(($image['size']/(1024*1024))>1){
      return 'inv_size';
    }
    else{
      $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
      $rname = 'IMG_'.random_int(11111,99999).".$ext";
      $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
      if(move_uploaded_file($image['tmp_name'],$img_path)){
        return $rname;
      }
      else{
        return 'upd_failed';
      }
    }
  }

  function uploadUserImage($image)
  {
    $valid_mime = ['image/jpeg','image/png','image/webp'];
    $img_mime = $image['type'];

    if(!in_array($img_mime,$valid_mime)){
      return 'inv_img';
    }
    else
    {
      $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
      $rname = 'IMG_'.random_int(11111,99999).".jpeg";
      $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

      if($ext == 'png' || $ext == 'PNG') {
        $img = imagecreatefrompng($image['tmp_name']);
      }
      else if($ext == 'webp' || $ext == 'WEBP') {
        $img = imagecreatefromwebp($image['tmp_name']);
      }
      else{
        $img = imagecreatefromjpeg($image['tmp_name']);
      }

      if(imagejpeg($img,$img_path,75)){
        return $rname;
      }
      else{
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