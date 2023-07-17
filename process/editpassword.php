<?php
include "../included/db_connection.php";
include_once "../included/session.php";
$userid =  $_SESSION['userid'];

if (isset($_POST['current_pword']) && isset($_POST['new_pword'])) {

  $current_pword = $_POST['current_pword'];
  $new_pword = $_POST['new_pword'];
  
  //GET HASH PASSWORD OF USER
  $sql = "SELECT * FROM user where userid = '$userid'";
  $res =mysqli_query($conn, $sql);

  if(mysqli_num_rows($res) > 0){
    while ($user = mysqli_fetch_assoc($res)) {
      $hashpword = $user['password'];
    }
  }

  //IF FORM IS INCOMPLETE
  if (empty($current_pword) || empty($new_pword)) {
    echo "FILL IN THE MISSING FIELDS";
  }

  //IF FORM IS COMPLETE
  else {

  //IF THE HASHED PASSWORD IS VERIFIED TO BE TRUE
  if (password_verify($current_pword,$hashpword)) {
      $new_hashpword = password_hash($new_pword, PASSWORD_DEFAULT);

      $sql = "UPDATE `user` SET `password`='$new_hashpword' WHERE userid = '$userid'";
      $res =mysqli_query($conn, $sql);
    }

  //IF THE HASHED PASSWORD IS AND INPUTTED PASSWORD DOES NOT MATCH
    else {
      echo "PASSWORD DOES NOT MATCH. TRY AGAIN.";
    }
  }
}
 ?>
