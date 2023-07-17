<?php
include "../included/db_connection.php";

//SERVICE DETAILS
$servid = $_POST['servid'];
$serv_name =  strtoupper($_POST['serv_name']);
$price = $_POST['price'];
$serv_description = $_POST['serv_description'];

if (isset($_POST['pertooth'])) {
  $pertooth = "yes";
}
else {
  $pertooth = "no";
}

//ERROR HANDLING VARIABLE
$x=0;


//IF FORM IS INCOMPLETE
if(empty($serv_name) || $price == ""  || empty($serv_description) || empty($pertooth))
{
  $x=0;
}

//IF FORM IS COMPLETE
else {
  $sql = "UPDATE `service` SET `servname`='$serv_name',`servdesc`='$serv_description',`price`='$price',`pertooth`='$pertooth' WHERE servid = '$servid'";
  mysqli_query($conn, $sql);
  $x=1;
}



//IF NEW IMAGE FILE IS UPLOADED
if(is_uploaded_file($_FILES['serv_image']['tmp_name']) && $x == 1){
  //REQUIRED ATTRIBUTES OF IMAGE FILE
  $img_name = $_FILES['serv_image']['name'];
  $img_size = $_FILES['serv_image']['size'];
  $tmp_name = $_FILES['serv_image']['tmp_name'];
  $error = $_FILES['serv_image']['error'];

  //IF NO ERROR OR IMAGE IS SUCCESSFULLY UPLOADED
  if($error == 0){

    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION); //GET IMAGE EXTENSION
    $img_ex_lc = strtolower($img_ex); //CONVERT EXTENSION STRING TO LOWER CASE FOR UNITY

    $allowed_ex = array("jpg", "jpeg", "png"); //ALLOWED IMAGE EXTENSIONS

    //IF FILE TYPE IS OF ALLOWED EXTENSION
    if(in_array($img_ex_lc, $allowed_ex)){
      $new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc; //NEW FILE NAME OF IMAGE
      $img_path = '../service_images/'.$new_img_name; //PATH FOR THE PRODUCT IMAGES
      move_uploaded_file($tmp_name,$img_path); //STORE THE UPLOADED FILE INTO THE PATH

      //DELETE THE PREVIOUS IMAGE OF THE SERVICE FROM THE SERVICE IMAGE FOLDER
      $filename = $_POST['filename'];
      $path = "../service_images/$filename";
      unlink($path);

      //INSERT INTO SERVICE TABLE
      $sql = "UPDATE `service` SET `servimage`='$new_img_name' WHERE servid = '$servid'";
      mysqli_query($conn, $sql);
      //echo "UPLOADED NEW IMAGE";
      $x = 1;
    }

    else {
      //echo "FILE TYPE NOT SUPPORTED. UPLOAD ANOTHER FILE.";
      $x = 2;
    }
  }

}

if ($x == 0) {
  echo "INCOMPLETE OR INVALID INPUT. TRY AGAIN.";
}

if ($x == 1) {
  echo "SUCCESS";
}

if ($x == 2) {
  echo "INVALID FILE TYPE";
}



?>
