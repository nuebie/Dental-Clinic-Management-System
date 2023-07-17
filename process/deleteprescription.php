<?php
include "../included/db_connection.php";

if(isset($_POST['presid']))
{

  $presid = $_POST['presid'];


  $sql = "DELETE FROM `prescription` WHERE presid = '$presid'";
  $res = mysqli_query($conn, $sql);


  //CHECK IF SERVICE RECORD HAS BEEN DELETED
  echo mysqli_affected_rows($conn);


}
 ?>
