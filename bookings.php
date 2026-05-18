<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Lịch sử đặt phòng</title>

    <style>
    .bookings-wrap{
        max-width:1140px;
        margin:0 auto;
        padding:0 16px 40px;
    }

    .bookings-header{
        padding:40px 0 24px;
    }

    .bookings-header h2{
        font-weight:700;
        margin-bottom:8px;
    }

    .bookings-header .breadcrumb{
        font-size:14px;
        color:#666;
    }

    .bookings-header .breadcrumb a{
        color:#666;
        text-decoration:none;
    }

    .bookings-grid{
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:20px;
    }

    .booking-card{
        background:#fff;
        border-radius:10px;
        padding:20px;
        box-shadow:0 2px 8px rgba(0,0,0,.08);
    }

    .booking-card h5{
        font-weight:700;
        margin:0 0 6px;
    }

    .booking-card p{
        margin:0 0 10px;
        font-size:14px;
    }

    .status-badge{
        display:inline-block;
        padding:4px 10px;
        border-radius:4px;
        font-size:13px;
        color:#fff;
        margin-bottom:10px;
    }

    .status-badge.success{
        background:#198754;
    }

    .status-badge.danger{
        background:#dc3545;
    }

    .status-badge.warning{
        background:#ffc107;
        color:#212529;
    }

    .review-btn,
    .deposit-btn,
    .cancel-btn{
        border:none;
        padding:8px 14px;
        border-radius:6px;
        cursor:pointer;
        color:#fff;
        margin-top:5px;
        margin-right:5px;
    }

    .review-btn{
        background:#111827;
    }

    .deposit-btn{
        background:#198754;
    }

    .cancel-btn{
        background:#dc3545;
    }

    .review-modal{
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.45);
        display:none;
        align-items:center;
        justify-content:center;
        z-index:9999;
    }

    .review-modal.active{
        display:flex;
    }

    .review-box{
        width:420px;
        max-width:95%;
        background:#fff;
        border-radius:14px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,.2);
    }

    .review-head{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:18px 20px;
        border-bottom:1px solid #eee;
    }

    .review-head h5{
        margin:0;
        font-size:18px;
    }

    .review-close{
        border:none;
        background:none;
        font-size:24px;
        cursor:pointer;
    }

    .review-body{
        padding:20px;
    }

    .review-group{
        margin-bottom:18px;
    }

    .review-group label{
        display:block;
        margin-bottom:8px;
        font-weight:600;
    }

    .review-group select,
    .review-group textarea{
        width:100%;
        border:1px solid #ccc;
        border-radius:8px;
        padding:10px 12px;
        font-size:14px;
        outline:none;
        box-sizing:border-box;
    }

    .review-group textarea{
        resize:none;
    }

    .review-submit{
        background:#111827;
        color:#fff;
        border:none;
        padding:10px 18px;
        border-radius:8px;
        cursor:pointer;
    }

    .deposit-box{
        width:520px;
    }

    .deposit-info{
        display:grid;
        grid-template-columns:150px 1fr;
        gap:8px 12px;
        margin-bottom:16px;
        font-size:14px;
    }

    .deposit-info b{
        color:#111827;
    }

    .deposit-qr{
        width:220px;
        max-width:100%;
        display:block;
        margin:0 auto 16px;
        border:1px solid #e5e7eb;
        border-radius:10px;
        background:#fff;
    }

    .deposit-actions{
        display:flex;
        justify-content:flex-end;
        gap:10px;
        flex-wrap:wrap;
    }

    .deposit-confirm{
        background:#198754;
        color:#fff;
        border:none;
        padding:10px 16px;
        border-radius:8px;
        cursor:pointer;
        font-weight:700;
    }

    @media (max-width:992px){
        .bookings-grid{
            grid-template-columns:repeat(2,1fr);
        }
    }

    @media (max-width:600px){
        .bookings-grid{
            grid-template-columns:1fr;
        }
    }
    </style>
