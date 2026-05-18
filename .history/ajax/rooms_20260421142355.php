<?php 

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');
  

  session_start();

  if(isset($_GET['fetch_rooms']))
  {
    // check availability data decode
    $chk_avail = json_decode($_GET['chk_avail'],true);
    
    // checkin and checkout filter validations
    if($chk_avail['checkin']!='' && $chk_avail['checkout']!='')
    {
      $today_date = new DateTime(date("Y-m-d"));
      $checkin_date = new DateTime($chk_avail['checkin']);
      $checkout_date = new DateTime($chk_avail['checkout']);
  
      if($checkin_date == $checkout_date){
        echo"<h3 class='text-center text-danger'>Invalid Dates Entered!</h3>";
        exit;
      }
      else if($checkout_date < $checkin_date){
        echo"<h3 class='text-center text-danger'>Invalid Dates Entered!</h3>";
        exit;
      }
      else if($checkin_date < $today_date){
        echo"<h3 class='text-center text-danger'>Invalid Dates Entered!</h3>";
        exit;
      }
    }

    // guests data decode
    $guests = json_decode($_GET['guests'],true);
    $adults = ($guests['adults']!='') ? $guests['adults'] : 0;
    $children = ($guests['children']!='') ? $guests['children'] : 0;

    // facilities data decode
    $facility_list = json_decode($_GET['facility_list'],true);

    // count no. of rooms and ouput variable to store room cards
    $count_rooms = 0;
    $output = "";


    // fetching settings table to check website is shutdown or not
    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=1";
    $settings_r = mysqli_fetch_assoc(mysqli_query($con,$settings_q));


    // query for room cards with guests filter
    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=?",[$adults,$children,1,0],'iiii');

    while($room_data = mysqli_fetch_assoc($room_res))
    {
      // check availability filter
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

      // get facilities of room with filters
      $fac_count=0;

      $fac_q = select("SELECT f.name, f.id FROM `facilities` f 
        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
        WHERE rfac.room_id = ?", [$room_data['id']], 'i');

      $facilities_data = "";
      while($fac_row = mysqli_fetch_assoc($fac_q))
      {
        if( in_array($fac_row['id'],$facility_list['facilities']) ){
          $fac_count++;
        }

        $facilities_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
          $fac_row[name]
        </span>";
      }

      if(count($facility_list['facilities'])!=$fac_count){
        continue;
      }


      // get features of room

      $fea_q = select("SELECT f.name FROM `features` f 
        INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
        WHERE rfea.room_id = ?", [$room_data['id']], 'i');

      $features_data = "";
      while($fea_row = mysqli_fetch_assoc($fea_q)){
        $features_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
          $fea_row[name]
        </span>";
      }


      // get thumbnail of image

      $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
      $thumb_q = select("SELECT * FROM `room_images` 
        WHERE `room_id`=? AND `thumb`=?", [$room_data['id'], 1], 'ii');

      if(mysqli_num_rows($thumb_q)>0){
        $thumb_res = mysqli_fetch_assoc($thumb_q);
        $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
      }

      $book_btn = "";

      if(!$settings_r['shutdown']){
        $login=0;
        if(isset($_SESSION['login']) && $_SESSION['login']==true){
          $login=1;
        }

        $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Đặt ngay</button>";
      }

      // print room card

      $output.="
        <div class='room-card'>
          <div class='room-row'>

            <div class='room-img-col'>
              <img src='$room_thumb' class='room-img'>
            </div>

            <div class='room-info-col'>
              <h5 class='room-title'>$room_data[name]</h5>

              <div class='room-features'>
                <h6>Không gian</h6>
                $features_data
              </div>

              <div class='room-facilities'>
                <h6>Tiện ích</h6>
                $facilities_data
              </div>

              <div class='room-guests'>
                <h6>Số lượng khách</h6>
                <span class='badge-custom'>
                  $room_data[adult] Người lớn
                </span>
                <span class='badge-custom'>
                  $room_data[children] Trẻ em
                </span>
              </div>
            </div>

            <div class='room-action-col'>
              <h6 class='room-price'>$room_data[price] VND / đêm</h6>
              $book_btn
              <a href='room_details.php?id=$room_data[id]' class='btn-outline-custom'>
                Chi tiết
              </a>
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
      echo"<h3 class='text-center text-danger'>No rooms to show!</h3>";
    }

  }


?>