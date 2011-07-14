

jQuery.noConflict();   
jQuery(function(){

    // Handle range input
    jQuery(".range-input-wrap :range").rangeinput();
    
    
    /* ------- teaser_text_meta ------- */
    jQuery("#teaser_text_image_meta,#teaser_text_custom_meta").css({display:'none'});
    var selectedRadio = jQuery('input:radio[name=teaser_text]:checked').val();
    if (selectedRadio === "custom") {
        jQuery("#teaser_text_image_meta,#teaser_text_custom_meta").css({display:'block'});
    }
    // Toggle the selected option details    
    jQuery("input:radio[name=teaser_text]").click(function(){   
        var selectedRadio = jQuery('input:radio[name=teaser_text]:checked').val(); 
        // Hide custom
        jQuery("#teaser_text_image_meta,#teaser_text_custom_meta").css({display:'none'});    
        // Show custom
        if(selectedRadio === 'custom'){
            jQuery("#teaser_text_image_meta,#teaser_text_custom_meta").fadeIn(450);    
        }           
    });    
    
    //  
    jQuery('.advertisement_count').live('change',function(){        
        var wrap = jQuery(this).closest('p').siblings('.advertisement_wrap');
        wrap.children('div').hide();
        var count = jQuery(this).val();
        for(var i = 1; i <= count; i++){
            wrap.find('.advertisement_'+i).show();
        }
    });
    
    // 
    jQuery('.social_icon_select_sites').live('change',function(){
        var wrap = jQuery(this).closest('p').siblings('.social_icon_wrap');
        wrap.children('p').hide();
        jQuery('option:selected',this).each(function(){
            wrap.find('.social_icon_'+this.value).show();
        });
    });
    
    // 
    jQuery('.social_icon_custom_count').live('change',function(){        
        var wrap = jQuery(this).closest('p').siblings('.social_custom_icon_wrap');
        wrap.children('div').hide();
        var count = jQuery(this).val();
        for(var i = 1; i <= count; i++){
            wrap.find('.social_icon_custom_'+i).show();
        }
    });
      
});