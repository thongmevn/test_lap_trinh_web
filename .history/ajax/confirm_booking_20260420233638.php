<?php 
  ob_start();
  // 1. Đưa session_start lên trên cùng và kiểm tra xem đã bật chưa để tránh lỗi đụng độ
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');

  // Đảm bảo dữ liệu trả về luôn là JSON để trình duyệt không bị nhầm lẫn
  header('Content-Type: application/json');

  if(isset($_POST['check_availability']))
  {
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    // check in and out validations
    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    if($checkin_date == $checkout_date){
      $status = 'check_in_out_equal';
      $result = json_encode(["status"=>$status]);
    }
    else if($checkout_date < $checkin_date){
      $status = 'check_out_earlier';
      $result = json_encode(["status"=>$status]);
    }
    else if($checkin_date < $today_date){
      $status = 'check_in_earlier';
      $result = json_encode(["status"=>$status]);
    }

    // check booking availability if status is blank else return the error
    if($status!=''){
      echo $result;
      exit; // Thêm exit để ngắt chương trình ngay lập tức
    }
    else{
      
      // 2. Kiểm tra xem session room có tồn tại không để tránh lỗi SQL
      if(!isset($_SESSION['room']['id'])) {
          echo json_encode(["status"=>"session_expired"]);
          exit;
      }

      // run query to check room is available or not 
      $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
        WHERE booking_status=? AND room_id=?
        AND check_out > ? AND check_in < ?";

      $values = ['booked', $_SESSION['room']['id'], $frm_data['check_in'], $frm_data['check_out']];
      
      $tb_result = select($tb_query, $values, 'siss');
      $tb_fetch = mysqli_fetch_assoc($tb_result);
      
      $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `id`=?", [$_SESSION['room']['id']], 'i');
      $rq_fetch = mysqli_fetch_assoc($rq_result);

      if(($rq_fetch['quantity'] - $tb_fetch['total_bookings']) == 0){
        $status = 'unavailable';
        $result = json_encode(['status'=>$status]);
        echo $result;
        exit;
      }

      $count_days = date_diff($checkin_date, $checkout_date)->days;
      $payment = $_SESSION['room']['price'] * $count_days;

      $_SESSION['room']['payment'] = $payment;
      $_SESSION['room']['available'] = true;
      
      $result = json_encode(["status"=>'available', "days"=>$count_days, "payment"=> $payment]);
      echo $result;
      exit;
    }
  }
?>