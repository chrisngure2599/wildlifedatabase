<?php 
	require '../includes/main.php';
	require '../includes/db.php';
	require 'nav.php';
	require_once 'gaurd.php';
?>	
 <!DOCTYPE html>
<html>
<head>
	<title>Please activate your Account</title>
</head>
<body>
 	<?php 
if (isset($_POST['go'])) 
{
	
 	$uname=mysqli_escape_string($db,$_POST['uname']);
 	$email=mysqli_escape_string($db,$_POST['email']);
 	$fname=mysqli_escape_string($db,$_POST['fname']);
 	$ps=mysqli_escape_string($db,$_POST['ps']);
 	$cardid=mysqli_escape_string($db,$_POST['cardid']);
 	$error=array();
 	if (empty($uname)) {
 		$error['uname']="Username is needed";
 	}
 	if (empty($email)) {
 		$error['email']="email is needed";
 	}
 	if (empty($fname)) {
 		$error['fname']="fname is needed";
 	}
 	if (empty($cardid)) {
 		$error['id']="id is needed";
 	}
 	if (empty($ps)) {
 		$error['ps']="Password is needed";
 	}
 	//then its time to check the user name or the email is there but not his own
 	$uid=$_SESSION['id'];
 	echo $query=("SELECT * FROM `users` WHERE `user_name`='$uname' AND NOT(id=$uid )"  );
 		$res=$db->query($query);
 		$ans=mysqlI_num_rows($res);
 		if ($ans==1) {
 			$error['uname']="Sorry that Username is taken ";
 		}
 		$query1=("SELECT * FROM `users` WHERE `user_name`='$email' LIMIT 1"  );
 		$res1=$db->query($query1);
 		$ans1=mysqlI_num_rows($res1);
 		if ($ans1==1) {
 			$error['email']="Sorry that email is taken ";
 		}
 	if (empty($error)) {
 		//Insertion!!!!
 		$password=password_hash($ps, PASSWORD_DEFAULT);
 		$id=$_SESSION['id'];
 		$query2=("
	UPDATE `users` SET `user_name`='$uname',`email`='$email',
	`password`='$password',`full_name`='$fname',`id_card_number`='$card_id',`status`='on'  WHERE `id`='$id' AND `status`='off'");
 		$db->query($query2);
 		//redirecting....
 		header('location:index.php');
 		}
}

//Quering for the Previous data of the user
$id=$_SESSION['id'];
$role=$_SESSION['role'];
$query=("SELECT * FROM users where
 `id`=$id AND  	`role`='$role' AND `status`='off' LIMIT 1 ");
	$res=$db->query($query);
	$ans=mysqli_num_rows($res);
	if ($ans>0) {
		$data=mysqli_fetch_assoc($res);
	?>


<body class="w3-container" >
<form method="post" action="" class="w3-container w3-row "  >
	<h1 class="w3-center" >Hello Surveyor Activate your Account </h1>
<label><i>User Name</i></label>
<input type="text" name="uname" 
		value="<?php 
		if (isset($_POST['go'])  ) {
			echo $_POST['uname'];
		}else
		{
			echo $data['user_name'];
		}
		 ?>"  
class="w3-input" >
	<span class="w3-red  " >
		<?php 
		if (isset($_POST['go']) && isset($error['uname']) ) {
			echo $error['uname'].'<br>';
		}
		 ?>
	</span>
<label><i>Email</i></label>
<input type="email" name="email" 
value="<?php 
		if (isset($_POST['go'])  ) {
			echo $_POST['email'];
		}else
		{
			echo $data['email'];
		}
		 ?>" 
  class="w3-input" >
	<span class="w3-red  " >
		<?php 
		if (isset($_POST['go']) && isset($error['email']) ) {
			echo $error['email'].'<br>';
		}
		 ?>
	</span>
<label><i>Password</i></label>
<input type="password" name="ps"  value=""   class="w3-input" >
<span class="w3-red  " >
		<?php 
		if (isset($_POST['go']) && isset($error['ps']) ) {
			echo $error['ps'].'<br>';
		}
		 ?>
	</span>
<label><i>Full Name</i></label>
<input type="text" name="fname" 
value="<?php 
		if (isset($_POST['go'])  ) {
			echo $_POST['fname'];
		}else
		{
			echo $data['full_name'];
		}
		 ?>" 
  class="w3-input" >
	<span class="w3-red  " >
		<?php 
		if (isset($_POST['go']) && isset($error['fname']) ) {
			echo $error['fname'].'<br>';
		}
		 ?>
	</span>
<label><i>Workers Card no</i></label>
<input type="text" name="cardid" 
	value="<?php 
		if (isset($_POST['go'])  ) {
			echo $_POST['id'];
		}else
		{
			echo $data['id_card_number'];
		}
		 ?>" 
 class="w3-input" >
	<span class="w3-red  " >
		<?php 
		if (isset($_POST['go']) && isset($error['id']) ) {
			echo $error['id'].'<br>';
		}
		 ?>
	</span>
<br>
<input type="submit"  value="Activate"  class="w3-btn w3-green w3-block " name="go">
</form>
	<?PHP	
	}else{
		die("Sorry There is an error");
	}
 ?>
</body>
</html>