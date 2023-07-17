<?php
include_once "../../included/db_connection.php";
include_once "../../included/session.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css">
    <title></title>
  </head>
  <body>
	<h1>Account</h1><br>
	<div class="main">
		<h2>Treatment Record</h2>
		<table>
			<tr>
				<th class="date">Date Visit</th>
				<th class="teethn">Teeth #</th>
				<th class="trtmnt">Treatment</th>
				<th class="desc">Description</th>
				<th class="chrg">Charge</th>
			</tr>

		<?php

		$sql = "SELECT * FROM treatment WHERE userid = '$userid' ORDER BY treatid DESC";
		$res = mysqli_query($conn, $sql);

		if(mysqli_num_rows($res) > 0){
		while($treatment = mysqli_fetch_assoc($res)){
			$treatid = $treatment['treatid'];
			$appointid = $treatment['appointid'];
			$teethno = $treatment['teethno'];
			$treatdesc = $treatment['treatdesc'];
			$fee = $treatment['fee'];

			//FETCH APPOINTMENT DATE
			$sql = "SELECT * FROM appointment where appointid = '$appointid' ";
			$appointres = mysqli_query($conn,$sql);

			if(mysqli_num_rows($appointres) > 0){

			while($appointment = mysqli_fetch_assoc($appointres)){
				$appointdate = $appointment['appointdate'];
				$servid = $appointment['servid'];

				//FETCH APPOINTMENT SERVICE
				$sql = "SELECT * FROM service where servid = '$servid' ";
				$servres = mysqli_query($conn,$sql);

				if(mysqli_num_rows($servres) > 0){

				while($service = mysqli_fetch_assoc($servres)){
					$servname = $service['servname'];
					}
				}
			}
		}
        ?>

			<tr>
				<td class="date"><?= $appointdate?></td>
				<td class="teethn"><?= $teethno?></td>
				<td class="trtmnt"><?= $servname?></td>
				<td class="desc"><?= $treatdesc?></td>
				<td class="chrg">PHP <?= $fee?></td>
			</tr>

		<?php }
		}
		?>
		</table>
	</div>
  </body>
</html>
