<?php
include "../included/db_connection.php";
include_once "../included/session.php";
$userid =  $_SESSION['userid'];

//USER DETAILS
$username = $_POST['username'];
$contactnum = $_POST['contactnum'];
$originalusername = $_POST['originalusername'];

if (!empty($username) && !empty($contactnum)) {

  //IF NEW USERNAME HAS BEEN INPUTTED
  if ($username != $originalusername) {

    //CHECK IF DUPLICATE USERNAME EXIST
    $sql = "SELECT * FROM user where username='$username'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();

    //IF THERE IS A DUPLICATE USERNAME
    if($res->num_rows > 0){
      echo "USERNAME ALREADY EXISTS. CHOOSE ANOTHER USERNAME";
      exit();
    }

    //IF NO DUPLICATE USERNAME
    else {
      $sql = "UPDATE `user` SET `username`='$username' WHERE userid = '$userid'";
      mysqli_query($conn, $sql);
    }
  }

    $sql = "UPDATE `user` SET `contactnum`='$contactnum' WHERE userid = '$userid'";
    mysqli_query($conn, $sql);

    echo "SUCCESS";

}

else {
  echo "INCOMPLETE FORM. TRY AGAIN.";
}

 ?>
