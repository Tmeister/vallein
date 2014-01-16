<?php

/**
 * GeoPoint Configuration File.
 */

$args = array();
$tabs = array();
ob_start();


$ct         = wp_get_theme();
$theme_data = $ct;
$item_name  = $theme_data->get('Name');
$tags       = $ct->Tags;
$screenshot = $ct->get_screenshot();
$class      = $screenshot ? 'has-screenshot' : '';
$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','geopoint' ), $ct->display('Name') );

?>
<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
    <?php if ( $screenshot ) : ?>
        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
            <img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
        </a>
        <?php endif; ?>
        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
    <?php endif; ?>

    <h4>
        <?php echo $ct->display('Name'); ?>
    </h4>

    <div>
        <ul class="theme-info">
            <li><?php printf( __('By %s','geopoint'), $ct->display('Author') ); ?></li>
            <li><?php printf( __('Version %s','geopoint'), $ct->display('Version') ); ?></li>
            <li><?php echo '<strong>'.__('Tags', 'geopoint').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
        </ul>
        <p class="theme-description"><?php echo $ct->display('Description'); ?></p>
        <?php if ( $ct->parent() ) {
            printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
                __( 'http://codex.wordpress.org/Child_Themes','geopoint' ),
                $ct->parent()->display( 'Name' ) );
        } ?>

    </div>

</div>

<?php
$item_info = ob_get_contents();
ob_end_clean();

$theme                          = wp_get_theme();

$args['dev_mode']               = true;
$args['dev_mode_icon_class']    = 'icon-large';
$args['opt_name']               = 'theme_options';
$args['system_info']            = false;
$args['display_name']           = $theme->get('Name');
$args['display_version']        = $theme->get('Version');
$args['google_api_key']         = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';
$args['default_icon_class']     = 'icon-large';
$args['menu_title']             = __('GeoPoint Options', 'geopoint');
$args['page_title']             = __('GeoPoint Options', 'geopoint');
$args['page_slug']              = 'geopoint_options';
$args['default_show']           = true;
$args['default_mark']           = '*';
$args['show_import_export']     = true;
$args['share_icons']['twitter'] = array(
    'link' => 'http://twitter.com/enriquestore',
    'title' => 'Follow me on Twitter',
    'img' => ReduxFramework::$_url . 'assets/img/social/Twitter.png'
);

$sections             = array();
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns      = array();

if ( is_dir( $sample_patterns_path ) ) :

  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
    $sample_patterns = array();

    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
        $name = explode(".", $sample_patterns_file);
        $name = str_replace('.'.end($name), '', $sample_patterns_file);
        $sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
      }
    }
  endif;
endif;


/******************************************************************************
* General Settings Tab
******************************************************************************/

$sections[] = array(
    'icon'       => 'el-icon-cogs',
    'icon_class' => 'icon-large',
    'title'      => __('General Settings', 'geopoint'),
    'fields'     => array(
    	array(
    		'id'       => 'layout',
            'type'     => 'select',
            'title'    => __('Site Layout.', 'geopoint'),
            'subtitle' => __('Select the site layout, Boxed or Fluid.', 'geopoint'),
            'options' => array(
                'fluid' => 'Fluid',
                'boxed' => 'Boxed'
            ),
            'default' => 'fluid'
    	),
        array(
            'id'       => 'site_bg_color',
            'type'     => 'color',
            'default'  => '#ffffff',
            'title'    => __('Site Background Color.', 'geopoint'),
            'subtitle' => __('Select main color to use as background for the entired site.', 'geopoint'),
        ),
        array(
        	'id'       => 'box_bg_color',
            'type'     => 'color',
            'default'  => '#ffffff',
            'title'    => __('Box Background Color.', 'geopoint'),
            'subtitle' => __('Select color to use as background for the boxed content.', 'geopoint'),
            'required' => array('layout', '=' , 'boxed')
        ),
        array(
            'id'       => 'accent_color',
            'type'     => 'color',
            'default'  => '#9295CA',
            'title'    => __('Site Accent Color.', 'geopoint'),
            'subtitle' => __('Select accent color to use in the site.', 'geopoint'),
        ),
        array(
            'id'       => 'border_color',
            'type'     => 'color',
            'default'  => '#d3d3d3',
            'title'    => __('Border Color.', 'geopoint'),
            'subtitle' => __('Select border color to use in the site. This color will be use in the tabs, accordions borders around the site.', 'geopoint'),
        ),

        array(
			'id'=>'site_typo',
			'type' => 'typography',
			'title' => __('Site Typography', 'geopoint'),
			'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup'=>false, // Select a backup non-google font in addition to a google font
			'font-size'=>true,
			'color'=>true,
			'line-height' => false,
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('h2.site-description'), // An array of CSS selectors to apply this font style to dynamically
			'units'=>'px', // Defaults to px
			'subtitle'=> __('Typography option with each property can be called individually.', 'geopoint'),
			'default'=> array(
				'color'=>"#232323",
				'font-weight'=>'300',
				'font-family'=>'Raleway',
				'google' => true,
				'font-size'=>'16px',
				'line-height'=>'40px',
			)
		),
        array(
            'id'       => 'site_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => __('Site Background Color.', 'geopoint'),
            'subtitle' => __('Select main color to use as background for the entired site.', 'geopoint'),
        ),
        array(
            'id'       =>'site_header_style',
            'type'     => 'select',
            'title'    => __('Site Header Style', 'geopoint'),
            'subtitle' => __('Select the header style for the site', 'geopoint'),
            'desc'     => __('GeoPoint comes with 2 different header styles.<br>1.- Default - Desc - Link<br>2.- Search on top - Desc - Link', 'geopoint'),
            'options' => array(
                'default' => 'Default',
                'logo-on-top' => 'Option 2'
            ),
            'default' => 'default'
        ),

    )
);

/******************************************************************************
* Blog Settings Tab
******************************************************************************/

$sections[] = array(
    'icon'       => 'el-icon-website',
    'icon_class' => 'icon-large',
    'title'      => __('Blog Settings', 'geopoint'),
    'fields'     => array(
    	array(
            'id'       =>'show_author_bio',
            'type'     => 'select',
            'title'    => __('Author Bio', 'geopoint'),
            'subtitle' => __('Show Author Bio', 'geopoint'),
            'desc'     => __('Select if you want to show the post author bio in the single post view.', 'geopoint'),
            'options' => array(
                'yes' => 'Yes',
                'no' => 'No'
            ),
            'default' => 'yes'
        ),
        array(
            'id'       => 'blog_header_image',
            'type'     => 'media',
            'url'      => true,
            'title'    => __('Blog Header Image.', 'geopoint'),
            'subtitle' => __('sub', 'geopoint'),
            'desc'		=> __('desc', 'geopoint'),
        ),
    )
);


if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
    $tabs['docs'] = array(
        'icon'       => 'el-icon-book',
        'icon_class' => 'icon-large',
        'title'      => __('Documentation', 'geopoint'),
        'content'    => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
    );
}

global $ReduxFramework;
$ReduxFramework = new ReduxFramework($sections, $args, $tabs);