jQuery.noConflict();
     
jQuery(document).ready(function(){

	jQuery("#tabs").tabs();
    
    /* ------- Slider Subject Selection ------- */
    
    var selectedRadio = jQuery('input:radio[name=adelante_slider_subject]:checked').val();
    jQuery("#slider_subject_"+selectedRadio).fadeIn(450);
    
    // Toggle the selected option details    
    jQuery("input:radio[name=adelante_slider_subject]").click(function(){   
        // Hide all options ULs
        jQuery(".subject").css({display:'none'});
        // Show the selected one
        var selectedRadio = jQuery('input:radio[name=adelante_slider_subject]:checked').val();
        jQuery("#slider_subject_"+selectedRadio).fadeIn(450);   
    });
	
    
    /* ------- Teaser Text Selection ------- */
    
    var selectedRadio = jQuery('input:radio[name=adelante_teaser_text]:checked').val();
    jQuery("#adelante_teaser_"+selectedRadio).fadeIn(450);
    
    // Toggle the selected option details    
    jQuery("input:radio[name=adelante_teaser_text]").click(function(){   
        var selectedRadio = jQuery('input:radio[name=adelante_teaser_text]:checked').val(); 
        // Hide custom
        jQuery("#adelante_teaser_custom").css({display:'none'});    
        // Show custom
        if(selectedRadio=='custom'){
            jQuery("#adelante_teaser_custom").fadeIn(450);    
        }           
    });
               
});