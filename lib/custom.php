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
    require_once( dirname( __FILE__ ) . '/../lib/cendres-config.php' );
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
* Main Cendres Class
*/
class Cendres
{

    function __construct()
    {
        add_filter( 'cmb_meta_boxes',                       array( &$this, 'cmb_add_page_options') );
        //add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,     array( &$this, 'add_custom_container'), 10, 2 );
        $this->map_test_shortcode();
        add_shortcode( 'test_shortcode',                    array( &$this, 'test_shortcode') );

    }

    function cmb_add_page_options( array $meta_boxes ) {
        return $meta_boxes;
    }

    function add_custom_container($classes, $base = 'lol'){
        return $classes.' '.$base;
    }

    function test_shortcode($atts){
        extract( shortcode_atts( array(
            'foo' => 'something',
            'bar' => 'something else',
        ), $atts ) );

        $out  = '<section class="test_wrapper '. $foo.'">';
        $out .= '<div class="container">';
        $out .= '<h1>HELLOOOO</h1>';
        $out .= '</div>';
        $out .= '</section>';
        return $out;
    }
    function map_test_shortcode(){
      vc_map( array(
         "name" => __("Bar tag test"),
         "base" => "test_shortcode",
         "class" => "",
         "category" => __('Content'),
         "is_container" => true,
         "params" => array(
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Text"),
               "param_name" => "foo",
               "value" => __("Default params value"),
               "description" => __("Description for foo param.")
            )
         )
      ) );
    }
}
new Cendres;

