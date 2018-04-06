jQuery(document).ready(function($) {
     if ($('#uvasom_section_type').val() !== "tertiary") {
       $("p.uvasom_tertiaryoption").hide();
	 }
$('#uvasom_section_type').change(function(){
    if ($(this).val() == "tertiary") {
        //document.getElementById("p#uvasom_tertiaryhome").style.display="block";
        //jQuery alternative
        $("p.uvasom_tertiaryoption").show();
    } else {
       // document.getElementById("p#uvasom_tertiaryhome").style.display="none";
        //jQuery alternative
        $("p.uvasom_tertiaryoption").hide();
    }
});
});