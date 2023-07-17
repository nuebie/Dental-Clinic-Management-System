<?php
include "../included/db_connection.php";

if(isset($_POST['serv_name']) && isset($_POST['price'])  && isset($_POST['serv_description'])
){
  //REQUIRED ATTRIBUTES OF IMAGE FILE
  $img_name = $_FILES['serv_image']['name'];
  $img_size = $_FILES['serv_image']['size'];
  $tmp_name = $_FILES['serv_image']['tmp_name'];
  $error = $_FILES['serv_image']['error'];



  //SERVICE DETAILS
  $serv_name =  strtoupper($_POST['serv_name']);
  $price = $_POST['price'];
  $serv_description = $_POST['serv_description'];

  if (isset($_POST['pertooth'])) {
    $pertooth = "yes";
  }
  else {
    $pertooth = "no";
  }


  //IF FORM IS INCOMPLETE
  if (empty($serv_name) || $price == ""  || empty($serv_description) || empty($_FILES['serv_image']['name']) || empty($pertooth)) {
    echo "FILL IN ALL REQUIRED FIELDS";
  }

  //IF FORM IS COMPLETE
  else {

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

          //INSERT INTO SERVICE TABLE

          $sql = "INSERT INTO `service`(`servimage`, `servname`, `price`, `servdesc`, `pertooth`) VALUES ('$new_img_name','$serv_name','$price','$serv_description','$pertooth')";
          mysqli_query($conn, $sql);
          echo "SUCCESS";
        }

        //IF FILE EXTENSION IS INVALID
        else {
          echo "FILE TYPE NOT SUPPORTED. UPLOAD ANOTHER FILE.";
        }


      }



    else{
      echo "INVALID INPUT. MAKE SURE ALL INPUTS ARE VALID";
    }




  }



}


?>
