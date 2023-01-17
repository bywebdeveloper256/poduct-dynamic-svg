function dp_start_preloader(elem){
    jQuery(
        '<div id="cl_preloader">'+
        '<div class="lds-ring"><div></div><div></div><div></div><div></div></div>'+
        '</div>'
    ).hide().prependTo(elem).fadeIn("slow");
}

function dp_end_preloader(){
    jQuery("#cl_preloader").fadeOut(300, function() { 
        jQuery(this).remove(); 
    });
}
