<?php 

function adelante_create_menu() 
{
	$icon = get_template_directory_uri() . '/includes/img/icon-adelante.png';

	// create menu
	$theme_name = get_current_theme();
	add_object_page($theme_name . ' Settings', $theme_name, 'administrator', 'adelante', 'adelante_settings_page', $icon);
	
	// call register settings function
	add_action('admin_init', 'adelante_register_settings');

	// add js
	wp_enqueue_script('jquery-ui-tabs');

	// add css
	add_action('admin_print_styles-toplevel_page_adelante', 'adelante_admin_styles');
}
add_action('admin_menu', 'adelante_create_menu');


function adelante_admin_styles() 
{
	wp_register_style('adelante_options_css', ADELANTE_INCLUDES_URI."/css/options.css");
	wp_enqueue_style('adelante_options_css');
    
	wp_register_script('adelante_options_js', ADELANTE_INCLUDES_URI."/js/options.js");
	wp_enqueue_script('adelante_options_js');
    	
	wp_register_style('jquery-ui-css', "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/smoothness/jquery-ui.css");
	wp_enqueue_style('jquery-ui-css');
}

function adelante_register_settings() 
{
	// General
	register_setting('adelante-settings-group', 'adelante_css_framework');	
	register_setting('adelante-settings-group', 'adelante_main_class');
	register_setting('adelante-settings-group', 'adelante_sidebar_class');
	register_setting('adelante-settings-group', 'adelante_google_analytics');
    register_setting('adelante-settings-group', 'adelante_general_css');
    
    // Theme
    register_setting('adelante-settings-group', 'adelante_theme');
    register_setting('adelante-settings-group', 'adelante_disable_cufon');    
    register_setting('adelante-settings-group', 'adelante_body_font_family');
    register_setting('adelante-settings-group', 'adelante_body_font_size');
    register_setting('adelante-settings-group', 'adelante_body_bg');
    register_setting('adelante-settings-group', 'adelante_body_bgcolor');
    register_setting('adelante-settings-group', 'adelante_theme_blur');
    register_setting('adelante-settings-group', 'adelante_theme_cufon');
    register_setting('adelante-settings-group', 'adelante_theme_toggle');
    register_setting('adelante-settings-group', 'adelante_theme_preload');
    register_setting('adelante-settings-group', 'adelante_syntaxhl_theme');
    
    // Header     
    register_setting('adelante-settings-group', 'adelante_heading_font');
    register_setting('adelante-settings-group', 'adelante_h1_font_size');
    register_setting('adelante-settings-group', 'adelante_h2_font_size');
    register_setting('adelante-settings-group', 'adelante_h3_font_size');
    register_setting('adelante-settings-group', 'adelante_h4_font_size');
    register_setting('adelante-settings-group', 'adelante_h5_font_size');
    register_setting('adelante-settings-group', 'adelante_h6_font_size');    
    register_setting('adelante-settings-group', 'adelante_teaser_font_size');
    register_setting('adelante-settings-group', 'adelante_teaser_text');
    register_setting('adelante-settings-group', 'adelante_teaser_custom_text');
    register_setting('adelante-settings-group', 'adelante_teaser_image');
    register_setting('adelante-settings-group', 'adelante_teaser_bg');
    register_setting('adelante-settings-group', 'adelante_teaser_bgcolor');
    register_setting('adelante-settings-group', 'adelante_teaser_color');
    
    // Slider
    register_setting('adelante-settings-group', 'adelante_slider_height');
    register_setting('adelante-settings-group', 'adelante_slider_fullheight');
    register_setting('adelante-settings-group', 'adelante_slider_bg');
    register_setting('adelante-settings-group', 'adelante_slider_bgcolor');
    register_setting('adelante-settings-group', 'adelante_slider_subject');
    register_setting('adelante-settings-group', 'adelante_slider_slide_count');
    register_setting('adelante-settings-group', 'adelante_slider_post_count');
    register_setting('adelante-settings-group', 'adelante_slider_post_character_count');
    register_setting('adelante-settings-group', 'adelante_slider_effects');
    register_setting('adelante-settings-group', 'adelante_slider_timeout');
    register_setting('adelante-settings-group', 'adelante_slider_speed');
    register_setting('adelante-settings-group', 'adelante_slider_text_locationV');
    register_setting('adelante-settings-group', 'adelante_slider_text_vertical_offset');
    register_setting('adelante-settings-group', 'adelante_slider_text_locationH');
    register_setting('adelante-settings-group', 'adelante_slider_text_horizontal_offset');
    register_setting('adelante-settings-group', 'adelante_slider_text_maxwidth');
        
    // Blog
	register_setting('adelante-settings-group', 'adelante_post_author');
    register_setting('adelante-settings-group', 'adelante_post_featured_image');
    register_setting('adelante-settings-group', 'adelante_blog_placeholder');
    
    // Social
	register_setting('adelante-settings-group', 'adelante_post_tweet');
	register_setting('adelante-settings-group', 'adelante_footer_social_share');
    register_setting('adelante-settings-group', 'adelante_twitter_username');
    register_setting('adelante-settings-group', 'adelante_twitter_loading_message');
    
    // Images
    register_setting('adelante-settings-group', 'adelante_images_cropping_location');
    register_setting('adelante-settings-group', 'adelante_images_filter');
    
    $post_types = adelante_get_post_types( false );
    foreach ( $post_types as $post_type ):
        register_setting( 'adelante-settings-group', "adelante_images_".$post_type."_placeholder" );
        register_setting( 'adelante-settings-group', "adelante_slider_".$post_type );
    endforeach;
    
    // Footer
    register_setting('adelante-settings-group', 'adelante_footer_bg');
    register_setting('adelante-settings-group', 'adelante_footer_bgcolor');
    register_setting('adelante-settings-group', 'adelante_footer_color');
    register_setting('adelante-settings-group', 'adelante_footer_columns');
    register_setting('adelante-settings-group', 'adelante_footer_text');
	register_setting('adelante-settings-group', 'adelante_vcard_street-address');
	register_setting('adelante-settings-group', 'adelante_vcard_locality');
	register_setting('adelante-settings-group', 'adelante_vcard_region');
	register_setting('adelante-settings-group', 'adelante_vcard_postal-code');
	register_setting('adelante-settings-group', 'adelante_vcard_tel');
	register_setting('adelante-settings-group', 'adelante_vcard_email');
	register_setting('adelante-settings-group', 'adelante_footer_vcard');
	
	// Add default settings
    add_option('adelante_theme', 'Black');
	add_option('adelante_css_framework', 'blueprint');
	add_option('adelante_main_class', 'span-16 eightcol grid_16');
	add_option('adelante_sidebar_class', 'span-8 last fourcol grid_8');	
	add_option('adelante_google_analytics', '');
    add_option('adelante_body_font_family', 'sans-serif');
    add_option('adelante_body_font_size', 90);
    add_option('adelante_body_bg', 'none');
    add_option('adelante_body_bgcolor', '#f7f7f7');
    add_option('adelante_theme_blur', '"figure.gallery-item", ".twitter_bird", ".flickr_badge_image", ".picasa-widget-img", ".widget_twitter img", "a.thumbnail img"');
    add_option('adelante_theme_cufon', '"h1", "h2", "h3", "h4", "h5", "h6", "#teaser-content"');
    add_option('adelante_theme_toggle', '"#sidebar .widget h2", "#sidebar .widget h3", ".widgetbox h3"');
    add_option('adelante_theme_preload', '"#main .container", ".slider-frame"');
    add_option('adelante_syntaxhl_theme', 'default');
    
    add_option('adelante_heading_font', 'SearsTower');
    add_option('adelante_h1_font_size', 36);
    add_option('adelante_h2_font_size', 30);
    add_option('adelante_h3_font_size', 24);
    add_option('adelante_h4_font_size', 18);
    add_option('adelante_h5_font_size', 12);
    add_option('adelante_h6_font_size', 10);
    add_option('adelante_teaser_font_size', 22);
    add_option('adelante_teaser_color', '#888');
    add_option('adelante_teaser_bgcolor', '#d6e4ed');
    add_option('adelante_teaser_option', 'custom');
    add_option('adelante_teaser_image', 'left');
    add_option('adelante_teaser_custom_text', get_bloginfo( 'description' ) );
    	
    add_option('adelante_slider_height', 318);
    add_option('adelante_slider_fullheight', 'checked');
    add_option('adelante_slider_bg', 'page-heading-gradient.png');
    add_option('adelante_slider_bgcolor', '#ffffff');
    add_option('adelante_slider_subject', 'images');
    add_option('adelante_slider_slide_count', 10);    
    add_option('adelante_slider_post_count', 10);
    add_option('adelante_slider_post_character_count', 450);
    add_option('adelante_slider_effects', 'fade');
    add_option('adelante_slider_timeout', 7000);
    add_option('adelante_slider_speed', 1500);
    add_option('adelante_slider_post', 'checked');
    add_option('adelante_slider_text_locationV', 'bottom');
    add_option('adelante_slider_text_vertical_offset', 25);
    add_option('adelante_slider_text_locationH', 'left');
    add_option('adelante_slider_text_horizontal_offset', 0);
    add_option('adelante_slider_text_maxwidth', 650);

    add_option('adelante_twitter_loading_message', 'Please wait ...');
    
    add_option('adelante_images_cropping_location', 'c');
    add_option('adelante_images_portfolio_placeholder', 'checked');       
    
    add_option('adelante_footer_columns', 4);
    add_option('adelante_footer_bgcolor', '#222222');          
    add_option('adelante_footer_color', '#cccccc');          
}

