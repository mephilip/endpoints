<?php
/**
 * This class initializes the NOUVEAU framework.
 *
 * A compatibility check is also performed
 */
class NV {

    /**
     * Initialize the NV class. This will also automatically perform the requirements check before attempting to load
     * any functionality (since Nouveau makes liberal use of closures).
     *
     * @return bool Returns compatibility check result. True for compatible, false if not.
     */
    public static function init() {

        // Load constants
        self::constants();

        // Load requirements check BEFORE LOADING ANYTHING ELSE
        require_once( NV_UTILS . '/NV_Requirements.php' );
        $nvCheck = new NV_Requirements();

        // Only continue if the requirements check passed
        if ( ! $nvCheck->is_compatible ) {
            return false;
        }

        // Finish loading
        self::bootstrap();
        self::hooks();
        return true;
    }


    /**
     * Defines constants any globals needed for the theme
     */
    public static function constants() {

        // Set the max width of content for benefit of WordPress's IMAGE EDITOR
        global $content_width;
        if ( !isset( $content_width ) ) {
            $content_width = 1000;
        }

        /** The current theme directory */
        define( 'THEME_DIR', get_template_directory() );

        /** The current theme uri */
        define( 'THEME_URI', get_template_directory_uri() );

        /** The directory for the NOUVEAU core library */
        define( 'NV_CORE', trailingslashit( THEME_DIR ) . basename( dirname( __FILE__ ) ) );

        /** The directory for NOUVEAU utility classes */
        define( 'NV_UTILS', trailingslashit( NV_CORE ) . 'utilities' );

        /** The directory for NOUVEAU hooks directory */
        define( 'NV_HOOKS', trailingslashit( NV_CORE ) . 'hooks' );

        /** The directory for NOUVEAU hooks directory */
        define( 'NV_CUSTOM', trailingslashit( NV_CORE ) . 'custom' );
        
        /** The directory for NOUVEAU hooks directory */
        define( 'NV_ENDPOINTS', trailingslashit( NV_CORE ) . 'endpoints' );

        /** The uri for theme assets (img, js, css, etc) */
        define( 'NV_ASSETS', trailingslashit( THEME_URI ) . 'assets' );

        /** The uri for theme images */
        define( 'NV_IMG', trailingslashit( NV_ASSETS ) . 'images' );

        /** The uri for theme stylesheets */
        define( 'NV_CSS', trailingslashit( NV_ASSETS ) . 'css' );

        /** The uri for theme javascripts */
        define( 'NV_JS', trailingslashit( NV_ASSETS ) . 'js' );
        
        /** The directory for theme languages */
        define( 'NV_LANGS', trailingslashit( NV_ASSETS ) . 'languages' );

        /** The directory for the parts folder */
        define( 'NV_PARTS', trailingslashit( THEME_DIR ) . 'parts' );

        /** The uri for Bower sources */
        define( 'NV_BOWER', trailingslashit( THEME_URI ) . '/bower_components' );

        /** The uri for Foundation sources */
        define( 'NV_ZF_JS', trailingslashit( NV_BOWER ) . 'foundation/js' );
        
        /** Removes Functionality for editing the theme files in wp-admin */
		define('DISALLOW_FILE_EDIT', true);

    }


    /**
     * Loads required files
     */
    public static function bootstrap() {
        /** GLOBAL SCOPE FUNCTIONS ****************************************************/
        require_once( NV_HOOKS . '/_pluggable.php' ); // Overrides WordPress' global functions

        /** HELPERS *******************************************************************/
        require_once( NV_UTILS . '/HtmlGen.php' ); // Allows dynamic building/encapsulation of HTML elements
        require_once( NV_UTILS . '/Html.php' ); // Extends HtmlGen to provide shortcuts for HTML elements
        require_once( NV_UTILS . '/WordPress.php' ); // Custom functions that extend basic WP functionality
        require_once( NV_UTILS . '/Theme.php' ); // Items that are used directly in theme templates
        require_once( NV_UTILS . '/Php.php' ); // Items that are used directly in theme templates

        /** HOOKS *********************************************************************/
        require_once( NV_HOOKS . '/Config.php' ); // Global, basic theme setup
        require_once( NV_HOOKS . '/Editor.php' ); // Configuration for the theme customizer
        require_once( NV_HOOKS . '/ThemeCustomize.php' ); // Configuration for the theme customizer

        /** CUSTOM *********************************************************************/
        require_once( NV_CUSTOM . '/WalkerComments.php' ); // Custom classes
        require_once( NV_CUSTOM . '/Functions.php' ); // Custom theme functions - extends /utilites/Theme.php
        
        /** Endpoints ******************************************************************/
        require_once( NV_ENDPOINTS . '/ReviewsEndpoint.php' ); // Extending endpoints for WP-REST

    }


