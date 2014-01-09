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
		add_action('after_setup_theme', array(&$this,
			'add_theme_menus'
		));
		$this->config_less();
	}
	function add_theme_menus()
	{
		register_nav_menus(array(
			'top_left_navigation' => __('Top Left Navigation', 'geopoint') ,
			'top_right_navigation' => __('Top right Navigation', 'geopoint') ,
		));
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
		$font = $this->theme_options['site_typo'];
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
}
new GeoPoint;
