<?php
include "../included/db_connection.php";

if(isset($_POST['serv']) && isset($_POST['date'])  && isset($_POST['time']) && isset($_POST['patientid']))
{

  $servid = $_POST['serv'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $patientid = $_POST['patientid'];

  if (!empty($servid) && !empty($date) && !empty($time) && !empty($patientid)) {
    $sql = "SELECT * from appointment where patientid = '$patientid' AND (status = 'pending' OR status = 'confirmed' OR (status = 'treated' AND hastreatment = 'no')) ";
    $res = mysqli_query($conn, $sql);

    //IF NO ONGOING APPOINTNENTS FOR THE GIVEN USER
    if(mysqli_num_rows($res) == 0){

      //INSERT INTO APPOINTMENT TABLE
       $sql = "INSERT INTO `appointment`(`patientid`, `servid`, `appointdate`, `appointtime`) VALUES ('$patientid','$servid','$date','$time')";
       mysqli_query($conn, $sql);
       echo "SUCCESS";
    }

    else {
      echo "PENDING APPOINTMENT AVAILABLE. CANNOT MAKE NEW APPOINTMENT";
    }
  }

  else {
    echo "INCOMPLETE FORM. TRY AGAIN.";
  }

}
 ?>
