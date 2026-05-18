<?php 
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require('admin/inc/db_config.php');
  ob_start();
  require('admin/inc/essentials.php');
  ob_end_clean();

  session_start();

  if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
  }

  $settings_q = select("SELECT `shutdown` FROM `settings` WHERE `sr_no`=? LIMIT 1",[1],'i');
  $settings_r = mysqli_fetch_assoc($settings_q);

  if($settings_r && $settings_r['shutdown']){
    redirect('rooms.php');
  }

  if(isset($_POST['pay_now']))
  {
    if(!isset($_SESSION['room']) || !isset($_SESSION['room']['available']) || $_SESSION['room']['available']!=true){
      redirect('rooms.php');
    }

    $frm_data = filteration($_POST);
    $CUST_ID = $_SESSION['uId'];
    $room_id = (int)$_SESSION['room']['id'];

    if(empty($frm_data['checkin']) || empty($frm_data['checkout'])){
      $_SESSION['room']['available'] = false;
      redirect("confirm_booking.php?id=$room_id");
    }

    try{
      $today_date = new DateTime(date("Y-m-d"));
      $checkin_date = new DateTime($frm_data['checkin']);
      $checkout_date = new DateTime($frm_data['checkout']);
    }
    catch(Exception $e){
      $_SESSION['room']['available'] = false;
      redirect("confirm_booking.php?id=$room_id");
    }

    if($checkin_date == $checkout_date || $checkout_date < $checkin_date || $checkin_date < $today_date){
      $_SESSION['room']['available'] = false;
      redirect("confirm_booking.php?id=$room_id");
    }

    $room_res = select("SELECT `name`, `price`, `quantity` FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=? LIMIT 1",[$room_id,1,0],'iii');

    if(mysqli_num_rows($room_res)==0){
      $_SESSION['room']['available'] = false;
      redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

    $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
      WHERE booking_status=? AND room_id=?
      AND check_out > ? AND check_in < ?";

    $tb_fetch = mysqli_fetch_assoc(select($tb_query,['booked',$room_id,$frm_data['checkin'],$frm_data['checkout']],'siss'));

    if(($room_data['quantity']-$tb_fetch['total_bookings'])<=0){
      $_SESSION['room']['available'] = false;
      redirect("confirm_booking.php?id=$room_id");
    }

    $count_days = date_diff($checkin_date,$checkout_date)->days;
    $TXN_AMOUNT = $room_data['price'] * $count_days;

    $_SESSION['room']['name'] = $room_data['name'];
    $_SESSION['room']['price'] = $room_data['price'];
    $_SESSION['room']['payment'] = $TXN_AMOUNT;

    $ORDER_ID = 'ORD_'.$_SESSION['uId'].random_int(11111,9999999);    
    // Insert payment data into database

    $query1 = "INSERT INTO `booking_order`
      (`user_id`, `room_id`, `check_in`, `check_out`, `booking_status`, `order_id`, `trans_amt`, `trans_status`, `trans_resp_msg`)
      VALUES (?,?,?,?,?,?,?,?,?)";

    insert($query1,[$CUST_ID,$room_id,$frm_data['checkin'],
      $frm_data['checkout'],'booked',$ORDER_ID,$TXN_AMOUNT,'TXN_SUCCESS','Payment successful'],'iissssiss');
    
    $booking_id = mysqli_insert_id($con);

    $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`,
      `user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";

    insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],
      $TXN_AMOUNT,$frm_data['name'],$frm_data['phonenum'],$frm_data['address']],'issssss');
  }

  redirect('bookings.php');
?>
