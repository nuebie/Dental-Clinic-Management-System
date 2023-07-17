<?php
include "db_connection.php";
session_start();

//IF USER IS ATTEMPTING TO LOGIN
if(isset($_POST['uname']) && isset($_POST['pword'])){

  $uname = $_POST['uname'];
  $pword = $_POST['pword'];

  $sql = "SELECT * FROM user where username = '$uname'";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $res = $stmt->get_result();

  // IF AN ACCOUNT IS FOUND
  if($res->num_rows == 1){
  while ($user = $res->fetch_assoc()) {
         $hashpword = $user['password'];

         //IF THE HASHED PASSWORD IS VERIFIED TO BE TRUE
         if(password_verify($pword,$hashpword)){
             $userid = $user['userid'];
             $_SESSION['userid'] = $userid;
             header("Location: ../web_pages/php/index.php");
         }

         //IF THE HASHED PASSWORD  AND INPUTTED PASSWORD DOES NOT MATCH
         else {
           $error = "USERNAME AND PASSWORD DO NOT MATCH. TRY AGAIN.";
           $_SESSION['error'] = $error;
           header("Location: ../web_pages/php/login.php");
         }
       }
     }

    // IF NO ACCOUNT IS FOUND
    else {
      $error = "ACCOUNT NOT FOUND. TRY AGAIN.";
      $_SESSION['error'] = $error;
      header("Location: ../web_pages/php/login.php");
    }

}

// IF USER LOGOUT OF THEIR ACCOUNT
if(isset($_POST['logout'])){
  unset($_SESSION['userid']);
  header("Location: ../web_pages/php/index.php");
}

?>
