<?php
include "../included/db_connection.php";

if(isset($_POST['treatid']))
{

  $treatid = $_POST['treatid'];


  $sql = "DELETE FROM `treatment` WHERE treatid = '$treatid'";
  $res = mysqli_query($conn, $sql);


  //CHECK IF SERVICE RECORD HAS BEEN DELETED
  echo mysqli_affected_rows($conn);


}
 ?>
