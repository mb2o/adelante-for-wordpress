<?php 

/* =Options
--------------------------------------------------------------------------------------------- */

/* ------- Body ------- */

$body['font_family'] = get_option("adelante_body_font_family");
$body['font_size'] = get_option("adelante_body_font_size");

$main['bg'] = get_option("adelante_body_bg");
if ( $main['bg'] != 'none' ) {
    $main['bg'] = ADELANTE_BASE_URI. "/img/tilables/". $main['bg'];
}
else {
    $main['bg'] = "";
}
$main['bgcolor'] = get_option("adelante_body_bgcolor");

/* ------- Images ------- */

$image['path'] = ADELANTE_BASE_URI. "/img";

/* ------- Heading ------- */

$heading['h1_font_size'] = get_option("adelante_h1_font_size");
$heading['h2_font_size'] = get_option("adelante_h2_font_size");
$heading['h3_font_size'] = get_option("adelante_h3_font_size");
$heading['h4_font_size'] = get_option("adelante_h4_font_size");
$heading['h5_font_size'] = get_option("adelante_h5_font_size");
$heading['h6_font_size'] = get_option("adelante_h6_font_size");

$teaser['topborder'] = ''; // filled later on in this scipt !!!
$teaser['font_size'] = get_option("adelante_teaser_font_size");
$teaser['color'] = get_option("adelante_teaser_color");
$teaser['bgcolor'] = get_option("adelante_teaser_bgcolor");
$teaser['bg'] = get_option("adelante_teaser_bg");
if ( $teaser['bg'] == 'default' ) {
    $teaser['bg'] = $image['path']. "/teaser-gradient.png";    
}
else {
    $teaser['bg'] = $image['path']. "/tilables/". $teaser['bg'];
}
 
/* ------- Slider ------- */

$slider['width'] = get_framework_size();
$slider['height'] = get_option('adelante_slider_height');
if (get_option('adelante_slider_fullheight') != 'checked') {
    $slider['fullheight'] = "margin-top: 1.5em; padding-bottom: 30px;";
    $slider['shadow'] = ".slider-shadow {background: url('{$image['path']}/shadow.png') no-repeat; bottom: -12px; height: 47px; overflow: hidden; position: absolute; width: {$slider['width']}px; z-index: 5;}";
}
$slider['bg'] = get_option('adelante_slider_bg');
if ( $slider['bg'] == 'none' ) {
    $slider['bg'] = $image['path']. "/page-heading.png";    
}
else {
    $slider['bg'] = $image['path']. "/tilables/". $slider['bg'];
}

$slider['bgcolor'] = get_option('adelante_slider_bgcolor');
if ( ! empty( $slider['bgcolor'] ) ) {
    $slider['bgcolor'] = "background: ".$slider['bgcolor']." !important;";
    $teaser['topborder'] = '#teaser {border-top: 1px '.$slider['bgcolor'].' solid !important;}';
} else {
    $slider['bgcolor'] = '';
}          
$slider['navTop'] = ($slider['height']-33)/2;
$slider['titleTop'] = $slider['height'] - 40;
$slider['postImgWidth'] = 418;
//$slider['postImgWidth'] = $slider['width'] - 430;

$slider['vpos'] = get_option('adelante_slider_text_locationV');
$slider['voff'] = get_option('adelante_slider_text_vertical_offset');
$slider['vertical'] = $slider['vpos'].":".$slider['voff']."px;";

$slider['hpos'] = get_option('adelante_slider_text_locationH');
$slider['hoff'] = get_option('adelante_slider_text_horizontal_offset');
$slider['horizontal'] = $slider['hpos'].":".$slider['hoff']."px;";

$slider['maxwidth'] = get_option('adelante_slider_text_maxwidth');

/* ------- Icons ------- */

$icons = adelante_load_files( ADELANTE_BASE. "/img"."/icons", array( "png" ), true );
$iconlink_css = $button_css = $infobox_css = '';
foreach ( $icons as $icon ) {
    $file = explode( ".", $icon );
    $iconlink_css .= ".adelante-ilink .{$file[0]}{background: transparent url({$image['path']}/icons/$icon) no-repeat center left;}";    
    $button_css .= ".adelante-button .adelante-{$file[0]} {background: transparent url({$image['path']}/icons/$icon) no-repeat center left;padding: 2px 0 2px 22px; left:-2px;}";
    $infobox_css .= ".adelante-box.{$file[0]} {background: transparent url({$image['path']}/icons/$icon) no-repeat 10px center;}";
}

/* ------- Footer ------- */

$footer['bg'] = get_option("adelante_footer_bg");
$footer['color'] = get_option("adelante_footer_color");
if ( $footer['bg'] == 'default' ) {
    $footer['bg'] = $image['path']. "/footer.png";    
}
else {
    $footer['bg'] = $image['path']. "/tilables/". $footer['bg'];
}
$footer['bgcolor'] = get_option("adelante_footer_bgcolor"); 


/* ------- Custom CSS ------- */

$custom_css = get_option('adelante_general_css');

return <<<CSS
 
/* =Typography
--------------------------------------------------------------------------------------------- */
html { 
    overflow-y: scroll; 
    }

body {
    background-image: url('{$image['path']}/gradient-dark-reverse.png');
    background-repeat: repeat-x;
    font-family: {$body['font_family']}, Arial, "Times New Roman", sans-serif;
    font-size: {$body['font_size']}%;    
    }

h1 {
    font-size: {$heading['h1_font_size']}px;
    line-height: 1;
    margin-bottom: 1em;
    }
h2 {
    font-size: {$heading['h2_font_size']}px;
    margin-bottom: 0.75em;
    }
h3 {
    font-size: {$heading['h3_font_size']}px;
    line-height: 1;
    margin-bottom: 1em;
    }
h4 {
    font-size: {$heading['h4_font_size']}px;
    line-height: 1.25;
    margin-bottom: 1.25em;
    }
h5 {
    font-size: {$heading['h5_font_size']}px;
    font-weight: bold;
    margin-bottom: 1.5em;
    }
h6 {
    font-size: {$heading['h6_font_size']}px;
    font-weight: bold;
    }
  
a:link,
a:visited,
a:hover,
a:active,
a:focus{
    text-decoration:none;
    outline:none;
    -moz-outline-style:none;
    }    
a:active, 
input.button:active { 
    position: relative; 
    top: 1px; 
    }

::-moz-selection { 
    text-shadow: none;  
    }
::selection { 
    text-shadow: none; 
    }

input {
    outline:none;
    transition: all 0.25s ease-in-out;
    -webkit-transition: all 0.25s ease-in-out;
    -moz-transition: all 0.25s ease-in-out;
    border-radius:3px;
    -webkit-border-radius:3px;
    -moz-border-radius:3px;
    border: 1px solid rgba(0,0,0, 0.2);
    color: gray;
    background-color: #eee;
    padding: 3px;         
    }     
    input:focus {
        background-color:white;
    }
                
input[type="text"],
input[type="email"],
input[type="url"], 
input[type="password"], 
textarea {
    background: url({$image['path']}/form.jpg) repeat-x top white;
    border: 1px solid #CCC;
    /*padding: 3px; */
    }
input:not([type]),
input[type="email"],
input[type="url"], 
input[type="text"], 
input[type="password"] {
    /*padding: 3px;*/
    }
input, 
input[type="password"], 
input[type="search"], 
isindex {
    -webkit-appearance: textfield;
    /*padding: 1px;*/
    background-color: white;
    border: 1px inset;
    -webkit-rtl-ordering: logical;
    -webkit-user-select: text;
    cursor: auto;
    }

ul, ol {
    margin: 1.5em 1.5em 1.5em 0;
    padding-left: 1.5em;
    }

ul.none { 
    margin: 0 0 1.5em 0; 
    padding: 0; 
    list-style: none; 
    }   

pre, code {
    font-family: "courier new", monospace !important;
    /*font-size: 11px; */
}
    
.wp-caption { 
    border: 1px solid #ddd; 
    text-align: center; 
    background: #eee; 
    padding: 10px 0 4px 10px; 
    margin: 15px 10px; 
    }
.wp-caption-text { 
    margin: 2px 0 0 0; 
    }
    
.ir { 
    display: block; 
    text-indent: -999em; 
    overflow: hidden; 
    background-repeat: no-repeat; 
    text-align: left; 
    direction: ltr; 
    }

.clear,
.clearboth {
    clear: both;
    }
    
.hidden { 
    display: none; 
    visibility: hidden; 
    }
    
.visuallyhidden { 
    border: 0; 
    clip: rect(0 0 0 0); 
    height: 1px; 
    margin: -1px; 
    overflow: hidden; 
    padding: 0; 
    position: absolute; 
    width: 1px; 
    }
    .visuallyhidden.focusable:active,
    .visuallyhidden.focusable:focus { 
        clip: auto; 
        height: auto; 
        margin: 0; 
        overflow: visible; 
        position: static; 
        width: auto; 
        }

.nomargin {
    margin: 0;
    }
.nopadding {
    padding: 0;
    }
.crop {
    margin: 0;
    padding: 0;
    }
.center {
    width: 100%;
    text-align: center;
    }
        
.doubleBorder {
    border: 1px solid #fff;
    -webkit-box-shadow: 0 0 0 1px #d1d1d1;    
       -moz-box-shadow: 0 0 0 1px #d1d1d1;
            box-shadow: 0 0 0 1px #d1d1d1;
}
        
.invisible { 
    visibility: hidden;
    }

.map-wrapper .map {
    padding: 0; 
    margin: 0; 
    }
       
/* ------- Forms ------- */

button, 
input, 
select, 
textarea { 
    overflow: visible; 
    margin: 0; 
    /*font-size: 1em;*/ 
    }
    
label, 
input[type=button], 
input[type=submit], 
button { 
    cursor: pointer; 
    }

textarea { 
    overflow: auto; 
    }

/* ------- Searchform ------- */

#searchform {
    margin: 1.5em 0 1.5em 1.5em;    
    }
    
/* ------- Ajax loader ------- */

.ajax-loader,
.twitterAvatar {
    border: none;
    vertical-align: middle;
}

