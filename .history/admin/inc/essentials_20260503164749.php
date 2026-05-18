<?php

  //frontend purpose data
  define('SITE_URL', 'http://localhost/QuanLy_KhachSan/');
  define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
  define('CAROUSEL_IMG_PATH',SITE_URL.'images/carousel/');
  define('FACILITIES_IMG_PATH',SITE_URL.'images/facilities/');
  define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');
  define('USERS_IMG_PATH',SITE_URL.'images/users/');

  //backend upload process needs this data

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

	function alert($type, $msg) {

		$css_class = ($type == 'success') ? 'alert-success' : 'alert-danger';

		echo <<<alert
			<div class="custom-alert $css_class">
				<span>$msg</span>
				<button onclick="this.parentElement.style.display='none'">&times;</button>
			</div>
		alert;
	}

function uploadImage($image, $folder)
  {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
      return 'inv_img'; // Đã sửa thành mã lỗi chuẩn
    } else if (($image['size'] / (1024 * 1024)) > 2) {
      return 'inv_size'; // Đã sửa thành mã lỗi chuẩn
    } else {
      // Đã sửa: Tự động tạo tên mới (vd: IMG_12345.png) để xóa bỏ khoảng trắng/tiếng Việt
      $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
      $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";

      $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
      
      if (move_uploaded_file($image['tmp_name'], $img_path)) {
        return $rname; // Trả về tên file mới
      } else {
        return 'upd_failed'; // Đã sửa thành mã lỗi chuẩn
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
      return 'inv_img'; // Đã sửa thành mã lỗi chuẩn
    }
    else if(($image['size']/(1024*1024))>1){
      return 'inv_size'; // Đã sửa thành mã lỗi chuẩn
    }
    else{
      $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
      $rname = 'IMG_'.random_int(11111,99999).".$ext";

      $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
      if(move_uploaded_file($image['tmp_name'],$img_path)){
        return $rname;
      }
      else{
        return 'Tải lên hình ảnh thất bại!';
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
/* custom alert thay bootstrap */
.custom-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 16px;
    border-radius: 6px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 9999;
}

.custom-alert button {
    background: none;
    border: none;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
}

.alert-success {
    background: #198754;
}

.alert-danger {
    background: #dc3545;
}
</style>