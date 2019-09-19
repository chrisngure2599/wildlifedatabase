<?php 
	require '../includes/main.php';
	require '../includes/db.php';
	require 'nav.php';
	require_once 'gaurd.php';
?>	
 <!DOCTYPE html>
<html>
<head>
<title>Viewdata | Wildlife Database</title>	
	<body>
		<?php 
		//First checking the get id if isset unless we redirect
		if (isset($_GET['pid'])) {
		#post id
		$pid=$_GET['pid'];
		}elseif (empty($_GET['pid'])) {
		header('location:index.php');
		}
		$id=$_SESSION['id'];

		$query=("SELECT *,results.id as pid FROM results JOIN parks on parks.id= results.park_id where user_id=2 AND results.id=$pid ");
		$res=$db->query($query);
		$reza=$res;
		$ans=mysqli_num_rows($res);
		if ($ans==1) {
			$data=mysqli_fetch_assoc($res);
			?>
			<h1 align="center" style="font-family:sans-serif;" >Basic Information</h1>
			<table class="w3-table-all w3-striped" >
				<tr>
					<th>
						Park name
					</th>
					<th>
						Date censored
					</th>
					<th>
						Date recorded
					</th>
				</tr>
				<tr>
			<td>
	   			<i><b><?php echo $data['name']; ?></b></i>
	   		</td>
	   		<td>
	   		<?php echo $data['time']; ?>
	   	</td>
	   	
	   	
	   <td>
	   		<?php echo $data['created_at']; ?>
	   	</td>
				</tr>
			</table><br><br>
		<!--The table for the species-->
		<table class="w3-table-all w3-striped" >

			<tr>
			<th>Species name</th>
			<th>Total Female</th>
			<th>Total Male</th>
			<th>Total</th>
			</tr>
			
		
			<?php 
		$query1=
	("
		SELECT *,results.id as pid FROM results 
		JOIN parks on parks.id= results.park_id
		JOIN species on species.id= results.species_id
		where results.user_id=2   AND
		results.created_at=
		(SELECT `created_at` FROM `results` WHERE  results.id=$pid) 
	");
		$res1=$db->query($query1);
		while ($dataz=mysqli_fetch_assoc($res1)) {

		    ?>
		<tr>
				<td><?php echo $dataz['name']; ?></td>
				<td><?php echo $dataz['total_female']; ?></td>
				<td><?php echo $dataz['total_male']; ?></td>
				<td><?php echo $dataz['total']; ?></td>
			</tr>
		    <?php
		}

		}elseif ($ans==0) {
			?>
			<h1 class="w3-red" >Sorry the data is not found</h1>
			<?php
			die();
		}
		 ?>
	</body>