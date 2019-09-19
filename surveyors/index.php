<?php 
	require '../includes/main.php';
	require '../includes/db.php';
	require 'nav.php';
	require_once 'gaurd.php';
?>	
 <!DOCTYPE html>
<html>
<head>
	<title>Welcome to Wildlife Database</title>
</head>
<body>
<!--
Displaying the data that the surveyor has uploaded

-->
<?php 
#The id of the user
$id=$_SESSION['id'];
  $query=("SELECT *,results.id as pid FROM results JOIN parks on parks.id= results.park_id   where user_id=$id  GROUP BY results.created_at ");
$res=$db->query($query);
$ans=mysqli_num_rows($res);
if ($ans) {
	?>
	<table class="w3-table-all w3-container w3-striped w3-hoverable" >
		<tr class="w3-border" >
			<th>
				Date Recorded
			</th>
			<th>
				Park name
			</th>
			<th colspan="2" >
				Date censorded
			</th>

		</tr>
	
	<?php
	while ($data=mysqli_fetch_assoc($res)) {
		//echo '<pre>';
		//print_r($data);
		//echo '</pre>';
		   ?>
	   <tr class="w3-border" >
	   	<td>
	   		<?php echo $data['created_at']; ?>
	   	</td>
	   	<td>
	   		<i><?php echo $data['name']; ?></i>
	   	</td>
	   	
	   <td>
	   		<?php echo $data['time']; ?>
	   	</td>
	   	<td>
	   		<a href="viewdata.php?pid=<?php echo $data['pid']?>">Viewdata</a>
	   	</td>
	   </tr>
	   <?php 
	}
}elseif ($ans==0) {
	?>
	<div>
		<h3>No Data Uploaded</h3>
	</div>
	<?php
}
 ?>
</body>
</html>