/* =Navigation
--------------------------------------------------------------------------------------------- */

#nav-main{
    position: relative;
    float: right;
    top: 16px;
    text-transform: uppercase;
    font-size: 12px;
    height: 40px;
    }
       
.slidemenu{
    position: relative;
    z-index: 100;
    }
.slidemenu ul{
    margin: 0;
    padding: 0;
    list-style-type: none;
    }
.slidemenu ul li{
    position: relative;
    display: inline;
    float: left;
    }   
#menu-primary-navigation > li > a {
    color: #fff;
    } 
* html .slidemenu ul li a{ 
    display: inline-block;
    }
.slidemenu ul li a, 
.slidemenu ul li a:link, 
.slidemenu ul li a:visited{
    /*color: #f5f5f5;*/
    text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1);
    }
.slidemenu ul li a{
    display: block;
    padding: 10px 10px; 
    text-decoration: none;
    height: 40px;
    line-height: 40px;
    /*overflow: hidden; */
    padding: 0 12px;
    text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1);
    }
.slidemenu ul li ul{
    position: absolute;
    left: 0px;
    display: block;
    visibility: hidden;
    }
.slidemenu ul li ul li{
    display: list-item;
    float: none;
    }
.slidemenu ul li ul li ul{
    top: 0px;
    }
.slidemenu ul li ul li a{
    width: 160px;
    padding: 6px 12px;
    margin: 0;
    }
.slidemenu ul ul{
    background: #fff;
    padding-top: 2px;
    top: 30px;
    padding-bottom: 2px;
    border-bottom: 1px solid rgba(35, 35, 35, 0.2);
    -webkit-box-shadow: 3px 3px 0px 0px rgba(35, 35, 35, 0.1);
    -moz-box-shadow: 3px 3px 0px 0px rgba(35, 35, 35, 0.1);
    box-shadow: 3px 3px 0px 0px rgba(35, 35, 35, 0.1);
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=95)";
    filter: alpha(opacity=95);
    -moz-opacity: 0.95;
    -khtml-opacity: 0.95;
    opacity: 0.95; 
    }
.slidemenu ul ul ul{
    margin-left: -4px;
    margin-top: -2px;
    padding-top: 2px;
    }
.slidemenu ul ul li a, 
.slidemenu ul ul li a:link, 
.slidemenu ul ul li a:visited {
    height: 100%;
    line-height: 20px;
    text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1);
    }
.slidemenu ul li ul li a:hover, 
.slidemenu ul ul li a:hover{
    padding: 6px 12px;
    color: #222 !important;
    }
.slidemenu ul ul li ul li a:hover, 
.slidemenu ul ul ul li a:hover{
    padding: 6px 12px;
    width: 160px;
    }

        
/* ------- Utility menu ------- */

#nav-utility { 
    position: absolute; 
    top: 0; 
    right: 0; 
    }
    #nav-utility ul { 
        list-style: none; 
        margin: 0; 
        padding: 0; 
        float: right; 
        width: auto; 
        position: relative; 
        }
        #nav-utility ul li { 
            float: left; 
            position: relative; 
            }
            #nav-utility ul li a { 
                display: block; 
                float: left; 
                padding: 2px 6px; 
                }

/* ------- Other ------- */
 
/* ------- Clean button ------- */

.tip {
    display: none;
    padding: 10px;
    position: absolute;    
    z-index: 1000;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    }
                                                     
#post-nav a, 
#comments-nav a {
    background: #eee;
    background: -moz-linear-gradient(top, #eee 0%, #ccc 100%);
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#eee), to(#ccc));
    border: 1px solid #ccc;
    border-bottom: 1px solid #bbb;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    color: #666;
    /*font-size: 11px;*/
    font-weight: bold;
    line-height: 1;
    padding: 5px;
    text-align: center;
    text-shadow: 0 1px 0 #eee;
    }
    #post-nav a:hover, 
    #comments-nav a:hover { 
      background: #ddd;
      background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
      background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#ddd), to(#bbb));
      border: 1px solid #bbb;
      border-bottom: 1px solid #999;
      cursor: pointer;
      /*text-shadow: 0 1px 0 #ddd;*/
      }

/* ------- Post, page, comment navigation ------- */

#post-nav { 
    clear: both; 
    }
    #post-nav:after { 
        content: "\0020"; 
        display: block; 
        height: 0; 
        clear: both; 
        visibility: hidden; 
        overflow: hidden;
        }
    #post-nav .post-previous { 
        float: left; 
        width: 50%; 
        }
    #post-nav .post-next { 
        float: right; 
        width: 50%; 
        text-align: right; 
        }
        #post-nav .post-next a { 
            float: right; 
            }

#comments-nav { 
    clear: both; 
    margin: 0 0 1.5em 0; 
    }
    #comments-nav:after { 
        content: "\0020"; 
        display: block; 
        height: 0; 
        clear: both; 
        visibility: hidden; 
        overflow: hidden; 
        }
    #comments-nav .comments-previous { 
        float: left; 
        width: 50%; 
        }
    #comments-nav .comments-next { 
        float: right; 
        width: 50%; 
        text-align: right; 
        }
        #comments-nav .comments-next a { 
            float: right; 
            }
                  
/* =HEADER
--------------------------------------------------------------------------------------------- */

#top {
    float: none;
    height: 80px;
    margin: 0 auto;
}

#logo { 
    float: left; 
    width: 270px; 
    height: 100%; 
    margin: 0; 
    padding: 0;
}    

/* ------- Page Header ------- */

#page-heading {
    float: none;
    overflow: hidden;
    {$slider['bgcolor']}    
    }
    
#page-heading-gradient {
    background-image: url('{$slider['bg']}');
    background-repeat: repeat-x;
    }
    
#page-heading-pattern {
    overflow: hidden;   
    }
    #page-heading-pattern > .inner {
        clear: both;
        float: none;
        height: 100%;
        position: relative;
        text-align: left;
        margin: 0 auto;
        }


/* ------- jQuery slider ------- */

#slider-wrapper {
    float: none;
    margin: 0 auto;    
    height: auto;
    position: relative;
    {$slider['fullheight']}
    overflow:hidden;
    }
    
.slider-frame {
    position:relative;
    -moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.7);
    -webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.7);
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.7);
    /*background-color: #fff;*/
    margin: 0 auto;
    height: {$slider['height']}px;
    overflow: hidden;
    z-index: 6;       
    }
    .slider-frame h2 {
        /*white-space:nowrap;*/
    }
    .slider-frame ul {
        width: 2880px;
        height: 2880px;
        float:left;
        margin: 0;
        padding: 0;
        list-style-type: none;
        }
        .slider-frame ul:after {
            content: ".";
            clear: both;
            display: block;
            height: 0;
            visibility: hidden;
            }   
    .slider-frame li {
        float: left;
        padding: 0;
        background:transparent !important;
        }
    .slider-frame h2 a {
        margin-top:-20px !important;
        padding-top:5px;
        }
    .slider-frame .postsnip {
		color: #e1e1e1;
        float: left;
        margin: 10px 6em 0 50px;
        width: 360px;
        overflow: hidden;
        padding: 0px;
        }
		.slider-frame .postsnip a {
			color: #c97b2c;
		}
    .slider-frame figure {
        margin-top: 10px;
        margin-right: 10px;
        float: right;
        overflow:hidden;
        padding:0px;
        width: {$slider['postImgWidth']}px;
        }
       
.slider-title {
    background-color: #222;
    display: none;
    color: #fff;
    font-size: 22px;
    position: absolute;
    {$slider['vertical']}
    {$slider['horizontal']}
    padding: 10px;
    max-width:{$slider['maxwidth']}px;    
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=85)";filter: alpha(opacity=85);-moz-opacity: 0.85;-khtml-opacity: 0.85;opacity: 0.85;
    z-index: 99;
    }
    .slider-title p {
        margin:0;
        padding:0;
    } 
    
.slider-prev {   
    position: absolute;
    display: block;
    left: 5px;
    top: {$slider['navTop']}px;
    background: url({$image['path']}/nivo_arrow_l.png) no-repeat;
    width: 19px;
    height: 33px;
    margin-left: 10px;
    z-index: 99; 
    }
.slider-next {
    position: absolute;
    display: block;
    right: 5px;
    top: {$slider['navTop']}px;
    background: url({$image['path']}/nivo_arrow_r.png) no-repeat;
    width: 19px;
    height: 33px;
    margin-right: 10px;
    z-index: 99; 
    }

{$slider['shadow']} 
    
.row .slider-shadow {
    background: none;
    }
       
.preloader { 
    background: url({$image['path']}/ajax-loader.gif) center center no-repeat #ffffff; 
    display: inline-block;  
    }
    

/* ------- Grid ------- */

#wrap {
    background: {$main['bgcolor']} url({$main['bg']}) repeat top center;
    }
        
/* ------- Teaser ------- */
    
#teaser {
    float: none;
    clear: both;          
    width: 100%;
    margin: 0 auto;
    min-height: 80px;
    height: auto;
    background: {$teaser['bgcolor']} url('{$teaser['bg']}') repeat top center;
    text-align: center; 
    }
    
#teaser-content {
    color: {$teaser['color']};  
    float: none; 
    text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.35);
    font-family: georgia;
    font-size: {$teaser['font_size']}px;
    font-style: italic;
    height: 80px;
    overflow: none;
    vertical-align: middle;
    }
    #teaser-inner {
        line-height: 80px;
        margin: 0;
        }
    #teaser-content .teaser-image {
        position: relative;
        display: inline;
        top: 15px;
        margin: 0 1em;
        }
        #teaser-content .teaser-image img { 
            height: 48px;
            width: 48px;
            }
    #teaser-content ul {
        list-style: none;
        margin: 0;
        padding: 0;
        }
        #teaser-content ul li {
            line-height: 80px;
        }
    #teaser-content  a {
        font-style: normal; 
    }  

#teaser-shadow {
    background: url({$image['path']}/page-heading-shadow.png) repeat-x center top;
    height: 2px;
    }

{$teaser['topborder']}
    
/* =CONTENT
--------------------------------------------------------------------------------------------- */
            
