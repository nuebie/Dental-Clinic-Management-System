<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];

if (is_null($userid)) {
  header("Location: login.php");
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css">
    <title></title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

     <script type="text/javascript">
         $(document).ready(function(){

           //IF DATE HAS BEEN CHOSEN, CHECK THE TIME TO MAKE SURE NO APPOINTMENTS ARE OVERLAPPING
           $("#date").change(function(){
                var date = $(this).val();

                $.ajax({
                    url: '../../process/checkappointmenttimeavailability.php',
                    type: 'post',
                    data: {date:date},
                    dataType: 'json',
                    success:function(response){

                      //window.alert(response);
                        var len = response.length;

                        $("#time").empty();
                        $("#time").append("<option value='0'>- Select -</option>");

                        for( var i = 0; i<len; i++){
                            var appointschedid = response[i]['appointschedid'];
                            var time = response[i]['time'];

                            $("#time").append("<option id='"+appointschedid+"' value = '"+appointschedid+"'>"+time+"</option>");

                        }
                    }
                });
            });

             //SCHEDULE NEW APPOINTMENT
             $(document).on("click",'#submit',function(){
               event.preventDefault();
               var form = $('#newappointfrm')[0];
               var fd = new FormData(form);

               $.ajax({
                 type: "POST",
                 url: "../../process/addnewappointment.php",
                 data: fd,
                 processData: false,
                 contentType: false,
                 cache: false,
                 timeout: 800000,
                 success: function (data) {
                   if (data == "SUCCESS") {
                     location.reload();
                   }

                   else{
                      //$("#treatupdatevalidation").empty().append(""+data+"");
                      alert(data);
                   }
                 }
               });
             });
            });
          </script>
  </head>
  <body>
	<div id="background1"></div>
	<h1>Schedule Appointment</h1>
	</div>
  <div class="main">
	<div id="box1">
	<br>
		<form class="" id="newappointfrm" action="" method="post">

      <input type="hidden" name="patientid" value= "<?= $userid ?>">
      <h2>Choose a Service:</h2> &nbsp; <select class="service" name="serv" id="sel_serv">
        <option value="0">- Select -</option>
        <?php
        //FETCH SERVICES
        $sql_service = "SELECT * FROM service";
        $service_data = mysqli_query($conn,$sql_service);

        if(mysqli_num_rows($service_data) > 0){
          while($service = mysqli_fetch_assoc($service_data) ){
            $servname = $service['servname'];
            $servid = $service['servid'];

           // OPTION
           echo "<option value='".$servid."' >".$servname."</option>";
        }
      }
      else {
        echo "NO ROWS";
      }
         ?>
      </select>
		<br><br>
		<h2>Date and time:</h2>
      &nbsp; <input class="date" type="date" min="<?php echo date('Y-m-d'); ?>" name="date" value="" id="date">
		&nbsp;
      <span id="appointmenttimesection">
      <select class="time" name="time" id="time">
        <option value="0">- Select -</option>

        <?php
        //FETCH APPOINTMENT SCHEDULE
        $format = "%h:%i %p";
        $sql_time = " SELECT TIME_FORMAT(starttime, '$format') as starttime, TIME_FORMAT(endtime, '$format') as endtime, appointschedid FROM `appointment_schedule` ";
        $service_time = mysqli_query($conn,$sql_time);

        if(mysqli_num_rows($service_time) > 0){
          while($schedule = mysqli_fetch_assoc($service_time) ){
            $appointschedid = $schedule['appointschedid'];
            $starttime = $schedule['starttime'];
            $endtime = $schedule['endtime'];
            $concatenatesched = $starttime." - ".$endtime;

           // OPTION
           echo '<option id="'.$appointschedid.'" value = "'.$appointschedid.'">'.$concatenatesched.'</option>';
        }
      }
      else {
        echo "NO ROWS";
      }
         ?>

      </select>
      </span>
		<br><br>
      &nbsp; <input class="btn1" type="submit" id="submit" name="" value="Submit">
    </form>
	</div>
	</div>
  </body>
</html>
