<?php
/**
 * Adding the Redux Framework and Theme Configuration Panel
 */
if (!class_exists('ReduxFramework') && file_exists(dirname(__FILE__) . '/../vendors/ReduxFramework/ReduxCore/framework.php')) {
	require_once (dirname(__FILE__) . '/../vendors/ReduxFramework/ReduxCore/framework.php');
}
if (!isset($cendres) && file_exists(dirname(__FILE__) . '/../lib/theme-options-config.php')) {
	require_once (dirname(__FILE__) . '/../lib/theme-options-config.php');
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
		add_action( 'after_setup_theme', 				array(&$this, 'add_theme_menus' ));
		add_action( 'edd_payment_mode_before_gateways', array(&$this, 'add_open_wrapper'));
		add_action( 'edd_payment_mode_after_gateways', 	array(&$this, 'add_close_wrapper'));
		add_action( 'edd_purchase_form_before_email', 	array(&$this, 'add_open_wrapper'));
		add_action( 'edd_purchase_form_user_info', 		array(&$this, 'add_close_wrapper'));
		add_filter( 'roots_display_sidebar', 			array(&$this, 'is_download' ));
		add_filter( 'excerpt_more',						array(&$this, 'remove_more_link') );

		remove_action( 'edd_cc_form', 					'edd_get_cc_form' );
		add_action( 'edd_cc_form', 						array(&$this,  'custom_edd_get_cc_form' ));
		$this->config_less();
	}

	function add_theme_menus()
	{
		register_nav_menus(array(
			'top_left_navigation' => __('Top Left Navigation', 'geopoint') ,
			'top_right_navigation' => __('Top right Navigation', 'geopoint') ,
		));

		add_image_size( 'blog-featured', 	770, 430, true );
		add_image_size( 'search-featured', 	510, 380, true );
		add_image_size( 'shop-featured', 	530, 390, true );
		add_image_size( 'shop-single', 		900, 900, true );
		add_theme_support( 'post-formats', array( 'gallery', 'aside', 'chat', 'image', 'quote', 'status', 'video', 'audio' ) );

	}

	function add_open_wrapper()
	{
		echo "<div class='divider'></div><div class='wrapper'>";
	}

	function add_close_wrapper()
	{
		echo "</div> <!-- /payments wrapper -->";
	}

	function remove_more_link($more)
	{
		global $post;
		if( $post->post_type == 'download' ){
			return '';
		}
		return $more;
	}

	function is_download($show)
	{
		if( 'download' == get_post_type() && is_single() ){
			$show = false;
		}

		return $show;
	}

	function config_less()
	{
		if (class_exists('WPLessPlugin')) {
			$less = WPLessPlugin::getInstance();
			$lessConfig = $less->getConfiguration();
			$lessConfig->setUploadDir(get_template_directory() . '/assets/css');
			$lessConfig->setUploadUrl(get_template_directory_uri() . '/assets/css');
			$this->set_less_variables();
			$less->dispatch();
		}
	}
	function set_less_variables()
	{
		if(!isset($this->theme_options['site_typo'])){
			return;
		}
		$font = $this->theme_options['site_typo'];
		//var_dump($font);
		$site_font = $font['font-weight'] .' ' . $font['font-size']. ' "' . $font['font-family'] .'", Arial, Helvetica, sans-serif';
		//var_dump($site_font);
		$font_color = $font['color'];
		$less = WPLessPlugin::getInstance();
		$less->addVariable('siteFont', "$site_font");
		$less->addVariable('siteFontFamily', $font['font-family']);
		$less->addVariable('siteFontColor', "$font_color");
		$less->addVariable('siteBgColor', $this->theme_options['site_bg_color']);
		$less->addVariable('accentColor', $this->theme_options['accent_color']);
		$less->addVariable('borderColor', $this->theme_options['border_color']);
		$less->addVariable('boxBgColor',  $this->theme_options['box_bg_color']);
	}

	function custom_edd_get_cc_form()
	{
		ob_start(); ?>

		<?php do_action( 'edd_before_cc_fields' ); ?>

		<fieldset id="edd_cc_fields" class="edd-do-validate">
			<span><legend><?php _e( 'Credit Card Info', 'edd' ); ?></legend></span>
			<?php if( is_ssl() ) : ?>
				<div id="edd_secure_site_wrapper">
					<span class="padlock"></span>
					<span><?php _e( 'This is a secure SSL encrypted payment.', 'edd' ); ?></span>
				</div>
			<?php endif; ?>
			<div class="divider"></div>
			<div class="wrapper">
				<p id="edd-card-number-wrap">
					<label for="card_number" class="edd-label">
						<?php _e( 'Card Number', 'edd' ); ?>
						<span class="edd-required-indicator">*</span>
						<span class="card-type"></span>
					</label>
					<span class="edd-description"><?php _e( 'The (typically) 16 digits on the front of your credit card.', 'edd' ); ?></span>
					<input type="text" autocomplete="off" name="card_number" id="card_number" class="card-number edd-input required" placeholder="<?php _e( 'Card number', 'edd' ); ?>" />
				</p>
				<p id="edd-card-cvc-wrap">
					<label for="card_cvc" class="edd-label">
						<?php _e( 'CVC', 'edd' ); ?>
						<span class="edd-required-indicator">*</span>
					</label>
					<span class="edd-description"><?php _e( 'The 3 digit (back) or 4 digit (front) value on your card.', 'edd' ); ?></span>
					<input type="text" size="4" autocomplete="off" name="card_cvc" id="card_cvc" class="card-cvc edd-input required" placeholder="<?php _e( 'Security code', 'edd' ); ?>" />
				</p>
				<p id="edd-card-name-wrap">
					<label for="card_name" class="edd-label">
						<?php _e( 'Name on the Card', 'edd' ); ?>
						<span class="edd-required-indicator">*</span>
					</label>
					<span class="edd-description"><?php _e( 'The name printed on the front of your credit card.', 'edd' ); ?></span>
					<input type="text" autocomplete="off" name="card_name" id="card_name" class="card-name edd-input required" placeholder="<?php _e( 'Card name', 'edd' ); ?>" />
				</p>
				<?php do_action( 'edd_before_cc_expiration' ); ?>
				<p class="card-expiration">
					<label for="card_exp_month" class="edd-label">
						<?php _e( 'Expiration (MM/YY)', 'edd' ); ?>
						<span class="edd-required-indicator">*</span>
					</label>
					<span class="edd-description"><?php _e( 'The date your credit card expires, typically on the front of the card.', 'edd' ); ?></span>
					<select id="card_exp_month" name="card_exp_month" class="card-expiry-month edd-select edd-select-small required">
						<?php for( $i = 1; $i <= 12; $i++ ) { echo '<option value="' . $i . '">' . sprintf ('%02d', $i ) . '</option>'; } ?>
					</select>
					<span class="exp-divider"> / </span>
					<select id="card_exp_year" name="card_exp_year" class="card-expiry-year edd-select edd-select-small required">
						<?php for( $i = date('Y'); $i <= date('Y') + 10; $i++ ) { echo '<option value="' . $i . '">' . substr( $i, 2 ) . '</option>'; } ?>
					</select>
				</p>
				<?php do_action( 'edd_after_cc_expiration' ); ?>
			</div>

		</fieldset>
		<?php
		do_action( 'edd_after_cc_fields' );
		echo ob_get_clean();
	}
}
new GeoPoint;

//Global Helpers

function is_blog_home () {
	global $post;
	$posttype = get_post_type($post );
	return ( (is_author()) ||  (is_home()) || (is_tag()) && ( $posttype == 'post') ) ? true : false ;
}