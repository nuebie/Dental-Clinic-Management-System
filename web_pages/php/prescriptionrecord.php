<?php
include_once "../../included/db_connection.php";
include_once "../../included/session.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css">
    <title></title>
  </head>
  <body>
	<h1>Account</h1><br>
	<div class="main">
	<h2>Prescription Record</h2>
    <table>
      <tr>
        <th>Dentist</th>
        <th>Date</th>
        <th>Medicine</th>
      </tr>

    <?php

    $sql = "SELECT * FROM prescription WHERE patientid = '$userid' ORDER BY presid DESC";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) > 0){
      while($prescription = mysqli_fetch_assoc($res)){
        $presid = $prescription['presid'];
        $dentistid = $prescription['dentistid'];
        $date = $prescription['date'];
        $med = $prescription['med'];

        //FETCH DENTIST FULL NAME
        $sql = "SELECT * FROM user where userid = '$dentistid' ";
        $userres = mysqli_query($conn,$sql);

        if(mysqli_num_rows($userres) > 0){

        while($user = mysqli_fetch_assoc($userres)){
          $fname = $user['fname'];
          $lname = $user['lname'];
          $dentistfullname = $fname." ".$lname;
        }
      }
        ?>

      <tr>
        <td><?= $dentistfullname?></td>
        <td><?= $date?></td>
        <td><?= $med?></td>
      </tr>

      <?php }
    }
     ?>
	 </div>
  </body>
</html>
