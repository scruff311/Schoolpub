<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Yearbooks</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="includes/spcstyle.css">
        <script language="javascript" src="includes/new_prices_yb.js"></script>
        <script language="javascript" src="includes/js/jquery-1.8.1.min.js"></script>
        <script type="text/javascript">     
            $(document).ready(function(){
                // Function to change page selection based on hard cover being selected
                $("#hard").bind('change', function(event) {
                    var hard = $(this).val();
                    var page_select = document.getElementById("pages");
                    var pages = page_select.options[page_select.selectedIndex].value;
                    page_select.options.length = 0;
                    
                    var j = 0;
                    if (hard > 0) {
                        for (i = 48; i <= 160; i+=4) {
                            page_select.options[j] = new Option(i, "" + i + "");
                            if (i == pages){
                                page_select.selectedIndex = j;
                            }
                            j++;
                        }
                    }
                    else {
                        for (i = 12; i <= 160; i+=4) {
                            page_select.options[j] = new Option(i, "" + i + "");
                            if (i == pages){
                                page_select.selectedIndex = j;
                            }
                            j++;
                        }                        
                    }

                    update_price();
                    
                });
            });
        </script>
        <style type="text/css">

            body
            {
	text-align: center;
	background-image: url(images/bg_body-black.png);
	background-color: #FFF;
	background-repeat: repeat-x;
	margin-bottom: 50px;
            }

            a
            {
                color: #306632;
            }

            a:hover
            {
                color: #0c190c;
            }          

            .heading
            {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 24px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	text-align: center;
	vertical-align: top;
	color: #060;
            }            

            .body-text
            {
                font-family: Verdana, Geneva, sans-serif;
                font-size: 14px;
                font-style: normal;
                line-height: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                text-align: left;
                color: #0c190c;
            }

            #content
            {
	width:900px;
	height: 485px;
	margin-top: 25px;
	padding-bottom: 60px;
	padding-left: 10px;
	padding-top: 1px;
	border-radius: 8px;
	-moz-border-radius: 8px 8px 8px 8px;
	-webkit-border-top-left-radius: 8px;
	-webkit-border-top-right-radius: 8px;
	-webkit-border-bottom-left-radius: 8px;
	-webkit-border-bottom-right-radius: 8px;
	background-color: #CCC;
	text-align: center;
            }

            #tables
            {
                margin-left: auto;
                margin-right: 18px;
                width: 400px;
                height: 300px;
            }

            #price_table_2
            {
	border-collapse: collapse;
	width: 400px;
	height: 150px;
	float: right;
	margin-bottom: 15px;
	border-radius: 8px;
	-moz-border-radius: 8px 8px 8px 8px;
	-webkit-border-top-left-radius: 8px;
	-webkit-border-top-right-radius: 8px;
	-webkit-border-bottom-left-radius: 8px;
	-webkit-border-bottom-right-radius: 8px;
	background-color: #000;
	text-align: left;
            }

            #price_table_2 td
            {
	padding: 6px 12px 6px 12px;
	font-size: 14px;
	background: none repeat scroll 0 0 transparent;
	border-bottom: 1px solid #bcffbf;
	border-top: 1px solid transparent;
	color: #FFF;
            }

            #price_table_2 tr
            {
                background: none repeat scroll 0 0 transparent;
                border: 0 none;
                font-size: 100%;
                margin: 0;
                outline: 0 none;
                padding: 0;
                vertical-align: baseline;

            }

            #price_table_2 td.bottom_cells
            {
                border-bottom: 1px solid transparent;
            }

            #price_table_2 td.right_cells
            {
                border-left: 1px solid #bcffbf;
            }

            #total_table
            {
	border-collapse: collapse;
	float: right;
	width: 240px;
	/*                height: 250px;*/
                border-radius: 8px;
	-moz-border-radius: 8px 8px 8px 8px;
	-webkit-border-top-left-radius: 8px;
	-webkit-border-top-right-radius: 8px;
	-webkit-border-bottom-left-radius: 8px;
	-webkit-border-bottom-right-radius: 8px;
	background-color: #000;
	text-align: left;
            }

            #total_table td
            {
	padding: 0px 0px 0px 8px;
	font-size: 15px;
	height: 40px;
	background: none repeat scroll 0 0 transparent;
	border-top: 1px solid transparent;
	color: #FFF;
            }

            select
            {
                background: #d7ffd8;
                width: 100%;
                font-size: 14px;
                font-family: Verdana, Geneva, sans-serif;
                border: 1px solid #55b258;
                color: #0c190c;
            }

            #total_table td.price
            {
                padding-left: 15px;
            }

            span.per_book
            {
                font-size: 9px;
            }

            #mag_types_table
            {
                margin-left: auto;
                margin-right: auto;
                width: 700px;
            }

            #mag_info
            {
	float: left;
	width: 450px;
	height: 365px;
	margin-left: 12px;
	border-radius: 8px;
	-moz-border-radius: 8px 8px 8px 8px;
	-webkit-border-top-left-radius: 8px;
	-webkit-border-top-right-radius: 8px;
	-webkit-border-bottom-left-radius: 8px;
	-webkit-border-bottom-right-radius: 8px;
	background-color: #000;
	text-align: left;
            }

            #section2
            {
                margin-top: 25px;
            }

            .shadow
            {
                box-shadow: 0px 0px 15px 0px #a1ffa5;
            }

            image
            {
                border: 0px;
            }

            #book_info td
            {
	font-size: 14px;
	color: #FFF;
	padding: 3px;
            }

        a:link {
	color: #00F;
}
a:visited {
	color: #06F;
}
        </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>

