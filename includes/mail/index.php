<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Email sender</title>
</head>
<body>
<form method="post"  >
	<label>To</label>
	<input style="width: 80%" type="email" name="email" value="chrisngure2599@gmail.com" ><br>
	<label>Message</label><br>
	<textarea style="width: 80%" name="sms" required="required" ></textarea><br>
	<input  type="submit" name="go" value="send Email" >
</form>
<?php 
if (isset($_POST['go'])) {
	//capturing the variables!
	$to=$_POST['email'];
	$msg=$_POST['sms'];
	//time to start the process!


//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
   // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    // SMTP username
    $mail->Username = 'rasnally@gmail.com';   

    $mail->Password = 'nasra1234';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('noreply@atcevents.ac.tz', 'Atc Events notification');
    $mail->addAddress($to, $to);     // Add a recipient
    //The Bcccs    
   // $mail->addCC('cc@example.com');
   // $mail->addBCC('bcc@example.com');


	// Set email format
    //Content
    $mail->isHTML(true);                                 // to HTML
    $mail->Subject = 'Hello we are testing our things';
    $mail->Body    = $msg;
    //Altbody is for peaple who doesnt have ability to render HTML
    $mail->AltBody = $msg;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
}
 ?>
</body>
</html>
