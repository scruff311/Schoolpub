<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Literary Magazines</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="includes/spcstyle.css">
        <script language="javascript" src="react-apps/src/assets/js/new_prices.js"></script>
        <script language="javascript" src="includes/js/jquery-1.8.1.min.js"></script>
        <script type="text/javascript">
            
            function MM_swapImgRestore() { //v3.0
                var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
            }
            
            function MM_preloadImages() { //v3.0
                var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
                    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
                        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
                }
                
                function MM_findObj(n, d) { //v4.01
                    var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                        d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                    if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
                    for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                    if(!x && d.getElementById) x=d.getElementById(n); return x;
                }

                function MM_swapImage() { //v3.0
                    var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
                    if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
                }
                
                $(document).ready(function(){

                    $("a.mags").bind('click', function(event) {
                        event.preventDefault();
                        console.log("ID = " + $(this).attr("href"));

                        $("#mag_frame").attr("src", $(this).attr("href"));

                    });
                    
                    $("#type").bind('change', function(event) {
                        var type = $(this).val();
                        var page_select = document.getElementById("pages");
                        var pages = page_select.options[page_select.selectedIndex].value;
                        var color_select = document.getElementById("color");
                        var color = color_select.options[color_select.selectedIndex].value;
                        
                        if (type == "Hemingway") {
                            document.getElementById("color_tag").innerHTML = "Full Color:";
                            document.getElementById("color_cell").innerHTML =
                                "<select id='color' onchange='updatePrice(&quot;color&quot;)'>\n\
                                            <option value='0'>No</option>\n\
                                            <option value='" + pages + "'>Yes</option>\n\
                                        </select>";
            
                            var color_select_2 = document.getElementById("color");
                            
                            if (color > 0) {                                
                                color_select_2.selectedIndex = 1;
                            }
                            else {                                
                                color_select_2.selectedIndex = 0;
                            }
                        }
                        else {
                            setColorOptions(type, pages);
                            document.getElementById("color_tag").innerHTML = "Number of Color Pages:";
                            color_select.selectedIndex = color;
                        }
                        
                        updatePrice();
                        
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
	color: #FF0;
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
                height: 750px;
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
                background-color: #000;
                text-align: center;
            }


            #tables
            {
                margin-left: auto;
                margin-right: 15px;
                width: 400px;
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
                text-align: left;
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
                text-align: left;
            }

            #total_table td
            {
                padding: 4px 0px 4px 8px;
                font-size: 15px;
                height: 50px;
                background: none repeat scroll 0 0 transparent;
                border-top: 1px solid transparent;
                color: #0f0000;                
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

            #mag_types_table
            {
                margin-left: auto;
                margin-right: auto;
                width: 700px;
            }
            
            #mag_info
            {                
                float: left;
                width: 555px;
                height: 515px;
                margin-left: 8px;
                border-radius: 8px;
                -moz-border-radius: 8px 8px 8px 8px;
                -webkit-border-top-left-radius: 8px;
                -webkit-border-top-right-radius: 8px;
                -webkit-border-bottom-left-radius: 8px;
                -webkit-border-bottom-right-radius: 8px;
                background-color: #E9DAB7;
                text-align: left;
            }
            
            #section2
            {
                margin-top: 15px;
            }
            
            .shadow
            {
                box-shadow: 0px 0px 15px 0px #cd8484;
            }
            
            image
            {
                border: 0px;
            }
            
            iframe
            {
                width: 545px;
                height: 505px;
                border: none;
                padding: 5px;
            }
            
            a
            {
                color: #990000;
            }
            
            a:hover
            {
	color: #FF0;
            }
            

        .yellow {
	color: #FF0;
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

<body onload="MM_preloadImages('images/Hemingway2.png','images/Dickinson2.png','images/Frost2.png')">
<div id="content">            
            <p align="left" class="body-text"><span class="heading">SPC Literary Magazines</span></p>
<!--            <p class="body-text">The &quot;X700 Newsletter" is SPC's newest newsletter. Designed to give schools who don't need many copies a very high quality newsletter at unbelievable prices.</p>
            <p class="body-text">Low minimum quantities and page counts make this a great choice for small schools and special projects.</p>-->
            <div id="section1">
                <table id="mag_types_table" border="0">
                    <tr>
                        <td width="25%" height="37" align="center" valign="middle" class="body_text"><a href="lm-poe.html" class="mags" id="lm-dick2" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Poe','','images/Poe2.png',1)"> <img src="images/Poe.png" alt="Poe prices" name="Poe" width="116" height="150" border="0" id="Poe" /> <br />
                <span class="yellow">The Poe</span></a></td>
                        <td width="25%" align="center" valign="middle" class="body_text"><a href="lm-dickinson.html" class="mags" id="lm-dick" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Dickinson','','images/Dickinson2.png',1)"> <img src="images/Dickinson.png" alt="Dickinson prices" name="Dickinson" width="116" height="150" border="0" id="Dickinson" /> <br />
                        <span class="yellow">The Dickinson</span></a></td>
                        <td width="25%" align="center" valign="middle" class="body_text"><a href="lm-frost.html" class="mags" id="lm-frost" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Frost','','images/Frost2.png',1)"> <img src="images/Frost.png" alt="Frost prices" name="Frost" width="132" height="150" border="0" id="Frost" /> <br />
                        <span class="yellow">The Frost</span></a></td>
                        <td width="25%" align="center" valign="middle" class="body_text"><a href="lm-hemingway.html" class="mags" id="lm-hem" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Hemingway','','images/Hemingway2.png',1)"> <img src="images/Hemingway.png" alt="Hemingway" name="Hemingway Prices" width="116" height="150" border="0" id="Hemingway" /> <br />
                        <span class="yellow">The Hemingway</span></a></td>
                    </tr>
                </table>
  </div>
            <br>
            <div id="section2">
            <div id="mag_info" class="shadow">
                <iframe id="mag_frame" src="lm-poe.html"></iframe>                
            </div>
            <div id="tables">
                <form id="lit-mag">
                    <table id="price_table_2">
                        <tr>
                            <td>Type of Magazine:</td>
                            <td class="right_cells">
                                <select id="type">
                                    <option value="">Choose One</option>
                                    <option value="Poe">Poe</option>
                                    <option value="Hemingway">Hemingway</option>
                                    <option value="Dickinson">Dickinson</option>
                                    <option value="Frost">Frost</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Type of Binding:</td>
                            <td class="right_cells">
                                <select id="cover" onchange="updatePrice()">
                                    <option value="">Choose One</option>
                                    <option value="self">Self Cover</option>
                                    <option value="soft">Soft Cover</option>                                    
                                </select>
                            </td>
                        </tr>
<!--                        <tr>
                            <td>Paper Stock:</td>
                            <td class="right_cells">
                                <select id="stock" onchange="updatePrice()">
                                    <option value="">Choose One</option>
                                    <option value="Glossy">Glossy</option>
                                    <option value="Offset">White Offset</option>
                                </select>
                            </td>
                        </tr>-->
                        <tr>
                            <td>Number of Copies:</td>
                            <td class="right_cells">
                                <select id="copies" onchange="updatePrice()">
                                    <option value="">Choose One</option>
                                    <?php copy_box(); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Number of Pages per Copy:</td>
                            <td class="right_cells">
                                <select id="pages" onchange="updatePrice('pages')">
                                    <option value="">Choose One</option>
                                    <?php page_box(); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td id="color_tag" class="bottom_cells">Number of Color Pages:</td>
                            <td id="color_cell" class="bottom_cells right_cells">
                                <select id="color" onchange="updatePrice('color')">
                                    <option value="0">0</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table id="total_table">
<!--                        <tr>
                            <td>Price per Book:</td>
                            <td id="per_book" class="price">--</td>
                        </tr>-->
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
                    <input id="per_book" type="hidden" value="" />
                    <input id="hard" type="hidden" value="0" />
                    <input id="cat" type="hidden" value="none" />
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
    </body>

</html>