</head>

<body class="bg-light">

<?php
require('inc/header.php');

if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
}
?>

<div class="bookings-wrap">

    <div class="bookings-header">
        <h2 class="h-font">Lịch sử đặt phòng</h2>

        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span> > </span>
            <a href="#">Lịch sử đặt phòng</a>
        </div>
    </div>

    <div class="bookings-grid">

<?php

$query = "SELECT bo.*, bd.* FROM `booking_order` bo
INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
WHERE (
bo.booking_status='booked'
OR bo.booking_status='cancelled'
OR bo.booking_status='payment failed'
OR bo.booking_status='pending'
)
AND bo.user_id=?
ORDER BY bo.booking_id DESC";

$result = select($query,[$_SESSION['uId']],'i');

while($data = mysqli_fetch_assoc($result))
{
    $date = date("d-m-Y", strtotime($data['datentime']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));

    $status_class = "";
    $btn = "";

    $booking_id = (int)$data['booking_id'];
    $room_id = isset($data['room_id']) ? (int)$data['room_id'] : 0;
    $payment_status = $data['payment_status'] ?? 'unpaid';
    $deposit = isset($data['deposit']) ? (float)$data['deposit'] : 0;
    $total_pay = isset($data['total_pay']) ? (float)$data['total_pay'] : 0;
    $deposit_due = round($total_pay * 0.2, 2);
    $deposit_display = $deposit > 0 ? $deposit : (($payment_status == 'unpaid') ? $deposit_due : 0);
    $deposit_text = number_format($deposit_display, 0, ',', '.');
    $deposit_due_json = json_encode($deposit_due);
    $order_id_json = json_encode($data['order_id'] ?? '');

    if($data['booking_status']=='booked')
    {
        $status_class = "success";

        if((int)($data['rate_review'] ?? 0)==0){

          $btn .= "<button type='button'
onclick='review_room(".$data['booking_id'].",".$data['room_id'].")'
class='review-btn'>
Đánh giá
</button>";
        }
        else{
            $btn .= "
            <span class='status-badge warning'>
            Đã đánh giá
            </span>";
        }

        if($data['arrival']!=1){

            if($payment_status=='unpaid'){

                $btn .= "
                <button
                onclick='openDepositModal($booking_id,$deposit_due_json,$order_id_json)'
                class='deposit-btn'>
                Thanh toán cọc
                </button>

                <button
                onclick='cancel_booking($booking_id)'
                class='cancel-btn'>
                Huỷ & hoàn tiền
                </button>";
            }

            else if($payment_status=='deposited'){

                $btn .= "
                <span class='status-badge success'>
                Đã thanh toán cọc
                </span>

                <button
                onclick='cancel_booking($booking_id)'
                class='cancel-btn'>
                Huỷ & hoàn tiền
                </button>";
            }
        }
    }

    else if($data['booking_status']=='cancelled')
    {
        $status_class = "danger";

        if($payment_status=='refunded'){

            $btn = "
            <span class='status-badge success'>
            Đã hoàn tiền
            </span>";
        }

        else if($payment_status=='no_refund'){

            $btn = "
            <span class='status-badge danger'>
            Không hoàn tiền
            </span>";
        }

        else{

            $btn = "
            <span class='status-badge warning'>
            Đang xử lý
            </span>";
        }
    }

    else{
        $status_class = "warning";
    }

    $status_vn = match($data['booking_status']){
        'booked' => 'Đã đặt phòng',
        'cancelled' => 'Đã huỷ',
        'payment failed' => 'Thanh toán thất bại',
        'pending' => 'Đang xử lý',
        default => $data['booking_status'],
    };

echo <<<bookings

<div class="booking-card">

    <h5>$data[room_name]</h5>

    <p>$data[price] VND / đêm</p>

    <p>
        <b>Nhận phòng:</b> $checkin <br>
        <b>Trả phòng:</b> $checkout
    </p>

    <p>
        <b>Số tiền:</b> $data[total_pay] VND <br>
        <b>Tiền cọc:</b> $deposit_text VND <br>
        <b>Mã đơn:</b> $data[order_id] <br>
        <b>Ngày:</b> $date
    </p>

    <span class="status-badge $status_class">
        $status_vn
    </span>

    <br>

    $btn

</div>

bookings;

}
?>

    </div>
