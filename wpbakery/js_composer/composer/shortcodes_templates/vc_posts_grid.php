<?php
$grid_link = $grid_layout_mode = $title = $filter= '';
$posts = array();
extract(shortcode_atts(array(
    'title' => '',
    'grid_columns_count' => 4,
    'grid_teasers_count' => 8,
    'grid_layout' => 'title,thumbnail,text', // title_thumbnail_text, thumbnail_title_text, thumbnail_text, thumbnail_title, thumbnail, title_text
    'grid_link_target' => '_self',
    'filter' => '', //grid,
    'grid_thumb_size' => 'thumbnail',
    'grid_layout_mode' => 'fitRows',
    'el_class' => '',
    'teaser_width' => '12',
    'orderby' => NULL,
    'order' => 'DESC',
    'loop' => '',
), $atts));

if(empty($loop)) return;

$this->getLoop($loop);
$my_query = $this->query;
$args = $this->loop_args;
$teaser_blocks = vc_sorted_list_parse_value($grid_layout);
while ( $my_query->have_posts() ) {
    $my_query->the_post(); // Get post from query
    $post = new stdClass(); // Creating post object.
    $post->id = get_the_ID();
    $post->title = isset($teaser_blocks['title']) ? the_title("", "", false) : '';
    $post->title_attribute = the_title_attribute('echo=0');
    $post->post_type = get_post_type();
    $post->content = isset($teaser_blocks['text']) ? $this->getPostContent() : '';
    $post->excerpt = isset($teaser_blocks['excerpt']) ? $this->getPostExcerpt() : '';
    $post->thumbnail_data = $this->getPostThumbnail($post->id, $grid_thumb_size);
    $post->thumbnail = $post->thumbnail_data && isset($post->thumbnail_data['thumbnail']) ? $post->thumbnail_data['thumbnail'] : '';
    $video = get_post_meta($post->id, "_p_video", true);
    $post->image_link =  empty($video) && $post->thumbnail && isset($post->thumbnail_data['p_img_large'][0]) ? $post->thumbnail_data['p_img_large'][0] : $video;
    $post->link = get_permalink($post->id);
    $post->categories_css = $this->getCategoriesCss($post->id);
    $posts[] = $post;
}
wp_reset_query();
/**
 * Css classes for grid and teasers.
 * {{
 */
$post_types_teasers = '';
if ( !empty($args['post_type']) && is_array($args['post_type']) ) {
    foreach ( $args['post_type'] as $post_type ) {
        $post_types_teasers .= 'wpb_teaser_grid_'.$post_type . ' ';
    }
}
$el_class = $this->getExtraClass( $el_class );
$li_span_class = $this->spanClass( $grid_columns_count );

$css_class = 'wpb_teaser_grid wpb_content_element '.
             $this->getMainCssClass($filter) . // Css class as selector for isotope plugin
             ' columns_count_'.$grid_columns_count . // Custom margin/padding for different count of columns in grid
             ' columns_count_'.$grid_columns_count . // Combination of layout and column count
             // ' post_grid_'.$li_span_class .
             ' ' . $post_types_teasers . // Css classes by selected post types
             $el_class; // Custom css class from shortcode attributes
// }}

$this->setLinktarget($grid_link_target);
?>
<div class="<?php echo apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base']) ?>">
    <div class="wpb_wrapper">
        <?php echo wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_teaser_grid_heading')) ?>
        <div class="teaser_grid_container">
            <?php if( $filter === 'yes' && !empty($this->filter_categories)):
            $categories_array = $this->getFilterCategories();
            ?>
            <ul class="categories_filter clearfix">
                <li class="active"><a href="#" data-filter="*"><?php _e('All', 'js_composer') ?></a></li>
                <?php foreach($this->getFilterCategories() as $cat): ?>
                <li><a href="#" data-filter=".grid-cat-<?php echo $cat->term_id ?>"><?php echo esc_attr($cat->name) ?></a></li>
                <?php endforeach; ?>
            </ul><div class="clearfix"></div>
            <?php endif; ?>
            <ul class="wpb_thumbnails wpb_thumbnails-fluid clearfix" data-layout-mode="<?php echo $grid_layout_mode ?>'">
                <?php if(count($posts) > 0): ?>
                <?php
                /**
                 * Enqueue js/css
                 * {{
                 */
                wp_enqueue_style('isotope-css');
                wp_enqueue_script( 'isotope' );
                ?>
                <?php foreach($posts as $post): ?>
                <li class="isotope-item <?php echo apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $li_span_class, 'vc_teaser_grid_li').$post->categories_css ?>">

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
                        <div class="entry-content"><?php echo $post->content; ?></div>
                    <?php elseif($block === 'excerpt'): ?>
                        <div class="entry-excerpt">
                            <?php echo !empty($link_settings) && $link_settings!='no_link' ? $this->getLinked($post, $post->excerpt, $link_settings, '') : $post->excerpt ?>
                        </div>
                    <?php elseif($block === 'read_more'): ?>
                        <a href="<?php echo $post->link ?>" class="vc_read_more" title="<?php echo esc_attr(sprintf(__( 'Permalink to %s', "js_composer" ), $post->title_attribute)); ?>"><?php _e('Read more...', "js_composer") ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>

                </li> <?php echo $this->endBlockComment('single teaser'); ?>
                <?php endforeach; ?>
                <?php else: ?>
                <li><?php _e("Nothing found." , "js_composer") ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div> <?php echo $this->endBlockComment('.wpb_wrapper') ?>
    <div class="clear"></div>
</div> <?php echo $this->endBlockComment('.wpb_teaser_grid') ?>