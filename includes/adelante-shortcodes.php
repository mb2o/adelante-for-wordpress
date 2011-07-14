<?php

/*
    Copyright 2010 VisualShortcodes.com  (email : info@visualshortcodes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
class adelante_shortcodes
{	
	function adelante_shortcodes() 
    {		
		add_action( 'admin_init', array( &$this, 'action_admin_init' ) );
		add_action( 'wp_ajax_scn_check_url_action', array( &$this, 'ajax_action_check_url' ) );
	}
	
	function action_admin_init() 
    {		    
		if ( current_user_can( 'edit_posts' ) 
		  && current_user_can( 'edit_pages' ) 
		  && get_user_option('rich_editing') == 'true' )  {
		  	
			add_filter( 'mce_buttons',          array( &$this, 'filter_mce_buttons'          ) );
			add_filter( 'mce_external_plugins', array( &$this, 'filter_mce_external_plugins' ) );
			
            // Set PHP variables for use in Javascript
            add_action('wp_footer', array(&$this, 'set_javascript_globals'));
            add_action('admin_print_scripts', array(&$this, 'set_javascript_globals'));

			wp_register_style('scnStyles', $this->plugin_url() . 'css/styles.css');
			wp_enqueue_style('scnStyles');
		}
	}
	
	function filter_mce_buttons( $buttons ) 
    {		
		array_push( $buttons, '|', 'scn_button');
        
		return $buttons;
	}
	
	function filter_mce_external_plugins( $plugins ) 
    {		
        $plugins['ShortcodeNinjaPlugin'] = $this->plugin_url() . 'tinymce/editor_plugin.js';
        
        return $plugins;
	}

    /**
     * Returns the full URL of this plugin including trailing slash.
     */
    function includes_url() 
    {        
        return ADELANTE_INCLUDES_URI. '/';
    }
    	
	/**
	 * Returns the full URL of this plugin including trailing slash.
	 */
	function plugin_url() 
    {		
		return ADELANTE_PLUGINS_URI. '/shortcode-ninja/';
	}
		
	/**
	 * Checks if a given url (via GET or POST) exists.
	 * Returns JSON
	 * 
	 * NOTE: for users that are not logged in this is not called.
	 *       The client recieves <code>-1</code> in that case.
	 */
	function ajax_action_check_url() 
    {
		$hadError = true;

		$url = isset( $_REQUEST['url'] ) ? $_REQUEST['url'] : '';

		if ( strlen( $url ) > 0  && function_exists( 'get_headers' ) ) {
				
			$file_headers = @get_headers( $url );
			$exists       = $file_headers && $file_headers[0] != 'HTTP/1.1 404 Not Found';
			$hadError     = false;
		}

		echo '{ "exists": '. ($exists ? '1' : '0') . ($hadError ? ', "error" : 1 ' : '') . ' }';

		die();
	}
        
    function set_javascript_globals()
    {
        $iconbox_files = adelante_load_files( ADELANTE_BASE. "/img/icons/iconbox", array( 'png' ) );
        $iconbox_filestring = "";
        foreach ( $iconbox_files as $iconbox_file ) { 
            $iconbox_filestring .= ',"'. $iconbox_file. '"'; 
        }
        $iconbox_filestring = substr( $iconbox_filestring, 1 );
        
        $icon_files = adelante_load_files( ADELANTE_BASE. "/img/icons", array( 'png' ), false );
        $icons_filestring = '"""';
        foreach ( $icon_files as $icon_file ) { 
            $icons_filestring .= ',"'. $icon_file. '"'; 
        }
        $icons_filestring = substr( $icons_filestring, 1 );                
    ?>
        <script>
             /* <![CDATA[ */
                var adelante_globals = {
                    plugin_path: '<?php echo $this->plugin_url(); ?>',
                    includes_path: '<?php echo $this->includes_url(); ?>',
                    iconbox_icons: ['none',<?php echo $iconbox_filestring; ?>],
                    icons: [<?php echo $icons_filestring; ?>] 
                }
             /* ]]> */                                        
        </script>
    <?php
    }    
}
new adelante_shortcodes();