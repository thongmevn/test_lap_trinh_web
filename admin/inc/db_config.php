<?php

// Load environment variables from project root .env if available
$env_path = __DIR__ . '/../../.env';
if (file_exists($env_path)) {
  $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    list($name, $value) = array_map('trim', explode('=', $line, 2));
    if (!array_key_exists($name, $_ENV)) {
      putenv("{$name}={$value}");
      $_ENV[$name] = $value;
    }
  }
}

$hname = getenv('DB_HOST') ?: 'localhost';
$uname = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'quanlykhachsan';

mysqli_report(MYSQLI_REPORT_OFF);
$con = mysqli_connect($hname, $uname, $pass, $db);

if(!$con){
  die("Cannot Connect to Database".mysqli_connect_error());
}

function filteration($data) {
  foreach($data as $key => $value){
    $value = trim($value);
    $value = htmlspecialchars($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $data[$key] = $value;
  }
  return $data;
}
  
function selectAll($table) {
  $con = $GLOBALS['con'];
  $res = mysqli_query($con, "SELECT * FROM $table");
  return $res;
}
  
function select($sql, $values, $datatypes) {
  $con = $GLOBALS['con'];
  if($stmt = mysqli_prepare($con, $sql)){
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
    if(mysqli_stmt_execute($stmt)){
      $res = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
      return $res;
    }
    else{
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - Execute");
    }
  }
  else{
    die("Query cannot be executed - Select");
  }
}

function update($sql, $values, $datatypes) {
  $con = $GLOBALS['con'];
  if($stmt = mysqli_prepare($con, $sql)){
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
    if(mysqli_stmt_execute($stmt)){
      $res = mysqli_stmt_affected_rows($stmt);
      mysqli_stmt_close($stmt);
      return $res;
    }
    else{
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - Update");
    }
  }
  else{
    die("Query cannot be executed - Update");
  }
}

function insert($sql,$values,$datatypes) {
  $con = $GLOBALS['con'];
  if($stmt = mysqli_prepare($con, $sql)){
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
    if(mysqli_stmt_execute($stmt)){
      $res = mysqli_stmt_affected_rows($stmt);
      mysqli_stmt_close($stmt);
      return $res;
    }
    else{
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - Insert");
    }
  }
  else{
    die("Query cannot be executed - Insert");
  }
}

function delete($sql, $values, $datatypes) {
  $con = $GLOBALS['con'];
  if($stmt = mysqli_prepare($con, $sql)){
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
    if(mysqli_stmt_execute($stmt)){
      $res = mysqli_stmt_affected_rows($stmt);
      mysqli_stmt_close($stmt);
      return $res;
    }
    else{
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - Delete");
    }
  }
  else{
    die("Query cannot be executed - Delete");
  }
}
?>
