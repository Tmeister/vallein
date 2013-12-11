<?php

/**
 * Main GeoPoint Class
 */
class GeoPoint
{
	/*var $theme_options;
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
		$less = WPLessPlugin::getInstance();
		$less->addVariable('siteBgColor', $this->theme_options['site_bg_color']);
	}*/
}
new GeoPoint;