    /**
     * Initializes default hooks
     */
    public static function hooks() {
        // Setup general theme options
        add_action( 'after_setup_theme',        array( '\NV\Hooks\Config', 'after_setup_theme' ) );

        // Load styles and scripts
        add_action( 'wp_enqueue_scripts',       array( '\NV\Hooks\Config', 'enqueue_assets' ) );

        // Load styles and scripts
        add_action( 'admin_enqueue_scripts',    array( '\NV\Hooks\Config', 'enqueue_admin_assets' ) );

        // Register sidebars
        add_action( 'widgets_init',             array( '\NV\Hooks\Config', 'sidebars' ) );

        // Any customizations to the body_class() function
        add_filter( 'body_class',               array( '\NV\Hooks\Config', 'body_class' ) );

        // OPTIONAL: Change WordPress's .sticky class (instead of Foundations) to prevent class conflict
        //add_filter( 'post_class',               array( '\NV\Hooks\Config', 'fix_sticky_class' ) );


        /** THEME CUSTOMIZATION *******************************************************/

        // Setup the theme customizer options
        add_action( 'customize_register',       array( '\NV\Hooks\ThemeCustomize', 'register' ) );

        // Load the customized style data on the frontend
        add_action( 'wp_head',                  array( '\NV\Hooks\ThemeCustomize', 'header_output' ) );

        // Load any javascript needed for live preview updates
        add_action( 'customize_preview_init',   array( '\NV\Hooks\ThemeCustomize', 'live_preview' ) );


        /** INTEGRATE THEME WITH TINYMCE EDITOR **************************************/

        // Adds custom stylesheet to the editor window so styling preview is accurate ( can also use add_editor_style() )
        add_filter( 'mce_css',                  array( '\NV\Hooks\Editor', 'style' ) );

        // Add a new "Styles" dropdown to the TinyMCE editor toolbar
        add_filter( 'mce_buttons_2',            array( '\NV\Hooks\Editor', 'buttons' ) );

        // Populate our new "Styles" dropdown with options/content
        add_filter( 'tiny_mce_before_init',     array( '\NV\Hooks\Editor', 'settings_advanced' ) );
        
        /** All AJAX Calls **************************************/
        add_action( 'wp_ajax_ajax_results',     		array( '\NV\Custom\AjaxData', 'ajax_results' ) );
        add_action( 'wp_ajax_nopriv_ajax_results',     	array( '\NV\Custom\AjaxData', 'ajax_results' ) );

        /** THEME CUSTOMIZATION *******************************************************/
        // Removes WSYIWYG editor
        add_action( 'init',                     array( '\NV\Custom\Functions', 'reset_editor' ) );
        // Adds filter to process shortcodes in ACF textarea fields
        add_filter('acf/format_value/type=textarea',  array( '\NV\Custom\Functions', 'process_textarea_shortcodes' ), 10, 3);
        // Adds Google Fonts
        // add_action( 'wp_enqueue_scripts',            array( '\NV\Custom\Functions', 'google_fonts' ) );

        /** SHORTCODES *******************************************************/
        // Adds blockquote shortcode
        add_shortcode( 'blockquote',            array( '\NV\Custom\Functions', 'blockquote_shortcode' ) );
        // Adds insurance minimums shortcode
        add_shortcode( 'state_ins_minimum',           array( '\NV\Custom\Functions', 'state_ins_minimum_shortcode' ) );
        // Adds company marketshare shortcode
        add_shortcode( 'state_comp_marketshare',      array( '\NV\Custom\Functions', 'state_comp_marketshare_shortcode' ) );
        // Adds state city bar graph shortcode
        add_shortcode( 'state_city_bar_graph',      array( '\NV\Custom\Functions', 'state_city_bar_graph_shortcode' ) );
        // Adds state stat compare shortcode
        add_shortcode( 'state_stat_compare',      array( '\NV\Custom\Functions', 'state_stat_compare_shortcode' ) );
        // Adds state zip code monetization shortcode
        add_shortcode( 'state_zip_monet',      array( '\NV\Custom\Functions', 'state_zip_monet_shortcode' ) );



    }


    /**
     * Loads alternate languages, if available.
     *
     * @see self::setup()
     * @since Nouveau 1.0
     */
    public static function languages() {
        load_theme_textdomain( 'nvLangScope', NV_LANGS ); //get_template_directory()
        $locale      = get_locale();
        $locale_file = sprintf( '%s/%s.php', NV_LANGS, $locale ); //get_template_directory()

        if ( is_readable( $locale_file ) ) {
            require_once $locale_file;
        }
    }

}