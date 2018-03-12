<?php
	date_default_timezone_set("America/New_York");

	// switch between debug (local) and live server params
	$debugging = 1;
	// Confirmation number
	$confirm = strtoupper("SPC" . substr(md5(uniqid(rand(), true)), 0, 7));
/*
    // Set for remote server. Remove for localhost testing.
    if ($debugging == 0) {
        ini_set("SMTP", "scriptmail.intermedia.net");
        ini_set("sendmail_from", "orders@seniorpublishing.net");
    }
*/

	$filenames = saveFiles();
    
    // // Determine if Submit or Print was pressed
    // if ($_POST['button_press'] == "submit") {
    // // Send confirmation email
  sendMail();
    // } else if ($_POST['button_press'] == "print") {
    // // Print order and send email to SPC
    //     $tableHTML = printTable();
    //     echo $tableHTML;
    // } else {
    // // No button pressed
    //     echo "No button";
		// }
		
function saveFiles() {
	global $confirm;

	$filenames = array();
	$i = 0;

	foreach ($_FILES as $file) {
		$n = $file['name'];
		$s = $file['size'];
		$t = $file['tmp_name'];
		if (!$n)
				continue;

		// $filename = $confirm . "_" . $n;
		// $directory = "uploads";
		$filename = $n;
		$directory = "uploads/" . $confirm;
		$file_path = $directory . "/" . $filename;

		// create a folder for this confirmation number if it doesn't exist
		if (!is_dir($directory)) {
			mkdir($directory, 0777, true);
		}

		if (move_uploaded_file($t, $file_path)) {
			$filenames[$i] = $filename;
			$i++;
		}
		else {
				echo $filename . " upload FAILED!\n";
		}
	}

	return $filenames;
}

function sendMail() {
    
    global $confirm, $debugging;
    
    // Set email
	  $from_email = "spc.ad.orders@gmail.com";
    if ($debugging == 1)
        $from_email = "kevinclark311@gmail.com";
    
    // Confirmation number
    if ($confirm == '0') {
        $confirm = strtoupper("SPC" . substr(md5(uniqid(rand(), true)), 0, 7));
    }    
    
    $subject = 'SPC Order Confirmation #' . $confirm;

    $headers = "From: " . $from_email . "\r\n";
    $headers .= "Reply-To: " . $from_email . "\r\n";
    $headers .= "BCC: " . $from_email . "\r\n";
//    $headers .= "CC: kevin@translateabroad.com\r\n"; // jenn@seniorpublishing.net
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$email = $_POST["schoolInfo_email"];

		$message = buildMessage($email);
		echo $message;

    if (mail($email, $subject, $message, $headers)) {
        echo 'Email sent successfully!';
    } else {
        die('Failure: Email was not sent!');
    }
    
}

function buildMessage($email) {
		global $confirm;

    $message = '<html><body>';
    $message .= "<h3><font face='Verdana, sans-serif' color='#576f75'>
            Your order has been submitted!</font></h3>";
    $message .= "<p><font face='Verdana, sans-serif' size='-1' color='#000'>
            Please call School Publications at <b>1-888-637-3200</b> to finalize your order.
            Have your credit card information and confirmation number <b>" . $confirm . "</b> handy.</font></p>";
    $message .= "<h4><font face='Verdana, serif' color='#576f75'>Order Summary:</font></h4>";
    
    $message .= createTable($email);

    $message .= "<br /><p><font face='Verdana, sans-serif' size='-1' color='#000'>
            Thank you,<br>School Publiscations Company Customer Service</font></p>";
    $message .= "<br /><br /><p style='color: #212a2c; font-family: Verdana, sans-serif; text-align: center;
            font-size: 9px;'>School Publiscations Company | 1520 Washington Avenue, Neptune NJ 07753 | 1-888-637-3200</p><br />";
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

function printTable()
{
    global $debugging;
    
//    $email = "spc.schoolpub@gmail.com";
	$email_to = "spc.schoolpub@gmail.com";
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