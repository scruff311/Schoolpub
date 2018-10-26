<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
    ini_set("memory_limit", "-1");

	date_default_timezone_set("America/New_York");

	// switch between debug (local) and live server params
    $debugging = FALSE;
    
	// Confirmation number
	$confirm = strtoupper("SPC" . substr(md5(uniqid(rand(), TRUE)), 0, 7));

    // Set for remote server. Remove for localhost testing.
    // if (!$debugging) {
    //     ini_set("SMTP", "smtp.schoolpub.com");
    //     ini_set("sendmail_from", "orders@schoolpub.com");
    // }

    $isQuote = filter_var ($_POST['isQuote'], FILTER_VALIDATE_BOOLEAN);

    $filenames = saveFiles($confirm);
    if ($isQuote) {
        $subject = 'SPC Literary Magazine Quote #' . $confirm;    
    }
    else {
        $subject = 'SPC Literary Magazine Order Confirmation #' . $confirm;
    }
    $email = $_POST["schoolInfo_email"];
    $message = buildMessage($email, $confirm, $isQuote);
    // // Send confirmation email - use PHP mail on production server, PHPMailer on testing environment
    // if (!$debugging) {
    //     sendMail($email, $confirm, $subject, $message);
    // }
    // else {
        sendMailWithPhpMailer($email, $confirm, $subject, $message);
    // }
		
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
        if (!is_dir($directory)) mkdir($directory, 0777, TRUE);

        if (is_writable($directory)) {
            // do upload logic here
        
            // $filename = $n;
            // $directory = "/uploads/" . $confirm;
            // $file_path = $directory . "/" . $filename;
            $file_path = $directory . $filename;

            // create a folder for this confirmation number if it doesn't exist
            // if (!is_dir($directory)) {
            // 	mkdir($directory, 0777, TRUE);
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

    require 'PHPMailer_5.2.0/class.phpmailer.php';    	
    $mail = new PHPMailer();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    // 3 = verbose debug output
	$mail->SMTPDebug = $debugging ? 3 : 0;
    //Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';

    // Set SMTP account
    $username = $debugging ? 'kevin.smtp.test@gmail.com' : 'kevin@schoolpub.com';
    $password = $debugging ? 'ema!ltester' : 'Spc!pass07717';
    $host = $debugging ? 'smtp.gmail.com' : 'localhost';
                                                   
    $mail->isSMTP();                          // Set mailer to use SMTP
    $mail->Host = $host;  					  // Specify main and backup SMTP servers
    $mail->SMTPAuth = TRUE;                   // Enable SMTP authentication
    $mail->Username = $username;              // SMTP username
    $mail->Password = $password;              // SMTP password
    // $mail->SMTPSecure = 'tls';                // Enable TLS encryption, `ssl` also accepted
    // $mail->Port = 587;                        // TCP port to connect to
    
    $mail->setFrom($username, 'School Publications');
//		$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->AddAddress($email);
	// $mail->addReplyTo('orders@schoolpub.com', 'School Publications');
//		$mail->addCC('cc@example.com');
	$mail->addBCC('spc.schoolpub@gmail.com');

    // $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//		$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(TRUE);                                  // Set email format to HTML
    
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
    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: PUT, GET, POST');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Content-type: application/json');
    echo json_encode( $result );  
}

function sendMail($email, $confirm, $subject, $message) {        
    // Set email
    $email_reply = "orders@schoolpub.com";
    $email_bcc = "spc.schoolpub@gmail.com";
	$email_from = "orders@schoolpub.com";

    $headers = "From: " . $email_from . "\r\n";
    $headers .= "Reply-To: " . $email_reply . "\r\n";
    $headers .= "BCC: " . $email_bcc . "\r\n";
//    $headers .= "CC: kevin@translateabroad.com\r\n"; // jenn@seniorpublishing.net
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";   

    $result = ['response' => -1];
    if (!mail($email, $subject, $message, $headers)) {
        // echo 'Message could not be sent.<br>';
        $result['response'] = 0;
    } 
    else {
        // echo 'Message has been sent';
        $result['response'] = 1;
    }

    header('Content-type: application/json');
    echo json_encode( $result );
}

