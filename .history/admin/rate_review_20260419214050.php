<?php
  require('inc/essentials.php');
  require('inc/db_config.php');
  adminLogin();

  if(isset($_GET['seen']))
  {
    $frm_data = filteration($_GET);

    if($frm_data['seen']=='all'){
      $q = "UPDATE `rating_review` SET `seen`=?";
      $values = [1];
      if(update($q,$values,'i')){
        alert('success','Đã xem tất cả đánh giá!');
      }
      else{
        alert('error','Thao tác thất bại!');
      }
    }
    else{
      $q = "UPDATE `rating_review` SET `seen`=? WHERE `sr_no`=?";
      $values = [1,$frm_data['seen']];
      if(update($q,$values,'ii')){
        alert('success','Đã xem đánh giá!');
      }
      else{
        alert('error','Thao tác thất bại!');
      }
    }
  }

  if(isset($_GET['del']))
  {
    $frm_data = filteration($_GET);

    if($frm_data['del']=='all'){
      $q = "DELETE FROM `rating_review`";
      if(delete($q, [], '')){
        alert('success','Đã xoá tất cả đánh giá!');
      }
      else{
        alert('error','Thao tác thất bại!');
      }
    }
    else{
      $q = "DELETE FROM `rating_review` WHERE `sr_no`=?";
      $values = [$frm_data['del']];
      if(delete($q,$values,'i')){
        alert('success','Đã xoá đánh giá!');
      }
      else{
        alert('error','Thao tác thất bại!');
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý - Đánh giá</title>
    <?php require('inc/links.php'); ?>

    <style>
    body {
        background-color: #f8f9fa;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    #main-content {
        width: 100%;
    }

    .row {
        display: flex;
    }

    .col-lg-10 {
        width: 83.3333%;
        margin-left: auto;
        padding: 24px;
        overflow: hidden;
    }

    h3 {
        margin-bottom: 16px;
    }

    .card {
        background: #fff;
        border-radius: 8px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .text-end {
        text-align: right;
        margin-bottom: 16px;
    }

    .btn {
        padding: 6px 12px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 12px;
        display: inline-block;
        margin-left: 5px;
    }

    .btn-dark {
        background-color: #343a40;
        color: #fff;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 12px;
    }

    .table-responsive-md {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    thead tr {
        background-color: #343a40;
        color: #fff;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }
    </style>
</head>

<body>

    <?php require('inc/header.php'); ?>

    <div id="main-content">
        <div class="row">
            <div class="col-lg-10">
                <h3>Đánh giá</h3>

                <div class="card">
                    <div class="card-body">

                        <div class="text-end">
                            <a href="?seen=all" class="btn btn-dark">Đã xem tất cả</a>
                            <a href="?del=all" class="btn btn-danger">Xoá tất cả</a>
                        </div>

                        <div class="table-responsive-md">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Room Name</th>
                                        <th>User Name</th>
                                        <th>Rating</th>
                                        <th style="width:30%">Review</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                    $q = "SELECT rr.*,uc.name AS uname, r.name AS rname FROM `rating_review` rr
                      INNER JOIN `user_cred` uc ON rr.user_id = uc.id
                      INNER JOIN `rooms` r ON rr.room_id = r.id
                      ORDER BY `sr_no` DESC";

                    $data = select($q, [], '');
                    $i=1;

                    while($row = mysqli_fetch_assoc($data))
                    {
                      $date = date('d-m-Y',strtotime($row['datentime']));

                      $seen='';
                      if($row['seen']!=1){
                        $seen = "<a href='?seen=$row[sr_no]' class='btn btn-primary'>Mark as read</a><br>";
                      }
                      $seen.="<a href='?del=$row[sr_no]' class='btn btn-danger'>Delete</a>";

                      echo<<<query
                        <tr>
                          <td>$i</td>
                          <td>$row[rname]</td>
                          <td>$row[uname]</td>
                          <td>$row[rating]</td>
                          <td>$row[review]</td>
                          <td>$date</td>
                          <td>$seen</td>
                        </tr>
                      query;
                      $i++;
                    }
                  ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

</body>

</html>