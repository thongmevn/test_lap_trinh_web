<?php

require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

function h($value) {
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function ensure_inventory_schema() {
  $con = $GLOBALS['con'];

  mysqli_query($con, "CREATE TABLE IF NOT EXISTS `hotel_items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(120) NOT NULL,
    `category` varchar(80) DEFAULT NULL,
    `default_charge` int(11) NOT NULL DEFAULT 0,
    `status` tinyint(4) NOT NULL DEFAULT 1,
    `datentime` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

  mysqli_query($con, "CREATE TABLE IF NOT EXISTS `booking_item_charges` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `booking_id` int(11) NOT NULL,
    `item_id` int(11) DEFAULT NULL,
    `item_name` varchar(120) NOT NULL,
    `damage_type` varchar(20) NOT NULL,
    `quantity` int(11) NOT NULL DEFAULT 1,
    `unit_charge` int(11) NOT NULL DEFAULT 0,
    `total_charge` int(11) NOT NULL DEFAULT 0,
    `note` text DEFAULT NULL,
    `payment_status` varchar(20) NOT NULL DEFAULT 'unpaid',
    `paid_at` datetime DEFAULT NULL,
    `datentime` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `booking_id` (`booking_id`),
    KEY `item_id` (`item_id`),
    CONSTRAINT `booking_item_charges_booking_fk` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`) ON DELETE CASCADE,
    CONSTRAINT `booking_item_charges_item_fk` FOREIGN KEY (`item_id`) REFERENCES `hotel_items` (`id`) ON DELETE SET NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
}

ensure_inventory_schema();

if(isset($_POST['add_item'])) {
  $frm = filteration($_POST);
  $name = $frm['name'] ?? '';
  $category = $frm['category'] ?? '';
  $default_charge = (int)($frm['default_charge'] ?? 0);

  if($name === '' || $default_charge < 0) {
    echo 0;
    exit;
  }

  $q = "INSERT INTO `hotel_items`(`name`, `category`, `default_charge`) VALUES (?,?,?)";
  echo insert($q, [$name, $category, $default_charge], 'ssi');
}

if(isset($_POST['get_item'])) {
  $frm = filteration($_POST);
  $res = select("SELECT * FROM `hotel_items` WHERE `id`=? LIMIT 1", [$frm['item_id']], 'i');
  echo json_encode(mysqli_fetch_assoc($res));
}

if(isset($_POST['update_item'])) {
  $frm = filteration($_POST);
  $default_charge = (int)($frm['default_charge'] ?? 0);

  if(($frm['name'] ?? '') === '' || $default_charge < 0) {
    echo 0;
    exit;
  }

  $q = "UPDATE `hotel_items` SET `name`=?, `category`=?, `default_charge`=? WHERE `id`=?";
  echo update($q, [$frm['name'], $frm['category'], $default_charge, $frm['item_id']], 'ssii');
}

if(isset($_POST['get_items'])) {
  $res = select("SELECT * FROM `hotel_items` ORDER BY `status` DESC, `id` DESC", [], '');
  $i = 1;
  $data = "";

  if(mysqli_num_rows($res) == 0) {
    echo "<tr><td colspan='6'>Chưa có đồ dùng nào.</td></tr>";
    exit;
  }

  while($row = mysqli_fetch_assoc($res)) {
    $status = $row['status'] == 1
      ? "<button class='btn btn-sm btn-dark' onclick='toggle_item_status($row[id],0)'>Đang dùng</button>"
      : "<button class='btn btn-sm btn-outline-dark' onclick='toggle_item_status($row[id],1)'>Tạm ẩn</button>";

    $data .= "
      <tr>
        <td>$i</td>
        <td>".h($row['name'])."</td>
        <td>".h($row['category'])."</td>
        <td>".number_format((int)$row['default_charge'])." VND</td>
        <td>$status</td>
        <td>
          <button class='btn btn-sm btn-outline-dark' onclick='edit_item($row[id])'>Sửa</button>
          <button class='btn btn-sm btn-danger' onclick='delete_item($row[id])'>Xóa</button>
        </td>
      </tr>
    ";
    $i++;
  }

  echo $data;
}

if(isset($_POST['toggle_item_status'])) {
  $frm = filteration($_POST);
  echo update("UPDATE `hotel_items` SET `status`=? WHERE `id`=?", [$frm['value'], $frm['toggle_item_status']], 'ii');
}

if(isset($_POST['delete_item'])) {
  $frm = filteration($_POST);
  $used = mysqli_fetch_assoc(select("SELECT COUNT(*) AS total FROM `booking_item_charges` WHERE `item_id`=?", [$frm['item_id']], 'i'));
  if($used['total'] > 0) {
    echo 'charge_exists';
    exit;
  }
  echo delete("DELETE FROM `hotel_items` WHERE `id`=?", [$frm['item_id']], 'i');
}

if(isset($_POST['get_item_options'])) {
  $res = select("SELECT * FROM `hotel_items` WHERE `status`=? ORDER BY `name` ASC", [1], 'i');
  $options = "<option value=''>Chọn đồ dùng</option>";
  while($row = mysqli_fetch_assoc($res)) {
    $options .= "<option value='$row[id]' data-charge='$row[default_charge]'>".h($row['name'])." - ".number_format((int)$row['default_charge'])." VND</option>";
  }
  echo $options;
}

if(isset($_POST['get_booking_options'])) {
  $search = filteration($_POST)['search'] ?? '';
  $like = "%$search%";
  $q = "SELECT bo.booking_id, bo.order_id, bd.user_name, bd.phonenum, bd.room_name, bd.room_no
    FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE bo.booking_status=? AND bo.arrival=? AND (bo.order_id LIKE ? OR bd.user_name LIKE ? OR bd.phonenum LIKE ? OR bd.room_no LIKE ?)
    ORDER BY bo.booking_id DESC LIMIT 40";
  $res = select($q, ['booked', 1, $like, $like, $like, $like], 'sissss');
  $options = "<option value=''>Chọn booking đã nhận phòng</option>";
  while($row = mysqli_fetch_assoc($res)) {
    $label = $row['order_id']." - ".$row['user_name']." - ".$row['room_name'];
    if($row['room_no'] != '') {
      $label .= " (P. ".$row['room_no'].")";
    }
    $options .= "<option value='$row[booking_id]'>".h($label)."</option>";
  }
  echo $options;
}

if(isset($_POST['add_charge'])) {
  $frm = filteration($_POST);
  $booking_id = (int)($frm['booking_id'] ?? 0);
  $item_id = (int)($frm['item_id'] ?? 0);
  $quantity = max(1, (int)($frm['quantity'] ?? 1));
  $unit_charge = max(0, (int)($frm['unit_charge'] ?? 0));
  $damage_type = in_array(($frm['damage_type'] ?? ''), ['lost', 'damaged']) ? $frm['damage_type'] : 'damaged';
  $note = $frm['note'] ?? '';

  $booking = select("SELECT booking_id FROM `booking_order` WHERE `booking_id`=? AND `booking_status`=? AND `arrival`=? LIMIT 1", [$booking_id, 'booked', 1], 'isi');
  $item = select("SELECT * FROM `hotel_items` WHERE `id`=? AND `status`=? LIMIT 1", [$item_id, 1], 'ii');

  if(mysqli_num_rows($booking) == 0 || mysqli_num_rows($item) == 0) {
    echo 0;
    exit;
  }

  $item_data = mysqli_fetch_assoc($item);
  $total = $quantity * $unit_charge;
  $q = "INSERT INTO `booking_item_charges`
    (`booking_id`, `item_id`, `item_name`, `damage_type`, `quantity`, `unit_charge`, `total_charge`, `note`)
    VALUES (?,?,?,?,?,?,?,?)";

  echo insert($q, [$booking_id, $item_id, $item_data['name'], $damage_type, $quantity, $unit_charge, $total, $note], 'iissiiis');
}

if(isset($_POST['get_charges'])) {
  $search = filteration($_POST)['search'] ?? '';
  $like = "%$search%";
  $q = "SELECT bic.*, bo.order_id, bd.user_name, bd.phonenum, bd.room_name, bd.room_no
    FROM `booking_item_charges` bic
    INNER JOIN `booking_order` bo ON bic.booking_id = bo.booking_id
    INNER JOIN `booking_details` bd ON bic.booking_id = bd.booking_id
    WHERE bo.order_id LIKE ? OR bd.user_name LIKE ? OR bd.phonenum LIKE ? OR bd.room_name LIKE ? OR bic.item_name LIKE ?
    ORDER BY bic.id DESC";
  $res = select($q, [$like, $like, $like, $like, $like], 'sssss');
  $i = 1;
  $data = "";

  if(mysqli_num_rows($res) == 0) {
    echo "<tr><td colspan='9'>Chưa có khoản bồi thường.</td></tr>";
    exit;
  }

  while($row = mysqli_fetch_assoc($res)) {
    $type = $row['damage_type'] === 'lost' ? 'Mất' : 'Hư hại';
    $status_class = $row['payment_status'] === 'paid' ? 'bg-success text-white' : ($row['payment_status'] === 'waived' ? 'bg-warning text-dark' : 'bg-danger text-white');
    $status_text = $row['payment_status'] === 'paid' ? 'Đã thu' : ($row['payment_status'] === 'waived' ? 'Miễn thu' : 'Chưa thu');

    $data .= "
      <tr>
        <td>$i</td>
        <td>
          <span class='badge bg-primary text-white'>".h($row['order_id'])."</span><br>
          <b>".h($row['user_name'])."</b><br>
          ".h($row['phonenum'])."
        </td>
        <td>".h($row['room_name'])."<br>P. ".h($row['room_no'])."</td>
        <td>".h($row['item_name'])."<br><small>$type</small></td>
        <td>$row[quantity]</td>
        <td>".number_format((int)$row['unit_charge'])." VND</td>
        <td><b>".number_format((int)$row['total_charge'])." VND</b></td>
        <td><span class='badge $status_class'>$status_text</span></td>
        <td>
          <button class='btn btn-sm btn-dark' onclick=\"set_charge_status($row[id],'paid')\">Đã thu</button>
          <button class='btn btn-sm btn-outline-dark' onclick=\"set_charge_status($row[id],'waived')\">Miễn</button>
          <button class='btn btn-sm btn-danger' onclick='delete_charge($row[id])'>Xóa</button>
        </td>
      </tr>
    ";
    $i++;
  }

  echo $data;
}

if(isset($_POST['set_charge_status'])) {
  $frm = filteration($_POST);
  $status = in_array($frm['status'], ['unpaid', 'paid', 'waived']) ? $frm['status'] : 'unpaid';
  $paid_at = $status === 'paid' ? date('Y-m-d H:i:s') : null;
  echo update("UPDATE `booking_item_charges` SET `payment_status`=?, `paid_at`=? WHERE `id`=?", [$status, $paid_at, $frm['charge_id']], 'ssi');
}

if(isset($_POST['delete_charge'])) {
  $frm = filteration($_POST);
  echo delete("DELETE FROM `booking_item_charges` WHERE `id`=?", [$frm['charge_id']], 'i');
}

?>
