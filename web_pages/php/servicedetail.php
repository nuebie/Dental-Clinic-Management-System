<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css">
    <title></title>
  </head>
  <body>
	<h1>Services We Offer</h1><br>
	<div class="main">
		<?php
		$servid = $_GET['servid'];

		$sql = "SELECT * FROM service WHERE servid = '$servid' ";
		$res = mysqli_query($conn, $sql);

		if(mysqli_num_rows($res) > 0){
		while($service = mysqli_fetch_assoc($res)){
			$servname = $service['servname'];
			$servimage = $service['servimage'];
			$servdesc = $service['servdesc']; ?>

			<h2><?=$servname?></h2>
			<center><img class="servimg" src="../../service_images/<?= $servimage?>" alt=""></center><br>
			<?=$servdesc?>

		<?php }
		}
		?>
	 </div>
  </body>
</html>
