<?php 

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  date_default_timezone_set("Asia/Kolkata");
  adminLogin();

  if(isset($_POST['get_bookings']))
  {
    $frm_data = filteration($_POST);

    $limit = 2;
    $page = $frm_data['page'];
    $start = ($page-1) * $limit;

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE ((bo.booking_status='booked' AND bo.arrival=1) 
      OR (bo.booking_status='cancelled' AND bo.refund=1)
      OR (bo.booking_status='payment failed')) 
      AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      ORDER BY bo.booking_id DESC";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');
    
    $limit_query = $query ." LIMIT $start,$limit";
    $limit_res = select($limit_query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

    $total_rows = mysqli_num_rows($res);

    if($total_rows==0){
      $output = json_encode([
        "table_data"=>"<b>No Data Found!</b>",
        "pagination"=>''
      ]);
      echo $output;
      exit;
    }

    $i=$start+1;
    $table_data = "";

    while($data = mysqli_fetch_assoc($limit_res))
    {
      $date = date("d-m-Y",strtotime($data['datentime']));
      $checkin = date("d-m-Y",strtotime($data['check_in']));
      $checkout = date("d-m-Y",strtotime($data['check_out']));

      if($data['booking_status']=='booked'){
        $status_class = 'status-success';
      }
      else if($data['booking_status']=='cancelled'){
        $status_class = 'status-danger';
      }
      else{
        $status_class = 'status-warning';
      }
      
      $table_data .="
        <tr>
          <td>$i</td>
          <td>
            <span class='badge-primary-custom'>
              Order ID: $data[order_id]
            </span>
            <br>
            <b>Name:</b> $data[user_name]
            <br>
            <b>Phone No:</b> $data[phonenum]
          </td>
          <td>
            <b>Room:</b> $data[room_name]
            <br>
            <b>Price:</b> $data[price] VND
          </td>
          <td>
            <b>Amount:</b> $data[trans_amt] VND
            <br>
            <b>Date:</b> $date
          </td>
          <td>
            <span class='badge-status $status_class'>$data[booking_status]</span>
          </td>
          <td>
            <button type='button' class='btn-outline-success-custom'>
              Download
            </button>
          </td>
        </tr>
      ";

      $i++;
    }

    $pagination = "";

    if($total_rows>$limit)
    {
      $total_pages = ceil($total_rows/$limit); 

      if($page!=1){
        $pagination .="<li class='page-item'>
          <button onclick='change_page(1)' class='page-link'>First</button>
        </li>";
      }

      $disabled = ($page==1) ? "disabled" : "";
      $prev= $page-1;
      $pagination .="<li class='page-item $disabled'>
        <button onclick='change_page($prev)' class='page-link'>Prev</button>
      </li>";

      $disabled = ($page==$total_pages) ? "disabled" : "";
      $next = $page+1;
      $pagination .="<li class='page-item $disabled'>
        <button onclick='change_page($next)' class='page-link'>Next</button>
      </li>";

      if($page!=$total_pages){
        $pagination .="<li class='page-item'>
          <button onclick='change_page($total_pages)' class='page-link'>Last</button>
        </li>";
      }
    }

    $output = json_encode([
      "table_data"=>"<style>
        .badge-primary-custom {
          background: #0d6efd;
          color: #fff;
          padding: 5px 10px;
          border-radius: 5px;
          font-size: 12px;
          font-weight: bold;
        }

        .badge-status {
          padding: 4px 8px;
          border-radius: 4px;
          font-size: 12px;
          font-weight: bold;
          display: inline-block;
        }

        .status-success {
          background: #198754;
          color: #fff;
        }

        .status-danger {
          background: #dc3545;
          color: #fff;
        }

        .status-warning {
          background: #ffc107;
          color: #000;
        }

        .btn-outline-success-custom {
          border: 1px solid #198754;
          color: #198754;
          padding: 5px 10px;
          border-radius: 4px;
          background: transparent;
          cursor: pointer;
          transition: 0.3s;
        }

        .btn-outline-success-custom:hover {
          background: #198754;
          color: #fff;
        }

        .page-item {
          display: inline-block;
          margin: 2px;
        }

        .page-link {
          padding: 5px 10px;
          border: 1px solid #ddd;
          background: #fff;
          cursor: pointer;
          border-radius: 4px;
        }

        .page-link:hover {
          background: #f1f1f1;
        }

        .disabled .page-link {
          opacity: 0.5;
          cursor: not-allowed;
        }
      </style>".$table_data,
      "pagination"=>$pagination
    ]);

    echo $output;
  }

?>