function adelante_settings_page() 
{ 
    // Grab all custom post types
    $post_types = adelante_get_post_types( false );
    
    // Grab all themes
    $themes = adelante_load_files( ADELANTE_STYLESHEET, array("css"), false );
    remove_value_from_array($themes, 'main');
    sort( $themes );

    // Grab all fonts
    $hstyles = adelante_load_files( ADELANTE_JS. "/fonts", array("js"), false );
    sort( $hstyles );
    
    // Grab all tilables
    $tilables = adelante_load_files( ADELANTE_BASE. "/img/tilables", array("gif","jpg","bmp","png"), true );
    sort( $tilables );
    
    // Grab some system fonts
    $fonts = array( 
        "Arial", 
        "Arial Narrow", 
        "Georgia", 
        "Helvetica", 
        "sans-serif", 
        "Tahoma", 
        "Times New Roman", 
        "Verdana" 
    );
    
    // Timthumb cropping locations 
    $cropping_locations = array(
        "c" => "Position in center(Default)", 
        "t" => "Align top", 
        "tr" => "Align top right", 
        "tl" => "Align top left", 
        "b" => "Align bottom", 
        "br" => "Align bottom right", 
        "bl" => "Align bottom left", 
        "l" => "Align left", 
        "r" => "Align right"
    );
    
    // Timthumb filters
    $filters = array( 
        0 => "None", 
        1 => "Negate", 
        2 => "Grayscale", 
        6 => "Edge Detect", 
        7 => "Emboss", 
        8 => "Gaussian Blur", 
        9 => "Selective Blur",
        10 => "Mean Removal"
    ); 
    
    $targets = array(
        "_blank", "_self", "_parent", "_top"
    ); 

    $slider_effects = array(
        "blindX","blindY","blindZ","cover","curtainX","curtainY","fade","fadeZoom","growX","growY",
        "scrollUp","scrollDown","scrollLeft","scrollRight","scrollHorz","scrollVert","shuffle","slideX",
        "slideY","toss","turnUp","turnDown","turnLeft","turnRight","uncover","wipe","zoom"
    ); 
    
    $shl_themes = array( 'default','django','eclipse','emacs','fadetogrey','midnight','rdark','none' )  
?>

<div class="wrap">          
	<div id="icon-options-general" class="icon32"></div>
        <h2><?php echo get_current_theme(); ?> Settings</h2>
	
<?php 
    if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] === 'true' ) { 
        if ( is_writable( ADELANTE_STYLESHEET ) ) {
            $fhandle = @fopen( ADELANTE_STYLESHEET. '/main.css', 'w+' );
            $content = include( ADELANTE_INCLUDES. '/adelante-style.php' );
            if ( $fhandle ) fwrite( $fhandle, $content, strlen( $content ) );
        }    
?>
	    <div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Settings saved.</strong></p></div>
<?php } ?>
	
	<form method="post" action="options.php">
			
		<?php settings_fields( 'adelante-settings-group' ); ?>
		
		<div id="tabs">
			
            <ul>
				<li><a href="#general">General</a></li>
                <li><a href="#theme">Theme</a></li>
                <li><a href="#heading">Heading</a></li>
                <li><a href="#slider">Slider</a></li>
                <li><a href="#teaser">Teaser</a></li>
                <li><a href="#blog">Blog</a></li>
                <li><a href="#social">Social</a></li>
                <li><a href="#images">Images</a></li>
                <li><a href="#foot">Footer</a></li>
			</ul>
			
            <div id="general">
				<ul class="options clearfix">	
					<li class="clearfix">
						<label class="settings-label">CSS Grid Framework</label>
						<div class="container">
							<input id="adelante_blueprint" name="adelante_css_framework" type="radio" <?php echo get_option('adelante_css_framework') === 'blueprint' ? 'checked' : ''; ?> value="blueprint" /> <label for="adelante_blueprint">Blueprint CSS</label><br />
							<input id="adelante_960gs_12" name="adelante_css_framework" type="radio" <?php echo get_option('adelante_css_framework') === '960gs_12' ? 'checked' : ''; ?> value="960gs_12" /> <label for="adelante_960gs_12">960gs (12 cols)</label><br />
							<input id="adelante_960gs_16" name="adelante_css_framework" type="radio" <?php echo get_option('adelante_css_framework') === '960gs_16' ? 'checked' : ''; ?> value="960gs_16" /> <label for="adelante_960gs_16">960gs (16 cols)</label><br />
							<input id="adelante_960gs_24" name="adelante_css_framework" type="radio" <?php echo get_option('adelante_css_framework') === '960gs_24' ? 'checked' : ''; ?> value="960gs_24" /> <label for="adelante_960gs_24">960gs (24 cols)</label><br />
							<input id="adelante_1140" name="adelante_css_framework" type="radio" <?php echo get_option('adelante_css_framework') === '1140' ? 'checked' : ''; ?> value="1140" /> <label for="adelante_1140">1140</label>
						</div>
					</li>
					<li>	
						<label class="settings-label">Class for #main</label>
						<input name="adelante_main_class" type="text" value="<?php echo get_option('adelante_main_class'); ?>" class="text" />
						<span class="note">Enter your grid classes</span>
					</li>
					<li>
						<label class="settings-label">Class for #sidebar</label>
						<input name="adelante_sidebar_class" type="text" value="<?php echo get_option('adelante_sidebar_class'); ?>" class="text" />
						<span class="note">Enter your grid classes</span>
					</li>									
					<li>
						<label class="settings-label">Google analytics tracking ID</label>
						<input name="adelante_google_analytics" type="text" value="<?php echo get_option('adelante_google_analytics'); ?>" class="text" />
						<span class="note">Enter your UA-XXXXX-X ID</span>
					</li> 
                    <li>
                        <label class="settings-label">Additional CSS</label>
                        <textarea name="adelante_general_css" type="text"><?php echo get_option('adelante_general_css'); ?></textarea>
                    </li>                 				               					
				</ul>
			</div>	

            <div id="theme">
                <ul class="options clearfix">
                
                    <li>
                        <label class="settings-label">Theme</label>
                        <select name="adelante_theme"> 
                            <?php
                                foreach ($themes as $theme) {
                                    if ( get_option('adelante_theme') == $theme ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $theme. "'>". $theme."</option>";
                                }
                            ?>
                        </select>
                    </li>
                    
                     <li>
                        <label class="settings-label">Disable Cufón Text Replacement?</label>
                        <input type="checkbox" id="adelante_disable_cufon" name="adelante_disable_cufon" id="adelante_disable_cufon" value="checked" <?php echo get_option('adelante_disable_cufon') === 'checked' ? 'checked' : ''; ?> />                                
                    </li> 
                                    
                    <li>
                        <label class="settings-label">Body Font</label>
                        <select name="adelante_body_font_family"> 
                            <?php
                                foreach ($fonts as $font) {
                                    if ( $font == get_option('adelante_body_font_family') ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $font. "'>". $font."</option>";
                                }
                            ?>                            
                        </select>
                    </li>
                    
                    <li>    
                        <label class="settings-label">Body Font Size</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_body_font_size" min="50" max="150" step="10" name="adelante_body_font_size" value="<?php echo get_option('adelante_body_font_size'); ?>"><span>%</span>
                        </div>
                    </li>
                    
                    <li>
                        <label class="settings-label">Body Background</label>
                        <select name="adelante_body_bg">
                            <option value="none">No Background</option> 
                            <?php
                                foreach ($tilables as $tilable) {
                                    if ( get_option('adelante_body_bg') == $tilable ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $tilable. "'>". $tilable."</option>";
                                }
                            ?>
                        </select>
                        <span class="note">Provide a custom background image for main wrapper</span>
                    </li>
                    
                    <li>
                        <label class="settings-label">Body Background Color</label>
                        <input data-hex="true" class="colorpicker" id="adelante_body_bgcolor" name="adelante_body_bgcolor" type="text" value="<?php echo get_option('adelante_body_bgcolor'); ?>" />
                        <span class="note">Specify a background color for the main wrapper</span>
                    </li>                    
                    
                    <li>    
                        <label class="settings-label">Elements to Blur</label>
                        <textarea id="adelante_theme_blur" name="adelante_theme_blur" type="text"><?php echo get_option('adelante_theme_blur'); ?></textarea>
                        <span class="note">Specify a comma-separated list of elements, e.g. ".container", "#teaser-title", "ul"</span>
                    </li>

                    <li>    
                        <label class="settings-label">Elements to Cufón Replace</label>
                        <textarea id="adelante_theme_cufon" name="adelante_theme_cufon" type="text"><?php echo get_option('adelante_theme_cufon'); ?></textarea>
                        <span class="note">Specify a comma-separated list of elements, e.g. ".container", "#teaser-title", "ul"</span>
                    </li>
                    
                    <li>    
                        <label class="settings-label">Elements to Toggle</label>
                        <textarea id="adelante_theme_toggle" name="adelante_theme_toggle" type="text"><?php echo get_option('adelante_theme_toggle'); ?></textarea>
                        <span class="note">Specify a comma-separated list of elements, e.g. ".container", "#teaser-title", "ul"</span>
                    </li>
                    
                    <li>    
                        <label class="settings-label">Elements to Preload</label>
                        <textarea id="adelante_theme_preload" name="adelante_theme_preload" type="text"><?php echo get_option('adelante_theme_preload'); ?></textarea>
                        <span class="note">Specify a comma-separated list of elements, e.g. ".container", "#teaser-title", "ul"</span>
                    </li>
                                                                             
                    <li>
                        <label class="settings-label">Syntaxhighlighter Theme</label> 
                        <select name="adelante_syntaxhl_theme">
                            <?php
                                foreach ($shl_themes as $shl_theme) {
                                    if ( get_option('adelante_syntaxhl_theme') == $shl_theme ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $shl_theme. "'>". $shl_theme."</option>";
                                }
                            ?>
                        </select>
                        <span class="note">Specify a theme for the syntaxhighlighter</span>
                    </li> 
                                                      
                </ul>
            </div>
                        
            <div id="heading">
                <ul class="options clearfix">
                
                    <li>
                        <label class="settings-label">Heading Font Script</label>
                        <select name="adelante_heading_font"> 
                            <?php
                                foreach ($hstyles as $style) {
                                    if ( get_option('adelante_heading_font') == $style ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $style. "'>". $style."</option>";
                                }
                            ?>
                        </select>
                    </li> 
                                    
                    <li>    
                        <label class="settings-label">H1 Font Size</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_h1_font_size" min="8" max="72" step="1" name="adelante_h1_font_size" value="<?php echo get_option('adelante_h1_font_size'); ?>"><span>px</span>
                        </div>
                    </li>
                       
                    <li>    
                        <label class="settings-label">H2 Font Size</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_h2_font_size" min="8" max="72" step="1" name="adelante_h2_font_size" value="<?php echo get_option('adelante_h2_font_size'); ?>"><span>px</span>
                        </div>
                    </li>
                    
                    <li>    
                        <label class="settings-label">H3 Font Size</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_h3_font_size" min="8" max="72" step="1" name="adelante_h3_font_size" value="<?php echo get_option('adelante_h3_font_size'); ?>"><span>px</span>
                        </div>
                    </li>
                    
                    <li>    
                        <label class="settings-label">H4 Font Size</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_h4_font_size" min="8" max="72" step="1" name="adelante_h4_font_size" value="<?php echo get_option('adelante_h4_font_size'); ?>"><span>px</span>
                        </div>
                    </li>
                    
                    <li>    
                        <label class="settings-label">H5 Font Size</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_h5_font_size" min="8" max="72" step="1" name="adelante_h5_font_size" value="<?php echo get_option('adelante_h5_font_size'); ?>"><span>px</span>
                        </div>
                    </li>
                    
                    <li>    
                        <label class="settings-label">H6 Font Size</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_h6_font_size" min="8" max="72" step="1" name="adelante_h6_font_size" value="<?php echo get_option('adelante_h6_font_size'); ?>"><span>px</span>
                        </div>
                    </li>
                                                                                                 
                </ul>
            </div>
           
           <div id="slider">
                <ul class="options clearfix">                          
                    <li>
                        <label class="settings-label">Height</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_slider_height" min="150" max="1024" step="1" name="adelante_slider_height" value="<?php echo get_option('adelante_slider_height'); ?>"><span>px</span>
                        </div>
                        <span class="note">Specify the initial height of the slider in pixels</span>
                    </li>
                    <li>
                        <label class="settings-label">Full Height</label>
                        <input type="checkbox" name="adelante_slider_fullheight" id="adelante_slider_fullheight" value="checked" <?php echo get_option('adelante_slider_fullheight') === 'checked' ? 'checked' : ''; ?> />                                
                    </li> 
                    <li>
                        <label class="settings-label">Background Color</label>
                        <input data-hex="true" class="colorpicker" id="adelante_slider_bgcolor" name="adelante_slider_bgcolor" type="text" value="<?php echo get_option('adelante_slider_bgcolor'); ?>" />
                        <span class="note">Specify a background color for the slider area</span>
                    </li> 
                    <li>
                        <label class="settings-label">Background Pattern</label>
                        <select name="adelante_slider_bg">
                            <option value="none">No Background</option> 
                            <?php
                                foreach ($tilables as $tilable) {
                                    if ( get_option('adelante_slider_bg') == $tilable ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $tilable. "'>". $tilable."</option>";
                                }
                            ?>
                        </select>
                        <span class="note">Specify a background pattern for the slider area</span>
                    </li> 
                    <li>
                        <label class="settings-label">Subject</label>
                        <div class="container">
                            <input id="adelante_slider_subject_images" name="adelante_slider_subject" type="radio" <?php echo get_option('adelante_slider_subject') === 'images' ? 'checked' : ''; ?> value="images" /> <label for="adelante_slider_subject_images">Images</label><br />
                            <input id="adelante_slider_subject_posts" name="adelante_slider_subject" type="radio" <?php echo get_option('adelante_slider_subject') === 'posts' ? 'checked' : ''; ?> value="posts" /> <label for="adelante_slider_subject_posts">Posts</label><br />
                        </div>
                        <span class="note">Specify what to slide with the slider</span>
                        
                        <ul id="slider_subject_images" class="subject options clearfix">
                            <li>
                                <label class="settings-label">Number of Slides</label>
                                <div class="range-input-wrap">
                                    <input type="range" id="adelante_slider_slide_count" min="0" max="50" step="1" name="adelante_slider_slide_count" value="<?php echo get_option('adelante_slider_slide_count'); ?>">
                                </div>
                                <span class="note">Specify the number of slides to retrieve (0 = All)</span>
                            </li>                            
                        </ul>
                        
                        <ul id="slider_subject_posts" class="subject options clearfix">
                            <li>
                                <label class="settings-label">Use posts of type</label>                       
                                <?php foreach ( $post_types as $post_type ): ?>
                                    <input id="adelante_slider_<?php echo $post_type ?>" name="adelante_slider_<?php echo $post_type ?>" type="checkbox" <?php echo get_option("adelante_slider_".$post_type) === 'checked' ?  'checked' : ''; ?> value="checked" /> <label for="adelante_slider_<?php echo $post_type ?>"><?php echo ucfirst($post_type); ?></label>
                                <?php endforeach; ?>
                            </li>
                            <li>
                                <label class="settings-label">Number of Posts</label>
                                <div class="range-input-wrap">
                                    <input type="range" id="adelante_slider_post_count" min="0" max="50" step="1" name="adelante_slider_post_count" value="<?php echo get_option('adelante_slider_post_count'); ?>">
                                </div>
                                <span class="note">Specify the number of posts to retrieve (0 = All)</span>
                            </li> 
                             <li>
                                <label class="settings-label">Number of Characters</label>
                                <div class="range-input-wrap">
                                    <input type="range" id="adelante_slider_post_character_count" min="0" max="1000" step="10" name="adelante_slider_post_character_count" value="<?php echo get_option('adelante_slider_post_character_count'); ?>">
                                </div>
                                <span class="note">Specify the number of characters to retrieve for a post (0 = Entrire post)</span>
                            </li>                                                        
                        </ul>                        
                    </li>
                    <li>
                        <label class="settings-label">Transition Effects</label>
                        <select name="adelante_slider_effects"> 
                            <?php
                                foreach ($slider_effects as $effect) {
                                    if ( $effect == get_option('adelante_slider_effects') ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $effect. "'>". $effect."</option>";
                                }
                            ?>                            
                        </select>
                    </li>
                    <li>
                        <label class="settings-label">Timeout</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_slider_timeout" min="0" max="30000" step="1000" name="adelante_slider_timeout" value="<?php echo get_option('adelante_slider_timeout'); ?>"><span>ms</span>
                        </div>
                        <span class="note">Milliseconds between slide transitions (0 to disable) </span>
                    </li>
                    <li>
                        <label class="settings-label">Slide Speed</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_slider_speed" min="0" max="10000" step="100" name="adelante_slider_speed" value="<?php echo get_option('adelante_slider_speed'); ?>"><span>sec.</span>
                        </div>
                        <span class="note">Speed of the transition in milliseconds (any valid fx speed value)</span>
                    </li>
                    <li>
                        <label class="settings-label">Slide Text Vertical Position</label>
                        <div class="container">
                            <input id="adelante_slider_text_top" name="adelante_slider_text_locationV" type="radio" <?php echo get_option('adelante_slider_text_locationV') === 'top' ? 'checked' : ''; ?> value="top" /> <label for="adelante_slider_text_top">Top</label><br />
                            <input id="adelante_slider_text_bottom" name="adelante_slider_text_locationV" type="radio" <?php echo get_option('adelante_slider_text_locationV') === 'bottom' ? 'checked' : ''; ?> value="bottom" /> <label for="adelante_slider_text_bottom">Bottom</label><br />
                        </div>
                        <span class="note">Specify the vertical position of the slide text</span>
                    </li>
                    <li>
                        <label class="settings-label">Slide Text Vertical Offset</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_slider_text_vertical_offset" min="0" max="500" step="1" name="adelante_slider_text_vertical_offset" value="<?php echo get_option('adelante_slider_text_vertical_offset'); ?>"><span>px</span>
                        </div>
                        <span class="note">Vertical offset of the slide text in pixels</span>
                    </li> 
                    <li>
                        <label class="settings-label">Slide Text Horizontal Position</label>
                        <div class="container">
                            <input id="adelante_slider_text_left" name="adelante_slider_text_locationH" type="radio" <?php echo get_option('adelante_slider_text_locationH') === 'left' ? 'checked' : ''; ?> value="left" /> <label for="adelante_slider_text_left">Left</label><br />
                            <input id="adelante_slider_text_right" name="adelante_slider_text_locationH" type="radio" <?php echo get_option('adelante_slider_text_locationH') === 'right' ? 'checked' : ''; ?> value="right" /> <label for="adelante_slider_text_right">Right</label><br />
                        </div>
                        <span class="note">Specify the horizontal position of the slide text</span>
                    </li>
                    <li>
                        <label class="settings-label">Slide Text Horizontal Offset</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_slider_text_horizontal_offset" min="0" max="500" step="1" name="adelante_slider_text_horizontal_offset" value="<?php echo get_option('adelante_slider_text_horizontal_offset'); ?>"><span>px</span>
                        </div>
                        <span class="note">Horizontal offset of the slide text in pixels</span>
                    </li> 
                    <li>
                        <label class="settings-label">Slide Text Max. Width</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_slider_text_maxwidth" min="0" max="2000" step="1" name="adelante_slider_text_maxwidth" value="<?php echo get_option('adelante_slider_text_maxwidth'); ?>"><span>px</span>
                        </div>
                        <span class="note">Horizontal offset of the slide text in pixels</span>
                    </li>                                                                  
                </ul>                
            </div>
            
            <div id="teaser">
                <ul class="options clearfix">
                    <li>
                        <label class="settings-label">Background</label>
                        <select name="adelante_teaser_bg">
                            <option value="default">Default</option> 
                            <?php
                                foreach ($tilables as $tilable) {
                                    if ( get_option('adelante_teaser_bg') == $tilable ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $tilable. "'>". $tilable."</option>";
                                }
                            ?>
                        </select>
                        <span class="note">Provide a custom background image for the teaser bar</span>
                    </li>
                    
                    <li>
                        <label class="settings-label">Background Color</label>
                        <input data-hex="true" class="colorpicker" id="adelante_teaser_bgcolor" name="adelante_teaser_bgcolor" type="text" value="<?php echo get_option('adelante_teaser_bgcolor'); ?>" />
                        <span class="note">Specify a color for the teaser bar</span>
                    </li>

                    <li>
                        <label class="settings-label">Font Color</label>
                        <input data-hex="true" class="colorpicker" id="adelante_teaser_color" name="adelante_teaser_color" type="text" value="<?php echo get_option('adelante_teaser_color'); ?>" />
                        <span class="note">Specify the font color for the teaser bar text</span>
                    </li> 
                    
                    <li>    
                        <label class="settings-label">Teaser Font Size</label>
                        <div class="range-input-wrap">
                            <input type="range" id="adelante_teaser_font_size" min="8" max="72" step="1" name="adelante_teaser_font_size" value="<?php echo get_option('adelante_teaser_font_size'); ?>"><span>px</span>
                        </div>
                        <span class="note">Specify the font size for the Teaser element in pixels</span>
                    </li>
                                                                
                    <li class="clearfix">
                        <label class="settings-label">Text</label>
                        <div class="container">
                            <input id="adelante_twitter" name="adelante_teaser_text" type="radio" <?php echo get_option('adelante_teaser_text') === 'twitter' ? 'checked' : ''; ?> value="twitter" /> <label for="adelante_twitter">Twitter</label><br />
                            <input id="adelante_custom" name="adelante_teaser_text" type="radio" <?php echo get_option('adelante_teaser_text') === 'custom' ? 'checked' : ''; ?> value="custom" /> <label for="adelante_custom">Custom</label><br />
                            <input id="adelante_disabled" name="adelante_teaser_text" type="radio" <?php echo get_option('adelante_teaser_text') === 'disabled' ? 'checked' : ''; ?> value="disabled" /> <label for="adelante_disabled">Disabled</label><br />
                        </div>
                        <span class="note">What do you want to display in the teaser bar?</span>
                        <ul id="adelante_teaser_custom" class="options clearfix">
                            <li>
                                <label class="settings-label">Image</label>
                                <div class="container">
                                    <input id="adelante_teaser_image_left" name="adelante_teaser_image" type="radio" <?php echo get_option('adelante_teaser_image') === 'left' ? 'checked' : ''; ?> value="left" /> <label for="adelante_twitter">Left</label><br />
                                    <input id="adelante_teaser_image_right" name="adelante_teaser_image" type="radio" <?php echo get_option('adelante_teaser_image') === 'right' ? 'checked' : ''; ?> value="right" /> <label for="adelante_custom">Right</label><br />
                                    <input id="adelante_teaser_image_both" name="adelante_teaser_image" type="radio" <?php echo get_option('adelante_teaser_image') === 'both' ? 'checked' : ''; ?> value="both" /> <label for="adelante_disabled">Both</label><br />
                                </div>
                                <span class="note">Select the location for your teaser bar image?</span>                                      
                            </li>
                            <li>    
                                <label class="settings-label">Custom Text</label>
                                <textarea id="adelante_teaser_custom_text" name="adelante_teaser_custom_text" type="text"><?php echo get_option('adelante_teaser_custom_text'); ?></textarea>
                            </li>                          
                        </ul>
                    </li>
                </ul>
            </div>
            
            <div id="blog">
                <ul class="options clearfix">                          
                     <li>
                        <label class="settings-label">Post author</label>
                        <input id="adelante_post_author" name="adelante_post_author" type="checkbox" <?php echo get_option('adelante_post_author') === 'checked' ? 'checked' : ''; ?> value="checked" /> <label for="adelante_post_author">Display the post author?</label>
                    </li> 
                    <li>
                        <label class="settings-label">Featured image</label>                        
                        <input name="adelante_post_featured_image" type="checkbox" <?php echo get_option('adelante_post_featured_image') === 'checked' ? 'checked' : ''; ?> value="checked" /> <label for="adelante_post_featured_image">Hide Featured Image in post details page?</label>
                    </li>                                                                   
                </ul>            
            </div>    
            
            <div id="social">
                <ul class="options clearfix">                          
                    <li>
                        <label class="settings-label">Post tweet button</label>
                        <input id="adelante_post_tweet" name="adelante_post_tweet" type="checkbox" <?php echo get_option('adelante_post_tweet') === 'checked' ? 'checked' : ''; ?> value="checked" /> <label for="adelante_post_tweet">Enable Tweet button on posts</label>
                    </li>                        
                    <li>
                        <label class="settings-label">Social share buttons</label>
                        <input id="adelante_footer_social_share" name="adelante_footer_social_share" type="checkbox" <?php echo get_option('adelante_footer_social_share') === 'checked' ?  'checked' : ''; ?> value="checked" /> <label for="adelante_footer_social_share">Enable official Twitter and Facebook buttons in the footer</label>
                    </li>
                    <li>
                        <label class="settings-label">Twitter username</label>
                        <input id="adelante_twitter_username" name="adelante_twitter_username" type="text" value="<?php echo get_option('adelante_twitter_username'); ?>" />
                        <span class="note">Specify your Twitter username</span>
                    </li> 
                    <li>
                        <label class="settings-label">Twitter loading message</label>
                        <input name="adelante_twitter_loading_message" type="text" value="<?php echo get_option('adelante_twitter_loading_message'); ?>" class="text" />
                        <span class="note">Enter the text that displays while loading your latest tweet</span>
                    </li>                                                                                     
                </ul>            
            </div>	
            
            <div id="images">
                <ul class="options clearfix">
                    <li>
                        <label class="settings-label">Use placeholder image on</label>                       
                        <?php foreach ( $post_types as $post_type ): ?>
                            <input id="adelante_images_<?php echo $post_type ?>_placeholder" name="adelante_images_<?php echo $post_type ?>_placeholder" type="checkbox" <?php echo get_option("adelante_images_".$post_type."_placeholder") === 'checked' ?  'checked' : ''; ?> value="checked" /> <label for="adelante_images_<?php echo $post_type ?>_placeholder"><?php echo ucfirst($post_type); ?></label>
                        <?php endforeach; ?>
                    </li>                                                  
                    <li>
                        <label class="settings-label">Timthumb cropping location</label>
                        <select name="adelante_images_cropping_location"> 
                            <?php
                                foreach ( $cropping_locations as $i => $crl ) {
                                    if ( $i == get_option('adelante_images_cropping_location') ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $i. "'>". $crl."</option>";
                                }
                            ?>
                        </select>   
                    </li>
                    <li>
                        <label class="settings-label">Timthumb filter</label>
                        <select name="adelante_images_filter"> 
                            <?php
                                foreach ( $filters as $i => $filter ) {
                                    if ( $i == get_option('adelante_images_filter') ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $i. "'>". $filter."</option>";
                                }
                            ?>
                        </select>
                    </li>                                                                                     
                </ul>            
            </div> 
                           
            <div id="foot">
                <ul class="options clearfix"> 
                     <li>
                        <label class="settings-label">Footer Columns</label>
                        <select name="adelante_footer_columns"> 
                            <?php
                                for ( $i = 1; $i < 6; $i++ ) {
                                    if ( get_option('adelante_footer_columns') == $i ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $i. "'>". $i."</option>";
                                }
                            ?>                            
                        </select>
                    </li> 
                    <li>
                        <label class="settings-label">Footer Background</label>
                        <select name="adelante_footer_bg">
                            <option value="default">Default</option> 
                            <?php
                                foreach ($tilables as $tilable) {
                                    if ( get_option('adelante_footer_bg') == $tilable ) {
                                        $selected = "selected='selected'";
                                    } 
                                    else {
                                        $selected = "";        
                                    }
                                    echo"<option $selected value='". $tilable. "'>". $tilable."</option>";
                                }
                            ?>
                        </select>
                        <span class="note">Provide a custom background image for the footer</span>
                    </li>
                    <li>
                        <label class="settings-label">Footer Background Color</label>
                        <input data-hex="true" class="colorpicker" id="adelante_footer_bgcolor" name="adelante_footer_bgcolor" type="text" value="<?php echo get_option('adelante_footer_bgcolor'); ?>" />
                        <span class="note">Specify a background color for the footer</span>
                    </li>
                    <li>
                        <label class="settings-label">Footer Font Color</label>
                        <input data-hex="true" class="colorpicker" id="adelante_footer_color" name="adelante_footer_color" type="text" value="<?php echo get_option('adelante_footer_color'); ?>" />
                        <span class="note">Specify the font color for the footer text</span>
                    </li> 
                    <li>
                        <label class="settings-label">Footer Text</label>
                        <textarea name="adelante_footer_text" type="text"><?php echo get_option('adelante_footer_text'); ?></textarea>
                    </li>                                       
                    <li>
                        <label class="settings-label">Footer vCard</label>
                        <input id="adelante_footer_vcard" name="adelante_footer_vcard" type="checkbox" <?php echo get_option('adelante_footer_vcard') === 'checked' ?  'checked' : ''; ?> value="checked" /> <label for="adelante_footer_vcard">Enable vCard in the footer</label>
                    </li>                                            
                    <li class="clearfix">
                        <label class="settings-label">vCard Information</label>
                        <div class="address">
                            <label for="adelante_vcard_street-address">Street Address</label> <input id="adelante_vcard_street-address" name="adelante_vcard_street-address" type="text" value="<?php echo get_option('adelante_vcard_street-address'); ?>" class="text" />
                            <label for="adelante_vcard_locality">City</label> <input id="adelante_vcard_locality" name="adelante_vcard_locality" type="text" value="<?php echo get_option('adelante_vcard_locality'); ?>" class="text" />
                            <label for="adelante_vcard_region">State</label> <input id="adelante_vcard_region" name="adelante_vcard_region" type="text" value="<?php echo get_option('adelante_vcard_region'); ?>" class="text" />
                            <label for="adelante_vcard_postal-code">Zipcode</label> <input id="adelante_vcard_postal-code" name="adelante_vcard_postal-code" type="text" value="<?php echo get_option('adelante_vcard_postal-code'); ?>" class="text" />
                            <label for="adelante_vcard_tel">Telephone Number</label> <input id="adelante_vcard_tel" name="adelante_vcard_tel" type="text" value="<?php echo get_option('adelante_vcard_tel'); ?>" class="text" />
                            <label for="adelante_vcard_email">Email Address</label> <input id="adelante_vcard_email" name="adelante_vcard_email" type="text" value="<?php echo get_option('adelante_vcard_email'); ?>" class="text" />
                        </div>
                    </li>                                                  
                </ul>            
            </div>
		</div>		
		
		<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes" />
		</p>

	</form>
</div>
<?php } ?>
