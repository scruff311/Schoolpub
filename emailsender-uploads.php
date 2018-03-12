<?php
if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "spc.schoolpub@gmail.com";
	$email_from = "orders@schoolpub.com";
    $email_subject = "OnLine NP Order";
 
//    function died($error) {
        // your error code can go here
//        echo "We are sorry, but we ar experiencing difficulties with this form. <br /><br />";
//        echo " We should have your file, but the email with your information did not send.<br /><br />";
//        echo $error."<br /><br />";
//        echo "<br /><br />";
//        die();
//    }
 
 
    // validation expected data exists
/*    if(!isset($_POST['SchoolName']) ||
        !isset($_POST['AdvisorName']) ||
        !isset($_POST['SchoolAddress']) ||
        !isset($_POST['City']) ||
        !isset($_POST['State']) ||
        !isset($_POST['Zip']) ||
        !isset($_POST['email']) ||
        !isset($_POST['PhoneNum']) ||
        !isset($_POST['YourName']) ||
        !isset($_POST['YourEmail']) ||
        !isset($_POST['FaxNum']) ||

		!isset($_POST['PaperSize']) ||
        !isset($_POST['PaperStock']) ||
        !isset($_POST['NoCopies']) ||
        !isset($_POST['NoPages']) ||
        !isset($_POST['SendProof']) ||
        !isset($_POST['ColorPages']) ||
        !isset($_POST['ShipTo']) ||
        !isset($_POST['ShipVia']) ||
        !isset($_POST['SpecialInstructions']) ||

		!isset($_POST['BillingName']) ||
		!isset($_POST['BillingAddress']) ||
		!isset($_POST['BillingCitySTZip']) ||
		!isset($_POST['PONumber']) ||

		!isset($_POST['FileList']) ||
		
        !isset($_POST['comments'])) {
//        died("Please call our office (888) 543-1000 and we'll take your info over the phone.");
    }
 */
     
 
    $SchoolName = $_POST['SchoolName']; // required
    $AdvisorName = $_POST['AdvisorName'];
    $SchoolAddress = $_POST['SchoolAddress'];
    $City = $_POST['City']; 
    $State = $_POST['State']; 
    $Zip = $_POST['Zip']; 
    $email = $_POST['email']; // required
    $PhoneNum = $_POST['PhoneNum']; 
    $YourName = $_POST['YourName']; 
  	$YourEmail = $_POST['YourEmail']; 
  	$FaxNum = $_POST['FaxNum']; 
    $comments = $_POST['comments'];
	$PaperSize = $_POST['PaperSize']; 
	$PaperStock = $_POST['PaperStock']; 
	$NoCopies = $_POST['NoCopies']; 
	$NoPages = $_POST['NoPages']; 
	$SendProof = $_POST['SendProof']; 
	$ColorPages = $_POST['ColorPages']; 
	$ShipTo = $_POST['ShipTo']; 
	$ShipVia = $_POST['ShipVia']; 
	$SpecialInstructions = $_POST['SpecialInstructions']; 
	$FileList = $_POST['FileList']; 
	$BillingName = $_POST['BillingName']; 
	$BillingAddress = $_POST['BillingAddress'];
	$BillingCitySTZip = $_POST['BillingCitySTZip'];
	$PONumber = $_POST['PONumber'];
	$PubName = $_POST['PubName'];
	$PromoCode = $_POST['PromoCode'];
	
	 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
