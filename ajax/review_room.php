<?php 
  ob_start();
  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');
  ob_end_clean();

  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
  }

  if(isset($_POST['review_form']))
  {
    $frm_data = filteration($_POST);

    $check_q = select("SELECT `booking_id` FROM `booking_order`
      WHERE `booking_id`=? AND `user_id`=? AND `booking_status`='booked' 
      AND (`rate_review` IS NULL OR `rate_review`=0) LIMIT 1",
      [$frm_data['booking_id'], $_SESSION['uId']], 'ii');

    if(mysqli_num_rows($check_q) == 0){
      echo 0;
      exit;
    }

    $upd_query = "UPDATE `booking_order` SET `rate_review`=1 WHERE `booking_id`=? AND `user_id`=?";
    $upd_values = [$frm_data['booking_id'], $_SESSION['uId']];
    $upd_result = update($upd_query, $upd_values, 'ii');

    $ins_query = "INSERT INTO `rating_review`(`booking_id`, `room_id`, `user_id`, `rating`, `review`)
      VALUES (?,?,?,?,?)";
    $ins_values = [$frm_data['booking_id'], $frm_data['room_id'], $_SESSION['uId'],
      $frm_data['rating'], $frm_data['review']];
    $ins_result = insert($ins_query, $ins_values, 'iiiis');

    if($ins_result) {
        echo 1;
    } else {
        echo 0;
    }
  }
?>