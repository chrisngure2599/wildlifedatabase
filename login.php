<?php 
require_once 'nav.php';
require_once 'includes/db.php';
 ?>	<!DOCTYPE html>
<html>
<head>
	<title>Login to Wildlife Database</title>
</head>
<body>
<form action="" method="post" class="w3-twothird  w3-container " >
	<table class="w3-table w3-center w3-section" >
		<tr>
			<th class="w3-center" >Username <br> or Email</th>
			<td>
				<input required="" type="text" class="w3-input" name="uname">
			</td>
			
		</tr>
		<tr>
			<th class="w3-center" >Password</th>
			<td>
				<input required="" type="Password" class="w3-input" name="password">
			</td>
		</tr>
	</table>
	<input type="submit" readonly="" class="w3-btn w3-block w3-blue-gray" name="go">

<?php 
if (isset($_POST['go'])) {
//Capturing za data
$uname=mysqli_escape_string($db,$_POST['uname']);	
$password=mysqli_escape_string($db,$_POST['password']);
if (empty($uname) OR empty($password) ) {
	echo 'Please Fill the inputs....';
}else{
	//quering the person
	$query=("SELECT * FROM users where `email`='$uname' OR  `user_name`='$uname' LIMIT 1 ");
	$res=$db->query($query);
	$ans=mysqli_num_rows($res);
	if ($ans>0) {
		//Fetching ze Data
		$data=mysqli_fetch_assoc($res);
		//Verifing the Password
		if (password_verify($password, $data['password'])) {
		//Checking for Role
		$role=$data['role'];
		if ($role==2) {
		//For Admins==2
		session_start();
		$_SESSION['id']=$data['id'];
		$_SESSION['role']=$data['role'];
		//Redirecting
		header('location:admin/index.php');
		}elseif ($role==1) {
		//For Surveyors==2
		session_start();
		$_SESSION['id']=$data['id'];
		$_SESSION['role']=$data['role'];
		if ($data['status']=="off") {
			$_SESSION['status']='off';
			//Redirecting to Activate
			header('location:surveyors/activate.php');
		}elseif ($data['status']=='on') {
			//Redirecting
		header('location:surveyors/index.php');
		}
		
		}
		}
	}elseif ($ans==0) {
		
	}

}

}
 ?>
</form>

</body>
</html>