/* 
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
*/ 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
    $email_message .= "ORDER INFORMATION"."\n";
    $email_message .= "School Name: ".clean_string($SchoolName)."\n";
    $email_message .= "Advisor: ".clean_string($AdvisorName)."\n";
    $email_message .= "School Address: ".clean_string($SchoolAddress)."\n";
    $email_message .= "City: ".clean_string($City)."\n";
    $email_message .= "State: ".clean_string($State)."\n";
    $email_message .= "Zip: ".clean_string($Zip)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Telephone: ".clean_string($PhoneNum)."\n";
    $email_message .= "Your Name: ".clean_string($YourName)."\n";
    $email_message .= "Your Email: ".clean_string($YourEmail)."\n";
    $email_message .= "Fax Number: ".clean_string($FaxNum)."\n";
	$email_message .= ""."\n";
	
	$email_message .= "JOB INFORMATION"."\n";
	$email_message .= "Publication Name: ".clean_string($PubName)."\n";
	$email_message .= "Paper Size: ".clean_string($PaperSize)."\n";
    $email_message .= "Paper Stock: ".clean_string($PaperStock)."\n";
	$email_message .= "Number Of Copies: ".clean_string($NoCopies)."\n";
	$email_message .= "Number Of Pages: ".clean_string($NoPages)."\n";
	$email_message .= "Send Proof: ".clean_string($SendProof)."\n";
	$email_message .= "Color Pages: ".clean_string($ColorPages)."\n";
	$email_message .= "Ship To: ".clean_string($ShipTo)."\n";
	$email_message .= "Ship Via: ".clean_string($ShipVia)."\n";
	$email_message .= ""."\n";
	
	$email_message .= "PROMO CODE"."\n";
	$email_message .= "".clean_string($PromoCode)."\n";

	$email_message .= ""."\n";
	$email_message .= "FILES SENT"."\n";
	$email_message .= "".clean_string($FileList)."\n";
	$email_message .= ""."\n";
	$email_message .= "SPECIAL INSTRUCTIONS"."\n";
	$email_message .= "".clean_string($SpecialInstructions)."\n";
	$email_message .= ""."\n";
	$email_message .= "BILLING INFORMATION"."\n";	
	$email_message .= "Billing Name: ".clean_string($BillingName)."\n";
	$email_message .= "Billing Street: ".clean_string($BillingAddress)."\n";
	$email_message .= "Billing City ST Zip: ".clean_string($BillingCitySTZip)."\n";
	$email_message .= "PO Number: ".clean_string($PONumber)."\n";
	
 
 
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
<title>SPC OnLine Order Form</title>
<link rel="stylesheet" href="includes/spcstyle.css">
<style type="text/css">
/*	#PleaseWait {position:absolute;top:60px;left:-10000px; width:100%; text-align:center;}
	#UploadForm {position:absolute;top:60px;left:0px; width:100%; text-align:center;}*/
	#PleaseWait {display:none; text-align:center;}
	#XUploadForm {display:block; text-align:center;}
	.upandaway {position:absolute;top:-10000px;height:100px;}
	.here {}
	.leftcolumn {width:200px;}
	.std {width:300px;}
	.city {width:200px;}
	.state {width:30px;}
	.zip {width:70px;}
	.phone {width:150px;}
	fieldset{margin-top:15px;border:solid 1px #897;padding:0px 10px 10px 10px;}
	legend{
	font-weight:bold;
	font-size:14px;
	font-family:Arial,Verdana,sans-serif;
	color: #060;
}
body {
	background-color: #FFF;
	background-image: url(images/bg_body-black.png);
	background-repeat: repeat-x;
}
.jungle_head {	color: #F00;
	font-family: "Comic Sans MS", Tahoma, sans-serif;
	font-size: 24px;
	/*                font-style: normal;
                line-height: normal;*/
                font-weight: bold;
	/*                font-variant: normal;
                text-transform: none;
                text-decoration: none;*/
                text-align: center;
}
</style>
<%IsUploadForm=1%>
<!--#include file="includes/form_functions.asp"-->
</head>
<body class="content">
<!--div style="position:fixed;top:100px left:100px;"><a href="javascript:showWaitMsg();">Show Msg</a> | <a href="javascript:hideWaitMsg();">Hide Msg</a></div-->
<div id="UploadForm">
  <!--<form action="HTTP://64.78.50.5/spcUpload/Upload.aspx" method="post" enctype="multipart/form-data" onSubmit="return Validate();" name="form1" id="form1">-->
  
  <form action="php_upload.php" Xaction="http://www.schoolpub.com/SPCUpload/upload" method="post" enctype="multipart/form-data" onSubmit="return Validate();" name="form1" id="form1">


<div style="width:600px;margin:0px auto 0px auto;text-align:left;">
	<h3>Upload Your File</h3>
<p>* indicates required field.</p>
	
	<fieldset>
	  <legend></legend>
	</fieldset>
<fieldset>
		<legend>Files to Upload</legend>
		<p><b>You may wish to compress your files to save transmission time. Files may be compressed as .zip or .sit files.  PC users can use WinZip to create .zip files; Mac users should use Stuffit to create either .sit files or .zip (preferred) archives to prevent file corruption.</b></p>
		<table border="0" cellpadding="20" cellspacing="0" ID="Files">
			<tr>
				<td style="text-align:center;border-right:solid 1px #C4B99D">&nbsp;</td>
				<td>
					<input class="std" type="File" name="FILE1"><br>
					<input class="std" type="File" name="FILE2"><br>
					<input class="std" type="File" name="FILE3">
					<p style="color:#F00; font-weight: bold;"><b>MAXIMUM FILE SIZE IS 64 MB!</b><br> 
					Files larger than 64 Mb will be rejected by the server! If you attach multiple files, the combined size can be no more than 64 MB.<br> 
					Call us if you need assistance.</p>
				</td>
			</tr>
		</table>
	</fieldset>
	<p align="center"><input type="submit" value=" SUBMIT REQUEST NOW " name="Submit" id="Submit"></p>
	<div style="position:absolute;top:-5000px;"><input type="text" name="cc_SHIPPINGCHARGES" id="cc_SHIPPINGCHARGES"></div>
	
</div>
</form>
</div>
&nbsp;
<div id="PleaseWait"><EMBED src="pics/spcpleasewait.swf" Flashvars="" quality=high bgcolor=#E0CA99  WIDTH=550 HEIGHT=200 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED></div>
</body>
</html>

<?php
 
}
?>