/* ------- Main content ------- */
           
#content { 
    margin: 1.5em auto 1.5em;
    float: none;
    overflow: hidden;
    }
    #content .container { 
        width: auto; 
        position: relative; 
        padding: 0; 
        }
    #content .inner { 
        width: auto; 
        position: relative; 
        padding: 0; 
        }
        
#main { 
    position: relative; 
    }
    #main .container {
        overflow: hidden;
        padding: 2em; 
        }
        #main .container article {
            margin-top: 10px;
            margin-bottom: 1.5em;
            }
    #main .inner {
        padding: 0.5em; 
        }
    #main footer p {
        line-height: 150%;
        }

 
#tag-list {
    float: left;
    position: relative;
    width: 580px;
    background: white;
    position: relative;
    height: 20px;
    margin-top: 1em;
    }
    #tag-list a {
        background: #F2F2F2;
        border: 1px solid #C1C1C1;
        padding: 2px 8px;
        text-decoration: none;
        /*font-size: 12px;*/
        margin-right: 4px;
        }
 
 /* ------- Pages ------- */
 
 .page h1 {
     margin-bottom: 1em;
     } 
 
 
 /* ------- Posts ------- */

 /* Prevent big space in posts on homepage */
 .home .hentry p,
 .home .hentry time {
    margin: 0;
    }
 
.blog_header {
    clear: both;
    }
    
.post footer {
    min-height: 1.5em;
    /*overflow: hidden;*/
} 
time {
    background: url({$image['path']}/line.gif) repeat-x scroll center bottom;
    color: #888;
    /*font-size: 11px;*/
    margin-bottom: 5px;
    padding: 4px 2px 8px;
    }
time a {
    /*font-size: 11px;*/
    text-transform: uppercase;
    word-spacing: -1px;
    } 

.entry-title {
    background: url({$image['path']}/line.gif) repeat-x scroll center bottom;   
}

.entry-content {
    overflow: hidden;
    margin-top: 1.5em;       
}

.hentry header { 
    /*margin-bottom: 1.5em; */
    clear: both;
    }
.hentry h1 { 
    line-height: 1.5em; 
    margin-bottom: 1em; 
    }
.hentry h2 {
    background: url({$image['path']}/line.gif) repeat-x scroll center bottom; 
    line-height: 1.5em;
    margin-bottom: 5px; 
    }
.hentry h2 a { 
    text-decoration: none; 
    }
.hentry iframe.twitter-share-button { 
    position: absolute; 
    display: block;
    top: 8px; 
    right: 0; 
    width: 110px; 
    height: 20px; 
    }
.hentry time { 
    display: block;  
    position: relative; 
    }
.hentry p.byline { 
    
    }
.sticky {

    }

.bypostauthor {

    }
                                          

/* ------- Custom Post Lists ------- */

.thumbnail_list li {
    padding-bottom: 5px;
    position: relative;
    }
    .thumbnail_list li img {
        border: 1px solid #EAEAEA;
        }
.thumbnail_title {
    display: inline-block;
    /*font-size: 12px;*/
    width: 150px;
    }
ul.thumbnail_list .alignleft {
    margin-bottom: 3px;
    margin-top: 5px;
    }
.date {
    color: #AAA;
    /*font-size: 10px;*/
    text-transform: uppercase;
    line-height: 15px;
    }

/* ------- Post comments -------*/

ol.commentlist img.avatar { 
    float: left; 
    margin-right: 10px; 
    }
ol.commentlist time { 
    display: block; 
    /*font-size: 1em;*/ 
    margin-bottom: 0.5em; 
    position: relative; 
    }
ol.commentlist .comment-reply-link { 
    display: block; 
    margin-bottom: 1.5em; 
    }

#comments,
#respond {    
    /*line-height: 1em; */
    /*font-size: 12px;*/
    font-weight: 700;
    margin: 30px 10px 10px 0;
    /*padding: 7px 10px;*/
    display: block;
    vertical-align: middle;    
    }
    #comments h3 {
        background: url('{$image['path']}/icons/iconbox/speech_bubbles.png') no-repeat 0 -8px;
        min-height: 30px;
        padding-left: 44px;    
        }
    #respond h3 {
        background: url('{$image['path']}/icons/iconbox/write.png') no-repeat 0 -8px;
        min-height: 30px;
        padding-left: 44px;    
        }

.comment {
    font-weight: normal;
    /*font-size: 11px;*/
    }   

.nocomments {
    background: white;
    border: solid #CCC;
    padding: 15px 10px;
    margin: 0 10px 10px 0;
    /*font-size: 12px; */
    border-width: 0 1px 1px;
}

#commentform {
    background: white;
    border: solid #f5f5f5;
    margin-right: 10px;
    padding: 10px;
    border-width: 1px;
    }
    #commentform textarea {
        width: 520px;
        }
    #commentform input[type="text"],
    #commentform input[type="email"],
    #commentform input[type="url"] {
        display: block;
        width: 300px;
        font: 14px 'Lucida Grande',Arial,Helvetica,sans-serif;
        margin: 5px 0;
    }
#commentform p { 
    margin-bottom: 1em; 
    }
#commentform label { 
    display: block; 
    }
#commentform textarea { 
    display: block; 
    }
#commentform input.button { 
    margin-top: 0.5em; 
    }
#commentform:after { 
    content: "\0020"; 
    display: block; 
    height: 0; 
    clear: both; 
    visibility: hidden; 
    overflow: hidden; 
    }
                  
                    
/* ------- Columns ------- */

.one_fifth {    
    overflow: hidden; 
    margin-left: 4%; 
    width: 16.5%; 
    float: left;    
    position: relative; 
    display: inline;
    }
.one_fourth {    
    overflow: hidden; 
    margin-left: 4%; 
    width: 22%;  
    float: left;     
    position: relative; 
    display: inline;
    }
.one_third {    
    overflow: hidden; 
    margin-left: 4%; 
    width:30%; 
    float:left;     
    position:relative; 
    display:inline;
    }
.two_fifth {    
    overflow: hidden; 
    margin-left: 4%; 
    width:38.5%; 
    float:left;    
    position:relative; 
    display:inline;
    }
.one_half {    
    overflow: hidden; 
    margin-left: 4%; 
    width:48%; 
    float:left;     
    position:relative; 
    display:inline;
    }
.three_fifth {    
    overflow: hidden; 
    margin-left: 4%; 
    width:57%; 
    float:left;     
    position:relative; 
    display:inline;
    }
.two_third {    
    overflow: hidden; 
    margin-left: 4%; 
    width:66%; 
    float:left;     
    position:relative; 
    display:inline;
    }
.three_fourth {    
    overflow: hidden; 
    margin-left: 4%; 
    width:74%; 
    float:left;     
    position:relative; 
    display:inline;
    }
.four_fifth {    
    overflow: hidden; 
    margin-left: 4%; 
    width:79%; 
    float:left;     
    position:relative; 
    display:inline;
    }

/* the first class overwrites both columns and grid container margins. */
div .first{
    margin-left: 0;
    clear: left;
    }

/* ------- Primary Sidebar ------- */

#sidebar { 
    position: relative; 
    }
    #sidebar .tagcloud {
        padding: 0 1.5em 1.5em 1.5em;
    } 
    #sidebar .widget { 
        clear: both; 
        margin-bottom: 1.5em; 
        }
        #sidebar .widget .gform_wrapper ul { 
            padding: 0; 
            list-style-type: none; 
            }
        #sidebar .widget .inner {
            width: auto; 
            /*padding: 0 !important;*/
            overflow: hidden;      
            list-style-type: none;
            }            
    #sidebar .widget h2 {
        padding: 0 4px 3px 8px;  
        }
    #sidebar .widget h3 {
        margin: 0;
        padding: 8px 8px 6px 8px;  
        }  
            
/* FOOTER
--------------------------------------------------------------------------------------------- */          

footer {
    /*font-size: 11px;*/
    }
    footer article {    
        position: relative;  
        }
        footer article .inner li { 
            background: url({$image['path']}/footer_hr.png) repeat-x bottom; 
            padding: 7px 0;
            overflow: hidden;
            float: none;
            display: block;
            margin: 0;
            }
        footer article .inner a {
            color: #ccc;
            } 
    footer ul {
        padding: 0 !important;
        }
    footer h3 {
        color: white;
        }
        
#content-info {   
    clear: both; 
    position: relative;
    background-color: {$footer['bgcolor']};
    background-image: url({$footer['bg']});  
    background-repeat: repeat;
    background-position: scroll center top;
    color: {$footer['color']};
    padding: 30px 0 20px;
    width: 100%;
    }
    #content-info > .container { 
        padding: 0 0 0 20px; 
        }

#content-info .menu { 
    margin: 0 0 24px; 
    padding: 0; 
    list-style-type: none; 
    }
    #content-info .menu li { 
        display: inline; 
        margin-right: 1em; 
        }
#content-info .copy small { 
    font-size: 1em; 
    }
#content-info .social {
    float: left;
    margin-top: 1em; 
}    
#content-info .social .twitter-share-button {}
#content-info .social .fb_iframe_widget {}
#content-info .social .plusone {
    margin-top: -5px;
}

#content-info .vcard { 
    position: absolute; 
    bottom: 0; 
    right: 0; 
    margin: 0; 
    text-align: right; 
    }
#content-info .vcard .fn { 
    /*font-size: 14px;*/ 
    }

.subfooter {
    clear: both;   
    }
            
/* =Shortcodes
--------------------------------------------------------------------------------------------- */

/* ------- Lorem ------- */

.lorem {
    clear:both;
    }

/* ------- Dropcaps ------- */

.dropcap1 {
    display: block;
    float: left;
    font-size: 40px;
    line-height: 40px;
    margin: 0 8px 0 0;
    }
.dropcap2{
    color: #EEEEEE;
    float: left;
    font-size: 30px;
    height: 40px;
    line-height: 30px;
    margin-bottom: -5px;
    margin-right: 10px;
    padding-left: 2px;
    padding-top: 7px;
    text-align: center;
    width: 40px;
    }
    
/* ------- Buttons ------- */

