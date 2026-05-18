<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phòng</title>

    <?php require('inc/links.php'); ?>

    <style>

    body{
        font-family:Arial;
        background:#f5f5f5;
    }

    .title{
        text-align:center;
        font-size:26px;
        margin-top:30px;
    }

    .line{
        width:80px;
        height:3px;
        background:#000;
        margin:10px auto 30px;
    }

    .container{
        width:95%;
        margin:auto;
        display:flex;
        gap:20px;
    }

    .sidebar{
        width:25%;
        background:#fff;
        padding:15px;
        border:1px solid #ddd;
        border-radius:10px;
        height:fit-content;
    }

    .content{
        width:75%;
    }

    .box{
        border:1px solid #ddd;
        background:#fafafa;
        padding:15px;
        margin-bottom:15px;
        border-radius:8px;
    }

    .box h4{
        font-size:16px;
        margin-bottom:10px;
    }

    .form-control{
        width:100%;
        padding:8px;
        margin-bottom:10px;
        border:1px solid #ccc;
        border-radius:6px;
    }

    .room-card{
        display:flex;
        gap:15px;
        background:#fff;
        border:1px solid #ddd;
        border-radius:10px;
        padding:15px;
        margin-bottom:20px;
    }

    .room-img{
        width:300px;
    }

    .room-img img{
        width:100%;
        height:220px;
        object-fit:cover;
        border-radius:8px;
    }

    .room-info{
        flex:1;
    }

    .room-info h3{
        font-size:20px;
        margin-bottom:10px;
    }

    .badge{
        display:inline-block;
        padding:5px 10px;
        background:#ffffff;
        color:#111;
        border:1px solid #d0d0d0;
        border-radius:20px;
        font-size:12px;
        margin:3px;
        font-weight:500;
        box-shadow:0 1px 3px rgba(0,0,0,0.08);
    }

    .room-side{
        width:170px;
        text-align:center;
    }

    .price{
        font-weight:bold;
        margin-bottom:10px;
    }

    .btn-book {
        width: 100%;
        padding: 10px;
        background: #28a745; 
        color: #fff;         
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin-bottom: 8px;
        font-weight: bold;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn-book:hover:not(:disabled) {
        background: #218838; 
        transform: translateY(-2px); 
    }

    .btn-book:disabled {
        background: #28a745; 
        color: #fff;
        opacity: 0.7;       
        cursor: not-allowed;
    }

    .btn-detail{
        display:block;
        padding:8px;
        border:1px solid #000;
        text-decoration:none;
        color:#000;
        border-radius:6px;
    }

    .btn-detail:hover{
        background:#000;
        color:#fff;
    }

    .error{
        text-align:center;
        color:red;
    }

    @media(max-width:900px){
        .container{
            flex-direction:column;
        }
        .sidebar,.content{
            width:100%;
        }
        .room-card{
            flex-direction:column;
        }
        .room-img{
            width:100%;
        }
        .room-side{
            width:100%;
        }
    }

    </style>
</head>

<body>

<?php 
require('inc/header.php'); 

$checkin_default="";
$checkout_default="";
$adult_default="";
$children_default="";

if(isset($_GET['check_availability']))
{
    $frm_data = filteration($_GET);
    $checkin_default = $frm_data['checkin'];
    $checkout_default = $frm_data['checkout'];
    $adult_default = $frm_data['adult'];
    $children_default = $frm_data['children'];
}
?>

<h2 class="title">DANH SÁCH PHÒNG</h2>
<div class="line"></div>

<div class="container">

    <div class="sidebar">

        <div class="box">
            <h4>Kiểm tra phòng</h4>

            <label>Nhận phòng</label>
            <input type="date" id="checkin" class="form-control" value="<?php echo $checkin_default ?>">

            <label>Trả phòng</label>
            <input type="date" id="checkout" class="form-control" value="<?php echo $checkout_default ?>">
        </div>

        <div class="box">
            <h4>Khách</h4>
            <input type="number" id="adults" class="form-control" placeholder="Người lớn" value="<?php echo $adult_default ?>">
            <input type="number" id="children" class="form-control" placeholder="Trẻ em" value="<?php echo $children_default ?>">
        </div>

        <div class="box">
            <h4>Tiện ích</h4>
            <?php 
            $facilities_q = selectAll('facilities');
            while($row = mysqli_fetch_assoc($facilities_q))
            {
                echo "
                <div>
                    <input type='checkbox' name='facilities' value='$row[id]'> $row[name]
                </div>";
            }
            ?>
        </div>

    </div>

    <div class="content" id="rooms-data"></div>

</div>

<script>
let rooms_data = document.getElementById('rooms-data');

let checkin = document.getElementById('checkin');
let checkout = document.getElementById('checkout');
let adults = document.getElementById('adults');
let children = document.getElementById('children');

function fetch_rooms(){

    let chk_avail = JSON.stringify({
        checkin:checkin.value,
        checkout:checkout.value
    });

    let guests = JSON.stringify({
        adults:adults.value,
        children:children.value
    });

    let facility_list = {facilities:[]};

    document.querySelectorAll('[name="facilities"]:checked').forEach(el=>{
        facility_list.facilities.push(el.value);
    });

    facility_list = JSON.stringify(facility_list);

    let xhr = new XMLHttpRequest();
    xhr.open("GET","ajax/rooms.php?fetch_rooms&chk_avail="+chk_avail+"&guests="+guests+"&facility_list="+facility_list,true);

    xhr.onprogress = function(){
        rooms_data.innerHTML = "<div class='error'>Loading...</div>";
    }

    xhr.onload = function(){
        rooms_data.innerHTML = this.responseText;
    }

    xhr.send();
}

window.onload = fetch_rooms;

checkin.addEventListener('change', fetch_rooms);
checkout.addEventListener('change', fetch_rooms);
adults.addEventListener('input', fetch_rooms);
children.addEventListener('input', fetch_rooms);

document.querySelectorAll('[name="facilities"]').forEach(checkbox => {
    checkbox.addEventListener('change', fetch_rooms);
});

function checkLoginToBook(status, room_id) {
    if (status) {
        window.location.href = 'confirm_booking.php?id=' + room_id;
    } else {
        openModal('loginModal');
    }
}
</script>

<?php require('inc/footer.php'); ?>

</body>
</html>