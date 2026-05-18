<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');

    session_start();

    if(isset($_POST['pay_deposit']))
    {
        $id = $_POST['id'];

        $res = select(
            "SELECT * FROM booking_order WHERE booking_id=? AND user_id=?",
            [$id,$_SESSION['uId']],
            'ii'
        );

        if(!$res || mysqli_num_rows($res)==0){
            echo 0;
            exit;
        }

        $data = mysqli_fetch_assoc($res);

        // ✔ tránh NULL gây lỗi
        $price = floatval($data['trans_amt'] ?? 0);

        if($price <= 0){
            echo 0;
            exit;
        }

        $deposit = $price * 0.2;

        $query = "UPDATE booking_order 
                SET deposit=?, payment_status=? 
                WHERE booking_id=? AND user_id=?";

        $values = [$deposit,'deposited',$id,$_SESSION['uId']];

        $result = update($query,$values,'dsii');

        if($result){
            echo 1;
            exit;
        } else {
            echo mysqli_error($con);
            exit;
        }
    }
?>