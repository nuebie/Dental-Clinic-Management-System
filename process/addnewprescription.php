<?php
include "../included/db_connection.php";
include_once "../included/session.php";
$userid =  $_SESSION['userid'];

if(isset($_POST['patient']) && isset($_POST['date'])  && isset($_POST['med'])){

  $patientid = $_POST['patient'];
  $date = $_POST['date'];
  $med = $_POST['med'];

  //INSERT NEW PRESCRIPTION FOR A PATIENT
  $sql = "INSERT INTO `prescription`(`dentistid`, `patientid`, `date`, `med`) VALUES ('$userid','$patientid','$date','$med')";
  mysqli_query($conn, $sql);
  echo "SUCCESS";

}

else {
  echo "INCOMPLETE FORM";
}
 ?>
