<?php
include "../included/db_connection.php";

if(isset($_POST['appointschedid']) && isset($_POST['starttime']) && isset($_POST['endtime']))
{
  $appointschedid = $_POST['appointschedid'];
  $starttime = $_POST['starttime'];
  $endtime = $_POST['endtime'];

  //EDIT APPOINTMENT TIME
  $sql = "UPDATE `appointment_schedule` SET `starttime`='$starttime',`endtime`='$endtime' WHERE appointschedid = '$appointschedid'";
  mysqli_query($conn, $sql);

  header("Location: ../web_pages/php/appointmentschedule.php");

}

?>
