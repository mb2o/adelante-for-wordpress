
var slideshow = {
    context: false,
    timeout: 5000,      
    slideSpeed: 500,   
    fx: 'fade', 

    init: function() {
        // set the context to help speed up selectors/improve performance
        this.context = $('#slider-wrapper');
        this.timeout = adelante_globals.slider_timeout;
        this.slideSpeed = adelante_globals.slider_speed;
        this.fx = adelante_globals.slider_fx;
        this.prepareSlideshow();
    },
    prepareSlideshow: function() {
        // * http://malsup.com/jquery/cycle/options.html */
        $('.slider-frame > ul', slideshow.context).cycle({
            fx: slideshow.fx, 
            timeout: slideshow.timeout,
            speed: slideshow.slideSpeed,
            pauseOnPagerHover: true,
            pause: true,
            prev: $('.slider-prev'),
            next: $('.slider-next'),
            after: function() {
                var img = $('img', this)[0];
                if(img!='undefined') slideshow.processCaption(img.title);
            }
        });
    },
    processCaption: function(title) {
        var sliderTitle = $('.slider-title', slideshow.context); 
        if(title != ''){
            if(title.substr(0,1) == '#'){
                title = $(title).html();                
            }       
            if(sliderTitle.css('display') == 'block'){
                sliderTitle.find('p').fadeOut(450, function(){
                    $(this).html(title);
                    $(this).fadeIn(450);
                });
            } else {
                sliderTitle.find('p').html(title);
            }                    
            sliderTitle.fadeIn(450);
        } else {
            sliderTitle.fadeOut(450);
        }
    }
};

var adelante = function(options){
    
    var defaults = {
        blurOpacity: 0.6,
        blurDuration: 500,
        preloadDelay: 250        
    }
    
    var settings = $.extend({}, defaults, options);

    function image_hover(elems, opacity, duration) {
        $(elems).hover(function() {
            $(this).animate({opacity:opacity},duration);
        },
        function() {
            $(this).animate({opacity:1},duration);
        });
    }
    
    // Preload images?
    if(typeof settings.elemsToPreload != "undefined" && settings.elemsToPreload.length > 0){
        $(settings.elemsToPreload.join(',')).preloadify({ 
            imageDelay: settings.preloadDelay 
        });        
    }
        
    // Perform blurring on hover? 
    if(typeof settings.elemsToBlur != "undefined" && settings.elemsToBlur.length > 0){
        image_hover(settings.elemsToBlur.join(','), settings.blurOpacity, settings.blurDuration); 
    }   
     
    // Activate fancybox functionality
    $("figure.gallery-item a").attr("rel","gallery");
    $("figure.gallery-item a[rel='gallery']").fancybox({
        'transitionIn': 'fade',
        'transitionOut': 'elastic',
        'speedIn': 600, 
        'speedOut': 200,
        'cyclic': true, 
        'overlayShow': true,
        'onClosed': function(){
            $(this).animate({opacity:1}, 500);    
        }       
    });
    
    // Perform Cufon replacement
    var disable_cufon = $("meta[name=disable_cufon]").attr('content');
    if (disable_cufon != 'checked') {
        Cufon.replace(settings.elemsToCufon.join(','), { 
            hover: 'true' 
        });       
    }

    $('a[href=#top]').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });

    // Tooltips 
    $('.hastip').tooltipsy({
        alignTo: 'cursor',
        offset: [10, 10],
        css: {
            'padding': '10px',
            'max-width': '350px',
            '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
            '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
            'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
            'text-shadow': 'none'
        }
    });
       
    var tip;
    $(".tip_trigger").hover(function(){
        // Caching the tooltip and removing it from container; then appending it to the body
        tip = $(this).find('.tip').remove();
        $('body').append(tip);
        tip.fadeIn('fast'); 
    }, function() {
        tip.hide().remove(); // Hide and remove tooltip appended to the body
        $(this).append(tip); // Return the tooltip to its original position
    }).mousemove(function(e) {
        var mousex = e.pageX + 20; // Get X coodrinates
        var mousey = e.pageY + 20; // Get Y coordinates
        var tipWidth = tip.width(); // Find width of tooltip
        var tipHeight = tip.height(); // Find height of tooltip          
        // Distance of element from the right edge of viewport
        var tipVisX = $(window).width() - (mousex + tipWidth);
        var tipVisY = $(window).height() - (mousey + tipHeight);
        if ( tipVisX < 20 ) { // If tooltip exceeds the X coordinate of viewport
            mousex = e.pageX - tipWidth - 20;
            $(this).find('.tip').css({  top: mousey, left: mousex });
        } if ( tipVisY < 20 ) { // If tooltip exceeds the Y coordinate of viewport
            mousey = e.pageY - tipHeight - 20;
            tip.css({  top: mousey, left: mousex });
        } else {
            tip.css({  top: mousey, left: mousex });
        }
    });
    
    // Widgetbox toggle
    $(settings.elemsToToggle.join(',')).click(function(){
        $(this).parent().children('div,form,ul').toggle();    
    });
        
    // Content Toggle
    jQuery(function($){
        $(".togglebox_content").hide();
        $("h4.togglebox_title").toggle(function(){
            $(this).addClass("clicked");
        }, function () {
            $(this).removeClass("clicked");
        });
        $("h4.togglebox_title").click(function(){
            $(this).next(".togglebox_content").slideToggle();
        });
    });
    
    // Activate dropdown menu
    jqueryslidemenu.buildmenu("nav-main", arrowimages);  
   
    // Initialize jQuery cycle
    slideshow.init();    
    
};


// -------------------------------------------------------------------------------------------
// =DOM Load
// -------------------------------------------------------------------------------------------

