<?php 

  require('../inc/db_config.php');
  ob_start();
  require('../inc/essentials.php');
  ob_end_clean();
  adminLogin();

  if(isset($_POST['get_bookings']))
  {
    $frm_data = filteration($_POST);

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      AND (bo.booking_status=? AND bo.refund=?) ORDER BY bo.booking_id ASC";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","cancelled",0],'sssss');
    
    $i=1;
    $table_data = "";

    if(mysqli_num_rows($res)==0){
      echo"<b>No Data Found!</b>";
      exit;
    }

    while($data = mysqli_fetch_assoc($res))
    {
      $date = date("d-m-Y",strtotime($data['datentime']));
      $checkin = date("d-m-Y",strtotime($data['check_in']));
      $checkout = date("d-m-Y",strtotime($data['check_out']));
      $refund_amount = floatval($data['deposit'] ?? 0);

      if($refund_amount <= 0){
        $refund_amount = floatval($data['trans_amt'] ?? 0);
      }

      $refund_amount_text = number_format($refund_amount,0,',','.');

      $table_data .="
        <tr>
          <td>$i</td>
          <td>
            <span class='badge-custom'>
              Order ID: $data[order_id]
            </span>
            <br>
            <b>Name:</b> $data[user_name]
            <br>
            <b>Phone No:</b> $data[phonenum]
          </td>
          <td>
            <b>Room:</b> $data[room_name]
            <br>
            <b>Check-in:</b> $checkin
            <br>
            <b>Check-out:</b> $checkout
            <br>
            <b>Date:</b> $date
          </td>
          <td>
            <b>$refund_amount_text VND</b> 
          </td>
          <td>
            <button type='button' onclick='refund_booking($data[booking_id])' class='btn-custom'>
              Refund
            </button>
          </td>
        </tr>
      ";

      $i++;
    }

    echo "
    <style>
      .badge-custom {
        display: inline-block;
        padding: 5px 10px;
        background-color: #0d6efd;
        color: #fff;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
      }

      .btn-custom {
        padding: 6px 12px;
        background-color: #198754;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
      }

      .btn-custom:hover {
        background-color: #157347;
      }
    </style>
    ".$table_data;
  }

  if(isset($_POST['refund_booking']))
  {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order`
      SET `refund`=?, `payment_status`=?
      WHERE `booking_id`=? AND `booking_status`=? AND `refund`=?";
    $values = [1,'refunded',$frm_data['booking_id'],'cancelled',0];
    $res = update($query,$values,'isisi');

    if($res == 1){
      echo 1;
    }
    else{
      $check = select(
        "SELECT `booking_id` FROM `booking_order` WHERE `booking_id`=? AND `payment_status`=? LIMIT 1",
        [$frm_data['booking_id'],'refunded'],
        'is'
      );
      echo mysqli_num_rows($check) ? 1 : 0;
    }
  }

?>