function buildMessage($email, $confirm, $isQuote) {
    $message = '<html><body>';
    if ($isQuote) {
        $message .= "<h3><font face='Verdana, sans-serif' color='#576f75'>
            Your quote has been submitted!</font></h3>";
        $message .= "<p><font face='Verdana, sans-serif' size='-1' color='#000'>
            We will contact you shortly to discuss your order and answer any questions you may have.</font></p>";
        $message .= "<h4><font face='Verdana, serif' color='#576f75'>Order Summary:</font></h4>";
    }
    else {
        $message .= "<h3><font face='Verdana, sans-serif' color='#576f75'>
            Your order has been submitted!</font></h3>";
        $message .= "<p><font face='Verdana, sans-serif' size='-1' color='#000'>
            Please call School Publications at <b>1-888-637-3200</b> to finalize your order.
            Have your credit card information and confirmation number <b>" . $confirm . "</b> handy.</font></p>";
        $message .= "<h4><font face='Verdana, serif' color='#576f75'>Order Summary:</font></h4>";
    }
    
    $message .= createTable($email, $isQuote);

    $message .= "<br /><p><font face='Verdana, sans-serif' size='-1' color='#000'>
            Thank you,<br>School Publications Company Customer Service</font></p>";
    $message .= "<br /><br /><p style='color: #212a2c; font-family: Verdana, sans-serif; text-align: center;
            font-size: 9px;'>School Publications Company | 1520 Washington Avenue, Neptune NJ 07753 | 1-888-637-3200</p><br />";
    $message .= "</body></html>";
    
    return $message;
}

function createTable($email, $isQuote) {    
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
    $instructions = $_POST["pubInfo_instructions"];

	// contact info
    $advisorName = ucwords(strtolower($_POST["schoolInfo_advisorName"]));
    $school = ucwords(strtolower($_POST["schoolInfo_name"]));
    $street = ucwords(strtolower($_POST["schoolInfo_address"]));
    $city = ucwords(strtolower($_POST["schoolInfo_city"]));
    $state = $_POST["schoolInfo_state"];
    $zip = $_POST["schoolInfo_zip"];
	$phone = $_POST["schoolInfo_phone"];
    
    // price
    $promoCode = $_POST['price_promo'];
	setlocale(LC_MONETARY, 'en_US.UTF-8');
    $total = money_format('%.2n', $_POST['price_total']);

    // proof
    $proof = $_POST['files_proof'];
		
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
    if (!empty($pagesToColor)) {
        $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Pages to Color:</strong> </td>
        <td style='font-family: Verdana, sans-serif;'>" . $pagesToColor . "</td></tr>";
    }
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Paper Stock:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $paper . "</td></tr>";
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Cover Style:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $cover . "</td></tr>";
    if (!empty($coverPrintingOptions)) {
        $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Cover Printing:</strong> </td>
        <td style='font-family: Verdana, sans-serif;'>" . $coverPrintingOptions . "</td></tr>";
    }
    $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Binding:</strong> </td>
                    <td style='font-family: Verdana, sans-serif;'>" . $binding . "</td></tr>";
    if (!empty($proof)) {
        $table .= "<tr><td style='font-family: Verdana, sans-serif;'><strong>Send Proof:</strong> </td>
        <td style='font-family: Verdana, sans-serif;'>" . $proof . "</td></tr>";
    }
    $table .= "</table><br />";
    
    // price
    $totalText = $isQuote ? "Total: " : "Order Total: ";
    $table .= "<p style='color: #212a2c; font-family: Verdana, sans-serif; font-size: 14px;'>
                    <b>" . $totalText . $total . "</b></p><br />";
    // promo
    if (!empty($promoCode)) {
        $table .= "<p style='color: #212a2c; font-family: Verdana, sans-serif; font-size: 11px;'>
                        <b>Promo Code:</b> " . $promoCode . "</p>";
    }
    // instructions
    if (!empty($instructions)) {
        $table .= "<p style='color: #212a2c; font-family: Verdana, sans-serif; font-size: 11px;'>
                        <b>Special Instructions:</b> " . $instructions . "</p>";
    }

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

?>