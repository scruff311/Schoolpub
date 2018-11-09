// ############ Constants #############
var b_charge_pg_copy = 0.044;
var c_charge_pg_copy = 0.033;
var in_coated_pc = 0.0429;
var in_offset_pc = 0.0297;
var cover_stock = 0.30;
var base = 175;
var cover_base = 15;
var sec_pg = 2;
var color_click = 0.049;
var black_click = 0.0129;
var full_layout = 15;
var type_set = 5;
var scan_pg = 3;
var ship = 0.007;
var half_size_mult = 0.85;

// ############ Initialize Global Vars #############
var black_cost = 0;
var add_color_cost = 0;
var coated_pc = 0;
var offset_pc = 0;
var hours = 0;
var click_charge = 0;
var hem_color_cost = 0;

function calculateGlobals(pages, copies, color, cover) {
    black_cost = (pages / 2) * b_charge_pg_copy * copies;
    add_color_cost = color * copies * c_charge_pg_copy;
    coated_pc = (pages / 2) * in_coated_pc * copies;
    offset_pc = (pages / 2) * in_offset_pc * copies;
    hours = pages * copies * (sec_pg / 3600);
    click_charge = (((pages - color) / 2) * copies * black_click) + ((color / 2) * copies * color_click);
    if (cover == 'soft')
        click_charge += (copies * color_click);
    
    hem_color_cost = 20 * color;    
}

function poe(copies, cover) {
    var total = (black_cost + add_color_cost + coated_pc + base);
    if (cover == 'soft') {
        total += (copies * c_charge_pg_copy * 3.5) + (copies * cover_stock) + cover_base;
    }
    
    return total;
}

function hemingway(pages, copies, cover) {
    var total = ((pages * 20.5 * 0.25) + 87) + (((9 + (pages - 4) / 2)) * (copies - 200) / 100)
        + (pages * copies * 0.0035) + (pages * copies * 0.0075) + 100 + hem_color_cost;

    if (cover == 'soft') {
        total += 300;
    }
    
    return total;
}

function dickinson(copies, cover) {
    var total = black_cost + add_color_cost + offset_pc + base;
    if (cover == 'soft') {
        total += (copies * c_charge_pg_copy * 3.5) + (copies * cover_stock) + cover_base;
    }
    
    return total;
}

function calcHardCover(copies) {
    if (copies < 100)
        return 1400;    
    else if (copies >= 100 && copies < 200)
        return copies * 14;
    else if (copies >= 200 && copies < 300)
        return copies * 12.5;
    else if (copies >= 300 && copies < 400)
        return copies * 10.5;
    else if (copies >= 400 && copies < 500)
        return copies * 9.75;
    else if (copies >= 500 && copies < 600)
        return copies * 9.5;
    else if (copies >= 600 && copies < 700)
        return copies * 9.3;
    else if (copies >= 700 && copies < 800)
        return copies * 9.15;
    else if (copies >= 800 && copies < 900)
        return copies * 9;
    else if (copies >= 900 && copies < 1000)
        return copies * 8.85;
    else
        return copies * 8.7;
}

function calcPerf(copies) {
    if (copies < 100)
        return copies;    
    else if (copies >= 100 && copies < 250)
        return copies * 0.75;
    else
        return copies * 0.5;
}

function update_price(sender) {
//    var shipping = 0;
//    var misc = 0;
    var printing_cost = 0;
    var hard_cover_cost = 0;
    
    var type = document.getElementById('type').value;
    var pages = document.getElementById('pages').value;				  
    var copies = document.getElementById('copies').value;
    var cover = document.getElementById('cover').value; 
    var hard = document.getElementById('hard').value;
    var cat = document.getElementById('cat').value;

    // If the number of pages was changed, rebuild color page dropdown
    if((pages > 0) && (sender == 'pages'))
        setColorOptions(type, pages);
    
    var num_color = document.getElementById('color').value;

    calculateGlobals(pages, copies, num_color, cover);
    
    if (hard > 0)
        hard_cover_cost = calcHardCover(copies);
		
	// if (perf > 0) <--- there is no variable named perf, so I am commenting this out
    perf_cost = calcPerf(copies);
        
    if (type == "Poe") {
        printing_cost = poe(copies, cover);
        if (cat == "Tiger") {
            printing_cost += (pages * scan_pg);
        }
        else if (cat == "Cougar") {
            printing_cost += (pages * type_set);
		}
		else if (cat == "silk") {
            printing_cost += (pages * full_layout);
        }
    }
    if (type == "Hemingway") {
        printing_cost = hemingway(pages, copies, cover);
    }
    if (type == "Dickinson") {
        printing_cost = dickinson(copies, cover);
    }
    if (type == "Frost") {
        printing_cost = poe(copies, cover) * half_size_mult;
    }

    printing_cost = Math.round((printing_cost + hard_cover_cost + perf_cost));
    //var grand_total = printing_cost + shipping + misc + non_four_premium;

    // If all necessary fields are selected, display total
    if (type != "" && copies != "" && pages != "" && cover != "" && cat != "") {
        document.getElementById("per_book").innerHTML = "$" + Math.round(100 * (printing_cost / copies)) / 100;
        document.getElementById("print_total").innerHTML = "<b>$" + printing_cost + "</b>";
    //    document.getElementById("shipping").innerHTML = "$" + shipping;
    //    document.getElementById("grand_total").innerHTML = "$" + grand_total + 
    //        "<br><span class='per_book'><b>$" + Math.round(100 * (grand_total / copies)) / 100 + " per book</b></span>";
    }
    else {
        document.getElementById("per_book").innerHTML = "--";
        document.getElementById("print_total").innerHTML = "<b>--</b>";
    //    document.getElementById("shipping").innerHTML = "--";
    //    document.getElementById("grand_total").innerHTML = "--";
    }
}

// Rebuild color selection to be 0 - number of pages. Hemingway only gets No or Yes.
function setColorOptions(type, pages) {
    var colorSelect = document.getElementById("color");
    colorSelect.options.length = 0;
    
    if (type != "Hemingway") {        
        for (i = 0; i <= pages; i++) {
            colorSelect.options[i] = new Option(i, "" + i + "");
        }
    }
    else {
        colorSelect.options[0] = new Option("No", 0);
        colorSelect.options[1] = new Option("Yes", pages);        
    }   
}