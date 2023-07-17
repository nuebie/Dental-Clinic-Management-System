<?php
include "../included/db_connection.php";
include_once "../included/session.php";
$userid =  $_SESSION['userid'];

if(isset($_POST['patientid'])){
  $patientid = $_POST['patientid'];

  $sql = " SELECT * from appointment where patientid = '$patientid' AND status = 'treated' AND hastreatment = 'no' ";
  $res = mysqli_query($conn,$sql);

  if(mysqli_num_rows($res) > 0){
    while($appointment = mysqli_fetch_assoc($res) ){
      $appointid = $appointment['appointid'];
      $appointdate = $appointment['appointdate'];
      $servid = $appointment['servid'];

      $sql = " SELECT * from service where servid = '$servid' ";
      $retserv = mysqli_query($conn,$sql);

      if(mysqli_num_rows($retserv) > 0){
        while($service = mysqli_fetch_assoc($retserv) ){
          $servname = $service['servname'];

          echo 'date:<input type="text" name="appointdate" value="'.$appointdate.'"><br>';
          echo 'treatment:<input type="text" name="service" value="'.$servname.'">';
          echo '<input type="hidden" name="appointid" value="'.$appointid.'">';
        }
      }


    }
  }
}
