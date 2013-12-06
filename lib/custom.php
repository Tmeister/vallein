<?php
/**
 * Custom Function:
 */

/**
 * Adding the Redux Framework and Theme Configuration Panel
 */

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/../vendors/ReduxFramework/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/../vendors/ReduxFramework/ReduxCore/framework.php' );
}
if ( !isset( $cendres ) && file_exists( dirname( __FILE__ ) . '/../vendors/ReduxFramework/sample/sample-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/../lib/theme-options-config.php' );
}

/**
 * Adding the Custom Meta Boxes Framework
 */

if( ! function_exists('cmb_init') ){
    require_once( dirname( __FILE__ ) . '/../vendors/cmb/custom-meta-boxes.php' );
}


/**
 * Adding Visual Composer
 */

if (!class_exists('WPBakeryVisualComposerAbstract')) {
  $dir = dirname(__FILE__) . '/../wpbakery/';
  $composer_settings = Array(
      'APP_ROOT'       => $dir . '/js_composer',
      'WP_ROOT'        => dirname( dirname( dirname( dirname($dir ) ) ) ). '/',
      'APP_DIR'        => basename( $dir ) . '/js_composer/',
      'CONFIG'         => $dir . '/js_composer/config/',
      'ASSETS_DIR'     => '/assets/',
      'COMPOSER'       => $dir . '/js_composer/composer/',
      'COMPOSER_LIB'   => $dir . '/js_composer/composer/lib/',
      'SHORTCODES_LIB' => $dir . '/js_composer/composer/lib/shortcodes/',
      'USER_DIR_NAME'  => '/../templates/vc_templates', /* Path relative to your current theme, where VC should look for new shortcode templates */

      //for which content types Visual Composer should be enabled by default
      'default_post_types' => Array('page')
  );
  is_file(dirname(__FILE__) . '/../wpbakery/js_composer/js_composer.php');
  require_once ( dirname(__FILE__) . '/../wpbakery/js_composer/js_composer.php');
  $wpVC_setup->init($composer_settings);
}

/**
 * Adding WP-LESS: No validation needed the code already do that
 */
require dirname(__FILE__) . '/../vendors/wp-less/bootstrap-for-theme.php';

/**
* Main GeoPoint Class
*/
class GeoPoint
{

    var $theme_options;

    function __construct()
    {
        global $theme_options;
        $this->theme_options = $theme_options;
        add_filter( 'cmb_meta_boxes',                       array( &$this, 'cmb_add_page_options') );
        add_action( 'after_setup_theme',                    array( &$this, 'add_theme_menus') );
        $this->config_less();

    }

    function add_theme_menus(){
      register_nav_menus(array(
        'top_left_navigation'  => __('Top Left Navigation', 'geopoint'),
        'top_right_navigation' => __('Top right Navigation', 'geopoint'),

      ));
    }

    function cmb_add_page_options( array $meta_boxes )
    {
        return $meta_boxes;
    }

    function config_less()
    {
      if (class_exists('WPLessPlugin'))
      {
        $less = WPLessPlugin::getInstance();
        $lessConfig = $less->getConfiguration();
        $lessConfig->setUploadDir(get_template_directory()     . '/assets/css');
        $lessConfig->setUploadUrl(get_template_directory_uri() . '/assets/css');
        $this->set_less_variables();
        $less->dispatch();
      }
    }

    function set_less_variables()
    {
      $less = WPLessPlugin::getInstance();
      $less->addVariable('siteBgColor', $this->theme_options['site_bg_color']);
    }
}
new GeoPoint;

