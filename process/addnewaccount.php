<?php
include "../included/db_connection.php";
include "../included/session.php";

//IF THE SIGN UP FORM IS COMPLETE
if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['email'])
    && isset($_POST['contact_num']) && isset($_POST['password']) && isset($_POST['gender'])  && isset($_POST['birthdate'])){

      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $uname = $_POST['username'];
      $email = $_POST['email'];
      $contact_num = $_POST['contact_num'];
      $pword = $_POST['password'];
      $gender = $_POST['gender'];
      $birthdate = strtotime($_POST['birthdate']);
      $birthdate = date('Y-m-d', $birthdate);

      echo $birthdate;
      echo $gender;

      //IF FORM IS INCOMPLETE
      if (empty($fname) || empty($lname) || empty($uname) || empty($email) || empty($pword) || empty($gender) || empty($birthdate)  || empty($contact_num)) {
      $error = "FILL IN ALL FIELDS IN THE FORM";
      $_SESSION['error'] = $error;
      header("Location: ../web_pages/php/signup.php");
      }

      //IF FORM IS COMPLETE
      else {

        //CHECK IF SAME USERNAME EXIST

        $sql = "SELECT * FROM user where username='$uname'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();

        //IF THERE IS A DUPLICATE USERNAME
        if($res->num_rows > 0){
          $error = "USERNAME ALREADY EXISTS. CHOOSE ANOTHER USERNAME";
          $_SESSION['error'] = $error;
          header("Location: ../web_pages/php/signup.php");
        }

        //IF NO DUPLICATE USERNAME FOUND
        else {
          //INSERT ACCOUNT DETAILS OF NEWLY CREATED ACCOUNT INTO DATABASE
          $userid = uniqid('user');
          $hashpword = password_hash($pword, PASSWORD_DEFAULT);

          $sql = "INSERT INTO `user`(`userid`, `username`, `fname`, `lname`, `email`, `password`, `gender`, `contactnum`, `birthdate`) VALUES ('$userid','$uname','$fname','$lname','$email','$hashpword','$gender','$contact_num','$birthdate')";
          mysqli_query($conn, $sql);

          header("location: ../web_pages/php/login.php");
        }
      }

    }




 ?>