<body>
<div id="content">            
            <p class="heading">SPC Yearbook Prices</p>
            <p class="body-text" style="margin-left: 12px; margin-right: 12px;">We have a complete line of yearbooks to fit your needs.
                You have the option of laying out your pages on computer, pasting your pages by hand, or having SPC do all the work for you. All SPC
                yearbooks are available with either a soft or hard cover. Below are the three
</p>
            <div id="section2">
                <div id="mag_info" class="shadow">
    <!--                <iframe id="mag_frame" src="lm-poe.html"></iframe>                -->
                    <table id="book_info">
                        <tr>
                            <td height="361"><b>Print Ready File - Finished file ready to be printed.<br>
                            <br>
                            Scan Ready Pages - Hand pasted and mailed to us. We scan and print those pages.<br>
                            <br>
                            SPC Student Page Layout - 
                            Finished files for entire book except SPC will  layout your student pages.<br>
                            <br>
                            Full Assistance - SPC Lays out your entire book. Just send us your information and pictures.<br>
                            <br>
<br>
                            Contact Us:<br>
                            School Publication Co.<br>
                            Phone: (888) 543-1000<br>
                            Fax: (877) 536-5153<br>
                            info@schoolpub.com
                          </b></td>
                        </tr>
                    </table>
    </div>
                <div id="tables">
                    <form id="lit-mag">
                        <table width="495" id="price_table_2">
                            <tr>
                                <td width="145" align="center" valign="middle">Type of Yearbook:</td>
                                <td width="316" align="center" valign="middle" class="right_cells">
                                    <select id="cat" onChange="update_price()">
                                        <option value="">Choose One</option>
                                        <option value="Lion">Finished Print Ready File</option>
                                        <option value="Tiger">Scan Ready Pages</option>
                                        <option value="Cougar">SPC Student Page Layout</option>
                                        <option value="silk">Full Assistance</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="middle">Hard Cover:</td>
                                <td align="center" valign="middle" class="right_cells">
                                    <select id="hard" onChange="update_price()">
                                        <option value="0">No</option>
                                        <option value="1">Yes - 48 page minimum</option>                                    
                                    </select>
                                </td>
                            </tr>
    <!--                        <tr>
                                <td>Paper Stock:</td>
                                <td class="right_cells">
                                    <select id="stock" onchange="update_price()">
                                        <option value="">Choose One</option>
                                        <option value="Glossy">Glossy</option>
                                        <option value="Offset">White Offset</option>
                                    </select>
                                </td>
                            </tr>-->
                            <tr>
                                <td align="center" valign="middle">Number of Copies:</td>
                                <td align="center" valign="middle" class="right_cells">
                                    <select id="copies" onChange="update_price()">
                                        <option value="">Choose One</option>
                                        <?php copy_box(); ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="middle">Number of Pages per Copy:</td>
                                <td align="center" valign="middle" class="right_cells">
                                    <select id="pages" onChange="update_price('pages')">
                                        <option value="">Choose One</option>
                                        <?php page_box(); ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="middle" class="bottom_cells" id="color_tag">Number of Color Pages:</td>
                                <td align="center" valign="middle" class="bottom_cells right_cells" id="color_cell">
                                    <select id="color" onChange="update_price('color')">
                                        <option value="0">0</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                <br>
                        <table id="total_table">
                            <tr>
                                <td>Price per Book:</td>
                                <td id="per_book" class="price">--</td>
                            </tr>
                            <tr>
                                <td><b>Printing Total:</b></td>
                                <td id="print_total" class="price"><b>--</b></td>
                            </tr>
                            <!--                        
                                                    <tr>
                                                        <td><b>Grand Total:</b></td>
                                                        <td id="grand_total" class="price" style="font-weight: bold;"
                                                            ><span class="per_book"></span></td>
                                                    </tr>                                                                                                                                                                                                        </tr>
                            -->
                        </table>
                        <!-- These hidden fields are required defaults for the calculations to work -->
                        <input id="cover" type="hidden" value="soft" />
                        <input id="type" type="hidden" value="Poe" />
                    </form>
                </div>
            </div>
        </div>
        <?php

        function copy_box() {
            $copies = "";
            for ($i = 25; $i <= 1000; $i += 25) {
                $copies .= "<option value=" . $i . ">$i</option>";
            }

            print($copies);
        }

        function page_box() {
            $pages = "";
            for ($i = 12; $i <= 160; $i += 4) {
                $pages .= "<option value=" . $i . ">$i</option>";
            }

            print($pages);
        }
        ?>
    <a href="yb-home.html">Back To Yearbook Home Page </a>
</body>

</html>