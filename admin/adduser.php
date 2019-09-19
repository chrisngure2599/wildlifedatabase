<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Wildlife Database </title>
<?php 
require '../includes/db.php';
require 'nav.php';
require_once 'gaurd.php';
require_once '../includes/mail/vendor/autoload.php';
 ?>	
</head>
<?php 
if (isset($_POST['go'])) {
 	$uname=mysqli_escape_string($db,$_POST['uname']);
 	$email=mysqli_escape_string($db,$_POST['email']);
 	$fname=mysqli_escape_string($db,$_POST['fname']);
 	$id=mysqli_escape_string($db,$_POST['id']);
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
 	if (empty($id)) {
 		$error['id']="id is needed";
 	}
 	//then its time to check the user name or the email is there
 		$query=("SELECT * FROM `users` WHERE `user_name`='$uname' LIMIT 1"  );
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
 		//Sending Email
 		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
	//Formating the email;
	$password="wild_%2019";
	 $msg="<div class='w3-container' ><h1 align='center'  >Hello $fname you are registered on Wildlife Database</h1>
	 <p align='justify' >Hello $fname this is an email to verify your registration on Wildlife Database your username is <b>$uname</b> and your password is
	 <b>$password</b>.
	 You are supposed to loggin and change your password for security reasons.
	 To login visit here 
	 <a href='http://localhost/wildlife_database/login.php'>Wildlife.database</a> 
	 </p><br>
	<center> <small><b>Wildlife Database</b></small></center>
	<center> <small><b>By Chris Ngure && Dickson Laurent</b></small></center>
	  ";
   
    //Server settings
   // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    // SMTP username
    $mail->Username = 'basewild@gmail.com';   

    $mail->Password = 'wild_%2019';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    $to=$email;
    //Recipients
    $mail->setFrom('noreply@wildbase.co.tz', 'Wildbase emails');
    $mail->addAddress($to, $to);     // Add a recipient
    //The Bcccs    
   // $mail->addCC('cc@example.com');
   // $mail->addBCC('bcc@example.com');


	// Set email format
    //Content
    $mail->isHTML(true);                                 // to HTML
    $mail->Subject = 'Wildbase Verification system';
    //Formating the message
    //

    $mail->Body    = $msg;
    //Altbody is for peaple who doesnt have ability to render HTML
    $mail->AltBody = $msg;

    $mail->send();
    echo 'Message has been sent';
    //Insertion!!!!
 		$password=password_hash('wild_life@Database', PASSWORD_DEFAULT);
 		$query2=("INSERT INTO `users`
 			(`user_name`, `email`, `password`, `role`, `full_name`) VALUES 
 			('$uname','$email','$password','1','$fname')");
 		$db->query($query2);
 		//redirecting....
 		header('location:adduser.php');
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
 		
 		}
 }
 ?>
<body class="w3-container" >
<form method="post" action="" class="w3-container w3-row "  >
<label><i>User Name</i></label>
<input type="text" name="uname" 
		value="<?php 
		if (isset($_POST['go'])  ) {
			echo $_POST['uname'];
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
<label><i>Default Password</i></label>
<input type="text" readonly="" value="wild_life@Database"  class="w3-input" >
<label><i>Full Name</i></label>
<input type="text" name="fname" 
value="<?php 
		if (isset($_POST['go'])  ) {
			echo $_POST['fname'];
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
<input type="text" name="id" 
	value="<?php 
		if (isset($_POST['go'])  ) {
			echo $_POST['id'];
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
<input type="submit"  value="Add"  class="w3-btn w3-green w3-block " name="go">
</form>

</body>
</html>