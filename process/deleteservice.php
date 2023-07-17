<?php
include "../included/db_connection.php";

if(isset($_POST['servid']))
{

  $servid = $_POST['servid'];

  //GET SERVICE IMAGE FOR DELETION
  $sql = "SELECT * FROM service WHERE servid='$servid'";
  $res = mysqli_query($conn,$sql);

  if(mysqli_num_rows($res) > 0){

    while($service = mysqli_fetch_assoc($res)){
      $servimage = $service['servimage'];
    }
  }

  $sql = "DELETE FROM `service` WHERE servid = '$servid'";
  $res = mysqli_query($conn, $sql);


  //CHECK IF SERVICE RECORD HAS BEEN DELETED
  echo mysqli_affected_rows($conn);

  //REMOVE IMAGE FROM THE FOLDER
  if(mysqli_affected_rows($conn) == 1){
    $path = "../service_images/$servimage";
    unlink($path);
  }

}
