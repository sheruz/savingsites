<?php 
require_once "config.php";

if(isset($_REQUEST['updateid']) && $_REQUEST['updateid'] > 0){
  $sqlget = "SELECT * FROM  multipurposeImage WHERE id = '".$_REQUEST['updateid']."' ";
  $res = mysqli_query($dbhandle, $sqlget);
   $result = mysqli_fetch_assoc($res);
  echo json_encode($result);
  die;
}

if(isset($_REQUEST['delid']) && $_REQUEST['delid'] > 0){
  $type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
  if($type == 'category'){
    $sqlget = "DELETE FROM  multiPurFoodCategory WHERE `id`= '".$_REQUEST['delid']."' ";
  }else{
    $sqlget = "DELETE FROM  multipurposeImage WHERE `id`= '".$_REQUEST['delid']."' ";
  }
  $res = mysqli_query($dbhandle, $sqlget); 
  echo json_encode(1);
  die;
}

if(isset($_POST['type']) && ($_POST['type'] == 'newcatadd' ||$_POST['type'] == 'updatecatadd')){
  $msg = array('msg' => 'something went wrong', 'type' => 'warning');
  
  if($_POST['type'] == 'updatecatadd'){
    $sqlget = "UPDATE  multiPurFoodCategory SET `foodCategoryName` = '".$_POST['catname']."' WHERE `id`= '".$_POST['catid']."' ";
    $res = mysqli_query($dbhandle, $sqlget); 
    $msg = array('msg' => 'Category Updated Successfully', 'type' => 'success');
  
  }else{
    $sqlget = "INSERT INTO  multiPurFoodCategory (`foodCategoryName`) VALUES ('".$_POST['newcat']."')";
    $res = mysqli_query($dbhandle, $sqlget); 
    $msg = array('msg' => 'Category Inserted Successfully', 'type' => 'success');  
  }
  
  echo json_encode($msg);
  die; 
}

if(isset($_REQUEST['fetch']) && $_REQUEST['fetch'] == 'category'){
  $dataArr = [];
  $sqlget = "SELECT * FROM  multiPurFoodCategory";
  $res = mysqli_query($dbhandle, $sqlget);
  while($r=mysqli_fetch_array($res)){
    $dataArr[] = ['id' => $r['id'],'foodCategoryName'=> $r['foodCategoryName']];
  }
  echo json_encode($dataArr);
  die;
}

if(isset($_REQUEST['fetch']) && $_REQUEST['fetch'] == 'image'){
  $dataArr = $datacatArr = [];
  $sqlget = "SELECT * FROM  multipurposeImage";
  $res = mysqli_query($dbhandle, $sqlget);
  while($r=mysqli_fetch_array($res)){
    $dataArr[] = ['id' => $r['id'],'category'=> $r['category'],'image' => $r['image']];
  }

  $sqlgetcat = "SELECT * FROM  multiPurFoodCategory";
  $rescat = mysqli_query($dbhandle, $sqlgetcat);
  while($rs=mysqli_fetch_array($rescat)){
    $datacatArr[$rs['id']] = $rs['foodCategoryName'];
  }
  foreach ($dataArr as $k => $v) {
    $dataArr[$k]['catname'] = isset($datacatArr[$v['category']])?$datacatArr[$v['category']]:'';
  }
  echo json_encode($dataArr);
  die;
}
  
if(isset($_REQUEST['insertImage']) && $_REQUEST['insertImage'] == 1){
  $category = $_POST['category']; 
  foreach ($_FILES['image']['name'] as $k => $v) {
    $uploaded_file = $_FILES['image']['tmp_name'][$k]; 
    $size = getimagesize($uploaded_file);
    if($size[0] < 700 && $size[1] <= 395){
      echo json_encode(['msg' => 'Image resolution must be 700x395','type' => 'error']);
      die;
    }
  }
  foreach ($_FILES['image']['name'] as $k => $v) {
    $filename = $v;
    $uploaded_file = $_FILES['image']['tmp_name'][$k];
    $img_ext = pathinfo($v, PATHINFO_EXTENSION);
    $folder_path = "/home/savingssites/public_html/assets/CommonImages/";
    $folder_path1 = "/home/savingssites/public_html/assets/CommonImages/demo/";
    $size = getimagesize($uploaded_file);
    $ratio = $size[0] / $size[1];
    $dst_y = 0;
    $dst_x = 0;
    if ($ratio > 1) {
      $width = 700;
      // $height = 395 / $ratio;
      $height = 395;
      $dst_y = (395 - $height) / 2;
    } else {
      $width = 700 * $ratio;
      $height = 395;
      $dst_x = (700 - $width) / 2;
    }
    $src = imagecreatefromstring(file_get_contents($uploaded_file));
    $dst = imagecreatetruecolor($width, $height);
           imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
           imagejpeg($dst, $folder_path. $filename);
    if(move_uploaded_file($uploaded_file, $folder_path1.$v)){
      $sql = "INSERT INTO multipurposeImage (`image`,`category`) VALUES ('$filename','$category')";
      mysqli_query($dbhandle, $sql);
      echo json_encode(['msg' => 'Image Uploaded Successfully','type' => 'success']);
      die;
    }
  }
}






if(isset($_REQUEST['updateImage']) && $_REQUEST['updateImage'] == 1){
  if(isset($_REQUEST['imageID']) && $_REQUEST['imageID'] > 0){
    $sql = "UPDATE multipurposeImage SET `category` ='".$_REQUEST['category']."' WHERE id='".$_REQUEST['imageID']."' ";
    mysqli_query($dbhandle, $sql);
  }  
  if(isset($_FILES['image']['name'])){
    foreach ($_FILES['image']['name'] as $k => $v) {
      $uploaded_file = $_FILES['image']['tmp_name'][$k];
      $size = getimagesize($uploaded_file);
      if($size[0] < 700 && $size[1] <= 395){
        echo json_encode(['msg' => 'Image resolution must be 700x395','type' => 'error']);
        die;
      }
    }
    foreach ($_FILES['image']['name'] as $k => $v) {
      $filename = $v;
      $uploaded_file = $_FILES['image']['tmp_name'][$k];
      $img_ext = pathinfo($v, PATHINFO_EXTENSION);
      $folder_path = "/home/savingssites/public_html/assets/CommonImages/";
      $folder_path1 = "/home/savingssites/public_html/assets/CommonImages/demo/";
      $size = getimagesize($uploaded_file);
      $ratio = $size[0] / $size[1];
      $dst_y = 0;
      $dst_x = 0;
      if ($ratio > 1) {
        $width = 700;
        // $height = 395 / $ratio;
        $height = 395;
        $dst_y = (395 - $height) / 2;
      } else {
        $width = 700 * $ratio;
        $height = 395;
        $dst_x = (700 - $width) / 2;
      }
      $src = imagecreatefromstring(file_get_contents($uploaded_file));
      $dst = imagecreatetruecolor($width, $height);
             imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
             imagejpeg($dst, $folder_path. $filename);
      if(move_uploaded_file($uploaded_file,$folder_path1.$v)){
        $sql = "UPDATE multipurposeImage SET `image` ='".$filename."' WHERE id='".$_REQUEST['imageID']."' ";
        mysqli_query($dbhandle, $sql);
        echo json_encode(['msg' => 'Image Updated Successfully','type' => 'success']);
      die;
      }
    }  
  }
}











// }




?>