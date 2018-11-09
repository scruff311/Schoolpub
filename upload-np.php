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
	font-size:24px;
	font-family:Arial,Verdana,sans-serif;
	color: #F00;
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
.red {
	color: #F00;
}
</style>

</head>
<body class="content">
<div id="UploadForm">


<!--<information form>--> 
  <form action="upload-np-send.php" Xaction="http://www.schoolpub.com/SPCUpload/upload" method="post" enctype="multipart/form-data" onSubmit="return Validate();" name="form1" id="form1">


<!--<input type="hidden" name="recipient" value="leads@schoolpub.com">
<input type="hidden" name="recipient" value="leads@schoolpub.com">
<input type="hidden" name="subject" value="Online Request Form">
<input type="hidden" name="redirect" value="thankyou.asp">
<input type="hidden" name="required" value="School, Advisor, Street, City, State, Zip, Phone, email,Publication, FileList" >        -->  
<table width="700" border="0" align="center" cellpadding="3">
    <tr>
      <td colspan="2" align="center"><h2>SPC Newspaper Upload Form</h2></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><strong>Privacy Policy</strong></td>
    </tr>
    <tr>
      <td colspan="2">Complet the job information for below. <br>
      When you are finished click the Submit Info button at the bottom of the form, <br>
      which will redirect you to the Upload Files form.</td>
    </tr>
    <tr>
      <td colspan="2" class="yellow"><h2><span class="Subhead">School Information</span></h2></td>
    </tr>
    <tr>
      <td colspan="2" class="OrderForm"><strong>Fields Labeled In <span class="red">RED</span> Are Required Fields.</strong></td>
      </tr>
    <tr>
      <td width="217" class="red">School Name:</td>
      <td width="465" align="left" class="OrderFormInfo"><input type="text" size="40" name="School" id="School" required></td>
    </tr>
    <tr>
      <td class="red">Advisor's Name: </td>
      <td align="left" class="OrderFormInfo"><input type="text" size="40" name="Advisor" id="Advisor" required></td>
    </tr>
    <tr>
      <td class="red">School Address: </td>
      <td align="left" class="OrderFormInfo"><input type="text" size="40" name="Street" id="Street" required></td>
    </tr>
    <tr>
      <td class="red">City:</td>
      <td align="left" class="OrderFormInfo"><input type="text" size="40" name="City" required></td>
    </tr>
    <tr>
      <td class="red">State:</td>
      <td align="left" class="OrderFormInfo"><input type="text" size="6" name="State" required></td>
    </tr>
    <tr>
      <td class="red">Zip Code:</td>
      <td align="left" class="OrderFormInfo"><input type="text" size="12" name="Zip" required></td>
    </tr>
    <tr>
      <td class="OrderForm"><span class="red">Phone:</span> (please include area code)</td>
      <td align="left" class="OrderFormInfo"><input type="text" size="25" name="Phone" id="Phone" required></td>
    </tr>
    <tr>
      <td class="OrderForm">Fax: (please include area code)</td>
      <td align="left" class="OrderFormInfo"><input type="text" size="25" name="Fax" id="Fax"></td>
    </tr>
    <tr>
      <td class="red">School Email Address:</td>
      <td align="left" class="OrderFormInfo"><input type="text" size="40" name="email" required></td>
    </tr>
    <tr>
      <td class="OrderForm">Your Name: </td>
      <td align="left" class="OrderFormInfo"><input type="text" size="40" name="YourName"></td>
    </tr>
    <tr>
      <td class="OrderForm">Your Email:</td>
      <td align="left" class="OrderFormInfo"><input type="text" size="40" name="YourEmail"></td>
    </tr>
    <tr>
      <td colspan="2" class="Subhead">Complete Billing Section If Different Than Above</td>
    </tr>
    <tr>
      <td class="OrderForm">Billing Name:</td>
      <td class="OrderFormInfo"><input type="text" size="40" name="BillingName" id="BillingName"></td>
    </tr>
    <tr>
      <td class="OrderForm">Billing Address:</td>
      <td class="OrderFormInfo"><input type="text" size="40" name="BillingAddress" id="BillingAddress"></td>
    </tr>
    <tr>
      <td class="OrderForm">Billing City, ST ZIP:</td>
      <td class="OrderFormInfo"><input type="text" size="40" name="BillingCitySTZip" id="BillingCitySTZip"></td>
    </tr>
    <tr>
      <td class="OrderForm">Purchase Order Number:</td>
      <td class="OrderFormInfo"><input type="text" size="40" name="PONumber" id="PONumber"></td>
    </tr>
    <tr>
      <td colspan="2" class="Subhead"><h2>Job Information</h2></td>
    </tr>
    <tr>
      <td class="red">Publication Name:</td>
      <td class="OrderFormInfo"><input type="text" size="60" name="Publication" id="Publication" required></td>
    </tr>
    <tr>
      <td class="red">Page Size:</td>
      <td class="OrderFormInfo"><label>
        <select name="PaperSize" id="PaperSize" required>
          <option value="Tabloid" selected>Tabloid (11 x 17)</option>
          <option value="Newsletter">Newsletter (8.5 x 11)</option>
          </select>
        </label></td>
    </tr>
    <tr>
      <td class="red">Paper Stock:</td>
      <td class="OrderFormInfo"><label>
        <select name="PaperStock" id="PaperStock" required>
          <option value="Newsprint" selected>Newsprint (tabloid only)</option>
          <option value="White Offset">White Offset</option>
          <option value="Glossy">Glossy (newsletter only)</option>
          </select>
        </label></td>
    </tr>
    <tr>
      <td class="red">Number Of Copies:</td>
      <td class="OrderFormInfo"><select name="copies" id="copies"  required>
                                <option value="">Choose One</option>
                                    <?php copy_box(); ?>  </select>          
    </tr>
    <tr>
      <td class="red">Number Of Pages:</td>
      <td class="OrderFormInfo"><select name="pages" id="pages"  required>
                                <option value="">Choose One</option>
                                    <?php page_box(); ?>  </select>     
      
      
      
      
 <!--     <input type="text" size="12" name="NoPages" id="NoPages" required></td> -->
    </tr>
    <tr>
      <td class="OrderForm">Send PDF Proof:</td>
      <td class="OrderFormInfo"><label>
        <select name="SendProof" id="SendProof">
          <option value="Yes">Yes</option>
          <option value="No" selected>No</option>
          </select>
        </label></td>
    </tr>
    <tr>
      <td class="red">Color Pages:</td>
      <td class="OrderFormInfo"><label>
        <select name="ColorPages" id="ColorPages" required>
          <option value="None" selected>None</option>
          <option value="FBC 4/1">Front, Back, Center (4 pages) - $250</option>
          <option value="Front-Back">Front and Back (2 pages) - $250</option>
          <option value="FBC and Insides * pages - 4/4">Front, Back, Inside Covers, 4 Center Pages (8 pages) - $375</option>
          <option value="Full Color">Full Color (call for pricing)</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td class="OrderForm">Promo Code:</td>
      <td class="OrderFormInfo"><input type="text" size="20" name="PromoCode" id="PromoCode"></td>
    </tr>
    <tr>
      <td colspan="2" class="Subhead"><h2>Shipping Information</h2></td>
    </tr>
    <tr>
      <td class="OrderForm">Ship To:</td>
      <td class="OrderFormInfo"><label>
        <select name="ShipTo" id="ShipTo">
          <option value="School Address" selected>School Address</option>
          <option value="Billing Address">Billing Address</option>
          </select>
        </label></td>
    </tr>
    <tr>
      <td class="OrderForm">Ship Via:</td>
      <td class="OrderFormInfo"><label>
        <select name="ShipVia" id="ShipVia">
          <option value="Ground" selected>Ground (no shipping charge)</option>
          <option value="Next Day Saver">Next Day Anytime</option>
          <option value="Next Day AM">Next Day AM (approx 10:30)</option>
          <option value="Next Day Early">Next Day Early (approx 8:30 am)</option>
          </select> 
        shipping chargess are in addition to printing prices
        </label></td>
    </tr>
    <tr>
      <td class="OrderForm">Special Instructions:</td>
      <td><textarea name="SpecialInstructions" cols="50" rows="4" class="OrderFormInfo" id="SpecialInstructions" style="width:100%;"></textarea></td>
    </tr>
    </table>
  
  
  


