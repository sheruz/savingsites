<?php
 

require_once "PHPMailer/PHPMailerAutoload.php";



if(isset($_POST['sendEmail']) && !empty($_POST['email'])){

	//PHPMailer Object

	$mail = new PHPMailer;

	

	//From email address and name

	$mail->From = "noreply@savingssites.com";

	$mail->FromName = "Super Admin";

	

	//To address and name

	$mail->addAddress($_POST['email'], "Recepient Name");

	//$mail->addAddress("soumya@gmail.com"); //Recipient name is optional

	

	//Address to which recipient will reply

	//$mail->addReplyTo("reply@yourdomain.com", "Reply");

	

	//CC and BCC

	//$mail->addCC("cc@example.com");

	//$mail->addBCC("bcc@example.com");

	

	//Send HTML or Plain Text email

	$mail->isHTML(true);

	

	$mail->Subject = "This is Subject";

	$mail->Body = "<i>Mail body in HTML</i><h1>This is very big text</h1>";

	$mail->AltBody = "This is the plain text version of the email content";

	

	if(!$mail->send()) 

	{

		echo "Mailer Error: " . $mail->ErrorInfo;

	} 

	else 

	{

		echo "Message has been sent successfully";

	}

}

?>





<form method="post">

	Enter Email: <input type="email" name="email" required />

	<button type="submit" name="sendEmail">Send Email</button>

</form>

