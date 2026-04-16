<?php
  require('inc/essentials.php');
  require('inc/db_config.php');

  session_start();
  if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
    redirect('dashboard.php');
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <?php require('inc/links.php'); ?>

    <style>
    body {
        background-color: #f8f9fa;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .login-form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .login-form h4 {
        background-color: #343a40;
        color: #fff;
        padding: 12px;
        margin: 0;
    }

    .form-body {
        padding: 20px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: center;
        outline: none;
    }

    .form-control:focus {
        border-color: #007bff;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
        font-size: 14px;
    }

    .btn:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>

    <div class="login-form">
        <form method="POST">
            <h4>Trang Quản Lý</h4>
            <div class="form-body">
                <input name="admin_name" required type="text" class="form-control" placeholder="Tên quản trị viên">
                <input name="admin_pass" required type="password" class="form-control" placeholder="Mật khẩu">
                <button name="login" type="submit" class="btn">Đăng Nhập</button>
            </div>
        </form>
    </div>


    <?php 
    
    if(isset($_POST['login']))
    {
      $frm_data = filteration($_POST);

      $query = "SELECT * FROM  `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
      $values = [$frm_data['admin_name'],$frm_data['admin_pass']];

      $res = select($query,$values,"ss");
      if($res->num_rows==1){
        $row = mysqli_fetch_assoc($res);
        $_SESSION['adminLogin'] = true;
        $_SESSION['adminId'] = $row['sr_no'];
        redirect('dashboard.php');
      }
      else{
        alert('error','Đăng nhập thất bại!');
      }
    }
  
  ?>

    <?php require('inc/scripts.php') ?>
</body>

</html>