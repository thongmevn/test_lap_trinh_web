<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

session_start();

if(isset($_POST['pay_deposit']))
{
  $id = $_POST['id'];

  // 🔍 lấy booking
  $res = select("SELECT * FROM booking_order WHERE booking_id=? AND user_id=?", 
                [$id,$_SESSION['uId']], 
                'ii');

  if(mysqli_num_rows($res)==0){
    echo "Không tìm thấy booking!";
    exit;
  }

  $data = mysqli_fetch_assoc($res);

  // 💰 tính tiền cọc (20%)
  $deposit = $data['price'] * 0.2;

  // 🔄 cập nhật
  $query = "UPDATE booking_order 
            SET deposit=?, payment_status=? 
            WHERE booking_id=? AND user_id=?";

  $values = [$deposit,'deposited',$id,$_SESSION['uId']];

  $result = update($query,$values,'dsii');

  if($result){
    echo 1;
  } else {
    echo "Update thất bại!";
  }
}
?>