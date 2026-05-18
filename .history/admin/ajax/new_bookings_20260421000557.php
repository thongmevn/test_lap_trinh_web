<?php 

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

  if(isset($_POST['get_bookings']))
  {
    $frm_data = filteration($_POST);

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      AND (bo.booking_status=? AND bo.arrival=?) ORDER BY bo.booking_id ASC";

// ✅ Sửa chữ "booked" thành "pending"
    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","pending",0],'ssssi');
        
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

      $table_data .="
        <tr>
          <td>$i</td>
          <td>
            <span class='badge-primary-custom'>
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
            <b>Price:</b> $data[price] VND
          </td>
          <td>
            <b>Check-in:</b> $checkin
            <br>
            <b>Check-out:</b> $checkout
            <br>
            <b>Paid:</b> $data[trans_amt] VND
            <br>
            <b>Date:</b> $date
          </td>
          <td>
            <button type='button' onclick='assign_room($data[booking_id])' class='btn-success-custom' data-bs-toggle='modal' data-bs-target='#assign-room'>
              Chọn phòng
            </button>
            <br>
            <button type='button' onclick='cancel_booking($data[booking_id])' class='btn-outline-danger-custom'>
              Huỷ đặt phòng
            </button>
          </td>
        </tr>
      ";

      $i++;
    }

    echo "
    <style>
      .badge-primary-custom {
        background: #0d6efd;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
      }

      .btn-success-custom {
        background: #198754;
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        margin-bottom: 5px;
      }

      .btn-success-custom:hover {
        background: #157347;
      }

      .btn-outline-danger-custom {
        background: transparent;
        color: #dc3545;
        border: 1px solid #dc3545;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
      }

      .btn-outline-danger-custom:hover {
        background: #dc3545;
        color: #fff;
      }
    </style>
    ".$table_data;
  }

  if(isset($_POST['assign_room']))
  {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
      ON bo.booking_id = bd.booking_id
      SET bo.arrival = ?, bo.rate_review = ?, bd.room_no = ? 
      WHERE bo.booking_id = ?";

    $values = [1,0,$frm_data['room_no'],$frm_data['booking_id']];

    $res = update($query,$values,'iisi');

    echo ($res >= 1) ? 1 : 0;
  }

  if(isset($_POST['cancel_booking']))
  {
    $frm_data = filteration($_POST);
    
    $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=?";
    $values = ['cancelled',0,$frm_data['booking_id']];
    $res = update($query,$values,'sii');

    echo $res;
  }

?>