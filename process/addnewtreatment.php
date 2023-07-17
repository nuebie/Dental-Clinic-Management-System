<?php
include "../included/db_connection.php";

if(isset($_POST['patient']) && isset($_POST['appointid'])  && isset($_POST['teethno']) && isset($_POST['treatdesc']) && isset($_POST['fee']))
{
  $patientid = $_POST['patient'];
  $appointid = $_POST['appointid'];
  $teethno = $_POST['teethno'];
  $treatdesc = $_POST['treatdesc'];
  $fee = $_POST['fee'];

  //INSERT NEW TREATMENT RECORD
  $sql = " INSERT INTO `treatment`(`userid`, `appointid`, `teethno`, `treatdesc`, `fee`) VALUES ('$patientid','$appointid','$teethno','$treatdesc','$fee') ";
  mysqli_query($conn, $sql);

  //UPDATE THE HASTREATMENT OF THE GIVEN APPOINTMENT TO "YES"
  $sql = "UPDATE `appointment` SET `hastreatment`='yes' WHERE appointid = '$appointid'";
  mysqli_query($conn, $sql);

  //CHECK IF SERVICE RECORD HAS BEEN DELETED
  echo "SUCCESS";
}
