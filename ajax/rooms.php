<?php 

ob_start();
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');
ob_end_clean();

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
    echo "<h3 class='error-text'>Invalid Dates Entered!</h3>";
    exit;
    }
    else if($checkout_date < $checkin_date){
    echo "<h3 class='error-text'>Invalid Dates Entered!</h3>";
    exit;
    }
    else if($checkin_date < $today_date){
    echo "<h3 class='error-text'>Invalid Dates Entered!</h3>";
    exit;
    }
}

$guests = json_decode($_GET['guests'],true);
$adults = ($guests['adults']!='') ? $guests['adults'] : 0;
$children = ($guests['children']!='') ? $guests['children'] : 0;

$facility_list = json_decode($_GET['facility_list'],true);

$count_rooms = 0;
$output = "";

$settings_q = "SELECT * FROM `settings` WHERE `sr_no`=1";
$settings_r = mysqli_fetch_assoc(mysqli_query($con,$settings_q));

$room_res = select(
    "SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=?",
    [$adults,$children,1,0],
    'iiii'
);

while($room_data = mysqli_fetch_assoc($room_res))
{

    if($chk_avail['checkin']!='' && $chk_avail['checkout']!='')
    {
    $tb_query = "SELECT COUNT(*) AS total_bookings FROM `booking_order`
    WHERE booking_status=? AND room_id=?
    AND check_out > ? AND check_in < ?";

    $values = ['booked',$room_data['id'],$chk_avail['checkin'],$chk_avail['checkout']];
    $tb_fetch = mysqli_fetch_assoc(select($tb_query,$values,'siss'));

    if(($room_data['quantity']-$tb_fetch['total_bookings'])==0){
        continue;
    }
    }

    $fac_count=0;

    $fac_q = mysqli_query($con,"SELECT f.name, f.id FROM facilities f 
    INNER JOIN room_facilities rfac ON f.id = rfac.facilities_id 
    WHERE rfac.room_id = '$room_data[id]'");

    $facilities_data = "";

    while($fac_row = mysqli_fetch_assoc($fac_q))
    {
    if(in_array($fac_row['id'],$facility_list['facilities'])){
        $fac_count++;
    }

    $facilities_data .="<span class='badge'>$fac_row[name]</span>";
    }

    if(count($facility_list['facilities'])!=$fac_count){
    continue;
    }

    $fea_q = mysqli_query($con,"SELECT f.name FROM features f 
    INNER JOIN room_features rfea ON f.id = rfea.features_id 
    WHERE rfea.room_id = '$room_data[id]'");

    $features_data = "";

    while($fea_row = mysqli_fetch_assoc($fea_q)){
    $features_data .="<span class='badge'>$fea_row[name]</span>";
    }

    $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";

    $thumb_q = mysqli_query($con,"SELECT * FROM room_images 
    WHERE room_id='$room_data[id]' AND thumb='1'");

    if(mysqli_num_rows($thumb_q)>0){
    $thumb_res = mysqli_fetch_assoc($thumb_q);

    if(file_exists(UPLOAD_IMAGE_PATH.ROOMS_FOLDER.$thumb_res['image'])){
        $room_thumb = roomImagePath($thumb_res['image']);
    }
    }

    $login = (isset($_SESSION['login']) && $_SESSION['login']==true) ? 1 : 0;

    if(!$settings_r['shutdown']){
        $book_btn = "
            <button onclick='checkLoginToBook($login,$room_data[id])' class='btn-book'>
            Đặt ngay
            </button>";
    } else {
        $book_btn = "
            <button class='btn-book' disabled>
            Bảo trì
            </button>";
    }

    $price = number_format($room_data['price'],0,',','.');

    $output .= "
    <div class='room-card'>

    <div class='room-img'>
        <img src='$room_thumb'>
    </div>

    <div class='room-info'>

        <h3 class='room-title'>$room_data[name]</h3>

        <div class='block'>
        <h6>Không gian</h6>
        <div class='tags'>$features_data</div>
        </div>

        <div class='block'>
        <h6>Tiện ích</h6>
        <div class='tags'>$facilities_data</div>
        </div>

        <div class='block'>
        <h6>Khách</h6>
        <span class='badge'>$room_data[adult] Người lớn</span>
        <span class='badge'>$room_data[children] Trẻ em</span>
        </div>

    </div>

    <div class='room-side'>
        <div class='price'>$price VND / đêm</div>

        $book_btn

        <a href='room_details.php?id=$room_data[id]' class='btn-detail'>
        Chi tiết
        </a>
    </div>

    </div>";
    $count_rooms++;
}

if($count_rooms>0){
    echo $output;
} else {
    echo "<h3 class='error-text'>No rooms to show!</h3>";
}
}
?>