$(function(){
                
    // Adds a class 'js_on' to the <html> tag if JavaScript is enabled, also helps remove flickering...
    document.documentElement.className += 'js_on';
    
    adelante({
        elemsToBlur: [adelante_globals.elemsToBlur],
        elemsToCufon: [adelante_globals.elemsToCufon],
        elemsToToggle: [adelante_globals.elemsToToggle],
        elemsToPreload: adelante_globals.elemsToPreload     
    });   
});


// -------------------------------------------------------------------------------------------
// Image preloader
// -------------------------------------------------------------------------------------------

(function($){
    $.fn.preloadify = function(options){
        
        var defaults = {
            delay: 0,
            imageDelay: 200,
            mode: "sequential",
            preloadParent: "a",
            checkTimer: 100,
            onDone: function(){},
            onEachLoad: function(image){},
            fadeIn: 500 ,
            forceIcon: false
        };
        
        var options = $.extend(defaults,options),
            parent = $(this),
            timer,
            i=0,
            j=options.imagedelay,
            counter=0,
            images = parent.find("img").css({
                display: "block",
                visibility: "hidden",
                opacity: 0
            }),
            checkFlag = [],
            imagedelayer = function(image,time){            
                $(image).css("visibility","visible").delay(time).animate({
                    opacity: 1
                },options.fadein,function(){ 
                    $(this).parent().removeClass("preloader");  
                });            
            };
            
        // Add preloader to parent or wrap anchor depending on option    
        images.each(function(){
            if($(this).hasClass('featured_image')){
                if($(this).parent(options.preloadParent).length==0)
                    $(this).wrap("<a class='preloader' />");
                else
                    $(this).parent().addClass("preloader");                
            }        
           
            checkFlag[i++] = false;                
        });

        // Convert into image array
        images = $.makeArray(images);
        counter = 0;
        
        // Function to show image 
        function showimage(i){
            if(checkFlag[i]==false){
                counter++; 
                options.onEachLoad(images[i]);
                checkFlag[i] = true;
            }                
            if(options.imageDelay==0&&options.delay==0)
                $(images[i]).css("visibility","visible").animate({opacity:1},700);
            else if(options.delay==0){
                imagedelayer(images[i],j);
                j += options.imageDelay;
            }else if(options.imageDelay==0){
                imagedelayer(images[i],options.delay);            
            }else{
                imagedelayer(images[i],(options.delay+j));
                j += options.imageDelay;
            }                
        }
        
        // Preload images parallel
        function preloadParallel(){
            for(i=0;i<images.length;i++){
                if(images[i].complete==true){
                    showimage(i);             
                }
            }
        }
        
        // Shows images based on index with respect to parent container
        function preloadSequential(){        
            if(images[i].complete==true){
                showimage(i);
                 i++;
            }
        }
        
        i=0; 
        j=options.imageDelay;
        
        // Keep on checking after predefined time, if image is loaded
        function init(){  
            timer = setInterval(function(){            
                if(counter>=checkFlag.length){
                    clearInterval(timer);
                    options.onDone();                
                    return;
                }                        
                if(options.mode=="parallel")
                    preloadParallel();
                else
                    preloadSequential();            
            },options.checkTimer);                
        }
        
        if(options.force_icon==true){    
            var src = $(".preloader").css("background-image");
            var pattern = /url\(|\)|"|'/g;
            
            src = src.replace(pattern,'');
            
            var icon = jQuery("<img />",{                
                id : 'loadingicon' ,
                src : src                
            }).hide().appendTo("body");

            timer = setInterval(function(){                
                if(icon[0].complete==true){
                    clearInterval(timer);
                    setTimeout(function(){ 
                        init(); 
                    },options.checkTimer);
                    icon.remove();
                    return;
                }                
            },50);
        }else
            init();
    }
})(jQuery);


// -------------------------------------------------------------------------------------------
// jQuery Multi Level CSS Menu #2- By Dynamic Drive: http://www.dynamicdrive.com/
// - Last update: Nov 7th, 08': Limit # of queued animations to minmize animation stuttering
// - Menu avaiable at DD CSS Library: http://www.dynamicdrive.com/style/
// -------------------------------------------------------------------------------------------

//Specify full URL to down and right arrow images (23 is padding-right to add to top level LIs with drop downs):
var arrowimages={down:['', ''], right:['', '']};

var jqueryslidemenu={

    animateduration: {over: 250, out: 150}, //duration of slide in/ out animation, in milliseconds

    buildmenu: function(menuid, arrowsvar){
        jQuery(function($){
            var $mainmenu=$("#"+menuid+">ul");
            var $headers=$mainmenu.find("ul").parent();
            $headers.each(function(i){
                var $curobj=$(this);
                var $subul=$(this).find('ul:eq(0)');
                this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth()-2, subulh:$subul.outerHeight()};
                this.istopheader=$curobj.parents("ul").length==1 ? true : false;
                $subul.css({top:this.istopheader ? this._dimensions.h+"px" : 0});
                $curobj.hover(
                    function(e){
                        var $targetul=$(this).children("ul:eq(0)");
                        this._offsets={left:$(this).offset().left, top:$(this).offset().top};
                        var menuleft=this.istopheader? 0 : this._dimensions.w;
                        menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft;
                        if ($targetul.queue().length<=1) //if 1 or less queued animations
                            $targetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).slideDown(jqueryslidemenu.animateduration.over);
                    },
                    function(e){                                  
                        var $targetul=$(this).children("ul:eq(0)");
                        $targetul.slideUp(jqueryslidemenu.animateduration.out);
                    }
                ); //end hover
                $curobj.click(function(){
                    $(this).children("ul:eq(0)").hide();
                });
            }); //end $headers.each()
            $mainmenu.find("ul").css({display:'none', visibility:'visible'});
        });
    }
};