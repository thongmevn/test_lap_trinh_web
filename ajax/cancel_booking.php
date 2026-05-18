<?php

  require('../admin/inc/db_config.php');
  ob_start();
  require('../admin/inc/essentials.php');
  ob_end_clean();

  session_start();

  if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    echo 0;
    exit;
  }

  if(isset($_POST['cancel_booking']))
  {
    $frm_data = filteration($_POST);
    $booking_id = intval($frm_data['id']);

    $res = select(
      "SELECT * FROM `booking_order`
       WHERE `booking_id`=? AND `user_id`=? AND `booking_status`=?",
      [$booking_id, $_SESSION['uId'], 'booked'],
      'iis'
    );

    if(!$res || mysqli_num_rows($res)==0){
      echo 0;
      exit;
    }

    $data = mysqli_fetch_assoc($res);
    $deposit = floatval($data['deposit'] ?? 0);
    $current_payment_status = $data['payment_status'] ?? 'unpaid';

    if($deposit > 0 || $current_payment_status == 'deposited'){
      $refund = 0;
      $payment_status = 'refund_pending';
    }
    else{
      $refund = 1;
      $payment_status = 'no_refund';
    }

    $query = "UPDATE `booking_order`
      SET `booking_status`=?, `refund`=?, `payment_status`=?
      WHERE `booking_id`=? AND `user_id`=?";

    $values = ['cancelled',$refund,$payment_status,$booking_id,$_SESSION['uId']];
    $result = update($query,$values,'sisii');

    echo $result ? 1 : 0;
    exit;
  }

  echo 0;
?>
