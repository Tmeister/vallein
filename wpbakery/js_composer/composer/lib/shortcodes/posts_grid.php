<?php

class WPBakeryShortCode_VC_Posts_Grid extends WPBakeryShortCode {
    protected $filter_categories = array();
    protected $query = false;
    protected $loop_args = array();
    protected $taxonomies = false;
    protected $partial_paths = array();
    protected static $pretty_photo_loaded = false;
    function __construct($settings) {
        parent::__construct($settings);
        $this->addAction( 'admin_init', 'jsComposerEditPage', 6 );
    }
    public function jsComposerEditPage() {

        $vc = visual_composer();
        $pt_array = $vc->getPostTypes();
        foreach ($pt_array as $pt) {
            add_meta_box( 'vc_teaser', __('VC Teaser', "js_composer"), Array(&$this, 'outputTeaser'), $pt, 'side');
        }
    }
    public function outputTeaser() {
        global $vc_layout_sub_controls;
        wp_enqueue_script('wpb_jscomposer_teaser_js');
        $blocks = array(
            array('thumbnail', __('Thumbnail', "js_composer"), $vc_layout_sub_controls),
            array('title', __('Title', "js_composer"), $vc_layout_sub_controls),
            array('excerpt', __('Teaser(excerpt)', "js_composer"), $vc_layout_sub_controls),
            array('text', __('Text (Editable)', "js_composer")),
            array('read_more', __('Read more link', "js_composer"))
        );
        $output = '<div class="vc-teaser-switch"><label><input type="checkbox" name="vc_teaser[enable]" value="1" id="vc-teaser-checkbox"> '.__('Enable custom teaser', "js_composer").'</label></div>';
        $output .= '<div class="vc-teaser-constructor">';
        $output .= '    <div class="vc-toolbar">'.vc_sorted_list_parts_list($blocks).'</div>';
        $output .= '    <ul class="vc-teaser-list"></ul>';
        $output .= '    <div class="vc-teaser-footer"><label>Background color</label><br/><input type="text" name="vc_teaser[bgcolor]" class="vc-teaser-bgcolor"></div>';
        $output .= '</div>';
        echo $output;
    }
    protected function getCategoriesCss($post_id) {
        $categories_css = '';
        $post_categories = wp_get_object_terms($post_id, $this->getTaxonomies());
        foreach($post_categories as $cat) {
            if(!in_array($cat->term_id, $this->filter_categories)) {
                $this->filter_categories[] = $cat->term_id;
            }
            $categories_css .= ' grid-cat-'.$cat->term_id;
        }
        return $categories_css;
    }
    protected function getTaxonomies() {
        if($this->taxonomies === false) {
            $this->taxonomies = get_object_taxonomies(!empty($this->loop_args['post_type']) ? $this->loop_args['post_type'] : get_post_types(array('public' => false, 'name' => 'attachment'), 'names', 'NOT'));
        }
        return $this->taxonomies;
    }
    protected function getLoop($loop) {
        list($this->loop_args, $this->query)  = vc_build_loop_query($loop);
    }
    protected function spanClass($grid_columns_count) {
        $teaser_width = '';
        switch ($grid_columns_count) {
            case '1' :
                $teaser_width = 'vc_span12';
                break;
            case '2' :
                $teaser_width = 'vc_span6';
                break;
            case '3' :
                $teaser_width = 'vc_span4';
                break;
            case '4' :
                $teaser_width = 'vc_span3';
                break;
            case '5':
                $teaser_width = 'vc_span10';
                break;
            case '6' :
                $teaser_width = 'vc_span2';
                break;
        }
        //return $teaser_width;
        $custom = get_custom_column_class($teaser_width);
        return $custom ? $custom : $teaser_width;
    }
    protected function getMainCssClass($filter) {
        return 'wpb_'.($filter==='yes' ? 'filtered_' : '').'grid';
    }
    protected function getFilterCategories() {
        return get_terms($this->getTaxonomies(), array(
        'orderby' => 'name',
        'include' => implode(',', $this->filter_categories)
        ));
    }
    protected function getPostThumbnail($post_id, $grid_thumb_size) {
            return  wpb_getImageBySize(array( 'post_id' => $post_id, 'thumb_size' => $grid_thumb_size ));
        return false;
    }
    protected function getPostContent() {
        $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
        return wpautop($content);
    }
    protected function getPostExcerpt() {
        $content = apply_filters('the_excerpt', get_the_excerpt());
        return wpautop($content);
    }
    protected function getLinked($post, $content, $type, $css_class) {
        $output = '';
        if($type === 'link_post') {
            $url = get_permalink($post->id);
            $title =  sprintf( esc_attr__( 'Permalink to %s', "js_composer" ), $post->title_attribute);
            $output .= '<a href="'.$url.'" class="'.$css_class.'"'.$this->link_target.' title="'.$title.'">'.$content.'</a>';
        } elseif($type === 'link_image') {
            $this->loadPrettyPhoto();
            $output .= '<a href="'.$post->image_link.'" class="'.$css_class.' prettyphoto"'.$this->link_target.' title="'.$post->title_attribute.'">'.$content.'</a>';
        } else {
            $output .= $content;
        }
        return $output;
    }
    protected function loadPrettyPhoto() {
        if(self::$pretty_photo_loaded!==true) {
            wp_enqueue_script( 'prettyphoto' );
            wp_enqueue_style( 'prettyphoto' );
            self::$pretty_photo_loaded = true;
        }
    }
    protected function setLinkTarget($grid_link_target = '') {
        $this->link_target = $grid_link_target=='_blank' ? ' target="_blank"' : '';
    }
}