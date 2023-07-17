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
	<div id="background2"> </div>
	<h1>Our Services</h1>
		<div class="main">
			<p class="service">Whether you are looking for your first Denture or repairs and adjustments to your existing set, 
				we provide the services that will leave you smiling.
				<br><br>
				We understand that any reason for visiting a denture clinic can leave you feeling anxious. 
				Our expert Denturist will explain the extensive range of services we provide and ensure you are 
				feeling informed and comfortable with our services.
			</p>
			<p>Here are the services that we offer:</p>
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
								<a class="serv" onclick="servfrm('<?=$servname?>')"><?php echo $servname ?></a>
							</form>
						

						<?php }
						}?>
		</div>
	</body>
</html>