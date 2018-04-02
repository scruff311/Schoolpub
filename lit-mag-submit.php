<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
    ini_set("memory_limit", "-1");

	date_default_timezone_set("America/New_York");

	// switch between debug (local) and live server params
    $debugging = 0;
    
	// Confirmation number
	$confirm = strtoupper("SPC" . substr(md5(uniqid(rand(), true)), 0, 7));
/*
    // Set for remote server. Remove for localhost testing.
    if ($debugging == 0) {
        ini_set("SMTP", "scriptmail.intermedia.net");
        ini_set("sendmail_from", "orders@seniorpublishing.net");
    }
*/

	$filenames = saveFiles($confirm);    
    $subject = 'SPC Literary Magazine Order Confirmation #' . $confirm;
    $email = $_POST["schoolInfo_email"];
    $message = buildMessage($email, $confirm);
    // // Send confirmation email
    // sendMail($email, $confirm, $subject, $message);
    sendMailWithPhpMailer($email, $confirm, $subject, $message);
		
function saveFiles($confirm) {
	$filenames = array();
	$i = 0;

	foreach ($_FILES as $file) {
		$n = $file['name'];
		$s = $file['size'];
		$t = $file['tmp_name'];
		if (!$n)
			continue;

        $filename = $confirm . "_" . $n;
        
        // $directory = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
        $directory = dirname(__FILE__) . "/uploads/";
        if (!is_dir($directory)) mkdir($directory, 0777, true);

        if (is_writable($directory)) {
            // do upload logic here
        
            // $filename = $n;
            // $directory = "/uploads/" . $confirm;
            // $file_path = $directory . "/" . $filename;
            $file_path = $directory . $filename;

            // create a folder for this confirmation number if it doesn't exist
            // if (!is_dir($directory)) {
            // 	mkdir($directory, 0777, true);
            // }

            if (move_uploaded_file($t, $file_path)) {
                $filenames[$i] = $filename;
                $i++;
            }
            else {
                // echo $filename . " upload FAILED!\n";
                // $error = error_get_last();
                // echo 'Could not move file. ' . $error['message'] . PHP_EOL;
            }
        }
        else {
            // $error = error_get_last();
            // echo 'Upload directory is not writable, or does not exist. ' . $error['message'] . PHP_EOL;
        }
	}

	return $filenames;
}

function sendMailWithPhpMailer($email, $confirm, $subject, $message) {
    global $debugging;
    require 'PHPMailer/PHPMailerAutoload.php';    	
    $mail = new PHPMailer;

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    // 3 = verbose debug output
//		$mail->SMTPDebug = 3;
    //Ask for HTML-friendly debug output
//		$mail->Debugoutput = 'html';

    // Set SMTP account
    if ($debugging) {
        $username = 'kevin.smtp.test@gmail.com';
        $password = 'ema!ltester';
    }
    else {
        // $username = 'spc.ad.orders@gmail.com';
        $username = 'spc.schoolpub@gmail.com';
        $password = 'password_goes_here';
    }
                                                   
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  					  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $username;                          // SMTP username
    $mail->Password = $password;                          // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    
    $mail->setFrom('orders@schoolpub.com', 'School Publications');
    // $mail->setFrom('spc.schoolpub@gmail.com', 'School Publications');
    // $mail->setFrom('kevin.smtp.test@gmail.com', 'School Publications');
//		$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress($email);               			  // Name is optional
	$mail->addReplyTo('orders@schoolpub.com', 'School Publications');
//		$mail->addCC('cc@example.com');
//		$mail->addBCC('bcc@example.com');

    // $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//		$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML
    
    $mail->Subject = $subject;
    $mail->Body    = $message;
       
    // echo $username . PHP_EOL;
    $result = ['response' => -1];
    if (!$mail->send()) {
        // echo 'Message could not be sent.<br>';
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
        $result['response'] = 0;
    } 
    else {
        // echo 'Message has been sent';
        $result['response'] = 1;
    }

    header('Content-type: application/json');
    echo json_encode( $result );  
}

// Not used currently. Using PHPMailer function above instead
function sendMail($email, $confirm, $subject, $message) {    
    global $debugging;
    
    // Set email
    $email_reply = "orders@schoolpub.com";
	$email_from = "spc.schoolpub@gmail.com";
    if ($debugging == 1)
        $email_from = "kevinclark311@gmail.com";

    $headers = "From: " . $email_from . "\r\n";
    $headers .= "Reply-To: " . $email_reply . "\r\n";
    $headers .= "BCC: " . $from_email . "\r\n";
//    $headers .= "CC: kevin@translateabroad.com\r\n"; // jenn@seniorpublishing.net
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (mail($email, $subject, $message, $headers)) {
        echo 'Email sent successfully!';
    } else {
        die('Failure: Email was not sent!');
    }    
}

function buildMessage($email, $confirm) {
    $message = '<html><body>';
    $message .= "<h3><font face='Verdana, sans-serif' color='#576f75'>
            Your order has been submitted!</font></h3>";
    $message .= "<p><font face='Verdana, sans-serif' size='-1' color='#000'>
            Please call School Publications at <b>1-888-637-3200</b> to finalize your order.
            Have your credit card information and confirmation number <b>" . $confirm . "</b> handy.</font></p>";
    $message .= "<h4><font face='Verdana, serif' color='#576f75'>Order Summary:</font></h4>";
    
    $message .= createTable($email);

    $message .= "<br /><p><font face='Verdana, sans-serif' size='-1' color='#000'>
            Thank you,<br>School Publications Company Customer Service</font></p>";
    $message .= "<br /><br /><p style='color: #212a2c; font-family: Verdana, sans-serif; text-align: center;
            font-size: 9px;'>School Publications Company | 1520 Washington Avenue, Neptune NJ 07753 | 1-888-637-3200</p><br />";
    $message .= "</body></html>";
    
    return $message;
}

