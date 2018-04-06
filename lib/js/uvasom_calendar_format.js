jQuery(document).ready(function($) {
var elem = $('div.category-event div.entry-content:contains("[")');
elem.text(elem.text().replace("[", "Location: "));
var elem2 = $('div.category-event div.entry-content:contains("]")');
elem2.text(elem2.text().replace("]", ""));
})
