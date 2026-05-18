<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/bootstrap-replacement.css">
<link rel="stylesheet" href="css/modal-collapse-replacement.css">
<link rel="stylesheet" href="css/common.css">

<?php

  session_start();
  

  require('admin/inc/db_config.php');
  require('admin/inc/essentials.php');
  
  $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
  $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
  $values = [1];
  $contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));
  $settings_r = mysqli_fetch_assoc(select($settings_q,$values,'i'));

  if($settings_r['shutdown']){
    echo<<<alertbar
      <div style="background:#dc3545;color:#fff;text-align:center;padding:10px;font-weight:bold;display:flex;align-items:center;justify-content:center;gap:8px;border-radius:4px;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        Tạm thời không hỗ trợ đặt phòng!
      </div>
    alertbar;
  }
  
?>