input[type="submit"],
.adelante-button {    
    background-image: url("{$image['path']}/bg-button.png");
    background-repeat: repeat-x;
    background-position: 0 0;
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    color: #fff;  
    display: inline-block;
    /*font-size: 12px; */
    line-height: 28px;
    margin: 3px 0;        
    min-width: 70px;
    padding: 0 10px;
    position: relative;
    text-decoration: none; 
    text-align: center;   
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    }  
    .adelante-button:hover {
        background-position: 0 -4px;        
        color: #fff;
        opacity: 0.9;
        text-decoration: none;
        }
     .adelante-button span {
        position: relative;
        }    
    .adelante-button.small {
        padding: 0 4px 0px 4px;
        font-size: 10px;
        line-height: 22px;
        }
    .adelante-button.large {
        padding: 0 10px 0px 10px;
        font-size: 13px;
        line-height: 33px;
        }
    .adelante-button.xl{
        padding: 0 18px 0px 18px;
        font-size: 14px;
        line-height: 42px;
        }
    
    .adelante-button.dark , 
    .adelante-button.dark:hover {
        color: #444;
        }
    .adelante-button.grey, 
    .adelante-button.grey:hover {color: #999;}
    .adelante-button.red {background-color: #b00202;border-color: #b00202;}
    .adelante-button.orange {background-color: #f6a240;border-color: #f6a240;}
    .adelante-button.green {background-color: #52851b;border-color: #52851b;}
    .adelante-button.aqua {background-color: #58c4be;border-color: #58c4be;}
    .adelante-button.teal {background-color: #1d9f9f;border-color: #1d9f9f;}
    .adelante-button.purple {background-color: #a258c4;border-color: #a258c4;}
    .adelante-button.pink {background-color: #f346b0;border-color: #f346b0;}
    .adelante-button.silver {background-color: #d7d7d7;border-color: #d7d7d7;}
    .adelante-button.black {background-color: #222;border-color: #222;}
        
{$button_css}

.download{background-image:url('{$image['path']}/downloadnow.png');display:inline-block;width:248px;height:80px;}

.wp-theme{background-position:0 0;}
.wp-theme:hover{background-position:-243px 0;}

.wp-plugin{background-position:0 -82px;}
.wp-plugin:hover{background-position:-243px -82px;}		

.sourcecode{background-position:0 -174px;}
.sourcecode:hover{background-position:-243px -174px;}

.software{background-position:0 -256px;}
.software:hover{background-position:-243px -256px;}


/* ------- Portfolio ------- */

ul#portfolio-filter{ margin: -20px 0; padding: 0; height: 64px; padding-left: 70px; line-height: 64px; }
ul#portfolio-filter li{ display: inline; }
ul#portfolio-filter a{ margin-right: 0.5em; padding: 0.5em 1em; background: #FFF; color: #AAA; font-weight: bold; text-decoration: none; }
ul#portfolio-filter a:hover, ul#portfolio-filter a.current{ color: #888; }
ul#portfolio-filter a.current{ background-color: #DDD; }

ul#portfolio-list{ 
    margin: 36px 0 0 0; 
    padding: 0; 
    list-style: none; 
    }
ul#portfolio-list li{    
    float: left; 
    overflow: hidden;
    margin: 0 0 1.5em 1.5em; 
    }
ul#portfolio-list li img {
    margin-left: 0;
    }

/* ------- Inline Links with icon ------- */

.adelante-ilink a {text-decoration :none;padding: 2px 0 2px 22px; display: inline-block;}    
{$iconlink_css}
    
    
/* Quotes */

blockquote {
    background: transparent url('{$image['path']}/quotes.png') no-repeat 0 8px; 
    color: #777;
    font-family: Georgia, "Times New Roman", Times, serif;
    clear: both;
    /*font-size: 1.2em;*/
    font-style: italic;
    line-height: 1.4em;
    margin: 10px 0 10px 0;
    padding: 0 0 0 40px;
    }
    blockquote p{
        padding: 11px 0px;
        }
    blockquote small, 
    blockquote cite, 
    blockquote small a, 
    blockquote cite a, 
    blockquote a small, 
    blockquote a cite{
        /*font-size: 12px;*/
        color: #aaa;
        }

.pullquote_right {
    float: right;
    margin: 1% 0 1% 4%;
    padding: 0 0 0 40px;
    width: 33.3333%;
    clear: none;
    }

.pullquote_left {
    float: left;
    margin: 1% 4% 1% 0;
    padding: 0 0 0 40px;
    width: 33.3333%;
    clear: none;
    }

.pullquote_boxed {
    padding: 10px 10px 10px 50px;
    border: 1px solid #e1e1e1;
    background: #f8f8f8 url('{$image['path']}/quotes.png') no-repeat 10px 18px;
    }


/* Preview modification only */
.shortcode_prev blockquote{
    /*font-size: 14px;*/
    }

.shortcode_prev .pullquote_boxed{
    background-position: 10px 28px;
    }

.shortcode_prev .pullquote_left, .shortcode_prev .pullquote_right{
    width: 60%;
    }


/* ------- Infoboxes ------- */

.adelante-box {
    clear: both;
    padding: 15px;
    /*font-size: 12px;*/
    background: #f8f8f8;
    border-top: 1px solid;
    border-bottom: 1px solid;
    border-color: #e1e1e1;
    line-height: 1.5em;
    margin: 1em 0;
    }
    .adelante-box.large {
        padding: 12px 12px 12px 40px !important;             
        min-height: 40px;
        }
    .adelante-box.full {
        border-left: 1px solid;
        border-right: 1px solid;
        border-color: #e1e1e1;
        }
    .adelante-box.rounded {
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        }

.adelante-innerbox {
    display: inline-block;
    padding: 0 1.5em 2px 1.5em;
    }
    
.adelante-box.custom_icon_none .adelante-innerbox {
    padding: 2px;
    }
    
{$infobox_css}


/* ------- Stylebox ------- */

div {
    vertical-align: middle;
    }
    .sproutebox {
        clear: both;
        color: #666;
        }
    .sproutebox .title {
        font-family: monospace;
        color: #666;
        font-size: 120%;
        padding-bottom: 4px;
        background-color: #ddd;
        padding-left: 10px;
        padding-top: 5px;
        }                         
        
    .sproutebox.code, 
    .sproutebox.important, 
    .sproutebox.warning, 
    .sproutebox.note, 
    .sproutebox.info {
        margin-bottom: 1.5em;
        }
        .sproutebox.important p, 
        .sproutebox.warning p, 
        .sproutebox.note p, 
        .sproutebox.info p {
            margin-bottom: 1em;
            }
                            
    .sproutebox.code {
        background: #EEE url({$image['path']}/code.png) no-repeat left top;
        border: none;
        padding: 1.25em 2em 1.25em 48px;         
        }
        .sproutebox.code .title {
            background-color: #CBE1AF;
            border-bottom: 1px solid #ccc;
            border-top: 1px solid #ccc;
            margin: -7px -3px 5px -11px;
            }
            
    .sproutebox.note {
        background: #fff9d8 url({$image['path']}/notes.png) no-repeat left top;
        border: none;
        padding: 1.25em 1em 1.25em 48px;
        }        
        .sproutebox.note .title {            
            background-color: #e8db8c;  
            border-bottom: 1px solid #e5d46c;   
            border-top: 1px solid #e5d46c;
            margin: -7px -3px 5px -11px;
            }
            
    .sproutebox.info {
        background: #E5CFEC url({$image['path']}/pin.png) no-repeat left top;
        border: none;
        padding: 1.25em 1em 1.25em 48px;
        }
        .sproutebox.info .title {            
            background-color: #cea7dc;        
            border-bottom: 1px solid #e8ccf4;   
            border-top: 1px solid #e8ccf4;
            color: #fff;
            margin: -7px -3px 5px -11px;
            }
            
    .sproutebox.warning {      
        background: #F9D9D8 url({$image['path']}/warning.png) no-repeat left top;
        border: none;
        padding: 1.25em 1.25em 1.25em 48px;                 
        }
        .sproutebox.warning .title {            
            background-color: #ed8b8a;        
            border-bottom: 1px solid #e8ccf4;      
            border-top: 1px solid #e8ccf4;
            color: #fff;
            margin: -7px -3px 5px -11px;
            }
        
        
/* ------- Imagebox ------- */

.imagebox {
    clear: both;
    margin: 1em 0 1.5em;
    height: 150px;
    position: relative;
    }
    .imagebox .imagebox_content .imagebox_content_title {
        border: medium none;
        padding: 8px 0 3px;
        position: relative;
        top: 7px;
        margin: 0 0 8px 0;
        font-size: 20px;
        }    
    .imagebox h3 {
        margin-bottom: 5px;
        clear: none;
        }
    
.imagebox_icon {
    float: left;
    padding: 0px 8px 0 0;
    }

.imagebox_content {
    overflow: hidden;
    /*font-size: 12px;*/
    line-height: 17px;
    }
    .imagebox_content p {
        /*font-size: 11px;*/
        }
    
.imagebox-button {
    position: absolute;
    bottom: 0;
    right: 1em;
    }

        
/* ------- Iconboxes ------- */

.iconbox {
    clear: both;
    margin-top: 1em;
    }
    .iconbox .iconbox_content .iconbox_content_title {
        border: medium none;
        padding: 8px 0 3px;
        position: relative;
        top: 7px;
        margin: 0 0 8px 0;
        font-size: 20px;
        }    

.iconbox_icon {
    float: left;
    padding: 8px 5px 0 0;
    }

.iconbox_content {
    overflow: hidden;
    /*font-size: 12px;*/
    line-height: 17px;
    }

/*.shortcode_prev .iconbox_content {
    color: #777;
    }
.shortcode_prev .iconbox_content_title {
    color: #000;
    } */
    
.hr {
    background: url({$image['path']}/hr.png) repeat-x center center;
    clear: both;
    display: block;
    overflow: hidden;
    width: 100%;
    height: 10px;
    padding: 20px 0;
    line-height: 30px;
    position: relative;
    margin: 0;
    }
    .hr a {
        float: right;
        /*font-size: 11px;*/
        padding: 0 4px 0 0;
        }

/* ------- Widget Box ------- */

.widgetbox {
    position: relative; 
    clear: both; 
    margin-bottom: 1.5em; 
    }
    .widgetbox .inner {
        width: auto; 
        padding: 0 !important;
        overflow: hidden;      
        list-style-type: none;
        background: #ffffff;
        border: 1px solid #d1d1d1;        
        } 
    .widgetbox .icon {      
        position: absolute;
        right: 3px;
        top: 0;
        } 
    .widgetbox div { 
        padding: 0; 
        list-style-type: none; 
        padding: 1.5em;
        } 
        
.widgetbox h2,
.widgetbox h3 {
    background: #f5f6f7; 
    border-bottom: 1px solid #d1d1d1;
    }           
.widgetbox h2 {
    padding: 0 4px 3px 8px;  
    }
.widgetbox h3 {
    margin: 0;
    padding: 8px 8px 6px 8px;  
    }
.widgetbox ul {
    margin: 0 !important;
}
        
/* ------- Toggle ------- */

h4.togglebox_title {
    margin: 10px 0;
    padding: 0 0 15px 50px;
    position: relative;
    }
    h4.togglebox_title a {
        padding-top: 5px;
        display: block;
        text-decoration: none;
        border: 0 none;
        outline: 0 none;
        line-height:75%;
        }
                   
.togglebox_content {
    background: #f1f1f1;
    border: 1px solid #cacaca;
    margin: 0 0 20px 20px;
    padding: 10px 30px;
    clear: both;
    overflow: hidden;
    } 
        
        
/* WIDGETS & PLUGINS
--------------------------------------------------------------------------------------------- */

.textwidget {
    padding: 7px 7px 0;
    display: table;
    width: 100%;
    overflow:hidden;
    }

/* Social Icon Widget
---------------------------------------------------------- */
.widget_social .social_wrap {
    padding: 1em 0 3px 1.5em;
}
footer .widget_social .social_wrap {
    padding: 0;
}
.widget_social a {
    padding:0 !important;
    margin: 0 !important;
    background: none !important;    
}
.widget_social a:hover {
    text-decoration: none;
    border: 0;
}
.widget_social img {
    margin:0 10px 5px 0;
}
.widget_social .social_animation_fade img, 
.widget_social .social_animation_combo img {
    opacity:0.7;
    -moz-opacity:0.7;
}
.widget_social .social_animation_fade img:hover {
    opacity: 1;
    -moz-opacity: 1;
    -moz-transition: all 0.2s ease-in;
    -o-transition: all 0.2s ease-in;
    -webkit-transition: all 0.2s ease-in;
    transition: all 0.2s ease;
}

.widget_social .social_animation_scale img:hover {
    -moz-transform: scale(1.2);
    -o-transition: scale(1.2);
    -webkit-transform: scale(1.2);
    -ms-zoom: 1.2;
    -moz-transition: all 0.2s ease-in;
    -o-transition: all 0.2s ease-in;
    -webkit-transition: all 0.2s ease-in;
    transition: all 0.2s ease;
}
    
.widget_social .social_animation_bounce img:hover {
    -moz-transform: translate(0px, -2px);
    -o-transition: translate(0px, -2px);
    -webkit-transform: translate(0px, -2px);
    transform: translate(0px, -2px);
    -webkit-transition: all 0.2s ease-in;
    -o-transition: all 0.2s ease-in;
    -moz-transition: all 0.2s ease-in;
    transition: all 0.2s ease;
}

.widget_social .social_wrap.social_animation_combo img:hover {
    opacity: 1;
    -moz-opacity: 1;
    transform: translate(0px, -2px);
    -moz-transform: scale(1.2) translate(0px, -2px);
    -o-transform: scale(1.2) translate(0px, -2px);
    -webkit-transform: scale(1.2) translate(0px, -2px);
    -ms-zoom: 1.2;
    -webkit-transition: all 0.2s ease-in;
    -o-transition: all 0.2s ease-in;
    -moz-transition: all 0.2s ease-in;
    transition: all 0.2s ease;
}

/* ------- Popular Posts Widget ------- */

/* Popular Post
--------------------------------------------------------- */

.widget_popular_posts time {
    background: none;
    }
.widget_popular_posts figure {
    margin: 4px 1em 0 0;
    }
        

/* Recent Post
---------------------------------------------------------- */

.widget_recent_posts figure {
    margin: 4px 1em 0 0;
    }
    
.posts_list {
    list-style: none;
    margin: 1em 0 0 0;
    }
    .posts_list p{
        margin:0;
        }
.posts_list li, 
#sidebar .posts_list li, 
#footer .posts_list li {
    padding: 0 1em 1em 0;
    }
.posts_list li a, 
#sidebar .posts_list li a, 
#footer .posts_list li a {
    background:none;
    padding:0;
    line-height:20px;
    }
/*.posts_list .thumbnail, 
#sidebar .posts_list .thumbnail,*/ 
#footer .posts_list .thumbnail{
    display:block;
    float:left;
    margin:4px 8px 8px 0;
    line-height:100%;
    border: 1px solid #eee;
    }
.posts_list .thumbnail img {
    /*border: 1px solid #fff;*/
    display:block;
    }
.posts_list time {
    display:block;
    }
.posts_list .post_extra_info {
    overflow:hidden;
    }

#footer .posts_list .thumbnail img {
    border:none;
    width:60px;
    height:60px;
    }

    
/* ------- Twitter Widget ------- */

.widget_twitter .thumbnail {
/*    display:block;
    float:left;
    margin:4px 4px 8px 0;
    line-height:100%;  */
    }
.widget_twitter .tweet_list li {
    padding:5px 5px 5px 22px;
    line-height:inherit;
    word-wrap:break-word;
    list-style: none;
    background: transparent url({$image['path']}/widget_list_arrow.png) no-repeat center left;
    }
.widget_twitter .tweet_list a {
    background:none;
    padding:0;
    line-height:20px;
    }
.widget_twitter .tweet_wrapper {
    margin-left:0;
    clear: left;
    overflow: hidden;
    float: left;
    position: relative;
    display: inline;
    
    }
.widget_twitter .tweet_avatar {
    overflow: hidden;
    float: left;
    position: relative;
    display: inline;
    width: 15%;
    margin-right: 4%;
    padding-top: 8px;    
    }
.widget_twitter .tweet_details {
    overflow: hidden;
    float: left;
    position: relative;
    display: inline;
    width: 81%;
    }
.widget_twitter .with_avatar .tweet_list li {
    background:none;
    padding-left:0px;
    overflow:hidden;
    }
.widget_twitter .with_avatar .tweet_list a.tweet_avatar {
/*    float:left;
    padding-right:10px;    */
    }

.twitter_bird {
    height: 54px;
    position: absolute;
    right: 5px;
    top: 2px;
    width: 54px;
    }

/* ------- Advertisement Widget ------- */

.widget_advertisement_125 {
    clear:left; 
       
    }
    .widget_advertisement_125 .inner {
        padding-bottom: 15px !important;
        }
    .widget_advertisement_125 a {
        display:block;
        float:left;
        line-height:100%;
        margin: 15px 0 0 15px;
        overflow:hidden;
        font-size:0;
        height:125px;
        }
        .widget_advertisement_125 a:hover{
            -moz-box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.1); /* FF3.5+ */
            -webkit-box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.1); /* Saf3.0+, Chrome */
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.1); /* Opera 10.5, IE 9.0 */
            }
            .widget_advertisement_125 a:hover img {
                opacity: 0.8;
                -moz-opacity: 0.8;
                }    
    .widget_advertisement_125 img {
        width:125px;
        height:125px;
    }

