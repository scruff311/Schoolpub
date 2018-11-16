// ############ Constants ############
const blackChargePerPagePerCopy = 0.044;
const colorChargePerPagePerCopy = 0.033;
const insideCoatedCost = 0.0429;
const insideOffsetCost = 0.0297;
const blackClick = 0.0129;
const colorClick = 0.049;
const ship = 0.007;
const coverStock = 0.3;
const coverBase = 15;
const base = 175;
const secPerPage = 2;
const typeSet = 15;
const scanPages = 5;
const halfSizeMult = 0.85;

// ############ Initialize Global Vars #############
var blackCost = 0;
var addColorCost = 0;
var coatedPaperCost = 0;
var offsetPaperCost = 0;
var hours = 0;
var clickCharge = 0;
var hemColorCost = 0;

function calculateGlobals(pages, copies, color, cover) {
  blackCost = (pages / 2.0) * blackChargePerPagePerCopy * copies;
  addColorCost = color * copies * colorChargePerPagePerCopy;
  coatedPaperCost = (pages / 2.0) * insideCoatedCost * copies;
  offsetPaperCost = (pages / 2.0) * insideOffsetCost * copies;
  hours = pages * copies * (secPerPage / 3600.0);
  clickCharge =
    ((pages - color) / 2.0) * copies * blackClick +
    (color / 2.0) * copies * colorClick;
  if (cover === 'soft') clickCharge += copies * colorClick;

  hemColorCost = 20 * color;
}

export function updateLitMagPrice(pubInfo, price) {
  const dimensions = pubInfo.dimensions;
  const copies = parseInt(pubInfo.copies);
  const pages = parseInt(pubInfo.insidePages);
  const color = parseInt(pubInfo.colorPages);
  const paper = pubInfo.paperStock;
  const cover = pubInfo.coverStyle;
  const binding = pubInfo.binding;
  const promoCode = price.promo;

  // calculate the globals using the old form format for cover, i.e. soft vs Soft-Cover
  const coverOldFormat = cover === 'Soft Cover (thicker cover)' ? 'soft' : 'self';
  calculateGlobals(pages, copies, color, coverOldFormat);

  var printingCost = 0;
  if (isHemingway(copies, color, pages)) {
    // this is a high volume run w/ either no color or all color, AKA Hemingway
    printingCost = hemingway(pages, copies, coverOldFormat);
  } else {
    // Poe, Dickinson, Frost
    // this is the only difference between poe and dickinson
    const paperCost = paper === 'Coated' ? coatedPaperCost : offsetPaperCost;

    // this decides poe/dickinson vs frost. including 'Other' here to give high end of price
    // in quote (could be lower if the size is closer to frost sizes)
    const largeFormat = ['7 x 10', '8 x 8', '8.5 x 11', 'Other'];

    var total = blackCost + addColorCost + paperCost + base;
    if (coverOldFormat === 'soft') {
      total +=
        (copies * colorChargePerPagePerCopy * 3.5) + (copies * coverStock) + coverBase;
    }
    const sizeMultiplier = largeFormat.includes(dimensions)
      ? 1
      : halfSizeMult;
    printingCost = total * sizeMultiplier;
  }

  // add the perfect bound cost if it is selected
  printingCost += (binding === 'Perfect Bound') ? addPerfectBoundCharge(copies) : 0;

  // apply the promo if applicable
  const finalCost = applyPromo(promoCode, printingCost, copies, color);

  return finalCost;
}

function addPerfectBoundCharge(copies) {
  if (copies <= 150) {
    return copies;
  }
  else if (copies <= 300) {
    return copies * 0.75;
  }
  // > 300 copies
  return copies * 0.5;
}

function isHemingway(copies, color, pages) {
  // return (copies >= 800 && copies % 100 === 0 && (color === 0 || color === pages));
  return false;
}

function applyPromo(code, cost, copies, color) {
  const today = new Date();
  const april15 = new Date('04/15/' + today.getFullYear());

  if (code.toLowerCase() === 'lm-early' && today < april15) {
    return {'total': 0.9 * cost, 'original': cost, 'promo-applied': 'LM-Early'};
  } else if (code.toLowerCase() === 'lm-4free') {
    const freePages = (color - 4) < 0 ? color : 4;
    const freeColor = freePages * copies * colorChargePerPagePerCopy;
    return {'total': cost - freeColor, 'original': cost, 'promo-applied': 'LM-4Free'};
  }

  return {'total': cost, 'original': cost, 'promo-applied': null};
}

