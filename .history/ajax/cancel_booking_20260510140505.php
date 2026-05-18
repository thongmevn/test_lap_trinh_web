<?php 

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');

  session_start();

  if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
  }

  if(isset($_POST['cancel_booking']))
  {
    $frm_data = filteration($_POST);

    $res = select("SELECT * FROM booking_order WHERE booking_id=? AND user_id=?", 
                  [$frm_data['id'], $_SESSION['uId']], 
                  'ii');

    $data = mysqli_fetch_assoc($res);

    $checkin = strtotime($data['check_in']);
    $today = time();

    if(($checkin - $today) > 86400){
      $refund = 1;
      $payment_status = 'refunded';
    }
    else{
      $refund = 0;
      $payment_status = 'no_refund';
    }

    $query = "UPDATE `booking_order` 
              SET `booking_status`=?, `refund`=?, `payment_status`=? 
              WHERE `booking_id`=? AND `user_id`=?";

    $values = ['cancelled',$refund,$payment_status,$frm_data['id'],$_SESSION['uId']];

    $result = update($query,$values,'sisii');

    echo $result;
  }

?>