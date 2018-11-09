<?php
//if(isset($_POST['email'])) {
 
 
//<?php
require("/home/schoo117/public_html/PHPMailer_5.2.0/class.phpmailer.php");



    $school_name = $_POST['school_name']; // required
    $advisor = $_POST['advisor']; // not required
    $SchoolAddress = $_POST['SchoolAddress']; // not required
    $City = $_POST['City']; // not required
    $State = $_POST['State']; // not required
    $Zip = $_POST['Zip']; // not required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['telephone']; // not required
    $YourName = $_POST['YourName']; // not required
  	$ProductInterest = $_POST['ProductInterest']; // not required
  	$WhereHeard = $_POST['WhereHeard']; // not required
    $comments = $_POST['comments']; // not required

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "localhost";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "kevin@schoolpub.com";  // SMTP username
$mail->Password = "Spc!pass07717"; // SMTP password

$mail->From = "kevin@schoolpub.com";
$mail->FromName = "Kevin";
$mail->AddAddress("bkirms@hotmail.com");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "OnLine Request Form";
//$mail->Body    = "This is the HTML message body <b>in bold!</b>";
//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
     $mail->Body    = "School Name: ".clean_string($school_name)."\n"."Advisor: ".clean_string($advisor)."\n"."SchoolAddress: ".clean_string($SchoolAddress)."\n" . "City: ".clean_string($City)."\n" . 	"State: ".clean_string($State)."\n" . 	"Zip: ".clean_string($Zip)."\n" . 	"Email: ".clean_string($email_from)."\n" . 	"Telephone: ".clean_string($telephone)."\n" . 	"Your Name: ".clean_string($YourName)."\n" . "Product Interest: ".clean_string($ProductInterest)."\n" . 	"WhereHeard: ".clean_string($WhereHeard)."\n" . 	"Comments: ".clean_string($comments)."\n";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";


 
/*
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    //   $email_to = "info@schoolpub.com";
	 $email_to = "bkirms@school.com";
	// $email_to = "spc.schoolpub@gmail.com";
    $email_subject = "OnLine Information Request";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 */
 
    // validation expected data exists
    if(!isset($_POST['school_name']) ||
        !isset($_POST['advisor']) ||
        !isset($_POST['SchoolAddress']) ||
        !isset($_POST['City']) ||
        !isset($_POST['State']) ||
        !isset($_POST['Zip']) ||
        !isset($_POST['email']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['YourName']) ||
        !isset($_POST['ProductInterest']) ||
        !isset($_POST['WhereHeard']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
 /*
    $school_name = $_POST['school_name']; // required
    $advisor = $_POST['advisor']; // not required
    $SchoolAddress = $_POST['SchoolAddress']; // not required
    $City = $_POST['City']; // not required
    $State = $_POST['State']; // not required
    $Zip = $_POST['Zip']; // not required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['telephone']; // not required
    $YourName = $_POST['YourName']; // not required
  	$ProductInterest = $_POST['ProductInterest']; // not required
  	$WhereHeard = $_POST['WhereHeard']; // not required
    $comments = $_POST['comments']; // not required
 */
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$school_name)) {
    $error_message .= 'The School Name you entered does not appear to be valid.<br />';
  }
 
  if(!preg_match($string_exp,$advisor)) {
    $error_message .= 'The Advisor you entered does not appear to be valid.<br />';

  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     

/*
create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
*/
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPC Thank You</title>
<style type="text/css">
<!--
body {
	background-color: #FFF;
	background-image: url(images/bg_body-black.png);
	background-repeat: repeat-x;
}
.body-text {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	color: #000;
}
.jungle_head {
	color: #060;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 36px;
	font-style: normal;
	line-height: normal;
	font-weight: bold;
	font-variant: normal;
	text-transform: none;
	text-decoration: none;
}
.subhead {
	color: #060;
	font-family: "Times New Roman", Times, serif;
	font-weight: bold;
	font-size: 24px;
	font-style: normal;
	line-height: normal;
	font-variant: normal;
	text-transform: none;
	text-decoration: none;
}
body,td,th {
	color: #333;
}
-->
</style></head>

<body>
<table width="700" height="357" border="0" align="center">
  <tr>
    <td height="76" colspan="2"><h1 align="center" class="jungle_head">Thank You For Your Interest!</h1></td>
  </tr>
  <tr>
    <td width="549" height="275"><h3 class="subhead">Check Your Email&hellip;</h3>
      <p class="body-text">Thanks for your information request. We'll email you a PDF of our follow up package with  prices.</p>
      <h3 class="subhead">Want More Info Now?</h3>
      <p class="body-text">If you have any questions, problems, or just need advice, give us a call on our toll free phone, 1.888.543.1000, and We'll gladly assist you.<a href="products-news-color.asp"></a></p>
    <p><span class="body-text">Our strengths are customer service, quality, and speed. If you&rsquo;re looking for courteous, friendly help, excellent photo quality, and the fastest turnaround time in the business, then you&rsquo;re looking for SPC</span>.</p></td>
    <td width="335"><img src="images/HappyTeacher - clear.png" width="300" height="385" align="top" /></td>
  </tr>
</table>
</body>
</html>
-->