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
      <div style="width:300px; display:inline-block; margin:10px;">
        <div style="position:relative; border-radius:10px; overflow:hidden; background:black;">
          
          <img src="$path$row[image]" 
              style="width:100%; height:200px; object-fit:cover;">

          <div style="position:absolute; top:10px; right:10px;">
            <button onclick="rem_image($row[sr_no])"
                    style="background:red; color:white; border:none; padding:6px 10px; border-radius:5px; cursor:pointer;">
              Xoá
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