function createTable($email) {    
    global $filenames;

	// publication info
    $pubName = ucwords(strtolower($_POST["pubInfo_name"]));
    $dimensions = $_POST["pubInfo_dimensions"];
    if (strcmp($dimensions, 'Other') == 0) {
        $dimensions = strtolower($_POST["pubInfo_customDimensions"]);
    }
    $copies = $_POST["pubInfo_copies"];
    $pages = $_POST["pubInfo_insidePages"];
    $color = $_POST["pubInfo_colorPages"];
    $pagesToColor = $_POST["pubInfo_pagesToColor"];
    $paper = $_POST["pubInfo_paperStock"];
    $cover = $_POST["pubInfo_coverStyle"];
    $coverPrintingOptions = str_replace(',', ', ', $_POST['pubInfo_coverPrinting']); // add space after commas
    $binding = $_POST["pubInfo_binding"];

	// contact info
    $advisorName = ucwords(strtolower($_POST["schoolInfo_advisorName"]));
    $school = ucwords(strtolower($_POST["schoolInfo_name"]));
    $street = ucwords(strtolower($_POST["schoolInfo_address"]));
    $city = ucwords(strtolower($_POST["schoolInfo_city"]));
    $state = $_POST["schoolInfo_state"];
    $zip = $_POST["schoolInfo_zip"];
	$phone = $_POST["schoolInfo_phone"];
		
	setlocale(LC_MONETARY, 'en_US.UTF-8');
    $total = money_format('%.2n', $_POST['price_total']);    
		
	// contact info table
    $table = '<table rules="all" frame="box" cellpadding="6" style="color: #212a2c; font-size: 11px;">';
    $table .= "<tr style='font-family: Verdana, sans-serif; font-weight: bold;'><th colspan='2'>Contact Info</th></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Name:</strong></td>
            <td style='font-family: Verdana, sans-serif;'>" . $advisorName . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>School:</strong> </td>
            <td style='font-family: Verdana, sans-serif;'>" . $school . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Address:</strong> </td>
            <td style='font-family: Verdana, sans-serif;'>" . $street . "<br>"
            . $city . ", " . $state . " " . $zip . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Phone:</strong> </td>
            <td style='font-family: Verdana, sans-serif;'>" . $phone . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Email:</strong> </td>
            <td style='font-family: Verdana, sans-serif;'>" . $email . "</td></tr>";
	$table .= "</table><br />";

	// pub info table
	$table .= '<table rules="all" frame="box" cellpadding="6" style="color: #212a2c; font-size: 11px;">';
	$table .= "<tr style='font-family: Verdana, sans-serif; font-weight: bold;'><th colspan='2'>Publication Info</th></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Name:</strong></td>
            <td style='font-family: Verdana, sans-serif;'>" . $pubName . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Dimensions:</strong> </td>
            <td style='font-family: Verdana, sans-serif;'>" . $dimensions . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Number of Copies:</strong> </td>
            <td style='font-family: Verdana, sans-serif;'>" . $copies . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Number of Pages:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $pages . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Number of Color Pages:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $color . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Pages to Color:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $pagesToColor . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Paper Stock:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $paper . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Cover Style:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $cover . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Cover Printing:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $coverPrintingOptions . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Binding:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $binding . "</td></tr>";
    $table .= "</table><br />";
    
    // price
    $table .= "<p style='color: #212a2c; font-family: Verdana, sans-serif; font-size: 14px;'>
                    <b>Order Total: " . $total . "</b></p>";						
    
    // Remove empty strings from $filenames array
    $filenames_mod = implode('', $filenames);
    // Create Uploaded Files table if $filenames_mod is non-empty
    // if ((!empty($filenames_mod)) && ($_POST['button_press'] == "submit")) {
	if (!empty($filenames_mod)) {
        $table .= '<br /><table rules="all" frame="box" cellpadding="6" style="color: #212a2c; font-size: 11px;">';
        $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Uploaded Files</strong></td></tr>";
        foreach ($filenames as $file) {
            if (!empty($file))
            $table .= "<tr><td style='font-family: Verdana, sans-serif;'>" . $file . "</td></tr>";
        }
        $table .= "</table>";
    }
    
    return $table; 
}

function printTable() {
    global $debugging;
    
   $email = "spc.schoolpub@gmail.com";
    if ($debugging == 1)
        $email = "kevinclark311@gmail.com";
    
    // Confirmation number
    $confirm = strtoupper("PRINT_" . substr(md5(uniqid(rand(), true)), 0, 5));    
    $subject = 'Print Notice #' . $confirm;

    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $message = "<html><body>";
    $message .= "<h3><font face='Verdana, sans-serif' color='#576f75'>
            A customer has printed a potential advertisement order (<b>#" . $confirm . "</b>).</font></h3>";
    $message .= "<h4><font face='Verdana, sans-serif' color='#576f75'>Order Summary:</font></h4>";
    $html = createTable();
    $message .= $html;
    $message .= "</body></html>";

    mail($email, $subject, $message, $headers);
   
    return $html;
}

?>