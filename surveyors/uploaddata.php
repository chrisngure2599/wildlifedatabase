<?php 
	require '../includes/main.php';
	require '../includes/db.php';
	require 'nav.php';
	require_once 'gaurd.php';
?>	
 <!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="upload.js" ></script>
	<title>Upload data | Wildlife Database</title>
</head>
<body>
<?php if (empty($_GET['parkid']) && empty($_GET['date']) ): ?>
		<?php 
	//First the person has to choose a park
	?>
	<form action="" method="get" class="w3-container" >
		<label>Park</label>
		<?php 
			//Selecting available parks
		$query=("SELECT  * FROM parks ORDER BY name ASC ");
		$res=$db->query($query);
		$ans=mysqli_num_rows($res);
		if ($ans>0) {
		?>
		<select class="w3-input" name="parkid" required="">
		<option value=""  >--Select Park---</option>
			<?php 
			//looping 
			while ($data=mysqli_fetch_assoc($res)) {
			    ?>
			    <option value="<?php echo $data['id'] ?>" ><?php echo $data['name'] ?></option>
			    <?php
			}
			 ?>
		</select>
		<label>Date Censored</label>
		<input type="date" class="w3-input" name="date" required="" ><br>
		<input type="submit" name="go" class="w3-input w3-border w3-green" value="next" >
		<?php	
		}elseif ($ans==0) {
			?>
			<div class="w3-container w3-red " >
				<h1 align="center" >Sorry the Parks are not found!!!!</h1>
			</div>
			<?php
			die();
		}
			 ?>
		
	</form>

<?php elseif (isset($_GET['parkid']) && isset($_GET['date']) ): ?>
	<div class="w3-bottom w3-gray" align="center" >
		<button id="submit" class="w3-blue w3-padding w3-centered"  >
			Save
		</button>
		</div>
	<div class="w3-container w3-row" >
		
		<div class="w3-quarter" >
			<?php 
				$query=("SELECT * FROM species Order by name ASC");
				$res=$db->query($query);
				$ans=mysqli_num_rows($res);
				if ($ans>0) {
					?>
					<h2>Registered animals</h2>
					<input type="search" name="" placeholder="type animals name" >
					<ul class="w3-ul" style="list-style-type: none" >
					<?php 
					while ($data=mysqli_fetch_assoc($res)) {
					    ?>
					    <li id="list<?php echo $data['id'] ?>" >
					    	<span id="text" ><?php echo $data['name']; ?></span>
					    	<button
					    	title="Click to add to the list"
					    	value="<?php echo $data['id'] ?>"
					    	 class=" animal w3-right w3-btn w3-round w3-small " >&rarr;</button><br><br>
					    </li>
					    <?php
					}
					 ?>	
					</ul>
					<?
				}elseif ($ans==0) {
					
				}

			 ?>
			
			
		</div>
		<!--The Form containing Basic Data -->
		<form>
			<input type="hidden" name="parkid" value="<?= $_GET['parkid'] ?>">
			<input type="hidden" name="date" value="<?= $_GET['date'] ?>">
		</form>
		<!--The main thing-->
		<div class="w3-padding w3-margin w3-border w3-rest" >
			<table class="w3-table" id="maintable" >
				<tr class="w3-border" >
					<th class="w3-border" >Animal's name</th>
					<th class="w3-border" >Total_female</th>
					<th class="w3-border" >Total_males</th>
					<th class="w3-border" >Act</th>
				</tr>
				
				
			</table>
		</div>
	</div>
</body>
<?php endif ?>
</html>
