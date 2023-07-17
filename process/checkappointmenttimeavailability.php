<?php
include "../included/db_connection.php";

$date = $_POST['date'];

//GET THE APPOINTMENT TIME OF ALL PATIENTS IN THE GIVEN DATE
$sql = " SELECT * from `appointment` WHERE appointdate = '$date'  ";
$getappointtime = mysqli_query($conn,$sql);
$appointtimearray = array();

// NOTE: NEW VARIABLE
$appointtime = array();
$x = 0;

if(mysqli_num_rows($getappointtime) > 0){
  while($appointment = mysqli_fetch_assoc($getappointtime) ){

    // NOTE: NEW VARIABLE
    //$appointtime[] = array($appointment['appointtime'], $appointment['status']);
    //$appointtime[x][] = $appointment['status'];
    //$x++;
    array_push($appointtimearray, array($appointment['appointtime'], $appointment['status']));




    //$appointtime = $appointment['appointtime'];
    //array_push($appointtimearray, $appointtime); //STORE THE TIME ID IN AN ARRAY
  }
}

//GET ALL THE APPOINTMENT TIME IN THE APPOINTMENT SCHEDULE TABLE
$format = "%h:%i %p";
$sql = "SELECT TIME_FORMAT(starttime, '$format') as starttime, TIME_FORMAT(endtime, '$format') as endtime, appointschedid FROM `appointment_schedule`";
$getappointtime = mysqli_query($conn,$sql);
$availableappointmenttimearray = array();
//$availableappointmenttimearray[];

if(mysqli_num_rows($getappointtime) > 0){
  while($appointment = mysqli_fetch_assoc($getappointtime) ){
    $appointschedid = $appointment['appointschedid'];
    $starttime = $appointment['starttime'];
    $endtime = $appointment['endtime'];
    $concatenatesched = $starttime." - ".$endtime;

    // NOTE: NEW CONDITION AND VARIABLES
    $arraysIterated = 0;

    foreach ($appointtimearray as $arr) {
      if ($arr[0] == $appointschedid) {
        if ($arr[1] == "cancelled") {
          $temparray = array('appointschedid' => $appointschedid , 'time' => $concatenatesched );
          array_push($availableappointmenttimearray, $temparray);
          break;
        }
        if ($arr[1] == "confirmed" || $arr[1] == "treated" || $arr[1] == "pending") {
          break;
        }
      }

      $arraysIterated++;
      if ($arraysIterated == count($appointtimearray)) {
        $temparray = array('appointschedid' => $appointschedid , 'time' => $concatenatesched );
        array_push($availableappointmenttimearray, $temparray);
      }

    }


/*
    //ITERATE THROUGH THE PREVIOUS ARRAY AND CHECK IF APPOINTSCHEDID HAS A DUPLICATE
    for ($i=0; $i < count($appointtimearray) ; $i++) {

      //IF A DUPLICATE HAS BEEN FOUND, THEN DONT ADD APPOINTSCHEDID INTO THE AVAILABLE APPOINTMENT TIME ARRAY
      if ($appointtimearray[$i] == $appointschedid) {
        break;
      }

      //IF THE PREVIOUS ARRAY DOES NOT CONTAIN A DUPLICATE OF APPOINTSCHEDID, ADD APPOINTSCHEDID INTO THE AVAILABLE APPOINTMENT TIME ARRAY
      if ($i == (count($appointtimearray) - 1)) {
        $temparray = array('appointschedid' => $appointschedid , 'time' => $concatenatesched );
        //array_push($availableappointmenttimearray, $appointschedid);
        array_push($availableappointmenttimearray, $temparray);
      }
    }
*/
    //IF NO APPOINTMENTS HAVE BEEN MADE IN THE GIVEN DATE
    if (count($appointtimearray) == 0) {
      $temparray = array('appointschedid' => $appointschedid , 'time' => $concatenatesched );
      //array_push($availableappointmenttimearray, $appointschedid);
      array_push($availableappointmenttimearray, $temparray);
    }

  }
}

echo json_encode($availableappointmenttimearray);
 ?>
