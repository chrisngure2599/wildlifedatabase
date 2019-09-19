<?php 
//The log
require_once "../includes/logz/logz.php";
$logs=new Logz;
/**Description
#This Guard  file is used to verify session and also prevent role misuse
  */
 session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role']) ) {
	//Ensuring that the user is in the dir of his/her role
	//For Surveyors =1
	//For Admin =2
	//For Others =3
	$role=1;
	if ($role!=$_SESSION['role']) {
	//logging out
	header('location:../logout.php');	
	//Making sure that the person is 	
	}
}else {
	header('location:..');
}
 ?>