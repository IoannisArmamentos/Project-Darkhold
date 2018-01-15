<?php
 $_SESSION['adress'] = $_GET["value1"];
	   $adress =  $_SESSION['adress'];
	    $_SESSION['send'] = $_GET["value2"];
	   $send =  $_SESSION['send'];
	    $_SESSION['path'] = $_GET["value3"];
	   $path =  $_SESSION['path'];
	   echo"<br>PATH:".$path;
require_once 'email_related/class.phpmailer.php';
require_once 'email_related/class.smtp.php';
require_once 'email_related/class.pop3.php';
ini_set('display_errors', 1);
$mail  = new PHPMailer();
$mail->charSet = 'utf-8';
$mail->IsSMTP();
$mail->Host       = 'smtp.aegean.gr';
$mail->SMTPAuth = true;

$mail->AuthType = "LOGIN";
$mail->SMTPSecure = "tls";
$mail->Port   =  587 ;
$mail->Username="icsd11159";
$mail->Password="Panemorfi!1";
//$mail->SMTPDebug=true;
$MailReportSMTPServer = "mail.mydomain.com";
$MailReportSMTPPort = "25";
$MailReportSMTPServerEnableSSL = true;
$MailReportSMTPServerUsername ="icsd11159" ;
$MailReportSMTPServerPassword = "Panemorfi!1";
 
$mail->Debugoutput="echo";
$mail->SetFrom("icsd11159@icsd.aegean.gr", "icsd11159");
$mail->AddReplyTo("icsd11159@icsd.aegean.gr", "icsd11159");
$mail->AddAddress($adress, "icsd16164");
$mail->AddAddress("tleoutsakos@aegean.gr", "thodoris");


//$msg = "Επιτυχής εγγραφή. Κάνε κλικ στο σύνδεσμο για να επιλέξεις ρόλο χρήστη.";
//$msg = "LINK";
$mail->SMTPDebug = true; // debugging: 1 = errors
if ( $path!=NULL) {
	   
$mail->AddAttachment($path,$send,$encoding = 'base64', $type = 'application/pdf');      // attachment
}
$mail->IsHTML(true);
$mail->Subject = "SYSTEM THESIS STUDENT  AEGEAN UNIVERSITY ICSD";
$mail->Body    = $send;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
?>