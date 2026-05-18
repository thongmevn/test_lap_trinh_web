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

  if(isset($_POST['pay_deposit']))
  {
    $frm_data = filteration($_POST);
    $id = intval($frm_data['id']);

    $res = select(
      "SELECT bo.*, bd.total_pay FROM `booking_order` bo
       INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
       WHERE bo.booking_id=? AND bo.user_id=? AND bo.booking_status=?",
      [$id,$_SESSION['uId'],'booked'],
      'iis'
    );

    if(!$res || mysqli_num_rows($res)==0){
      echo 0;
      exit;
    }

    $data = mysqli_fetch_assoc($res);
    $current_payment_status = $data['payment_status'] ?? 'unpaid';
    $current_deposit = floatval($data['deposit'] ?? 0);

    if($current_payment_status == 'deposited'){
      echo 1;
      exit;
    }

    $amount = floatval($data['trans_amt'] ?? 0);
    if($amount <= 0){
      $amount = floatval($data['total_pay'] ?? 0);
    }

    if($amount <= 0){
      echo 0;
      exit;
    }

    $deposit = round($amount * 0.2, 2);

    $query = "UPDATE `booking_order`
      SET `deposit`=?, `payment_status`=?
      WHERE `booking_id`=? AND `user_id`=?";

    $values = [$deposit,'deposited',$id,$_SESSION['uId']];
    $result = update($query,$values,'dsii');

    echo ($result || $current_deposit == $deposit) ? 1 : 0;
    exit;
  }

  echo 0;
?>