</div>

<div class="review-modal" id="reviewModal">

    <div class="review-box">

        <form id="review-form">

            <div class="review-head">

                <h5>Đánh giá phòng</h5>

                <button
                type="button"
                class="review-close"
                onclick="closeReviewModal()">
                ×
                </button>

            </div>

            <div class="review-body">

                <div class="review-group">

                    <label>Mức độ hài lòng</label>

                    <select name="rating">
                        <option value="5">Xuất sắc</option>
                        <option value="4">Tốt</option>
                        <option value="3">Bình thường</option>
                        <option value="2">Kém</option>
                        <option value="1">Tệ</option>
                    </select>

                </div>

                <div class="review-group">

                    <label>Nhận xét</label>

                    <textarea
                    name="review"
                    rows="4"
                    required></textarea>

                </div>

                <input type="hidden" name="booking_id">
                <input type="hidden" name="room_id">

                <div style="text-align:right">

                    <button
                    type="submit"
                    class="review-submit">
                    Gửi đánh giá
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="review-modal" id="depositModal">

    <div class="review-box deposit-box">

        <div class="review-head">
            <h5>Thanh toán cọc</h5>
            <button type="button" class="review-close" onclick="closeDepositModal()">×</button>
        </div>

        <div class="review-body">
            <img src="" alt="QR thanh toán cọc" class="deposit-qr" id="deposit_qr_img">

            <div class="deposit-info">
                <b>Số tiền cọc</b>
                <span id="deposit_amount_text"></span>

                <b>Ngân hàng</b>
                <span id="deposit_bank_text"></span>

                <b>Số tài khoản</b>
                <span id="deposit_account_text"></span>

                <b>Chủ tài khoản</b>
                <span id="deposit_name_text"></span>

                <b>Nội dung</b>
                <span id="deposit_note_text"></span>
            </div>

            <div class="deposit-actions">
                <button type="button" class="review-submit" onclick="closeDepositModal()">Đóng</button>
                <button type="button" class="deposit-confirm" onclick="confirmDepositPayment()">Tôi đã chuyển khoản</button>
            </div>
        </div>

    </div>

</div>

<?php

if(isset($_GET['cancel_status'])){
    alert('success','Huỷ đặt phòng thành công!');
}

else if(isset($_GET['review_status'])){
    alert('success','Cảm ơn bạn đã để lại đánh giá!');
}

else if(isset($_GET['deposit_status'])){
        alert('success','Thanh toán cọc thành công!');
    }

?>

<?php require('inc/footer.php'); ?>

<script>

function openReviewModal(){
    document
    .getElementById('reviewModal')
    .classList.add('active');
}

function closeReviewModal(){
    document
    .getElementById('reviewModal')
    .classList.remove('active');
}

function review_room(bid,rid){

    // Đã xóa dòng alert() gây lỗi hiển thị chữ undefined tại đây

    let review_form =
    document.getElementById('review-form');

    review_form.elements['booking_id'].value = bid;

    review_form.elements['room_id'].value = rid;

    openReviewModal();
}

function cancel_booking(id){

    if(confirm(
        'Bạn có chắc muốn huỷ đặt phòng này?'
    )){

        let xhr = new XMLHttpRequest();

        xhr.open(
            "POST",
            "ajax/cancel_booking.php",
            true
        );

        xhr.setRequestHeader(
            'Content-Type',
            'application/x-www-form-urlencoded'
        );

        xhr.onload = function(){

            let res =
            this.responseText.trim();

            if(res == "1"){

                window.location.href =
                "bookings.php?cancel_status=true";

            }else{

                // Thêm tham số 'error' để tránh hiển thị undefined
                alert(
                    'error',
                    'Huỷ đặt phòng không thành công!'
                );
            }
        }

        xhr.send(
            'cancel_booking=1&id=' +
            encodeURIComponent(id)
        );
    }
}

