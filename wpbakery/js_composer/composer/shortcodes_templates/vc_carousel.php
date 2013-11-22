<?php
$posts_query = $el_class = $args = $my_query = $speed = $mode = $swiper_options = '';
$content = $link = $layout = $thumb_size = $link_target = $slides_per_view = $loop = '';
$autoplay = $hide_pagination_control = $hide_prev_next_buttons = '';
$posts = array();
extract(shortcode_atts(array(
    'el_class' => '',
    'posts_query' => '',
    'mode' => 'horizontal',
    'speed' => '500',
    'slides_per_view' => '1',
    'swiper_options' => '',
    'loop' => '',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
    'autoplay' => '5000',
    'layout' => 'title,thumbnail,excerpt',
    'link_target' => '',
    'thumb_size' => 'thumbnail',
    'partial_view' => ''
), $atts));
list($args, $my_query) = vc_build_loop_query($posts_query); //
$teaser_blocks = vc_sorted_list_parse_value($layout);
while ( $my_query->have_posts() ) {
    $my_query->the_post(); // Get post from query
    $post = new stdClass(); // Creating post object.
    $post->id = get_the_ID();
    $post->title = isset($teaser_blocks['title']) ? the_title("", "", false) : '';
    $post->title_attribute = the_title_attribute('echo=0');
    $post->post_type = get_post_type();
    $post->content = isset($teaser_blocks['text']) ? $this->getPostContent() : '';
    $post->excerpt = isset($teaser_blocks['excerpt']) ? $this->getPostExcerpt() : '';
    $post->thumbnail_data = $this->getPostThumbnail($post->id, $thumb_size);
    $post->thumbnail = $post->thumbnail_data && isset($post->thumbnail_data['thumbnail']) ? $post->thumbnail_data['thumbnail'] : '';
    $video = get_post_meta($post->id, "_p_video", true);
    $post->image_link =  empty($video) && $post->thumbnail && isset($post->thumbnail_data['p_img_large'][0]) ? $post->thumbnail_data['p_img_large'][0] : $video;
    $post->link = get_permalink($post->id);
    $posts[] = $post;
}
wp_reset_query();
// $options = vc_parse_options_string($bxslider_options, $this->shortcode, 'bxslider_options');
$tmp_options = vc_parse_options_string($swiper_options, $this->shortcode, 'swiper_options');
// }}
$this->setLinktarget($link_target);

// wp_enqueue_script('vc_bxslider');
// wp_enqueue_style('vc_bxslider_css');
wp_enqueue_script('vc_swiper');
wp_enqueue_style('vc_swiper_css');

$options = array();
// Convert keys to Camel case.
foreach($tmp_options as $key => $value) {
    $key = preg_replace('/_([a-z])/e', "strtoupper('\\1')", $key);
    $options[$key] = $value;
}

if((int)$speed > 0) $options['speed'] = (int)$speed;
if((int)$slides_per_view > 0) $options['slidesPerView'] =  (int)$slides_per_view;
if($loop==='yes') $options['loop'] = true;
if((int)$autoplay > 0) $options['autoplay'] = (int)$autoplay;
$options['mode'] = $mode;
if($hide_pagination_control!=='yes') {
    $options['pagination'] = '.vc_pagination';
    $options['paginationClickable'] = true;
}
// $options['calculateHeight'] = true;
$css_class = $this->settings['base'].' vc_carousel_slider_'.$slides_per_view.' vc_carousel_'.$mode.(empty($el_class) ? '' : ' '.$el_class);
?>
<div class="<?php echo apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base']) ?>">
    <div class="wpb_wrapper">
        <div class="swiper-container" data-settings="<?php echo htmlspecialchars(json_encode($options)) ?>">
            <?php if($hide_prev_next_buttons !== 'yes'): ?>
            <a href="#" class="vc-arrow-left"></a>
            <a href="#" class="vc-arrow-right"></a>
            <?php endif; ?>
            <div class="swiper-wrapper vc_swiper">
                <?php foreach($posts as $post): ?>
                <div class="swiper-slide vc_slide_<?php echo $post->post_type ?>">
                <?php foreach($teaser_blocks as $block => $link_settings): ?>
                <?php if($block === 'title'): ?>
                    <div class="post-title">
                        <?php echo !empty($link_settings) && $link_settings!='no_link' ? $this->getLinked($post, $post->title, $link_settings, 'link_title') : htmlspecialchars($post->title) ?>
                    </div>
                <?php elseif($block === 'thumbnail'): ?>
                    <div class="post-thumb">
                        <?php echo !empty($link_settings) && $link_settings!='no_link' ? $this->getLinked($post, $post->thumbnail, $link_settings, 'link_image') : $post->thumbnail ?>
                    </div>
                <?php elseif($block === 'text'): ?>
                    <div class="entry-content">
                        <?php echo $post->content; ?>
                    </div>
                <?php elseif($block === 'excerpt'): ?>
                    <div class="entry-excerpt">
                        <?php echo !empty($link_settings) && $link_settings!='no_link' ? $this->getLinked($post, $post->excerpt, $link_settings, '') : $post->excerpt ?>
                    </div>
                <?php elseif($block === 'read_more'): ?>
                    <a href="<?php echo $post->link ?>" class="vc_read_more" title="<?php echo esc_attr(sprintf(__( 'Permalink to %s', "js_composer" ), $post->title_attribute)); ?>"><?php _e('Read more...', "js_composer") ?></a>
                <?php endif; ?>
                <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php if($hide_pagination_control!=='yes'): ?>
            <div class="vc_pagination"></div>
            <?php endif; ?>
        </div>
    </div>
</div>