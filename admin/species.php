<!DOCTYPE html>
<html>
<head>
<title>Species | Wildlife Database </title>
<?php 
require '../includes/db.php';
require 'nav.php';
require_once 'gaurd.php';
 ?>	
</head>
<body>

	<?php 
		function updater($name,$image=NULL,$data)
		{
			$db=$GLOBALS['db'];
			/*
			Function to update the animals data
			 */
			$name=mysqli_escape_string($db,$name);
			//the image processing
			//Checking if the image is uploaded
			if (isset($image) && $image!=NULL ) {
				//trying to delete the old image
				$oldimage=$data['image'];
				@unlink("../uploads/$oldimage");
				//then uploading the new one
				//Processing the image
				$size=$image['size'];
				$tmp_name=$image['tmp_name'];
				$imgname=$image['name'];
				//the size in megabytes
				$asize=10;
				$asize=$asize*1024*1024;
				//checking the size if is allowed
				if ($size<=$asize) {
				//if the size is allowed its time to check the type
				#allowed type = $atype
				
				$atype=array('jpg','png','jpeg','gif');
				#The image $type
				strtolower($ext=explode('.', $imgname));
				
				 $ext=end($ext);
				if (in_array($ext,$atype)) {
					//if the image hass passed through all those checks ->
					//then its time to upload
					#But first creating the final name $fname
					$fname=$name.uniqid().'.'.$ext;
					//finally uploading
					//print_r($image);
					move_uploaded_file($tmp_name,'../uploads/'.$fname);
					//and now upating to the darabase
					}}elseif (empty($image) && $image==NULL ) {
						$fname=$data['image'];
					}
					$query=("UPDATE `species` SET 
						`name`='$name',`image`='$fname',`user_id`=$_SESSION[id] WHERE `id`=$data[id]");
					$db->query($query);
					//echo $db->error;
					//redirecting to the same page
					header('location:species.php');
				
			}
		}
	 ?>
	<?php  if (empty($_GET['edit']) AND empty($_GET['id']) ) {

		?>
	
<div class="w3-container w3-row " >
	<div class="w3-quarter" >
		<h1 align="center" class="w3-blue" >Add Species</h1>
		<form method="post" action="" enctype="multipart/form-data"  >
			<label><i>Species Name</i></label>
			<input required="" type="text" class="w3-input w3-border" name="name" autofocus="">
			<label><i>Species Image</i></label>
			<input type="file" required="" class="w3-input w3-border" name="image" autofocus=""><br>
			<input type="submit" name="go" class="w3-input w3-border w3-green" >
		
<?php 
	if (isset($_POST['go'])) {
		//time to recieve the variable
		$name=mysqli_escape_string($db,$_POST['name']);

		//Processing the image
		$image=$_FILES['image'];
		$size=$image['size'];
		$tmp_name=$image['tmp_name'];
		$imgname=$image['name'];
		//the size in megabytes
		$asize=10;
		$asize=$asize*1024*1024;
		//checking the size if is allowed
		if ($size<=$asize) {
		//if the size is allowed its time to check the type
		#allowed type = $atype
		
		$atype=array('jpg','png','jpeg','gif');
		#The image $type
		strtolower($ext=explode('.', $imgname));
		
		 $ext=end($ext);
		if (in_array($ext,$atype)) {
			//if the image hass passed through all those checks ->
			//then its time to upload
			#But first creating the final name $fname
			$fname=$name.uniqid().'.'.$ext;
			//finally uploading
			//print_r($image);
			move_uploaded_file($tmp_name,'../uploads/'.$fname);
			//and now save to the darabase
			$query=("INSERT INTO `species`
				( `name`, `image`) VALUES 
				('$name','$fname')");
			$db->query($query);
			//echo $db->error;
			//redirecting to the same page
			header('location:species.php');
		}
		}elseif ($size>$asize) {
			echo 'The size is too large allowed is $asize mb';
		}


	}

?>
</form>
	</div>
	<div class="w3-rest w3-padding " >
		<h4 align="center" >Available Species</h4>
		<?php 
		//quering the available species
		$query=("SELECT * FROM species ");
		$res=$db->query($query);
		$ans=mysqli_num_rows($res);
		if ($ans==0) {
			echo "<p class='w3-center' aligned='justified' >Sorry $ans found in the database";
		}elseif ($ans>0) {
			echo "<h2 align='center'  ><b>$ans</b> WildAnimals Found</h2>";
			//looping to  list Dar animals
			echo "<div class='w3-row-padding'>";
			while ($data=mysqli_fetch_assoc($res)) {
			    ?>
			    <div class=" w3-border w3-quarter w3-padding w3-margin " >
			    	<h5 align="center" >
			    		<?php echo $data['name']; ?>
			 		</h5>
			 		<hr  style="border-color: gray;border-style:dashed;" >
			 		<img width="200px" height="210px"  src="../uploads/<?php echo$data['image'] ?>" class=" w3-round w3-centered"  >
			 		<table class="w3-table" >
			 			<tr>
			 				<th>
			 					<form action="species.php" method="get" >
			 						<input type="hidden" name="id"  value="<?php echo $data['id'] ?>"	  >
			 						<button  class="w3-btn" name="edit" >Edit</button>
			 					</form>
			 					
			 				</th>
			 				<th>
			 					<a href="" class="w3-btn w3-red " >Delete</a>
			 				</th>
			 			</tr>
			 		</table>
			    </div>
			    <?php
			}
				
			}
		 ?>
	</div>
</div>
</div>
<?php /* End of if(!isset($_POST['edit']))*/}elseif (isset($_GET['edit'])) {
	$id=mysqli_escape_string($db,$_GET['id']);
	$query=("SELECT * FROM species where id=$id ");
		$res=$db->query($query);
		$ans=mysqli_num_rows($res);
		if ($ans==1) {
			$data=mysqli_fetch_assoc($res);
			?>
			<h1>Edit Species Details</h1>
			<form method="post" action="" enctype="multipart/form-data"  >
			<label><i>Species Name</i></label>
			<input required="" type="text" class="w3-input w3-border" name="name" autofocus="" value="<?php echo $data['name'] ?>" ><br>
			Curent image <br>
			<img width="200px" height="210px"  src="../uploads/<?php echo$data['image'] ?>" class=" w3-round w3-centered"  ><br>
			<label><i>Choose new Image</i></label>
			<input type="file"  class="w3-input w3-border" name="image" autofocus=""><br>
			<input type="submit" name="update" class="w3-input w3-border w3-green" >
			<?

			//Listening for update
			if (isset($_POST['update'])) {
				$name=$_POST['name'];
				$image=$_FILES['image'];
				updater($name,$image,$data);
			}
		}elseif ($ans==0) {
			header('location:species.php');
		}
} 

 ?>
</body>

</html>
