<?php 

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

  if(isset($_POST['get_users']))
  {
    $res = selectAll('user_cred');    
    $i=1;
    $path = USERS_IMG_PATH;

    $data = "";

    while($row = mysqli_fetch_assoc($res))
    {
      $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn-danger-custom'>
        🗑
      </button>";

      $verified = "<span class='badge-warning-custom'>✖</span>";

      if($row['is_verified']){
        $verified = "<span class='badge-success-custom'>✔</span>";
        $del_btn = ""; 
      }

      $status = "<button onclick='toggle_status($row[id],0)' class='btn-dark-custom'>
        active
      </button>";

      if(!$row['status']){
        $status = "<button onclick='toggle_status($row[id],1)' class='btn-danger-custom'>
          inactive
        </button>";
      }

      $date = date("d-m-Y",strtotime($row['datentime']));

      $data.="
        <tr>
          <td>$i</td>
          <td>
            <img src='$path$row[profile]' class='user-img'>
            <br>
            $row[name]
          </td>
          <td>$row[email]</td>
          <td>$row[phonenum]</td>
          <td>$row[address] | $row[pincode]</td>
          <td>$row[dob]</td>
          <td>$verified</td>
          <td>$status</td>
          <td>$date</td>
          <td>$del_btn</td>
        </tr>
      ";
      $i++;
    }

    echo "
    <style>
      .user-img {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 6px;
      }

      .badge-warning-custom {
        background: #ffc107;
        color: #000;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
      }

      .badge-success-custom {
        background: #198754;
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
      }

      .btn-danger-custom {
        background: #dc3545;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: 0.3s;
      }

      .btn-danger-custom:hover {
        background: #bb2d3b;
      }

      .btn-dark-custom {
        background: #212529;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: 0.3s;
      }

      .btn-dark-custom:hover {
        background: #1a1e21;
      }
    </style>
    ".$data;
  }

  if(isset($_POST['toggle_status']))
  {
    $frm_data = filteration($_POST);

    $q = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'],$frm_data['toggle_status']];

    if(update($q,$v,'ii')){
      echo 1;
    }
    else{
      echo 0;
    }
  }

  if(isset($_POST['remove_user']))
  {
    $frm_data = filteration($_POST);

    $res = delete("DELETE FROM `user_cred` WHERE `id`=? AND `is_verified`=?",[$frm_data['user_id'],0],'ii');

    if($res){
      echo 1;
    }
    else{
      echo 0;
    }

  }

  if(isset($_POST['search_user']))
  {
    $frm_data = filteration($_POST);

    $query = "SELECT * FROM `user_cred` WHERE `name` LIKE ?";

    $res = select($query,["%$frm_data[name]%"],'s');    
    $i=1;
    $path = USERS_IMG_PATH;

    $data = "";

    while($row = mysqli_fetch_assoc($res))
    {
      $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn-danger-custom'>
        🗑
      </button>";

      $verified = "<span class='badge-warning-custom'>✖</span>";

      if($row['is_verified']){
        $verified = "<span class='badge-success-custom'>✔</span>";
        $del_btn = ""; 
      }

      $status = "<button onclick='toggle_status($row[id],0)' class='btn-dark-custom'>
        active
      </button>";

      if(!$row['status']){
        $status = "<button onclick='toggle_status($row[id],1)' class='btn-danger-custom'>
          inactive
        </button>";
      }

      $date = date("d-m-Y",strtotime($row['datentime']));

      $data.="
        <tr>
          <td>$i</td>
          <td>
            <img src='$path$row[profile]' class='user-img'>
            <br>
            $row[name]
          </td>
          <td>$row[email]</td>
          <td>$row[phonenum]</td>
          <td>$row[address] | $row[pincode]</td>
          <td>$row[dob]</td>
          <td>$verified</td>
          <td>$status</td>
          <td>$date</td>
          <td>$del_btn</td>
        </tr>
      ";
      $i++;
    }

    echo $data;
  }

?>