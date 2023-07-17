<?php
include "../included/db_connection.php";

if(isset($_POST['appointschedid']))
{
  $appointschedid = $_POST['appointschedid'];


  //DELETE APPOINTMENT TIME
  $sql = " DELETE FROM `appointment_schedule` WHERE appointschedid = '$appointschedid'";
  mysqli_query($conn, $sql);

  //CHECK IF APPOINTMENT TIME RECORD HAS BEEN DELETED
  echo mysqli_affected_rows($conn);

}