<!--<upload section>-->

<div style="width:600px;margin:0px auto 0px auto;text-align:left;">
  <fieldset>
		<p class="jungle_head">
		  <legend>Attention:	90	MB Limit</legend>
		</p>
		<p><b style="color: #F00">		  The file size limit is currently 90 MB. <br>
If you are uploading multiple files the combined size can be no more than 90 MB.</b></p>
		<table border="0" cellpadding="20" cellspacing="0" ID="Files">
		  <tr>
				<td style="text-align:center;border-right:solid 1px #C4B99D">&nbsp;</td>
				<td>
					<input class="std" type="File" name="FILE1" required><br>
					<input class="std" type="File" name="FILE2"><br>
					<input class="std" type="File" name="FILE3"></td>
			</tr>
		</table>
	</fieldset>
	<p align="center"><input type="submit" value=" Submit Your Order " name="Submit" id="Submit"></p>
<!--  	<div style="position:absolute;top:-5000px;"><input type="text" name="cc_SHIPPINGCHARGES" id="cc_SHIPPINGCHARGES"></div>   -->
	
</div>


</form>
</div>
&nbsp;
<div id="PleaseWait"><EMBED src="pics/spcpleasewait.swf" Flashvars="" quality=high bgcolor=#E0CA99  WIDTH=550 HEIGHT=200 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED></div>
</body>

        <?php

        function copy_box() {
            $copies = "";
            for ($i = 200; $i <= 3000; $i += 100) {
                $copies .= "<option value=" . $i . ">$i</option>";
            }

            print($copies);
        }

        function page_box() {
            $pages = "";
            for ($i = 2; $i <= 48; $i += 2) {
                $pages .= "<option value=" . $i . ">$i</option>";
            }

            print($pages);
        }
        ?>
    </body>




</html>