/* ------- Random Quotes ------- */

.widget_quotes {

    }
    .widget_quotes .quote_wrap {
        font-size: large;
        margin: 1.5em;
        min-height: 125px;
        overflow:hidden;   
        }
   
/* ------- Flickr Widget ------- */

.widget_flickr .flickr_wrap {
    margin: 1.5em 0 1.5em -11px;
    padding-left: 1.5em; 
    position: relative;
    }
.widget_flickr a {
    display: inline-block;
    }
    .widget_flickr a img {
        padding: 4px;
        width: 70px;
        height: 70px;
        }
.widget_flickr .flickr_badge_image {
    padding: 0;    
    display: block;
    float: left;
    margin-bottom: 1.5em;
    margin-left: 1em;
    width: 80px;
    height: 80px;
    } 


/* ------- Picasa ------- */

.widget_picasa {
    overflow: hidden;
    } 
    .widget_picasa .picasa_wrap {
        margin: 1.5em 1em 0.2em .8em;
        position: relative;   
        }        
    .widget_picasa .picasa_wrap .picasa-widget-img {
        background: whitesmoke none repeat scroll 0 0;
        padding: 0;    
        display: block;
        float: left;
        margin-bottom: 1.5em;
        margin-left: 1em;
        position: relative;
    }   

/* ------- Contact Info ------- */

.widget_contact_info {
    margin-bottom: 2.5em;
    }
    .widget_contact_info span p {
        line-height: 20px;
        }
    
.contact_info_wrap p {
    margin: 0; 
    margin-bottom: 1em;
    }
    
.contact_info_wrap .icon_text, 
.contact_info_wrap .contact_address{
    padding-left: 26px;
    }
    
.contact_info_wrap .contact_zip {
    padding-left: 5px;
    }
    
.icon_text {
    height: 20px;
    padding: 0 0 0 26px; 
    background-image:url("../../img/icons_light.png");
    background-repeat:no-repeat;
    background-attachment:scroll;
    background-color:transparent;
}
.icon_globe {
    background-position: -386px 0px;
}
.icon_home {
    background-position: -356px -30px;
}
.icon_email {
    background-position: -326px -60px;
}
.icon_user {
    background-position: -296px -90px;
}
.icon_multiuser {
    background-position: -266px -120px;
}
.icon_id {
    background-position: -236px -150px;
}
.icon_addressbook {
    background-position: -206px -180px;
}
.icon_phone {
    background-position: -176px -210px;
}
.icon_link {
    background-position: -146px -240px;
}
.icon_chain {
    background-position: -116px -270px;
}
.icon_calendar {
    background-position: -86px -300px;
}
.icon_tag {
    background-position: -56px -330px;
}
.icon_download {
    background-position: -26px -360px;
}
.icon_cellphone {
    background-position: 1px -390px;
}        
    
