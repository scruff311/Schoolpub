 
// ############ Constants #############
var per_page = 21.5;
var in_offset_pc = 0.0297;
var base = 92;
var ship = 0.007;
var start_page_count = 8;

// ############ Initialize Global Vars #############
var newsprint_cost = 0;
var add_color_cost = 0;
var coated_pc = 0;
var offset_pc = 0;

function calculateGlobals(pages, copies) {
    
    pages_cost = base + (pages * per_page); 
    addl_cost = start_page_count + (pages *1);
	addl_copies = (copies-200)/100
	// color_cost = (color *1) * 100;
	econotab = 0.75
	Offset = (pages * 1) * (copies * 1) * 0.019
}

function Newsprint(copies) {
    var total = pages_cost + (addl_cost * addl_copies);  
    return total;
}

function WhiteOffset(copies) {
    var total = Newsprint(copies) + Offset; 
    return total;
}

function update_price(sender) {
    var printing_cost = 0;

    var type = document.getElementById('type').value;
    var pages = document.getElementById('pages').value;				  
    var copies = document.getElementById('copies').value;
    var color = document.getElementById('color').value;
    console.log('color: ' + color);

    // If the number of pages was changed, rebuild color page dropdown
    // if ((pages > 0) && (sender == 'pages'))
    //     setColorOptions(type, pages);
    
    // var num_color = document.getElementById('color').value;

    calculateGlobals(pages, copies);   
        
    if (type == "Newsprint") {
        printing_cost = Newsprint(copies);
    }
	
    if (type == "WhiteOffset") {
        printing_cost = WhiteOffset(copies);
    }
	
    printing_cost = Math.round(printing_cost + parseInt(color));
    //var grand_total = printing_cost + shipping + misc + non_four_premium;

    // If all necessary fields are selected, display total
    if (type != "" && copies != "" && pages != "" && cover != "" && cat != "") {
        document.getElementById("per_book").innerHTML = "$" + Math.round(100 * (printing_cost / copies)) / 100;
        document.getElementById("print_total").innerHTML = "<b>$" + printing_cost + "</b>";
    }
    else {
        document.getElementById("per_book").innerHTML = "--";
        document.getElementById("print_total").innerHTML = "<b>--</b>";
    }
}

// Rebuild color selection to be 0 - number of pages. WhiteOffset only gets No or Yes.
// function setColorOptions(type, pages) {
    
//     var colorSelect = document.getElementById("color");
//     colorSelect.options.length = 0;
// }   