let review_form =
document.getElementById('review-form');

if(review_form){

review_form.addEventListener(
'submit',
function(e){

    e.preventDefault();

    let data = new FormData();

    data.append('review_form','1');

    data.append(
        'rating',
        review_form.elements['rating'].value
    );

    data.append(
        'review',
        review_form.elements['review'].value
    );

    data.append(
        'booking_id',
        review_form.elements['booking_id'].value
    );

    data.append(
        'room_id',
        review_form.elements['room_id'].value
    );

    let xhr = new XMLHttpRequest();

    xhr.open(
        "POST",
        "ajax/review_room.php",
        true
    );

    xhr.onload = function(){

        let result =
        this.responseText.trim();

        if(result == "1"){

            closeReviewModal();

            window.location.href =
            'bookings.php?review_status=true';

        }else{
            
            alert(
                'error',
                result || 'Đánh giá thất bại!'
            );
        }
    };

    xhr.onerror = function(){

        alert(
            'error',
            'Lỗi kết nối server!'
        );
    };

    xhr.send(data);

});
}

const depositPayment = {
    bankCode: 'MB',
    bankName: 'MB Bank',
    accountNo: '0123456789',
    accountName: 'DAWNCHILL HOTEL'
};

let selectedDepositBookingId = 0;

function formatVnd(amount){
    return Number(amount || 0).toLocaleString('vi-VN') + ' VND';
}

function openDepositModal(id, amount, orderId){
    selectedDepositBookingId = id;

    let note = 'COC ' + orderId;
    let qrUrl = 'https://img.vietqr.io/image/' +
        encodeURIComponent(depositPayment.bankCode) + '-' +
        encodeURIComponent(depositPayment.accountNo) +
        '-compact2.png?amount=' + encodeURIComponent(Math.round(amount)) +
        '&addInfo=' + encodeURIComponent(note) +
        '&accountName=' + encodeURIComponent(depositPayment.accountName);

    document.getElementById('deposit_qr_img').src = qrUrl;
    document.getElementById('deposit_amount_text').innerText = formatVnd(amount);
    document.getElementById('deposit_bank_text').innerText = depositPayment.bankName;
    document.getElementById('deposit_account_text').innerText = depositPayment.accountNo;
    document.getElementById('deposit_name_text').innerText = depositPayment.accountName;
    document.getElementById('deposit_note_text').innerText = note;
    document.getElementById('depositModal').classList.add('active');
}

function closeDepositModal(){
    document.getElementById('depositModal').classList.remove('active');
}

function confirmDepositPayment(){
    if(selectedDepositBookingId){
        pay_deposit(selectedDepositBookingId);
    }
}

function pay_deposit(id){

    if(true || confirm(
        'Bạn có muốn thanh toán tiền cọc không?'
    )){

        let xhr = new XMLHttpRequest();

        xhr.open(
            "POST",
            "ajax/pay_deposit.php",
            true
        );

        xhr.setRequestHeader(
            'Content-Type',
            'application/x-www-form-urlencoded'
        );

        xhr.onload = function(){

            let res =
            this.responseText.trim();

            if(res == "1"){

                alert(
                    'success',
                    'Thanh toán thành công!'
                );

                closeDepositModal();
                window.location.href = 'bookings.php?deposit_status=true';

            }else{

                alert(
                    'error',
                    'Thanh toán thất bại!'
                );
            }
        }
        xhr.send(
            'pay_deposit=1&id=' +
            encodeURIComponent(id)
        );
    }
}
</script>
</body>
</html>