function poe(copies, cover) {
  var total = blackCost + addColorCost + coatedPaperCost + base;
  if (cover === 'soft') {
    total +=
      copies * colorChargePerPagePerCopy * 3.5 + copies * coverStock + coverBase;
  }

  return total;
}

function hemingway(pages, copies, cover) {
  var total =
    pages * 20.5 * 0.25 +
    87 +
    (9 + (pages - 4) / 2.0) * (copies - 200) / 100.0 +
    pages * copies * 0.0035 +
    pages * copies * 0.0075 +
    100 +
    hemColorCost;

  if (cover === 'soft') {
    total += 300;
  }

  return total;
}

function dickinson(copies, cover) {
  var total = blackCost + addColorCost + offsetPaperCost + base;
  if (cover === 'soft') {
    total +=
      copies * colorChargePerPagePerCopy * 3.5 + copies * coverStock + coverBase;
  }

  return total;
}

function calcHardCover(copies) {
  if (copies < 100) return 1400;
  else if (copies >= 100 && copies < 200) return copies * 14;
  else if (copies >= 200 && copies < 300) return copies * 12.5;
  else if (copies >= 300 && copies < 400) return copies * 10.5;
  else if (copies >= 400 && copies < 500) return copies * 9.75;
  else if (copies >= 500 && copies < 600) return copies * 9.5;
  else if (copies >= 600 && copies < 700) return copies * 9.3;
  else if (copies >= 700 && copies < 800) return copies * 9.15;
  else if (copies >= 800 && copies < 900) return copies * 9;
  else if (copies >= 900 && copies < 1000) return copies * 8.85;
  else return copies * 8.7;
}

function updatePrice(sender) {
  //    var shipping = 0;
  //    var misc = 0;
  var printingCost = 0;
  var hard_cover_cost = 0;

  var type = document.getElementById('type').value;
  var pages = document.getElementById('pages').value;
  var copies = document.getElementById('copies').value;
  var cover = document.getElementById('cover').value;
  var hard = document.getElementById('hard').value;
  var cat = document.getElementById('cat').value;

  // If the number of pages was changed, rebuild color page dropdown
  if (pages > 0 && sender === 'pages') setColorOptions(type, pages);

  var num_color = document.getElementById('color').value;

  calculateGlobals(pages, copies, num_color, cover);

  if (hard > 0) hard_cover_cost = calcHardCover(copies);

  if (type === 'Poe') {
    printingCost = poe(copies, cover);
    if (cat === 'Tiger') {
      printingCost += pages * scanPages;
    } else if (cat === 'Cougar') {
      printingCost += pages * typeSet;
    }
  }
  if (type === 'Hemingway') {
    printingCost = hemingway(pages, copies, cover);
  }
  if (type === 'Dickinson') {
    printingCost = dickinson(copies, cover);
  }
  if (type === 'Frost') {
    printingCost = poe(copies, cover) * halfSizeMult;
  }

  printingCost = Math.round(printingCost + hard_cover_cost);
  //var grand_total = printingCost + shipping + misc + non_four_premium;

  // If all necessary fields are selected, display total
  if (
    type !== '' &&
    copies !== '' &&
    pages !== '' &&
    cover !== '' &&
    cat !== ''
  ) {
    document.getElementById('per_book').innerHTML =
      '$' + Math.round(100 * (printingCost / copies)) / 100;
    document.getElementById('print_total').innerHTML =
      '<b>$' + printingCost + '</b>';
    //    document.getElementById("shipping").innerHTML = "$" + shipping;
    //    document.getElementById("grand_total").innerHTML = "$" + grand_total +
    //        "<br><span class='per_book'><b>$" + Math.round(100 * (grand_total / copies)) / 100 + " per book</b></span>";
  } else {
    document.getElementById('per_book').innerHTML = '--';
    document.getElementById('print_total').innerHTML = '<b>--</b>';
    //    document.getElementById("shipping").innerHTML = "--";
    //    document.getElementById("grand_total").innerHTML = "--";
  }
}

// Rebuild color selection to be 0 - number of pages. Hemingway only gets No or Yes.
function setColorOptions(type, pages) {
  var colorSelect = document.getElementById('color');
  colorSelect.options.length = 0;

  if (type !== 'Hemingway') {
    for (var i = 0; i <= pages; i++) {
      colorSelect.options[i] = new Option(i, '' + i + '');
    }
  } else {
    colorSelect.options[0] = new Option('No', 0);
    colorSelect.options[1] = new Option('Yes', pages);
  }
}
