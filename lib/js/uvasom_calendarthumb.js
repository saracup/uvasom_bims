jQuery(document).ready(function($) {
//get content of the link for the calendar
	var calendarThumb = $('ul.cets_embedRSS li a').html();
//take the first six characters of that content
	var n = calendarThumb.substr(0,5);
//wrap it in a span tag
	$(calendarThumb).wrapAll('<span class="calendarThumb" />');
 });
