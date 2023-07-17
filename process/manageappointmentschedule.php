<?php
include "../included/db_connection.php";

if (isset($_POST['starttime']) && isset($_POST['endtime'])) {
  $starttime = $_POST['starttime'];
  $endtime = $_POST['endtime'];


  //INSERT INTO APPOINTMENT SCHEDULE TABLE
   $sql = "INSERT INTO `appointment_schedule`(`starttime`, `endtime`) VALUES ('$starttime','$endtime')";
   mysqli_query($conn, $sql);

   header("Location: ../web_pages/php/appointmentschedule.php");
}
 ?>
