<?php
$output = $el_class = '';
extract(shortcode_atts(array(
    'el_class' => '',
    'use_parallax' => ''
), $atts));

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.get_row_css_class().$el_class, $this->settings['base']);

//var_dump($this);

$output .= '<section class="'.$css_class.' '.$use_parallax.'">';
$output .= '<div class="container">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
$output .= '</section>';
echo $output;