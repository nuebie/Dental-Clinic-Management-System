<?php
include "../included/db_connection.php";
include_once "../included/session.php";
$userid =  $_SESSION['userid'];

//PRESCRIPTION DETAILS
$presid = $_POST['presid'];
$med =  $_POST['med'];

//ERROR HANDLING VARIABLE
$x=0;


//IF FORM IS INCOMPLETE
if(empty($presid) || empty($med))
{
  $x=0;
}

//IF FORM IS COMPLETE
else {
  $sql = "UPDATE `prescription` SET `med`='$med',`dentistid`='$userid' WHERE presid = '$presid'";
  mysqli_query($conn, $sql);
  $x=1;
}

if ($x == 0) {
  echo "INCOMPLETE OR INVALID INPUT. TRY AGAIN.";
}

if ($x == 1) {
  echo "SUCCESS";
}
 ?>
