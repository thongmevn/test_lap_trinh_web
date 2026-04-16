<?php 

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();


  if(isset($_POST['add_image']))
  {
    $img_r = uploadImage($_FILES['picture'],CAROUSEL_FOLDER);

    if($img_r == 'inv_img'){
      echo $img_r;
    }
    else if($img_r == 'inv_size'){
      echo $img_r;
    }
    else if($img_r == 'upd_failed'){
      echo $img_r;
    }
    else{
      $q = "INSERT INTO `carousel`(`image`) VALUES (?)";
      $values = [$img_r];
      $res = insert($q,$values,'s');
      echo $res;
    }
  }

  if(isset($_POST['get_carousel']))
  {
    $res = selectAll('carousel');

    while($row = mysqli_fetch_assoc($res))
    {
      $path = CAROUSEL_IMG_PATH;
      echo <<<data
        <div class="col-4">
          <div class="card-custom">
            <img src="$path$row[image]" class="card-img-custom">
            <div class="card-overlay">
              <button type="button" onclick="rem_image($row[sr_no])" class="btn-delete">
                <i class="bi bi-trash"></i> Xoá
              </button>
            </div>
          </div>
        </div>
      data;
    }
  }

  if(isset($_POST['rem_image']))
  {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_image']];

    $pre_q = "SELECT * FROM `carousel` WHERE `sr_no`=?";
    $res = select($pre_q,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['image'],CAROUSEL_FOLDER)){
      $q = "DELETE FROM `carousel` WHERE `sr_no`=?";
      $res = delete($q,$values,'i');
      echo $res;
    }
    else{
      echo 0;
    }

  }

?>

<style>
/* Grid */
.col-4 {
    width: 33.33%;
    padding: 10px;
    box-sizing: border-box;
    float: left;
}

/* Card */
.card-custom {
    position: relative;
    background: #000;
    border-radius: 10px;
    overflow: hidden;
}

/* Image */
.card-img-custom {
    width: 100%;
    height: auto;
    display: block;
}

/* Overlay */
.card-overlay {
    position: absolute;
    top: 0;
    right: 0;
    padding: 10px;
}

/* Button delete */
.btn-delete {
    background: #dc3545;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    transition: 0.3s;
}

.btn-delete:hover {
    background: #bb2d3b;
}
</style>