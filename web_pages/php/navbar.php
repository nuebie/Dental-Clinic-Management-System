<?php
include_once "../../included/db_connection.php";
include_once "../../included/session.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/navbar.css">
    <title></title>

  </head>
  <body>
		<div class="topnav">
			<a id="logo" href="index.php"><img id="logo" src="../../web_pages/logo.png"></a>
			<a href="index.php">Home</a>
			<div class="dropdown">
				<button class="dropbtn"><a href="services.php">Services</a></button>
					<div class="dropdown-content">
					<?php
						//FETCH DENTAL SERVICES
						$sql = "SELECT * FROM service ";
						$res = mysqli_query($conn, $sql);

						if(mysqli_num_rows($res) > 0){
						while($service = mysqli_fetch_assoc($res)){
							$servid = $service['servid'];
							$servname = $service['servname']; ?>


							<form class="frm_subcatname" action="servicedetail.php" method="get" id="<?="frm".$servname;?>">
								<input type="hidden" name="servid" value="<?=$servid?>">
								<input type="hidden" name="servname" value="<?=$servname?>">
								<a class="drpa" onclick="servfrm('<?=$servname?>')"><?php echo $servname ?></a>
							</form>


						<?php }
						}?>
						</div>
			</div>
			<a href="pricing.php">Pricing</a>
			<a href="scheduleappointment.php">Schedule Appointment</a>
			<div class="topnav-right">
				<?php
					//IF USER IS NOT LOGGED IN
					if (!isset($_SESSION['userid'])) {
					        echo '<a href="login.php">Login</a>
					              <a class="hglt" href="signup.php">Signup</a>';
					      }

			      else {
 					        $userid = $_SESSION['userid'];

					        //CHECK IF USER TYPE/ROLE
					        $sql = "SELECT * FROM user where userid = '$userid' and (role = 'staff' OR role = 'dentist')";
					        $res = mysqli_query($conn, $sql);

					        //IF USER IS A STAFF OR DENTIST
					        if(mysqli_num_rows($res) != 0){
					          while($user = mysqli_fetch_assoc($res)){
					            $role = $user['role'];

					            //IF USER IS A STAFF
					            if ($role == "staff") {
					              echo '<div class="dropdown">
										<button class="dropbtn"><a href="#">Account</a></button>
					                        <div class="dropdown-content">
                                  <a href="appointmentrecord.php">Appointments</a>
                                  <a href="treatmentrecord.php">Treatments</a>
                                  <a href="prescriptionrecord.php">Prescriptions</a>
          												<a href="dentistdashboard.php">Dasboard</a>
                                  <a href="accountsettings.php">Settings</a>
											</div>
										</div>
					                          <form class="frmlogout" action="../../included/session.php" method="post" id="logoutfrm">
					                            <input type="hidden" name="logout" value="logout">
					                            <a class="hglt" onclick="frmsubmit()">Logout</a>
					                          </form>';
					            }

					            //IF USER IS A DENTIST
					            elseif ($role == "dentist") {
					              echo '<div class="dropdown">
										<button class="dropbtn"><a href="#">Account</a></button>
											<div class="dropdown-content">
                        <a href="appointmentrecord.php">Appointments</a>
                        <a href="treatmentrecord.php">Treatments</a>
                        <a href="prescriptionrecord.php">Prescriptions</a>
												<a href="dentistdashboard.php">Dasboard</a>
                        <a href="accountsettings.php">Settings</a>
											</div>
										</div>
					                          <form class="frmlogout" action="../../included/session.php" method="post" id="logoutfrm">
					                            <input type="hidden" name="logout" value="logout">
												<a class="hglt" onclick="frmsubmit()">Logout</a>
					                        </form>';
					            }
					          }
					        }

					        //IF USER IS A REGULAR USER
					        else {
					          echo '<div class="dropdown">
									<button class="dropbtn">Account</button>
					                    <div class="dropdown-content">
											<a href="appointmentrecord.php">Appointments</a>
											<a href="treatmentrecord.php">Treatments</a>
											<a href="prescriptionrecord.php">Prescriptions</a>
                      <a href="accountsettings.php">Settings</a>
										</div>
									</div>
					                      <form class="frmlogout" action="../../included/session.php" method="post" id="logoutfrm">
					                        <input type="hidden" name="logout" value="logout">
					                        <a class="hglt" onclick="frmsubmit()">Logout</a>
					                      </form>';
					        }
					      }
					       ?>
						</div>
		</div>
  </body>
</html>

<script type="text/javascript">

  function frmsubmit(){
    document.getElementById("logoutfrm").submit();
  }

  function servfrm(serv){
    let str = "frm";
    document.getElementById(str.concat(serv)).submit();
  }

</script>