/* ------- Contact form ------- */

.widget_contact_form textarea {
	font-family: Helvetica, Arial;
	font-size: 12px;
    height: 150px;
    }
.widget_contact_form p {
    margin: 0 0 1em;
    padding:0;
    }

    
/* ------- Gallery ------- */

figure {   
    float: left;
    margin: 0;
    padding: 0;
    position: relative;
    }
    figure.small-gallery-item figcaption,
    figure.gallery-item figcaption { 
        display: none; 
        }  
    figure.gallery-item img {
        /*margin-left: 1.5em;*/
        } 
  
        
/* ------- Images ------- */

.frameborder {
    background: none repeat scroll 0 0 black;
    display: block;
    position: absolute;
    z-index: 99;
    }
    
    
figure.gallery-item {
    background-color: #fff;
    }
        
.alignleft,
img.alignleft,
a img.alignleft {
    float: left; 
    margin: 0 1.5em 1.5em 0;
    }    

.entry-content .gallery-item.alignedleft {
    float: left;
    margin: 0 1em 1em 0;
    } 
       
img.left { 
    margin: 0 1.5em 1.5em 0;
    float: left; 
    } 
     
.alignright,
img.alignright,
a img.alignright {
    float: right; 
    margin: 0 0 1em 1em;
    overflow: hidden;
    }  
         
.entry-content .gallery-item.alignedright {
    float: right;
    margin: 0 0 1em 1em;
    }
  
img.right { 
    margin: 0 0 1.5em 1.5em; 
    float: right; 
    } 
   
.aligncenter,
img.aligncenter,
a img.aligncenter {
    display: block; 
    margin: 0 auto; 
    }

.icon { 
    vertical-align: middle; 
    }
        
.frame,
.small_frame {
    display: inline-block;
    }
.frame img{
    padding: 8px;
    margin: 0;    
    }
.small_frame img {
    padding: 4px;
    margin: 0;
    }

/* ------- WP Pagenavi ------- */

