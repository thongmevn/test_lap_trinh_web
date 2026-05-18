<?php 

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');

  session_start();

  if(isset($_GET['fetch_rooms']))
  {
    $chk_avail = json_decode($_GET['chk_avail'],true);
    
    if($chk_avail['checkin']!='' && $chk_avail['checkout']!='')
    {
      $today_date = new DateTime(date("Y-m-d"));
      $checkin_date = new DateTime($chk_avail['checkin']);
      $checkout_date = new DateTime($chk_avail['checkout']);
  
      if($checkin_date == $checkout_date){
        echo"<h3 style='text-align:center;color:#dc3545;'>Ngày nhập không hợp lệ!</h3>";
        exit;
      }
      else if($checkout_date < $checkin_date){
        echo"<h3 style='text-align:center;color:#dc3545;'>Ngày nhập không hợp lệ!</h3>";
        exit;
      }
      else if($checkin_date < $today_date){
        echo"<h3 style='text-align:center;color:#dc3545;'>Ngày nhập không hợp lệ!</h3>";
        exit;
      }
    }

    $guests = json_decode($_GET['guests'],true);
    $adults   = ($guests['adults']!='')   ? $guests['adults']   : 0;
    $children = ($guests['children']!='') ? $guests['children'] : 0;

    $facility_list = json_decode($_GET['facility_list'],true);

    $count_rooms = 0;
    $output = "";

    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=1";
    $settings_r = mysqli_fetch_assoc(mysqli_query($con,$settings_q));

    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=?",[$adults,$children,1,0],'iiii');

    while($room_data = mysqli_fetch_assoc($room_res))
    {
      if($chk_avail['checkin']!='' && $chk_avail['checkout']!='')
      {
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
          WHERE booking_status=? AND room_id=?
          AND check_out > ? AND check_in < ?";

        $values = ['booked',$room_data['id'],$chk_avail['checkin'],$chk_avail['checkout']];
        $tb_fetch = mysqli_fetch_assoc(select($tb_query,$values,'siss'));

        if(($room_data['quantity']-$tb_fetch['total_bookings'])==0){
          continue;
        }
      }

      $fac_count = 0;

      $fac_q = select("SELECT f.name, f.id FROM `facilities` f 
        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
        WHERE rfac.room_id = ?", [$room_data['id']], 'i');

      $facilities_data = "";
      while($fac_row = mysqli_fetch_assoc($fac_q))
      {
        if( in_array($fac_row['id'],$facility_list['facilities']) ){
          $fac_count++;
        }

        $facilities_data .= "
          <span style='
            display:inline-block;
            background:#f8f9fa;
            color:#212529;
            border-radius:50px;
            padding:3px 10px;
            font-size:0.8rem;
            margin:0 4px 4px 0;
            white-space:normal;
            word-break:break-word;
          '>$fac_row[name]</span>";
      }

      if(count($facility_list['facilities'])!=$fac_count){
        continue;
      }

      $fea_q = select("SELECT f.name FROM `features` f 
        INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
        WHERE rfea.room_id = ?", [$room_data['id']], 'i');

      $features_data = "";
      while($fea_row = mysqli_fetch_assoc($fea_q)){
        $features_data .= "
          <span style='
            display:inline-block;
            background:#f8f9fa;
            color:#212529;
            border-radius:50px;
            padding:3px 10px;
            font-size:0.8rem;
            margin:0 4px 4px 0;
            white-space:normal;
            word-break:break-word;
          '>$fea_row[name]</span>";
      }

      $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
      $thumb_q = select("SELECT * FROM `room_images` 
        WHERE `room_id`=? AND `thumb`=?", [$room_data['id'], 1], 'ii');

      if(mysqli_num_rows($thumb_q)>0){
        $thumb_res = mysqli_fetch_assoc($thumb_q);
        $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
      }

      $book_btn = "";

      if(!$settings_r['shutdown']){
        $login = 0;
        if(isset($_SESSION['login']) && $_SESSION['login']==true){
          $login = 1;
        }

        $book_btn = "
          <button 
            onclick='checkLoginToBook($login,$room_data[id])' 
            style='
              display:block;
              width:100%;
              padding:6px 12px;
              margin-bottom:8px;
              font-size:0.875rem;
              color:#fff;
              background-color:#a0845c;
              border:none;
              border-radius:4px;
              cursor:pointer;
              box-shadow:none;
            '
          >Đặt ngay</button>";
      }

      $output .= "
        <div style='
          background:#fff;
          border-radius:8px;
          box-shadow:0 2px 8px rgba(0,0,0,0.1);
          margin-bottom:24px;
          overflow:hidden;
        '>
          <div style='
            display:flex;
            flex-wrap:wrap;
            align-items:center;
            padding:16px;
            gap:16px;
          '>

            <!-- Ảnh phòng -->
            <div style='flex:0 0 auto; width:100%; max-width:340px;'>
              <img 
                src='$room_thumb' 
                style='width:100%;height:auto;border-radius:6px;display:block;'
              >
            </div>

            <!-- Thông tin phòng -->
            <div style='flex:1 1 200px;'>
              <h5 style='margin:0 0 12px;font-size:1.1rem;'>$room_data[name]</h5>

              <div style='margin-bottom:12px;'>
                <h6 style='margin:0 0 6px;font-size:0.9rem;'>Không gian</h6>
                $features_data
              </div>

              <div style='margin-bottom:12px;'>
                <h6 style='margin:0 0 6px;font-size:0.9rem;'>Tiện ích</h6>
                $facilities_data
              </div>

              <div>
                <h6 style='margin:0 0 6px;font-size:0.9rem;'>Số lượng khách</h6>
                <span style='
                  display:inline-block;
                  background:#f8f9fa;
                  color:#212529;
                  border-radius:50px;
                  padding:3px 10px;
                  font-size:0.8rem;
                  margin-right:4px;
                '>$room_data[adult] Người lớn</span>
                <span style='
                  display:inline-block;
                  background:#f8f9fa;
                  color:#212529;
                  border-radius:50px;
                  padding:3px 10px;
                  font-size:0.8rem;
                '>$room_data[children] Trẻ em</span>
              </div>
            </div>

            <!-- Giá & nút -->
            <div style='
              flex:0 0 auto;
              width:140px;
              text-align:center;
            '>
              <h6 style='margin:0 0 16px;font-size:0.9rem;'>$room_data[price] VND / đêm</h6>
              $book_btn
              <a 
                href='room_details.php?id=$room_data[id]' 
                style='
                  display:block;
                  width:100%;
                  padding:6px 12px;
                  font-size:0.875rem;
                  color:#212529;
                  background:#fff;
                  border:1px solid #212529;
                  border-radius:4px;
                  text-align:center;
                  text-decoration:none;
                  box-sizing:border-box;
                '
              >Chi tiết</a>
            </div>

          </div>
        </div>
      ";

      $count_rooms++;
    }

    if($count_rooms>0){
      echo $output;
    }
    else{
      echo"<h3 style='text-align:center;color:#dc3545;'>Không có phòng nào!</h3>";
    }
  }

?>