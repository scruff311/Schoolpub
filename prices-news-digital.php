<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SPC Digital Press Newsletters</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="includes/spcstyle.css">
        <script language="javascript" src="includes/new_prices.js"></script>
        <style type="text/css">

            .Quantity
            {
                font-family: "Comic Sans MS", cursive;
                font-size: 14px;
                color: #C00;
            }

            h5
            {
                font-family: Georgia, "Times New Roman", Times, serif;
                font-size: 24px;
                color: #F00;
                background-color: #000;
            }

            .heading
            {
	font-family: Verdana, Geneva, sans-serif;
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

            body_text
            {
                font-family: Georgia, "Times New Roman", Times, serif;
                font-size: 16px;
                font-style: normal;
                line-height: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                color: #000;
            }

            .body_text p
            {
                font-family: Georgia, "Times New Roman", Times, serif;
            }

            .body-text
            {
                font-family: Georgia, "Times New Roman", Times, serif;
                font-size: 16px;
                font-style: normal;
                line-height: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                color: #000;
            }
            
            #content
            {
	width:1000px;
	height: 350px;
	margin-top: 50px;
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
            }
            
            
            #tables
            {
                margin: 0 290px;
                width: 400px;
                height: 250px;
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
                background-color: #cd8484;
            }
            
            #price_table_2 td
            {
                padding: 6px 12px 6px 12px;
                font-size: 14px;
                background: none repeat scroll 0 0 transparent;
                border-bottom: 1px solid #d69999;
                border-top: 1px solid transparent;
                color: #0f0000;
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
                border-left: 1px solid #d69999;
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
                background-color: #bd5a5a;
            }
            
            #total_table td
            {
                padding: 6px 0px 6px 8px;
                font-size: 15px;
                height: 55px;
                background: none repeat scroll 0 0 transparent;
                border-top: 1px solid transparent;
                color: #0f0000;
                font-weight: bold;
            }
            
            select
            {
                background: #eacccc;
                width: 100%;
                font-size: 14px;
                font-family: Verdana, Geneva, sans-serif;
                border: 1px solid #b74c4c;
                color: #0f0000;
            }
            
            #total_table td.price
            {
                padding-left: 15px;
            }
            
            span.per_book
            {
                font-size: 9px;
            }

        body {
	background-color: #FFF;
	background-image: url(images/bg_body-black.png);
	background-repeat: repeat-x;
}
        </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>

<body>
        <div id="content">            
            <p align="center" class="body-text"><span class="heading">Digital Press Newsletter</span></p>
            <p class="body-text">The &quot;Digital Press Newsletter" is SPC's full digital newsletter. Designed to give schools who don't need many copies a very high quality newsletter at unbelievable prices.</p>
            <p class="body-text">Low minimum quantities and page counts make this a great choice for small schools and special projects.</p>
            <br>
            <div id="tables">
                <form id="x700">
                    <table id="price_table_2">
                        <tr>
                            <td>Paper Stock:</td>
                            <td class="right_cells">
                                <select id="type" onchange="update_price()">
                                    <option value="">Choose One</option>
                                    <option value="Poe">Glossy</option>
                                    <option value="Dickinson">White Offset</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Number of Copies:</td>
                            <td class="right_cells">
                                <select id="copies" onchange="update_price()">
                                    <option value="">Choose One</option>
                                    <?php copy_box(); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Number of Pages per Copy:</td>
                            <td class="right_cells">
                                <select id="pages" onchange="update_price('pages')">
                                    <option value="">Choose One</option>
                                    <?php page_box(); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="bottom_cells">Number of Color Pages:</td>
                            <td class="bottom_cells right_cells">
                                <select id="color" onchange="update_price('color')">
                                    <option value="0">0</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table id="total_table">
                        <tr>
                            <td>Printing Total:</td>
                            <td id="print_total" class="price">--<span class="per_book"></span></td>
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
                    <input id="per_book" type="hidden" value="" />
                    <input id="hard" type="hidden" value="0" />
                    <input id="cover" type="hidden" value="self" />
                    <input id="cat" type="hidden" value="none" />
                </form>
            </div>
        </div>
        <?php

        function copy_box() {
            $copies = "";
            for ($i = 25; $i <= 300; $i += 25) {
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