.wp-pagenavi{clear:both;padding-top:10px;height:40px;text-align:right;background:url({$image['path']}/line.gif) repeat-x scroll center top;}
.wp-pagenavi a, .wp-pagenavi a:link,.wp-pagenavi a:visited,.wp-pagenavi a:active,.wp-pagenavi span.pages,.wp-pagenavi span.current,.wp-pagenavi span.extend {
    border:1px solid transparent;
    color:#AAAAAA;
    /*font-size:10px;*/
    margin:1px;
    padding:4px 5px;
    text-shadow:1px 1px 0 #FFFFFF;}
.wp-pagenavi a:hover {    
    background:#eee;
    background:#F9F9F9 url(images/form-gradient.gif) repeat-x scroll -1px -2px;
    border-color:#D9D9D9 #EAEAEA #FFFFFF;
    border-style:solid;
    border-width:1px;}
.wp-pagenavi span.current {
    background:#111111 url(images/buttons.gif) no-repeat scroll center -35px;
    border:1px solid #222;
    border-bottom:0;
    color:#EEEEEE;
    font-weight:bold;
    height:29px;
    text-shadow:none;}
    
    
/* ------- Videos ------- */

.video_frame {line-height:100%;}
.video-js-box { text-align: left; position: relative; line-height: 0 !important; margin: 0; padding: 0 !important; border: none !important;  }

/* Video Element */
video.video-js { background-color: #000; position: relative; padding: 0; }

.vjs-flash-fallback { display: block; }

/* Poster Overlay Style */
.video-js-box img.vjs-poster { display: block; position: absolute; left: 0; top: 0; width: 100%; height: 100%; margin: 0; padding: 0; cursor: pointer; }
/* Subtiles Style */
.video-js-box .vjs-subtitles { color: #fff; font-size: 20px; text-align: center; position: absolute; bottom: 40px; left: 0; right: 0; }

/* Fullscreen styles for main elements */
.video-js-box.vjs-fullscreen { position: fixed; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: 1000; }
.video-js-box.vjs-fullscreen video.video-js,
.video-js-box.vjs-fullscreen .vjs-flash-fallback { position: relative; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000; }
.video-js-box.vjs-fullscreen img.vjs-poster { z-index: 1001; }
.video-js-box.vjs-fullscreen .vjs-spinner { z-index: 1001; }
.video-js-box.vjs-fullscreen .vjs-controls { z-index: 1003; }
.video-js-box.vjs-fullscreen .vjs-big-play-button { z-index: 1004; }
.video-js-box.vjs-fullscreen .vjs-subtitles { z-index: 1004; }

/* Styles Loaded Check */
.vjs-styles-check { height: 5px; position: absolute; }
/* Controls Below Video */
.video-js-box.vjs-controls-below .vjs-controls { position: relative; opacity: 1; background-color: #000; }
.video-js-box.vjs-controls-below .vjs-subtitles { bottom: 75px; } /* Account for height of controls below video */

/* DEFAULT SKIN (override in another file)
================================================================================
Using all CSS to draw the controls. Images could be used if desired.
Instead of editing this file, I recommend creating your own skin CSS file to be included after this file,
so you can upgrade to newer versions easier. */

/* Controls Layout 
  Using absolute positioning to position controls */
.video-js-box .vjs-controls {
  position: absolute; margin: 0; opacity: 0.85; color: #fff;
  display: none; /* Start hidden */
  left: 0; right: 0; /* 100% width of video-js-box */ 
  width: 100%;
  bottom: 0px; /* Distance from the bottom of the box/video. Keep 0. Use height to add more bottom margin. */
  height: 35px; /* Including any margin you want above or below control items */
  padding: 0; /* Controls are absolutely position, so no padding necessary */
}

.video-js-box .vjs-controls > div { /* Direct div children of control bar */
    position: absolute; /* Use top, bottom, left, and right to specifically position the control. */
    text-align: center; margin: 0; padding: 0;
    height: 25px; /* Default height of individual controls */
    top: 5px; /* Top margin to put space between video and controls when controls are below */

    background-color: #0B151A;
    background: #1F3744 -webkit-gradient(linear, left top, left bottom, from(#0B151A), to(#1F3744)) left 12px;
    background: #1F3744 -moz-linear-gradient(top, #0B151A, #1F3744) left 12px;

    /* CSS Curved Corners */
    border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;

    /* CSS Shadows */
    box-shadow: 1px 1px 2px #000; -webkit-box-shadow: 1px 1px 2px #000; -moz-box-shadow: 1px 1px 2px #000;
}

/* Placement of Control Items 
   - Left side of pogress bar, use left & width
   - Rigth side of progress bar, use right & width
   - Expand with the video (like progress bar) use left & right */
.vjs-controls > div.vjs-play-control       { left: 5px;   width: 25px;  }
.vjs-controls > div.vjs-progress-control   { left: 35px;  right: 165px; } /* Using left & right so it expands with the width of the video */
.vjs-controls > div.vjs-time-control       { width: 75px; right: 90px;  } /* Time control and progress bar are combined to look like one */
.vjs-controls > div.vjs-volume-control     { width: 50px; right: 35px;  }
.vjs-controls > div.vjs-fullscreen-control { width: 25px; right: 5px;   }

/* Removing curved corners on progress control and time control to join them. */
.vjs-controls > div.vjs-progress-control {
    border-top-right-radius: 0; -webkit-border-top-right-radius: 0; -moz-border-radius-topright: 0;
    border-bottom-right-radius: 0; -webkit-border-bottom-right-radius: 0; -moz-border-radius-bottomright: 0;
}
.vjs-controls > div.vjs-time-control { 
    border-top-left-radius: 0; -webkit-border-top-left-radius: 0; -moz-border-radius-topleft: 0;
    border-bottom-left-radius: 0; -webkit-border-bottom-left-radius: 0; -moz-border-radius-bottomleft: 0;
}

/* Play/Pause
-------------------------------------------------------------------------------- */
.vjs-play-control { cursor: pointer !important; }
/* Play Icon */
.vjs-play-control span { display: block; font-size: 0; line-height: 0; }
.vjs-paused .vjs-play-control span {
    width: 0; height: 0; margin: 8px 0 0 8px;
    /* Drawing the play triangle with borders - http://www.infimum.dk/HTML/slantinfo.html */
    border-left: 10px solid #fff; /* Width & Color of play icon */
    /* Height of play icon is total top & bottom border widths. Color is transparent. */
    border-top: 5px solid rgba(0,0,0,0); border-bottom: 5px solid rgba(0,0,0,0);
}
.vjs-playing .vjs-play-control span {
    width: 3px; height: 10px; margin: 8px auto 0;
    /* Drawing the pause bars with borders */
    border-top: 0px; border-left: 3px solid #fff; border-bottom: 0px; border-right: 3px solid #fff;
}

/* Progress
-------------------------------------------------------------------------------- */
.vjs-progress-holder { /* Box containing play and load progresses */
    position: relative; padding: 0; overflow:hidden; cursor: pointer !important;
    height: 9px; border: 1px solid #777;
    margin: 7px 1px 0 5px; /* Placement within the progress control item */
    border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;
}
.vjs-progress-holder div { /* Progress Bars */
  position: absolute; display: block; width: 0; height: 9px; margin: 0; padding: 0;
  border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;
}
.vjs-play-progress {
    background: #fff;
    background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#777));
    background: -moz-linear-gradient(top,    #fff,    #777);
}
.vjs-load-progress {
    opacity: 0.8;
    background-color: #555;
    background: -webkit-gradient(linear, left top, left bottom, from(#555), to(#aaa));
    background: -moz-linear-gradient(top,    #555,    #aaa);
}

/* Time Display
-------------------------------------------------------------------------------- */
.vjs-controls .vjs-time-control { font-size: 10px; line-height: 1; font-weight: normal; font-family: Helvetica, Arial, sans-serif; }
.vjs-controls .vjs-time-control span { line-height: 25px; /* Centering vertically */ }

/* Volume
-------------------------------------------------------------------------------- */
.vjs-volume-control { cursor: pointer !important; }
.vjs-volume-control div { display: block; margin: 0 5px 0 5px; padding: 4px 0 0 0; }
/* Drawing the volume icon using 6 span elements */
.vjs-volume-control div span { /* Individual volume bars */
    float: left; padding: 0;
    margin: 0 2px 0 0; /* Space between */
    width: 5px; height: 0px; /* Total height is height + bottom border */
    border-bottom: 18px solid #555; /* Default (off) color and height of visible portion */
}
.vjs-volume-control div span.vjs-volume-level-on { border-color: #fff; /* Volume on bar color */ }
/* Creating differnt bar heights through height (transparent) and bottom border (visible). */
.vjs-volume-control div span:nth-child(1) { border-bottom-width: 2px; height: 16px; }
.vjs-volume-control div span:nth-child(2) { border-bottom-width: 4px; height: 14px; }
.vjs-volume-control div span:nth-child(3) { border-bottom-width: 7px; height: 11px; }
.vjs-volume-control div span:nth-child(4) { border-bottom-width: 10px; height: 8px; }
.vjs-volume-control div span:nth-child(5) { border-bottom-width: 14px; height: 4px; }
.vjs-volume-control div span:nth-child(6) { margin-right: 0; }

/* Fullscreen
-------------------------------------------------------------------------------- */
.vjs-fullscreen-control { cursor: pointer !important; }
.vjs-fullscreen-control div {
    padding: 0; text-align: left; vertical-align: top; cursor: pointer !important; 
    margin: 5px 0 0 5px; /* Placement within the fullscreen control item */
    width: 20px; height: 20px;
}
/* Drawing the fullscreen icon using 4 span elements */
.vjs-fullscreen-control div span { float: left; margin: 0; padding: 0; font-size: 0; line-height: 0; width: 0; text-align: left; vertical-align: top; }
.vjs-fullscreen-control div span:nth-child(1) { /* Top-left triangle */
    margin-right: 3px; /* Space between top-left and top-right */
    margin-bottom: 3px; /* Space between top-left and bottom-left */
    border-top: 6px solid #fff; /* Height and color */
    border-right: 6px solid rgba(0,0,0,0);  /* Width */
}
.vjs-fullscreen-control div span:nth-child(2) { border-top: 6px solid #fff; border-left: 6px solid rgba(0,0,0,0); }
.vjs-fullscreen-control div span:nth-child(3) { clear: both; margin: 0 3px 0 0; border-bottom: 6px solid #fff; border-right: 6px solid rgba(0,0,0,0); }
.vjs-fullscreen-control div span:nth-child(4) { border-bottom: 6px solid #fff; border-left: 6px solid rgba(0,0,0,0); }
/* Icon when video is in fullscreen mode */
.vjs-fullscreen .vjs-fullscreen-control div span:nth-child(1) { border: none; border-bottom: 6px solid #fff; border-left: 6px solid rgba(0,0,0,0); }
.vjs-fullscreen .vjs-fullscreen-control div span:nth-child(2) { border: none; border-bottom: 6px solid #fff; border-right: 6px solid rgba(0,0,0,0); }
.vjs-fullscreen .vjs-fullscreen-control div span:nth-child(3) { border: none; border-top: 6px solid #fff; border-left: 6px solid rgba(0,0,0,0); }
.vjs-fullscreen .vjs-fullscreen-control div span:nth-child(4) { border: none; border-top: 6px solid #fff; border-right: 6px solid rgba(0,0,0,0); }

/* Download Links - Used for browsers that don't support any video.
-------------------------------------------------------------------------------- */
.vjs-no-video { margin-top:10px; font-size: small; }

/* Big Play Button (at start)
---------------------------------------------------------*/
div.vjs-big-play-button {
    display: none; 
    position: absolute; top: 50%; left: 50%; width: 76px; height: 70px; margin: -35px 0 0 -38px; z-index: 102; text-align: center; vertical-align: center; cursor: pointer !important;
    border: 1px solid #ccc; opacity: 0.8;
    
    background-color: #0B151A;
    background: rgba(50,50,50,0.8);
}
div.vjs-big-play-button:hover {
    box-shadow: 0px 0px 80px #fff; -webkit-box-shadow: 0px 0px 80px #fff; -moz-box-shadow: 0px 0px 80px #fff;
}

div.vjs-big-play-button span {
    display: block; font-size: 0; line-height: 0;
    width: 0; height: 0;margin: 16px 0 0 21px;
    border-left: 40px solid #fff;
    border-top: 20px solid rgba(0,0,0,0); border-bottom: 20px solid rgba(0,0,0,0);
}

    
/* ------- Gravity Forms ------- */

.gform_wrapper { margin: 0; max-width: none; }
.gform_wrapper .gform_heading { width: 100%; margin-bottom: 1.5em; }
.gform_wrapper .gsection .gfield_label, .gform_wrapper h2.gsection_title, .gform_wrapper h3.gform_title {    font-size: 1.5em; font-weight: 400; }
.gform_wrapper h3.gform_title { margin-top: 0; }
.gform_wrapper .top_label .gfield_label { margin: 6px 0 0 0; }
.gform_wrapper .top_label input.medium { padding-right: 0; }
.gform_wrapper .left_label .gfield_label,
.gform_wrapper .right_label .gfield_label { margin: 10px 10px 0 0; }
.gform_wrapper .left_label ul.gfield_checkbox, 
.gform_wrapper .left_label ul.gfield_radio, 
.gform_wrapper .right_label ul.gfield_checkbox, 
.gform_wrapper .right_label ul.gfield_radio {
    margin: 9px 0 0 31%;
}
.gform_wrapper input[type=text],
.gform_wrapper input[type=url],
.gform_wrapper input[type=email],
.gform_wrapper input[type=tel],
.gform_wrapper input[type=file],
.gform_wrapper input[type=number],
.gform_wrapper input[type=password],
.gform_wrapper textarea,
.gform_wrapper select {
    font-size: 1em;
    line-height: 14px;
    padding: 4px;
    margin: 6px 0;
    border: 1px solid #bbb;
    -moz-background-clip: padding;
    -webkit-background-clip: padding;
    background-clip: padding-box;
    -moz-box-sizing: border-box;    
    -webkit-box-sizing: border-box;
    box-sizing: border-box;    
    vertical-align: middle;    
}
.gform_wrapper input[type=text]:focus,
.gform_wrapper input[type=url]:focus,
.gform_wrapper input[type=email]:focus,
.gform_wrapper input[type=tel]:focus,
.gform_wrapper input[type=number]:focus,
.gform_wrapper input[type=password]:focus,
.gform_wrapper textarea:focus,
.gform_wrapper select:focus {
    border: 1px solid #666;
}
.gform_wrapper select { padding: 3px; }
.gform_wrapper .small, .gform_wrapper .large { font-size: 1em; line-height: 14px; }
.gform_wrapper ul.right_label li, 
.gform_wrapper ul.left_label li, 
.gform_wrapper form ul.right_label li, 
.gform_wrapper form ul.left_label li {
    margin-bottom: 4px;
}
.gform_wrapper .description, 
.gform_wrapper .gfield_description, 
.gform_wrapper .gsection_description, 
.gform_wrapper .instruction {
    font-size: 0.9em;
    font-style: normal;
    padding: 0;
}
.gform_wrapper .right_label .gfield_description, 
.gform_wrapper .right_label .instruction,
.gform_wrapper .left_label .gfield_description, 
.gform_wrapper .left_label .instruction {
    padding: 0;
    margin-left: 31%;
}
.gform_wrapper .ginput_complex label, 
.gform_wrapper .gfield_time_hour label, 
.gform_wrapper .gfield_time_minute label, 
.gform_wrapper .gfield_date_month label, 
.gform_wrapper .gfield_date_day label, 
.gform_wrapper .gfield_date_year label, 
.gform_wrapper .instruction {
    font-size: 0.9em;
    font-weight: 400;
    letter-spacing: 0;
    margin: 0 0 6px 0;
}
.gform_wrapper .gfield_checkbox li input[type=checkbox], 
.gform_wrapper .gfield_radio li input[type=radio], 
.gform_wrapper .gfield_checkbox li input { float: none; display: inline-block; margin-top: 0; vertical-align: middle; }
.gform_wrapper .gfield_checkbox li label, .gform_wrapper .gfield_radio li label  { display: inline-block; margin: 0 0 0 8px; vertical-align: middle; }
.gform_wrapper .left_label .ginput_complex .ginput_right label, 
.gform_wrapper .left_label .ginput_complex .ginput_left label, 
.gform_wrapper .right_label .ginput_complex .ginput_right label, 
.gform_wrapper .right_label .ginput_complex .ginput_left label { word-spacing: 0; }
.gform_wrapper .gfield_checkbox li label, .gform_wrapper .gfield_radio li label { font-weight: 400; }
img.ui-datepicker-trigger { vertical-align: middle; }
.gform_wrapper .gf_progressbar_wrapper { width: 100%; }
.gform_wrapper .gf_page_steps { border-bottom: 1px dashed #ddd; width: 100%; }
.gform_wrapper .gsection  { border-bottom: 1px dashed #ddd; }
.gform_wrapper .gform_page_footer { border-top: 1px dashed #ddd; }
.gform_wrapper .gform_footer { margin: 6px 0 0 0; padding: 0; }
.gform_wrapper .gform_footer.right_label, .gform_wrapper .gform_footer.left_label { margin: 6px 0 0 0; padding: 0 0 0 31%; }
.ie7 .gform_footer input.button { padding: 8px 16px; }
.gform_wrapper .gform_edit_link { display: none; }
.gform_wrapper .validation_error { font-size: 1em; font-weight: 400; padding: 0.8em; margin-bottom: 1.5em; background: #fbe3e4; color: #8a1f11; border: 2px solid #fbc2c4; }
.gform_wrapper .validation_message { display: none; }
.gform_wrapper li.gfield.gfield_error {
    background: none;
    margin-bottom: 6px !important;
    padding: 0 !important;
    border: none;
}
.gform_wrapper .top_label .gfield_error .ginput_container { max-width: none; }
.gform_wrapper .top_label .gfield_error { margin-bottom: 0 !important; }
.gform_wrapper .gfield_error .gfield_label { color: #8a1f11; }
.gform_wrapper .gfield_error input, 
.gform_wrapper .gfield_error select, 
.gform_wrapper .gfield_error textarea { background: #FBE3E4; border-color: #FBC2C4; }
.gform_wrapper .top_label .gfield_error input, 
.gform_wrapper .top_label .gfield_error textarea, 
.gform_wrapper .top_label .gfield_error select { border-color: #FBC2C4; }
.gform_wrapper .top_label .gfield_error { width: auto; }

/* ------- Fancybox ------- */

#fancybox-loading { position: fixed; top: 50%; left: 50%; width: 40px; height: 40px; margin-top: -20px; margin-left: -20px; cursor: pointer; overflow: hidden; z-index: 1104; display: none; }
#fancybox-loading div { position: absolute; top: 0; left: 0; width: 40px; height: 480px; background-image: url({$image['path']}/fancybox/fancybox.png); }
#fancybox-overlay { position: absolute; top: 0; left: 0; width: 100%; z-index: 1100; display: none; }
#fancybox-tmp { padding: 0; margin: 0; border: 0; overflow: auto; display: none; }
#fancybox-wrap { position: absolute; top: 0; left: 0; padding: 20px; z-index: 1101; outline: none; display: none; }
#fancybox-outer { position: relative; width: 100%; height: 100%; background: #fff; }
#fancybox-content { width: 0; height: 0; padding: 0; outline: none; position: relative; overflow: hidden; z-index: 1102; border: 0px solid #fff; }
#fancybox-hide-sel-frame { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: transparent; z-index: 1101; }
#fancybox-close { position: absolute; top: -15px; right: -15px; width: 30px; height: 30px; background: transparent url({$image['path']}/fancybox/fancybox.png) -40px 0px; cursor: pointer; z-index: 1103; display: none; }
#fancybox- { color: #444; font: normal 12px/20px sans-serif; padding: 14px; margin: 0; }
#fancybox-img { width: 100%; height: 100%; padding: 0; margin: 0; border: none; outline: none; line-height: 0; vertical-align: top; }
#fancybox-frame { width: 100%; height: 100%; border: none; display: block; }
#fancybox-left, #fancybox-right { position: absolute; bottom: 0px; height: 100%; width: 35%; cursor: pointer; outline: none; background: transparent url({$image['path']}/fancybox/blank.gif); z-index: 1102; display: none; }
#fancybox-left:hover, #fancybox-right:hover { visibility: visible; }
#fancybox-right:hover span { left: auto; right: 20px; }
#fancybox-left:hover span { left: 20px }
#fancybox-left { left: 0px }
#fancybox-right { right: 0px }
#fancybox-left-ico, #fancybox-right-ico { position: absolute; top: 50%; left: -9999px; width: 30px; height: 30px; margin-top: -15px; cursor: pointer; z-index: 1102; display: block; }
#fancybox-left-ico { background-image: url({$image['path']}/fancybox/fancybox.png); background-position: -40px -30px; }
#fancybox-right-ico { background-image: url({$image['path']}/fancybox/fancybox.png); background-position: -40px -60px; }
.fancybox-bg { position: absolute; padding: 0; margin: 0; border: 0; width: 20px; height: 20px; z-index: 1001; }
#fancybox-bg-n { top: -20px; left: 0; width: 100%; background-image: url({$image['path']}/fancybox/fancybox-x.png); }
#fancybox-bg-ne { top: -20px; right: -20px; background-image: url({$image['path']}/fancybox/fancybox.png); background-position: -40px -162px; }
#fancybox-bg-e { top: 0; right: -20px; height: 100%; background-image: url({$image['path']}/fancybox/fancybox-y.png); background-position: -20px 0px; }
#fancybox-bg-se { bottom: -20px; right: -20px; background-image: url({$image['path']}/fancybox/fancybox.png); background-position: -40px -182px; }
#fancybox-bg-s { bottom: -20px; left: 0; width: 100%; background-image: url({$image['path']}/fancybox/fancybox-x.png); background-position: 0px -20px; }
#fancybox-bg-sw { bottom: -20px; left: -20px; background-image: url({$image['path']}/fancybox/fancybox.png); background-position: -40px -142px; }
#fancybox-bg-w { top: 0; left: -20px; height: 100%; background-image: url({$image['path']}/fancybox/fancybox-y.png); }
#fancybox-bg-nw { top: -20px; left: -20px; background-image: url({$image['path']}/fancybox/fancybox.png); background-position: -40px -122px; }
#fancybox-title { font-size: 12px; z-index: 1102; }
.fancybox-title-inside { padding-bottom: 10px; text-align: center; color: #333; background: #fff; position: relative; }
.fancybox-title-outside { padding-top: 10px; color: #fff; }
.fancybox-title-over { position: absolute; bottom: 0; left: 0; color: #fff; text-align: left; }
#fancybox-title-over { padding: 10px; background-image: url({$image['path']}/fancybox/fancy_title_over.png); display: block; }
.fancybox-title-float { position: absolute; left: 0; bottom: -20px; height: 32px; }
#fancybox-title-float-wrap { border: none; border-collapse: collapse; width: auto; }
#fancybox-title-float-wrap td { border: none; white-space: nowrap; }
#fancybox-title-float-left { padding: 0 0 0 15px; background: url({$image['path']}/fancybox/fancybox.png) -40px -90px no-repeat; }
#fancybox-title-float-main { color: #fff; line-height: 29px; font-weight: bold; padding: 0 0 3px 0; background: url({$image['path']}/fancybox/fancybox-x.png) 0px -40px; }
#fancybox-title-float-right { padding: 0 0 0 15px; background: url({$image['path']}/fancybox/fancybox.png) -55px -90px no-repeat; }

/* ------- MapPress ------- */

#mapp0_poweredby, #mapp1_poweredby, #mapp2_poweredby, #mapp3_poweredby, #mapp4_poweredby, #mapp5_poweredby, #mapp6_poweredby, #mapp7_poweredby, #mapp8_poweredby, #mapp9_poweredby, #mapp10_poweredby { display: none !important; } /* remove MapPress credit */

/* ------- Search -------*/
#searchform #s { padding: 5px; }
#searchform #searchsubmit { -moz-appearance: textfield; -webkit-appearance: textfield; }


/* theme options */
#tabs { margin-top: 1em; }
body.toplevel_page_adelante .ui-widget { font-size: 1em !important; font-family: inherit !important; }
body.toplevel_page_adelante .ui-widget-header {
    /* match #wp-head */
    background: #d9d9d9;
    background: -moz-linear-gradient(bottom, #d7d7d7, #e4e4e4) !important;
    background: -webkit-gradient(linear, left bottom, left top, from(#d7d7d7), to(#e4e4e4)) !important;
}

body.toplevel_page_adelante .ui-state-default, 
body.toplevel_page_adelante .ui-widget-content .ui-state-default, 
body.toplevel_page_adelante .ui-widget-header .ui-state-default {
    /* match #adminmenu a.menu-top */
    background: url(../images/menu-bits.gif) repeat-x scroll left -379px #F1F1F1 !important;
}
body.toplevel_page_adelante .ui-state-active, 
body.toplevel_page_adelante .ui-widget-content .ui-state-active, 
body.toplevel_page_adelante .ui-widget-header .ui-state-active { background: #fff !important; }

ul.options li { clear: both; margin-bottom: 8px; }
ul.options li .container { float: left; }
ul.options label.settings-label { font-size: 1em; font-weight: 700; float: left; width: 250px; margin: 3px 0 0 0; }
ul.options input.text { float: left; width: 300px; }
ul.options span.note { clear: both; float: left; margin: 2px 0 8px 250px; display: block; font-size: 0.8em; line-height: 1.5em; }

ul.options div.address { float: left; }
ul.options div.address label { clear: both; float: left; width: 160px; margin: 3px 10px 0 0; }
ul.options div.address input.text { float: left; width: 200px; }


/* =INTERNET EXPLORER
--------------------------------------------------------------------------------------------------------------------------------------------------- */
.ie7 #nav-main ul li { 
    zoom: 1; 
    }

/* ------- Clearfixes ------- */
.ie7 #commentform, 
.ie7 #post-nav, 
.ie7 #comments-nav { 
    display: inline-block; 
    }


/* =MEDIA QUERIES
--------------------------------------------------------------------------------------------------------------------------------------------------- */

@media screen and (-moz-document) {
    .adelante-button {
        padding: 3px 10px;
    }
}

@media all and (orientation: portrait) {
    /* Style adjustments for portrait mode goes here */

}

@media all and (orientation: landscape) {
    /* Style adjustments for landscape mode goes here */

}

@media screen and (max-device-width: 480px) {
    /* Grade-A Mobile Browsers (Opera Mobile, iPhone Safari, Android Chrome) */

}

@media print {
  * { 
      background: transparent !important; 
      color: black !important; 
      text-shadow: none !important; 
      filter: none !important; 
      -ms-filter: none !important; 
      } 
  a, 
  a: visited { 
      color: #444 !important; 
      text-decoration: underline; 
      }
  a[href]:after { 
      content: " (" attr(href) ")"; 
      }
  abbr[title]:after { 
      content: " (" attr(title) ")"; 
      }
  .ir a:after, 
  a[href^="javascript:"]:after, 
  a[href^="#"]:after { 
      content: ""; 
      }
  pre, 
  blockquote { 
    border: 1px solid #999; 
    page-break-inside: avoid; 
    }
  thead { 
      display: table-header-group; 
      }
  tr, 
  img { 
      page-break-inside: avoid; 
      }
  @page { 
      margin: 0.5cm; 
      }
  p, 
  h2, 
  h3 { 
      orphans: 3; 
      widows: 3; 
      }
  h2, 
  h3 { 
      page-break-after: avoid; 
      }    
}
{$custom_css}
CSS;
?>