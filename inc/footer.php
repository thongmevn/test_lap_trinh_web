<?php
if(!isset($con)){
    require_once(__DIR__ . '/../admin/inc/db_config.php');
}

$settings_q = "SELECT * FROM `settings` WHERE `sr_no`='1'";
$settings_r = mysqli_fetch_assoc(mysqli_query($con,$settings_q));

$contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`='1'";
$contact_r = mysqli_fetch_assoc(mysqli_query($con,$contact_q));
?>

<style>

/* ================= FOOTER (GIỮ NGUYÊN) ================= */
.footer-wrapper{
    background:#fff;
    margin-top:50px;
    border-top:1px solid #e5e5e5;
}

.footer-container{
    display:flex;
    flex-wrap:wrap;
    max-width:1400px;
    margin:0 auto;
}

.footer-col{
    flex:1 1 280px;
    padding:32px 24px;
}

.footer-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:15px;
    color:#111;
}

.footer-text{
    color:#555;
    line-height:1.8;
    font-size:15px;
}

.footer-link{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:12px;
    color:#222;
    text-decoration:none;
    transition:.3s;
    font-size:15px;
}

.footer-link:hover{
    color:#0d6efd;
    transform:translateX(3px);
}

.footer-icon{
    width:22px;
    height:22px;
    object-fit:contain;
}

.footer-bottom{
    text-align:center;
    background:#111;
    color:#fff;
    padding:15px;
    margin:0;
    font-size:14px;
    letter-spacing:.5px;
}

/* ================= ALERT (GIỮ NGUYÊN) ================= */
.alert{
    padding:14px 18px;
    border-radius:10px;
    margin-bottom:10px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    min-width:300px;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
    animation:fadeIn .3s ease;
}

.alert-success{background:#198754;color:#fff;}
.alert-danger{background:#dc3545;color:#fff;}

.custom-alert{
    position:fixed;
    top:20px;
    right:20px;
    z-index:99999;
}

.btn-close{
    background:none;
    border:none;
    color:#fff;
    font-size:22px;
    cursor:pointer;
    line-height:1;
}

/* ================= MODAL (GIỮ NGUYÊN) ================= */
.modal{
    position:fixed;
    inset:0;
    display:none;
    align-items:center;
    justify-content:center;
    z-index:99999;
}

.modal.show{display:flex;}

.modal-backdrop{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.55);
    z-index:9999;
}

/* ================= DROPDOWN / COLLAPSE ================= */
.dropdown-menu{display:none;}
.dropdown-menu.show{display:block;}

.collapse{display:none;}
.collapse.show{display:block;}

.active{
    color:#0d6efd !important;
    font-weight:700;
}

/* ================= PROFILE MODAL (THEO YÊU CẦU CỦA BẠN) ================= */
.profile-modal{
    position:fixed;
    inset:0;
    display:none;
    align-items:center;
    justify-content:center;
    background:rgba(0,0,0,.5);
    z-index:99999;
}

.profile-box{
    width:320px;
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.2);
    animation:fadeIn .2s ease;
}

.profile-title{
    font-size:20px;
    font-weight:bold;
    margin-bottom:15px;
}

.profile-item{
    margin-bottom:10px;
    font-size:14px;
    color:#333;
}

.profile-btn{
    margin-top:15px;
    width:100%;
    padding:8px;
    border:none;
    background:#111;
    color:#fff;
    border-radius:6px;
    cursor:pointer;
}

.profile-btn:hover{
    background:#333;
}

/* ================= ANIMATION ================= */
@keyframes fadeIn{
    from{opacity:0;transform:translateY(-10px);}
    to{opacity:1;transform:translateY(0);}
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .footer-container{
        flex-direction:column;
    }

    .footer-col{
        padding:25px 20px;
    }

    .alert{
        min-width:auto;
        width:90%;
    }
}

</style>

<!-- ================= FOOTER ================= -->
<div class="footer-wrapper">

    <div class="footer-container">

        <div class="footer-col">
            <h3 class="footer-title h-font">
                <?php echo $settings_r['site_title']; ?>
            </h3>
            <p class="footer-text">
                <?php echo $settings_r['site_about']; ?>
            </p>
        </div>

        <div class="footer-col">
            <h5 class="footer-title">Liên kết</h5>
            <a href="index.php" class="footer-link">Trang chủ</a>
            <a href="rooms.php" class="footer-link">Danh sách phòng</a>
            <a href="facilities.php" class="footer-link">Tiện ích</a>
            <a href="contact.php" class="footer-link">Liên hệ</a>
            <a href="about.php" class="footer-link">Về chúng tôi</a>
        </div>

        <div class="footer-col">
            <h5 class="footer-title">Theo dõi chúng tôi</h5>

            <?php if(!empty($contact_r['tw'])){ ?>
            <a href="<?php echo $contact_r['tw']; ?>" class="footer-link">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" class="footer-icon">
                Twitter
            </a>
            <?php } ?>

            <a href="<?php echo $contact_r['fb']; ?>" class="footer-link">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" class="footer-icon">
                Facebook
            </a>

            <a href="<?php echo $contact_r['insta']; ?>" class="footer-link">
                <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" class="footer-icon">
                Instagram
            </a>
        </div>

    </div>
</div>

<h6 class="footer-bottom">
    Đồ án môn học Lập Trình Web - QNU
</h6>

<!-- ================= PROFILE MODAL ================= -->
<?php if(isset($_SESSION['user_name'])){ ?>

<div id="profileModal" class="profile-modal">

    <div class="profile-box">

        <div class="profile-title">Hồ sơ cá nhân</div>

        <div class="profile-item">
            <b>Tên:</b> <?php echo $_SESSION['user_name']; ?>
        </div>

        <div class="profile-item">
            <b>Email:</b> <?php echo $_SESSION['user_email']; ?>
        </div>

        <button class="profile-btn" onclick="closeProfile()">Đóng</button>

    </div>

</div>

<?php } ?>

<!-- ================= SCRIPT (GIỮ NGUYÊN + THÊM PROFILE) ================= -->
<script>

function openProfile(){
    let modal = document.getElementById('profileModal');
    if(modal){
        modal.style.display='flex';
    }
}

function closeProfile(){
    let modal = document.getElementById('profileModal');
    if(modal){
        modal.style.display='none';
    }
}

document.addEventListener('click',function(e){
    let modal=document.getElementById('profileModal');

    if(modal && e.target===modal){
        modal.style.display='none';
    }
});

/* ===== CÁC FUNCTION CŨ GIỮ NGUYÊN ===== */

function alert(type, msg, position='body'){
    let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
    let wrapper = document.createElement('div');
    wrapper.innerHTML = `
      <div class="alert ${bs_class}" role="alert" style="display:flex;align-items:center;justify-content:space-between;gap:15px;">
        <span>${msg}</span>
        <button type="button" class="btn-close" onclick="this.closest('.custom-alert').remove()">&times;</button>
      </div>
    `;
    wrapper.classList.add('custom-alert');
    document.body.appendChild(wrapper);
    setTimeout(function(){ if(wrapper.parentElement) wrapper.parentElement.removeChild(wrapper); }, 3000);
}
function setActive(){/* giữ nguyên */ }
function openModalById(id){/* giữ nguyên */ }
function closeModalById(id){/* giữ nguyên */ }

</script>