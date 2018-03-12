<? 
$Subject = "SPC Newspaper Upload";
$Email = "SPC_Uploads@schoolpub.com";
$SendToRecipient1 = "orders@seniopub.com";

if($_POST){
	$target_file_path = dirname(__FILE__) . "/uploads/";
	if (!is_dir($target_file_path)) mkdir($target_file_path, 0777, true);
	
	// GET FILE NAMES
	
	if($_FILES['FILE1']['name']) $final_filename1 = getFileName($target_file_path, $_FILES['FILE1']['name']);
	if($_FILES['FILE2']['name']) $final_filename2 = getFileName($target_file_path, $_FILES['FILE2']['name']);
	if($_FILES['FILE3']['name']) $final_filename3 = getFileName($target_file_path, $_FILES['FILE3']['name']);


	$file_uploads = "";
	$file_uploads2 = "";

	if($_FILES['FILE1']['name']) $file_uploads .= "<li>" . $final_filename1 . "</li>";
	if($_FILES['FILE2']['name']) $file_uploads .= "<li>" . $final_filename2 . "</li>";
	if($_FILES['FILE3']['name']) $file_uploads .= "<li>" . $final_filename3 . "</li>";

	if($_FILES['FILE1']['name']) $file_uploads2 .= $final_filename1 . "\n";
	if($_FILES['FILE2']['name']) $file_uploads2 .= $final_filename2 . "\n";
	if($_FILES['FILE3']['name']) $file_uploads2 .= $final_filename3 . "\n";

	// echo $target_file_path . $final_filename1;

	if($_FILES['FILE1']['tmp_name']) move_uploaded_file($_FILES['FILE1']['tmp_name'], $target_file_path . $final_filename1);
	if($_FILES['FILE2']['tmp_name']) move_uploaded_file($_FILES['FILE2']['tmp_name'], $target_file_path . $final_filename2);
	if($_FILES['FILE3']['tmp_name']) move_uploaded_file($_FILES['FILE3']['tmp_name'], $target_file_path . $final_filename3);

	$output = "";
	foreach($_POST AS $key => $val){
		if($key != "Submit") $output .= "$key: $val\n";
	}
	$output .= "\nFILES:\n\n$file_uploads2";
	
	$files_output = ($file_uploads ? "<ul style='margin:auto auto;'>$file_uploads</ul>" : "");
	$body = "
		$files_output
		";

	if($SendToRecipient1) send_mail($SendToRecipient1,$Email,$Subject,$output,0);
	if($SendToRecipient2) send_mail($SendToRecipient2,$Email,$Subject,$output,0);
} 

// ############ FUNCTIONS

// Get File Name for Uploads:
function getFileName($target_file_path, $file_name, $i = 0){
	$a = ($i > 0 ? "-$i" : "");
	if(file_exists("$target_file_path$file_name$a")){
		$i++;
		return getFileName($target_file_path, $file_name, $i);
	}else{
		return "$file_name$a";
	}
}

// EMAIL FUNCTION:
function send_mail($recipient,$from,$subject,$body,$html) {
	//add FROM:
	$headers = 'From: '. $from;
	$headers .= '
Return-path:'. $from; 

	if($html){// if HTML email:
        //specify MIME version 1.0 for HTML Email
        $headers .= "\nMIME-Version: 1.0\n"; 
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\n";//
        $headers .= "Content-Transfer-Encoding: base64\n"; 
        $headers .= chunk_split(base64_encode($body)); 
		$sentOk = mail($recipient, $subject, "", $headers); // Send HTML EMAIL
	}else{// if NOT HTML email:
        //specify plain text for PLAIN Email
		$headers .= "Content-Type: text/plain; charset=ISO-8859-1\n"; 
		$sentOk = mail($recipient, $subject, $body, $headers);  // Send Non-HTML EMAIL
	}
	// echo "sentOk=" . $sentOk; // VERIFY OK
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPC Thank You</title>
<style type="text/css">
<!--
body {
	background-color: #F0F0F0;
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
    <td width="530" height="76"><h1 align="center" class="jungle_head">Thank You For 
      Your Order</h1></td>
    <td width="160"><img src="images/HappyTeacher - clear.png" width="140" height="178" alt="teacher" /></td>
  </tr>
  <tr>
    <td colspan="2"><h3 class="subhead">Call Our Office To Confirm&hellip;</h3>
      <p class="body-text">Wait 10 minutes to make certain your files have finished transferring, then give us a call (888) 543-1000. We'll confirm receipt of your information and files ad start working on your paper.</p>
      <h3 class="subhead">What Happens Next?</h3>
      <p class="body-text">If you requested a proof we'll make any adjustments and email the proof to the email address supplied on the order form.<a href="products-news-color.asp"></a></p>
    <p><span class="body-text">Our strengths are customer service, quality, and speed. If you&rsquo;re looking for courteous, friendly help, excellent photo quality, and the fastest turnaround time in the business, then you&rsquo;re looking for SPC</span>.</p>
    <h3 class="subhead">We Received the following files&hellip;</h3>
    <?
		print $body;
    ?>
</td>
    <p>&nbsp;</p>
     
</table>
</body>
</html>
