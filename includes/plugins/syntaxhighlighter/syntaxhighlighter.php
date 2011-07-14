<?php /*

**************************************************************************

Plugin Name:  SyntaxHighlighter Evolved
Plugin URI:   http://www.viper007bond.com/wordpress-plugins/syntaxhighlighter/
Version:      3.1.1
Description:  Easily post syntax-highlighted code to your site without having to modify the code at all. Uses Alex Gorbatchev's <a href="http://alexgorbatchev.com/wiki/SyntaxHighlighter">SyntaxHighlighter</a>. <strong>TIP:</strong> Don't use the Visual editor if you don't want your code mangled. TinyMCE will "clean up" your HTML.
Author:       Viper007Bond
Author URI:   http://www.viper007bond.com/

**************************************************************************

Thanks to:

* Alex Gorbatchev for writing the Javascript-powered synatax highlighter script

* Andrew Ozz for writing the TinyMCE plugin

**************************************************************************/

class SyntaxHighlighter 
{
	// All of these variables are private. Filters are provided for things that can be modified.
	var $pluginver            = '3.1.1';  // Plugin version
	var $agshver              = false;    // Alex Gorbatchev's SyntaxHighlighter version (dynamically set below due to v2 vs v3)
	var $shfolder             = false;    // Controls what subfolder to load SyntaxHighlighter from (v2 or v3)
	var $settings             = array();  // Contains the user's settings
	var $defaultsettings      = array();  // Contains the default settings
	var $brushes              = array();  // Array of aliases => brushes
	var $shortcodes           = array();  // Array of shortcodes to use
	var $themes               = array();  // Array of themes
	var $usedbrushes          = array();  // Stores used brushes so we know what to output
	var $encoded              = false;    // Used to mark that a character encode took place
	var $codeformat           = false;    // If set, SyntaxHighlighter::get_code_format() will return this value
	var $content_save_pre_ran = false;    // It's possible for the "content_save_pre" filter to run multiple times, so keep track

