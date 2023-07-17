<?php
include "../included/db_connection.php";

//TREATMENT DETAILS
$treatid = $_POST['treatid'];
$teethno =  $_POST['teethno'];
$treatdesc = $_POST['treatdesc'];
$fee = $_POST['fee'];

//ERROR HANDLING VARIABLE
$x=0;


//IF FORM IS INCOMPLETE
if(empty($teethno) || $fee == ""  || empty($treatdesc) || empty($treatid))
{
  $x=0;
}

//IF FORM IS COMPLETE
else {
  $sql = "UPDATE `treatment` SET `teethno`='$teethno',`treatdesc`='$treatdesc',`fee`='$fee'WHERE treatid = '$treatid'";
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
