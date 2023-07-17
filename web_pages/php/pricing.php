<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css">
    <title>Prices</title>
  </head>
  <body>
	<h1>Prices</h1><br>
	<div class="main">
		<?php

		$sql = "SELECT * FROM service ";
		$res = mysqli_query($conn, $sql);

		if(mysqli_num_rows($res) > 0){
		while($service = mysqli_fetch_assoc($res)){
			$servname = $service['servname'];
			$servimage = $service['servimage'];
			$servdesc = $service['servdesc'];
			$price = $service['price'];
			$pertooth = $service['pertooth']; ?>
			<div class="prcontainer">
				<div class="box-overlay3">
					<h2><?=$servname?></h2>

					<?php
						echo '&nbsp;' . $price;
						if ($pertooth == "yes") {
							echo " /tooth";
						}
					?>
					<br>
					<a href="scheduleappointment.php"><button class="btn1" type="button" name="button">Book Appointment Now</button></a>
				</div>
			</div>

			<?php }
				}
			?>
		</div>
  </body>
</html>