	// Initalize the plugin by registering the hooks
	function __construct() 
    {
		if ( ! function_exists( 'esc_html' ) )
			return;

		// Load localization domain
		load_plugin_textdomain( 'syntaxhighlighter', false, '/syntaxhighlighter/localization' );

		// Display hooks
		add_filter( 'the_content',                        array(&$this, 'parse_shortcodes'),                              7 ); // Posts
		add_filter( 'comment_text',                       array(&$this, 'parse_shortcodes_comment'),                      7 ); // Comments
		add_filter( 'bp_get_the_topic_post_content',      array(&$this, 'parse_shortcodes'),                              7 ); // BuddyPress

		// Into the database
		add_filter( 'content_save_pre',                   array(&$this, 'encode_shortcode_contents_slashed_noquickedit'), 1 ); // Posts
		add_filter( 'pre_comment_content',                array(&$this, 'encode_shortcode_contents_slashed'),             1 ); // Comments
		add_filter( 'group_forum_post_text_before_save',  array(&$this, 'encode_shortcode_contents_slashed'),             1 ); // BuddyPress
		add_filter( 'group_forum_topic_text_before_save', array(&$this, 'encode_shortcode_contents_slashed'),             1 ); // BuddyPress

		// Out of the database for editing
		add_filter( 'the_editor_content',                 array(&$this, 'the_editor_content'),                            1 ); // Posts
		add_filter( 'comment_edit_pre',                   array(&$this, 'decode_shortcode_contents'),                     1 ); // Comments
		add_filter( 'bp_get_the_topic_text',              array(&$this, 'decode_shortcode_contents'),                     1 ); // BuddyPress
		add_filter( 'bp_get_the_topic_post_edit_text',    array(&$this, 'decode_shortcode_contents'),                     1 ); // BuddyPress

		// Outputting SyntaxHighlighter's JS and CSS
		add_action( 'wp_head',                            array(&$this, 'output_header_placeholder'),                     15 );
		add_action( 'admin_head',                         array(&$this, 'output_header_placeholder'),                     15 ); // For comments
		add_action( 'wp_footer',                          array(&$this, 'maybe_output_scripts'),                          15 );
		add_action( 'admin_footer',                       array(&$this, 'maybe_output_scripts'),                          15 ); // For comments

		// Admin hooks
		add_action( 'admin_init',                         array(&$this, 'register_setting') );
		add_action( 'admin_menu',                         array(&$this, 'register_settings_page') );
		add_action( 'admin_head',                         array(&$this, 'output_shortcodes_for_tinymce') );
		add_filter( 'mce_external_plugins',               array(&$this, 'add_tinymce_plugin') );
		add_filter( 'tiny_mce_version',                   array(&$this, 'break_tinymce_cache') );
		add_filter( 'save_post',                          array(&$this, 'mark_as_encoded'),                               10, 2 );
		//add_filter( 'plugin_action_links',                array(&$this, 'settings_link'),                                 10, 2 );

		// Register widget hooks
		// Requires change added in WordPress 2.9
		if ( class_exists('WP_Embed') ) {
			add_filter( 'widget_text',                    array(&$this, 'widget_text_output'),                            7, 2 );
			add_filter( 'widget_update_callback',         array(&$this, 'widget_text_save'),                              1, 4 );
			add_filter( 'widget_form_callback',           array(&$this, 'widget_text_form'),                              1, 2 );
		}


		// Create array of default settings (you can use the filter to modify these)
		$this->defaultsettings = (array) apply_filters( 'syntaxhighlighter_defaultsettings', array(
			'theme'          => get_option('adelante_syntaxhl_theme'),
			'loadallbrushes' => 0,
			'shversion'      => 3,
			'title'          => '',
			'autolinks'      => 1,
			'classname'      => '',
			'collapse'       => 0,
			'firstline'      => 1,
			'gutter'         => 1,
			'htmlscript'     => 0,
			'light'          => 0,
			'padlinenumbers' => 'false',
			'smarttabs'      => 1,
			'tabsize'        => 4,
			'toolbar'        => 0,
			'wraplines'      => 1, // 2.x only
		) );

		// Create the settings array by merging the user's settings and the defaults
		$usersettings = (array) get_option('syntaxhighlighter_settings');
		$this->settings = wp_parse_args( $usersettings, $this->defaultsettings );

		// Dynamically set folder and version names for SynaxHighlighter
		$this->shfolder = ( 2 == $this->settings['shversion'] ) ? 'syntaxhighlighter2' : 'syntaxhighlighter3';
		$this->agshver  = ( 2 == $this->settings['shversion'] ) ? '2.1.364' : '3.0.83b';

		// Register brush scripts
		wp_register_script( 'syntaxhighlighter-core',             ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shCore.js',            array(),                         $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-as3',        ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushAS3.js',        array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-bash',       ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushBash.js',       array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-coldfusion', ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushColdFusion.js', array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-cpp',        ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushCpp.js',        array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-csharp',     ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushCSharp.js',     array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-css',        ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushCss.js',        array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-delphi',     ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushDelphi.js',     array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-diff',       ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushDiff.js',       array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-erlang',     ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushErlang.js',     array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-groovy',     ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushGroovy.js',     array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-java',       ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushJava.js',       array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-javafx',     ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushJavaFX.js',     array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-jscript',    ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushJScript.js',    array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-perl',       ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushPerl.js',       array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-php',        ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushPhp.js',        array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-plain',      ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushPlain.js',      array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-powershell', ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushPowerShell.js', array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-python',     ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushPython.js',     array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-ruby',       ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushRuby.js',       array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-scala',      ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushScala.js',      array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-sql',        ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushSql.js',        array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-vb',         ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushVb.js',         array('syntaxhighlighter-core'), $this->agshver );
		wp_register_script( 'syntaxhighlighter-brush-xml',        ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/scripts/shBrushXml.js',        array('syntaxhighlighter-core'), $this->agshver );

		// Register some popular third-party brushes
		wp_register_script( 'syntaxhighlighter-brush-clojure',    ADELANTE_PLUGINS_URI. 'syntaxhighlighter/third-party-brushes/shBrushClojure.js',          array('syntaxhighlighter-core'), '20090602'     );
		wp_register_script( 'syntaxhighlighter-brush-fsharp',     ADELANTE_PLUGINS_URI. 'syntaxhighlighter/third-party-brushes/shBrushFSharp.js',           array('syntaxhighlighter-core'), '20091003'     );
		wp_register_script( 'syntaxhighlighter-brush-latex',      ADELANTE_PLUGINS_URI. 'syntaxhighlighter/third-party-brushes/shBrushLatex.js',            array('syntaxhighlighter-core'), '20090613'     );
		wp_register_script( 'syntaxhighlighter-brush-matlabkey',  ADELANTE_PLUGINS_URI. 'syntaxhighlighter/third-party-brushes/shBrushMatlabKey.js',        array('syntaxhighlighter-core'), '20091209'     );
		wp_register_script( 'syntaxhighlighter-brush-objc',       ADELANTE_PLUGINS_URI. 'syntaxhighlighter/third-party-brushes/shBrushObjC.js',             array('syntaxhighlighter-core'), '20091207'     );
		wp_register_script( 'syntaxhighlighter-brush-r',          ADELANTE_PLUGINS_URI. 'syntaxhighlighter/third-party-brushes/shBrushR.js',                array('syntaxhighlighter-core'), '20100919'     );

		// Register theme stylesheets
		wp_register_style(  'syntaxhighlighter-core',             ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/styles/shCore.css',            array(),                         $this->agshver );
		wp_register_style(  'syntaxhighlighter-theme-default',    ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/styles/shThemeDefault.css',    array('syntaxhighlighter-core'), $this->agshver );
		wp_register_style(  'syntaxhighlighter-theme-django',     ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/styles/shThemeDjango.css',     array('syntaxhighlighter-core'), $this->agshver );
		wp_register_style(  'syntaxhighlighter-theme-eclipse',    ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/styles/shThemeEclipse.css',    array('syntaxhighlighter-core'), $this->agshver );
		wp_register_style(  'syntaxhighlighter-theme-emacs',      ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/styles/shThemeEmacs.css',      array('syntaxhighlighter-core'), $this->agshver );
		wp_register_style(  'syntaxhighlighter-theme-fadetogrey', ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/styles/shThemeFadeToGrey.css', array('syntaxhighlighter-core'), $this->agshver );
		wp_register_style(  'syntaxhighlighter-theme-midnight',   ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/styles/shThemeMidnight.css',   array('syntaxhighlighter-core'), $this->agshver );
		wp_register_style(  'syntaxhighlighter-theme-rdark',      ADELANTE_PLUGINS_URI. 'syntaxhighlighter/' . $this->shfolder . '/styles/shThemeRDark.css',      array('syntaxhighlighter-core'), $this->agshver );


		// Create list of brush aliases and map them to their real brushes
		// The key is the language alias
		// The value is the script handle suffix: syntaxhighlighter-brush-ThisBitHere  (your plugin needs to register the script itself)
		$this->brushes = (array) apply_filters( 'syntaxhighlighter_brushes', array(
			'as3'           => 'as3',
			'actionscript3' => 'as3',
			'bash'          => 'bash',
			'shell'         => 'bash',
			'coldfusion'    => 'coldfusion',
			'cf'            => 'coldfusion',
			'clojure'       => 'clojure',
			'clj'           => 'clojure',
			'cpp'           => 'cpp',
			'c'             => 'cpp',
			'c-sharp'       => 'csharp',
			'csharp'        => 'csharp',
			'css'           => 'css',
			'delphi'        => 'delphi',
			'pas'           => 'delphi',
			'pascal'        => 'delphi',
			'diff'          => 'diff',
			'patch'         => 'diff',
			'erl'           => 'erlang',
			'erlang'        => 'erlang',
			'fsharp'        => 'fsharp',
			'groovy'        => 'groovy',
			'java'          => 'java',
			'jfx'           => 'javafx',
			'javafx'        => 'javafx',
			'js'            => 'jscript',
			'jscript'       => 'jscript',
			'javascript'    => 'jscript',
			'latex'         => 'latex', // Not used as a shortcode
			'tex'           => 'latex',
			'matlab'        => 'matlabkey',
			'objc'          => 'objc',
			'obj-c'         => 'objc',
			'perl'          => 'perl',
			'pl'            => 'perl',
			'php'           => 'php',
			'plain'         => 'plain',
			'text'          => 'plain',
			'ps'            => 'powershell',
			'powershell'    => 'powershell',
			'py'            => 'python',
			'python'        => 'python',
			'r'             => 'r', // Not used as a shortcode
			'splus'         => 'r',
			'rails'         => 'ruby',
			'rb'            => 'ruby',
			'ror'           => 'ruby',
			'ruby'          => 'ruby',
			'scala'         => 'scala',
			'sql'           => 'sql',
			'vb'            => 'vb',
			'vbnet'         => 'vb',
			'xml'           => 'xml',
			'xhtml'         => 'xml',
			'xslt'          => 'xml',
			'html'          => 'xml',
			'xhtml'         => 'xml',
		) );


		// Create a list of shortcodes to use. You can use the filter to add/remove ones.
		// If the language/lang parameter is left out, it's assumed the shortcode name is the language.
		// If that's invalid, then "plain" is used.
		$this->shortcodes = array( 'sourcecode', 'source', 'code' );
		$this->shortcodes = array_merge( $this->shortcodes, array_keys( $this->brushes ) );

		// Remove some shortcodes we don't want while still supporting them as language values
		unset( $this->shortcodes[array_search( 'latex', $this->shortcodes )] ); // Remove "latex" shortcode (it'll collide)
		unset( $this->shortcodes[array_search( 'r', $this->shortcodes )] ); // Remove "r" shortcode (too short)

		$this->shortcodes = (array) apply_filters( 'syntaxhighlighter_shortcodes', $this->shortcodes );


		// Create list of themes and their human readable names
		// Plugins can add to this list: http://www.viper007bond.com/wordpress-plugins/syntaxhighlighter/adding-a-new-theme/
		$this->themes = (array) apply_filters( 'syntaxhighlighter_themes', array(
			'default'    => __( 'Default',      'syntaxhighlighter' ),
			'django'     => __( 'Django',       'syntaxhighlighter' ),
			'eclipse'    => __( 'Eclipse',      'syntaxhighlighter' ),
			'emacs'      => __( 'Emacs',        'syntaxhighlighter' ),
			'fadetogrey' => __( 'Fade to Grey', 'syntaxhighlighter' ),
			'midnight'   => __( 'Midnight',     'syntaxhighlighter' ),
			'rdark'      => __( 'RDark',        'syntaxhighlighter' ),
			'none'       => __( '[None]',       'syntaxhighlighter' ),
		) );

		// Other special characters that need to be encoded before going into the database (namely to work around kses)
		$this->specialchars = (array) apply_filters( 'syntaxhighlighter_specialchars', array(
			'\0' => '&#92;&#48;',
		) );
	}


	// Register the settings page
	function register_settings_page() 
    {
		add_options_page( __( 'SyntaxHighlighter Settings', 'syntaxhighlighter' ), __( 'SyntaxHighlighter', 'syntaxhighlighter' ), 'manage_options', 'syntaxhighlighter', array(&$this, 'settings_page') );
	}


	// Register the plugin's setting
	function register_setting() 
    {
		register_setting( 'syntaxhighlighter_settings', 'syntaxhighlighter_settings', array(&$this, 'validate_settings') );
	}


	// Add the custom TinyMCE plugin which wraps plugin shortcodes in <pre> in TinyMCE
	function add_tinymce_plugin( $plugins ) 
    {
		$plugins['syntaxhighlighter'] = ADELANTE_PLUGINS_URI. 'syntaxhighlighter/syntaxhighlighter_mce.js';
		return $plugins;
	}


	// Break the TinyMCE cache
	function break_tinymce_cache( $version ) {
		return $version . '-sh' . $this->pluginver;
	}

	// Output list of shortcode tags for the TinyMCE plugin
	function output_shortcodes_for_tinymce() 
    {
		$shortcodes = array();

		foreach ( $this->shortcodes as $shortcode )
			$shortcodes[] = preg_quote( $shortcode );

		echo "<script type='text/javascript'>\n";
		echo "	var syntaxHLcodes = '" . implode( '|', $shortcodes ) . "';\n";
		echo "</script>\n";
	}


	// Additional CSS for the front end (to ensure themes don't screw too much with the code)
	function enforce_font_size() 
    {
		echo '	<style type="text/css">.syntaxhighlighter { font-size: 12px !important; }</style>' . "\n";
	}


	// A filter function that runs do_shortcode() but only with this plugin's shortcodes
	function shortcode_hack( $content, $callback ) 
    {
		global $shortcode_tags;

		// Backup current registered shortcodes and clear them all out
		$orig_shortcode_tags = $shortcode_tags;
		remove_all_shortcodes();

		// Register all of this plugin's shortcodes
		foreach ( $this->shortcodes as $shortcode )
			add_shortcode( $shortcode, $callback );

		// Do the shortcodes (only this plugins's are registered)
		$content = do_shortcode( $content );

		// Put the original shortcodes back
		$shortcode_tags = $orig_shortcode_tags;

		return $content;
	}


	// The main filter for the post contents. The regular shortcode filter can't be used as it's post-wpautop().
	function parse_shortcodes( $content ) 
    {
		return $this->shortcode_hack( $content, array(&$this, 'shortcode_callback') );
	}


	// HTML entity encode the contents of shortcodes
	function encode_shortcode_contents( $content ) 
    {
		return $this->shortcode_hack( $content, array(&$this, 'encode_shortcode_contents_callback') );
	}


	// HTML entity encode the contents of shortcodes. Expects slashed content.
	function encode_shortcode_contents_slashed( $content ) 
    {
		return addslashes( $this->encode_shortcode_contents( stripslashes( $content ) ) );
	}


	// HTML entity encode the contents of shortcodes. Expects slashed content. Aborts if AJAX.
	function encode_shortcode_contents_slashed_noquickedit( $content ) 
    {
		// In certain weird circumstances, the content gets run through "content_save_pre" twice
		// Keep track and don't allow this filter to be run twice
		// I couldn't easily figure out why this happens and didn't bother looking into it further as this works fine
		if ( true == $this->content_save_pre_ran )
			return $content;
		$this->content_save_pre_ran = true;

		// Post quick edits aren't decoded for display, so we don't need to encode them (again)
		if ( !empty($_POST) && !empty($_POST['action']) && 'inline-save' == $_POST['action'] )
			return $content;

		return $this->encode_shortcode_contents_slashed( $content );
	}


	// HTML entity decode the contents of shortcodes
	function decode_shortcode_contents( $content ) 
    {
		return $this->shortcode_hack( $content, array(&$this, 'decode_shortcode_contents_callback') );
	}


	// The callback function for SyntaxHighlighter::encode_shortcode_contents()
	function encode_shortcode_contents_callback( $atts, $code = '', $tag = false ) 
    {
		$this->encoded = true;
		$code = str_replace( array_keys($this->specialchars), array_values($this->specialchars), htmlspecialchars( $code ) );
		return '[' . $tag . $this->atts2string( $atts ) . "]{$code}[/$tag]";
	}


	// The callback function for SyntaxHighlighter::decode_shortcode_contents()
	// Shortcode attribute values need to not be quoted with TinyMCE disabled for some reason (weird bug)
	function decode_shortcode_contents_callback( $atts, $code = '', $tag = false ) 
    {
		$quotes = ( user_can_richedit() ) ? true : false;
		$code = str_replace(  array_values($this->specialchars), array_keys($this->specialchars), htmlspecialchars_decode( $code ) );
		return '[' . $tag . $this->atts2string( $atts, $quotes ) . "]{$code}[/$tag]";
	}


	// Dynamically format the post content for the edit form
	function the_editor_content( $content ) 
    {
		global $post;

		// New code format (stored encoded in database)
		if ( 2 == $this->get_code_format( $post ) ) {
			// If TinyMCE is disabled or the HTML tab is set to be displayed first, we need to decode the HTML
			if ( !user_can_richedit() || 'html' == wp_default_editor() )
				$content = $this->decode_shortcode_contents( $content );
		}

		// Old code format (stored raw in database)
		else {
			// If TinyMCE is enabled and is set to be displayed first, we need to encode the HTML
			if ( user_can_richedit() && 'html' != wp_default_editor() )
				$content = $this->encode_shortcode_contents( $content );
		}

		return $content;
	}


	// Run SyntaxHighlighter::encode_shortcode_contents() on the contents of the text widget
	function widget_text_save( $instance, $new_instance, $old_instance, $widgetclass ) 
    {
		if ( 'text' == $widgetclass->id_base ) {
			// Re-save the widget settings but this time with the shortcode contents encoded
			$new_instance['text'] = $this->encode_shortcode_contents( $new_instance['text'] );
			$instance = $widgetclass->update( $new_instance, $old_instance );

			// And flag it as encoded
			$instance['syntaxhighlighter_encoded'] = true;
		}

		return $instance;
	}


	// Run SyntaxHighlighter::decode_shortcode_contents_callback() on the contents of the text widget form
	function widget_text_form( $instance, $widgetclass ) 
    {
		if ( 'text' == $widgetclass->id_base && !empty($instance['syntaxhighlighter_encoded']) ) {
			$instance['text'] = $this->shortcode_hack( $instance['text'], array(&$this, 'decode_shortcode_contents_callback') );
		}

		return $instance;
	}


	// Run SyntaxHighlighter::parse_shortcodes() on the contents of a text widget
	function widget_text_output( $content, $instance = false ) 
    {
		$this->codeformat = ( false === $instance || empty($instance['syntaxhighlighter_encoded']) ) ? 1 : 2;
		$content = $this->parse_shortcodes( $content );
		$this->codeformat = false;

		return $content;
	}


	// Run SyntaxHighlighter::parse_shortcodes() on the contents of a comment
	function parse_shortcodes_comment( $content ) 
    {
		$this->codeformat = 2;
		$content = $this->parse_shortcodes( $content );
		$this->codeformat = false;

		return $content;
	}


	// This function determines what version of SyntaxHighlighter was used when the post was written
	// This is because the code was stored differently for different versions of SyntaxHighlighter
	function get_code_format( $post )
    {
		if ( false !== $this->codeformat )
			return $this->codeformat;

		if ( empty($post) )
			$post = new stdClass();

		if ( null !== $version = apply_filters( 'syntaxhighlighter_pre_getcodeformat', null, $post ) )
			return $version;

		$version = ( empty($post->ID) || get_post_meta( $post->ID, '_syntaxhighlighter_encoded', true ) || get_post_meta( $post->ID, 'syntaxhighlighter_encoded', true ) ) ? 2 : 1;

		return apply_filters( 'syntaxhighlighter_getcodeformat', $version, $post );
	}


	// Adds a post meta saying that HTML entities are encoded (for backwards compatibility)
	function mark_as_encoded( $post_ID, $post ) 
    {
		if ( false == $this->encoded || 'revision' == $post->post_type )
			return;

		delete_post_meta( $post_ID, 'syntaxhighlighter_encoded' ); // Previously used
		add_post_meta( $post_ID, '_syntaxhighlighter_encoded', true, true );
	}


	// Transforms an attributes array into a 'key="value"' format (i.e. reverses the process)
	function atts2string( $atts, $quotes = true ) 
    {
		if ( empty($atts) )
			return '';

		$atts = $this->attributefix( $atts );

		// Re-map [code="php"] style tags
		if ( isset($atts[0]) ) {
			if ( empty($atts['language']) )
				$atts['language'] = $atts[0];

			unset($atts[0]);
		}

		$strings = array();
		foreach ( $atts as $key => $value )
			$strings[] = ( $quotes ) ? $key . '="' . esc_attr( $value ) . '"' : $key . '=' . esc_attr( $value );

		return ' ' . implode( ' ', $strings );
	}


	// Simple function for escaping just single quotes (the original js_escape() escapes more than we need)
	function js_escape_singlequotes( $string ) 
    {
		return str_replace( "'", "\'", $string );
	}


	// Output an anchor in the header for the Javascript to use
	// Might as well use it to output the version to help me debug people's sites
	function output_header_placeholder() 
    {
		echo '<meta id="syntaxhighlighteranchor" name="syntaxhighlighter-version" content="' . esc_attr( $this->pluginver ) . '" />' . "\n";
	}


	// Output any needed scripts. This is meant for the footer.
	function maybe_output_scripts() 
    {
		global $wp_styles;

		if ( 1 == $this->settings['loadallbrushes'] )
			$this->usedbrushes = array_flip( array_values( $this->brushes ) );

		if ( empty($this->usedbrushes) )
			return;

		$scripts = array();
		foreach ( $this->usedbrushes as $brush => $unused )
			$scripts[] = 'syntaxhighlighter-brush-' . strtolower( $brush );

		wp_print_scripts( $scripts );

		// Stylesheets can't be in the footer, so inject them via Javascript
		echo "<script type='text/javascript'>\n";
		echo "	(function(){\n";
		echo "		var corecss = document.createElement('link');\n";
		echo "		var themecss = document.createElement('link');\n";

		if ( !is_a($wp_styles, 'WP_Styles') )
			$wp_styles = new WP_Styles();

		$needcore = false;
		if ( 'none' == $this->settings['theme'] ) {
			$needcore = true;
		} else {
			$theme = ( !empty($this->themes[$this->settings['theme']]) ) ? strtolower($this->settings['theme']) : $this->defaultsettings['theme'];
			$theme = 'syntaxhighlighter-theme-' . $theme;

			// See if the requested theme has been registered
			if ( !empty($wp_styles) && !empty($wp_styles->registered) && !empty($wp_styles->registered[$theme]) && !empty($wp_styles->registered[$theme]->src) ) {

				// Users can register their own stylesheet and may opt to not load the core stylesheet if they wish for some reason
				if ( is_array($wp_styles->registered[$theme]->deps) && in_array( 'syntaxhighlighter-core', $wp_styles->registered[$theme]->deps ) )
					$needcore = true;
			}

			// Otherwise use the default theme
			else {
				$theme = 'syntaxhighlighter-theme-' . $this->defaultsettings['theme'];
				$needcore = true;
			}
		}

		if ( $needcore && !empty($wp_styles) && !empty($wp_styles->registered) && !empty($wp_styles->registered['syntaxhighlighter-core']) && !empty($wp_styles->registered['syntaxhighlighter-core']->src) ) :
			$corecssurl = add_query_arg( 'ver', $this->agshver, $wp_styles->registered['syntaxhighlighter-core']->src );
			$corecssurl = apply_filters( 'syntaxhighlighter_csscoreurl', $corecssurl );
?>
		var corecssurl = "<?php echo esc_js( $corecssurl ); ?>";
		if ( corecss.setAttribute ) {
				corecss.setAttribute( "rel", "stylesheet" );
				corecss.setAttribute( "type", "text/css" );
				corecss.setAttribute( "href", corecssurl );
		} else {
				corecss.rel = "stylesheet";
				corecss.href = corecssurl;
		}
		document.getElementsByTagName("head")[0].insertBefore( corecss, document.getElementById("syntaxhighlighteranchor") );
<?php
		endif; // Endif $needcore

		if ( 'none' != $this->settings['theme'] ) : ?>
		var themecssurl = "<?php echo esc_js( apply_filters( 'syntaxhighlighter_cssthemeurl', add_query_arg( 'ver', $this->agshver, $wp_styles->registered[$theme]->src ) ) ); ?>";
		if ( themecss.setAttribute ) {
				themecss.setAttribute( "rel", "stylesheet" );
				themecss.setAttribute( "type", "text/css" );
				themecss.setAttribute( "href", themecssurl );
		} else {
				themecss.rel = "stylesheet";
				themecss.href = themecssurl;
		}
		//document.getElementById("syntaxhighlighteranchor").appendChild(themecss);
		document.getElementsByTagName("head")[0].insertBefore( themecss, document.getElementById("syntaxhighlighteranchor") );
<?php
		endif; // Endif none != theme

		echo "	})();\n";

		switch ( $this->settings['shversion'] ) {
			case 2:
				echo "	SyntaxHighlighter.config.clipboardSwf = '" . esc_js( apply_filters( 'syntaxhighlighter_clipboardurl', ADELANTE_PLUGINS_URI. 'syntaxhighlighter/syntaxhighlighter2/scripts/clipboard.swf') ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.expandSource = '" . $this->js_escape_singlequotes( __( 'show source', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.viewSource = '" . $this->js_escape_singlequotes( __( 'view source', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.copyToClipboard = '" . $this->js_escape_singlequotes( __( 'copy to clipboard', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.copyToClipboardConfirmation = '" . $this->js_escape_singlequotes( __( 'The code is in your clipboard now', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.print = '" . $this->js_escape_singlequotes( __( 'print', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.help = '" . $this->js_escape_singlequotes( __( '?', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.alert = '" . $this->js_escape_singlequotes( __( 'SyntaxHighlighter\n\n', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.noBrush = '" . $this->js_escape_singlequotes( __( "Can't find brush for: ", 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.brushNotHtmlScript = '" . $this->js_escape_singlequotes( __( "Brush wasn't configured for html-script option: ", 'syntaxhighlighter' ) ) . "';\n";
				break;
			case 3:
				echo "	SyntaxHighlighter.config.strings.expandSource = '" . $this->js_escape_singlequotes( __( '+ expand source', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.help = '" . $this->js_escape_singlequotes( __( '?', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.alert = '" . $this->js_escape_singlequotes( __( 'SyntaxHighlighter\n\n', 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.noBrush = '" . $this->js_escape_singlequotes( __( "Can't find brush for: ", 'syntaxhighlighter' ) ) . "';\n";
				echo "	SyntaxHighlighter.config.strings.brushNotHtmlScript = '" . $this->js_escape_singlequotes( __( "Brush wasn't configured for html-script option: ", 'syntaxhighlighter' ) ) . "';\n";
				break;
		}

		if ( 1 != $this->settings['autolinks'] )
			echo "	SyntaxHighlighter.defaults['auto-links'] = false;\n";

		if ( !empty($this->settings['classname']) )
			echo "	SyntaxHighlighter.defaults['class-name'] = '" . $this->js_escape_singlequotes( $this->settings['classname'] ) . "';\n";

		if ( 1 == $this->settings['collapse'] )
			echo "	SyntaxHighlighter.defaults['collapse'] = true;\n";

		if ( 1 != $this->settings['firstline'] )
			echo "	SyntaxHighlighter.defaults['first-line'] = " . $this->settings['firstline'] . ";\n";

		if ( 1 != $this->settings['gutter'] )
			echo "	SyntaxHighlighter.defaults['gutter'] = false;\n";

		/*
		if ( 1 == $this->settings['htmlscript'] )
			echo "	SyntaxHighlighter.defaults['html-script'] = true;\n";
		*/

		if ( 1 == $this->settings['light'] )
			echo "	SyntaxHighlighter.defaults['light'] = true;\n";

		echo "	SyntaxHighlighter.defaults['pad-line-numbers'] = ";
		switch ( $this->settings['padlinenumbers'] ) {
			case 'true':
				echo 'true';
				break;
			case 'false';
				echo 'false';
				break;
			default;
				echo (int) $this->settings['padlinenumbers'];
		}
		echo ";\n";

		if ( 1 != $this->settings['smarttabs'] )
			echo "	SyntaxHighlighter.defaults['smart-tabs'] = false;\n";

		if ( 4 != $this->settings['tabsize'] )
			echo "	SyntaxHighlighter.defaults['tab-size'] = " . $this->settings['tabsize'] . ";\n";

		if ( 1 != $this->settings['toolbar'] )
			echo "	SyntaxHighlighter.defaults['toolbar'] = false;\n";

		// 2.x only for now
		if ( 1 != $this->settings['wraplines'] )
			echo "	SyntaxHighlighter.defaults['wrap-lines'] = false;\n";

?>	SyntaxHighlighter.all();
</script>
<?php
	}


	// No-name attribute fixing
	function attributefix( $atts = array() ) 
    {
		if ( empty($atts[0]) )
			return $atts;

		// Quoted value
		if ( 0 !== preg_match( '#=("|\')(.*?)\1#', $atts[0], $match ) )
			$atts[0] = $match[2];

		// Unquoted value
		elseif ( '=' == substr( $atts[0], 0, 1 ) )
			$atts[0] = substr( $atts[0], 1 );

		return $atts;
	}


	// Shortcode handler for transforming the shortcodes to their final <pre>'s
	function shortcode_callback( $atts, $code = '', $tag = false ) 
    {
		global $post;

		if ( false === $tag || empty($code) )
			return $code;

		// Avoid PHP notices
		if ( !isset($post) )
			$post = null;

		$code = apply_filters( 'syntaxhighlighter_precode', $code, $atts, $tag );

		// Error fixing for [tag="language"]
		if ( isset($atts[0]) ) {
			$atts = $this->attributefix( $atts );
			$atts['language'] = $atts[0];
			unset($atts[0]);
		}

		// Default out all of the available parameters to "false" (easy way to check if they're set or not)
		// Note this isn't the same as if the user passes the string "false" to the shortcode
		$atts = (array) apply_filters( 'syntaxhighlighter_shortcodeatts', shortcode_atts( array(
			'language'       => false,
			'lang'           => false,
			'type'           => false, // language alias
			'autolinks'      => false,
			'classname'      => false,
			'collapse'       => false,
			'firstline'      => false,
			'fontsize'       => false,
			'gutter'         => false,
			'highlight'      => false,
			'htmlscript'     => false,
			'light'          => false,
			'padlinenumbers' => false,
			'smarttabs'      => false,
			'tabsize'        => false,
			'title'          => $this->settings['title'],
			'toolbar'        => false,
			'wraplines'      => false,
		), $atts ) );

		// Check for language shortcode tag such as [php]code[/php]
		if ( isset($this->brushes[$tag]) ) {
			$lang = $tag;
		}

		// If a valid tag is not used, it must be sourcecode/source/code
		else {
			$atts = $this->attributefix( $atts );

			// Check for the "language" attribute
			if ( false !== $atts['language'] )
				$lang = $atts['language'];

			// Check for the "lang" attribute
			elseif ( false !== $atts['lang'] )
				$lang = $atts['lang'];

			// Default to plain text
			else
				$lang = 'text';

			// All language aliases are lowercase
			$lang = strtolower( $lang );

			// Validate passed attribute
			if ( !isset($this->brushes[$lang]) )
				return $code;
		}

		// Switch from the alias to the real brush name (so custom aliases can be used)
		$lang = $this->brushes[$lang];

		// Register this brush as used so it's script will be outputted
		$this->usedbrushes[$lang] = true;

		$params = array();
		$params[] = "brush: $lang;";

		// Fix bug that prevents collapse from working if the toolbar is off or light mode is on
		if ( 'true' == $atts['collapse'] || '1' === $atts['collapse'] || 1 == $this->settings['collapse'] ) {
			$atts['toolbar'] = 'true';
			$atts['light'] = 'false';
		}

		// Parameter renaming (the shortcode API doesn't like parameter names with dashes)
		$rename_map = array(
			'autolinks'      => 'auto-links',
			'classname'      => 'class-name',
			'firstline'      => 'first-line',
			'fontsize'       => 'font-size',
			'htmlscript'     => 'html-script',
			'padlinenumbers' => 'pad-line-numbers',
			'smarttabs'      => 'smart-tabs',
			'tabsize'        => 'tab-size',
			'wraplines'      => 'wrap-lines',
		);

		// Allowed configuration parameters and their type
		// Use the proper names (see above)
		$allowed_atts = (array) apply_filters( 'syntaxhighlighter_allowedatts', array(
			'auto-links'       => 'boolean',
			'class-name'       => 'other',
			'collapse'         => 'boolean',
			'first-line'       => 'integer',
			'font-size'        => 'integer',
			'gutter'           => 'boolean',
			'highlight'        => 'other',
			'html-script'      => 'boolean',
			'light'            => 'boolean',
			'pad-line-numbers' => 'other',
			'smart-tabs'       => 'boolean',
			'tab-size'         => 'integer',
			'title'            => 'other',
			'toolbar'          => 'boolean',
			'wrap-lines'       => 'boolean',
		) );

		$title = '';

		// Sanitize configuration parameters and such
		foreach ( $atts as $key => $value ) {
			$key = strtolower( $key );

			// Put back parameter names that have been renamed for shortcode use
			if ( !empty($rename_map[$key]) )
				$key = $rename_map[$key];

			// This this parameter if it's unknown, not set, or the language which was already handled
			if ( empty($allowed_atts[$key]) || false === $value || in_array( $key, array( 'language', 'lang' ) ) )
				continue;

			// Sanitize values
			switch ( $allowed_atts[$key] ) {
				case 'boolean':
					$value = strtolower( $value );
					if ( 'true' === $value || '1' === $value || 'on' == $value )
						$value = 'true';
					elseif ( 'false' === $value || '0' === $value || 'off' == $value )
						$value = 'false';
					else
						continue 2; // Invalid value, ditch parameter
					break;

				// integer
				case 'integer':
					$value = (int) $value;
					break;
			}

			// Sanitize the "classname" parameter
			if ( 'classname' == $key )
				$value = trim( preg_replace( '/[^a-zA-Z0-9 _-]/i', '', $value ) );

			// Special sanitization for "pad-line-numbers"
			if ( 'pad-line-numbers' == $key ) {
				$value = strtolower( $value );
				if ( 'true' === $value || '1' === $value )
					$value = 'true';
				elseif ( 'false' === $value || '0' === $value )
					$value = 'false';
				else
					$value = (int) $value;
			}

			// Add % sign to "font-size"
			if ( 'font-size' == $key )
				$value = $value . '%';

			// If "html-script", then include the XML brush as it's needed
			if ( 'html-script' == $key && 'true' == $value )
				$this->usedbrushes['xml'] = true;

			// Sanitize row highlights
			if ( 'highlight' == $key ) {
				if ( false === strpos( $value, ',' ) ) {
					$value = (int) $value;
				} else {
					$lines = explode( ',', $value );
					$highlights = array();

					foreach ( $lines as $line ) {
						// Line range
						if ( false !== strpos( $line, '-' ) ) {
							list( $range_start, $range_end ) = array_map( 'intval', explode( '-', $line ) );
							if ( ! $range_start || ! $range_end || $range_end <= $range_start )
								continue;

							for ( $i = $range_start; $i <= $range_end; $i++ )
								$highlights[] = $i;
						} else {
							$highlights[] = (int) $line;
						}
					}

					natsort( $highlights );

					$value = implode( ',', $highlights );
				}

				if ( empty( $value ) )
					continue;

				// Wrap highlight in [ ]
				$params[] = "$key: [$value];";
				continue;
			}

			$params[] = "$key: $value;";

			// Set the title variable if the title parameter is set (but not for feeds)
			if ( 'title' == $key && ! is_feed() )
				$title = ' title="' . esc_attr( $value ) . '"';
		}

		$code = ( false === strpos( $code, '<' ) && false === strpos( $code, '>' ) && 2 == $this->get_code_format($post) ) ? strip_tags( $code ) : htmlspecialchars( $code );

		return apply_filters( 'syntaxhighlighter_htmlresult', '<pre class="' . esc_attr( implode( ' ', $params ) ) . '"' . $title . '>' . $code . '</pre>' );;
	}


	// PHP4 compatibility
	function SyntaxHighlighter() {
		$this->__construct();
	}
}


// Start this plugin once all other plugins are fully loaded
add_action( 'init', 'SyntaxHighlighter', 5 );
function SyntaxHighlighter() 
{
	global $SyntaxHighlighter;
	$SyntaxHighlighter = new SyntaxHighlighter();
}

?>