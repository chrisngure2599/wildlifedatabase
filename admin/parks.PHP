<!DOCTYPE html>
<html>
<head>
<title>Parks | Wildlife Database </title>
<?php 
require '../includes/db.php';
require 'nav.php';
require_once 'gaurd.php';
 ?>	
</head>
<body>
<div class="w3-container w3-row " >
	<div class="w3-quarter" >
		<h1 align="center" class="w3-blue" >Add Park</h1>
		<form method="post" action="" enctype="multipart/form-data"  >
			<label><i>Park Name</i></label>
			<input required="" type="text" class="w3-input w3-border" name="name" autofocus="">
			<label><i>Park type</i></label>
			<select required="" class="w3-input" name="type" >
				<option value="" >--Select park type</option>
				<option>Hifadhi ya taifa</option>
				<option>Hifadhi teule</option>
				<option>Hifadhi ya mawindo</option>
				<option>Mapori ya akiba</option>
			</select>
			<br>
			<input type="submit" name="go" class="w3-input w3-border w3-green" >
		
<?php 
	if (isset($_POST['go'])) {
		//time to recieve the variable
		$name=mysqli_escape_string($db,$_POST['name']);
		$type=mysqli_escape_string($db,$_POST['type']);

		
		//the size in megabyt//and now save to the darabase
		$query=("INSERT INTO `parks`
				( `name`, `type`) VALUES 
				('$name','$type')");
			$db->query($query);
			//echo $db->error;
			//redirecting to the same page
		//	header('location:parks.php');
		
	}

?>
</form>
	</div>
	<div class="w3-rest w3-padding " >
		<h4 align="center" >Available Parks</h4>
		<?php 
		//quering the available by Default
		$query=("SELECT * FROM parks ");
		//Checking if someone wants to sort
		if (isset($_GET['st']) && isset($_GET['by']) ) {
		//For name
		if ($_GET['st']=="nm"  ) {
			if ($_GET['by']=="d") {
		$query=("SELECT * FROM parks ORDER BY name DESC ");
		}else{
			$query=("SELECT * FROM parks ORDER BY name ASC ");
		}
		}elseif ($_GET['st']=="type"  ) {//For type
			if ($_GET['by']=="d") {
			$query=("SELECT * FROM parks ORDER BY type DESC ");
			}else{
			$query=("SELECT * FROM parks ORDER BY type ASC ");
			}
			}
		}
		
		$res=$db->query($query);
		$ans=mysqli_num_rows($res);
		if ($ans==0) {
			echo "<p class='w3-center' aligned='justified' >Sorry $ans found in the database";
		}elseif ($ans>0) {
			echo "<h2 align='center'  ><b>$ans</b> Parks Found</h2>";
			//looping to  list Dar animals
			echo "<div class='w3-row-padding'>";
			?>
			<table class="w3-table w3-border" >
				<tr class="w3-centered w3-border" >
					<th>
						<a href="parks.php?st=sn" class="w3-hover-text-blue" >
							#S/N
						</a>
					</th>
					<th>
						<a 
						href="parks.php?<?php 
						//Checking which sort by type is present then reversing it
						if(isset($_GET['by'])&&$_GET['by']=='d'){
							echo "st=nm&&by=a";
						}else{
							echo "st=nm&&by=d";
						}
						 ?>"
						 class="w3-hover-text-blue" >
							Park name
						</a>
					</th>
					<th>
						<a 
						href="parks.php?<?php 
						//Checking which sort by type is present then reversing it
						if(isset($_GET['by'])&&$_GET['by']=='d'){
							echo "st=type&&by=a";
						}else{
							echo "st=type&&by=d";
						}
						 ?>"
						 class="w3-hover-text-blue" >
							Type
						</a>
					</th>
				</tr>
			<?php
			$sn=0;
			while ($data=mysqli_fetch_assoc($res)) {
				$sn++;
			    ?>
			   <tr class="w3-border" >
			   	<td>#<?php echo $sn; ?></td>
			   <td>
			    	<?php echo $data['name']; ?>
			 	</td>
			 	<td>
			 		<?php echo $data['type']; ?>
			 	</td>

			   </tr>
			    <?php
			}
				
			}
		 ?>
	</div>
</div>
</div>
</body>
</html>
