<?php

	$post_format_data = '';
	$content = trim( get_the_content('Read more'));
	if(preg_match('#^http?://\S+#', $content, $match)){
		$post_format_data = do_shortcode('[audio src="' . $match[0] . '" ][/audio]');
		$content = substr($content, strlen($match[0]));
	}else if(preg_match('#^\[audio\s.+\[/audio\]#', $content, $match)){
		$post_format_data = do_shortcode($match[0]);
		$content = substr($content, strlen($match[0]));
	}
?>
<?php if (!is_search()): ?>
	<article <?php post_class(); ?>>
	  <header>
	  	<?php echo $post_format_data; ?>
	    <div class="meta-info">
	    	<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	    	<?php get_template_part('templates/entry-meta'); ?>
	    </div>
	  </header>
	  <div class="entry-summary">
	    <?php echo apply_filters('the_content', $content); ?>
	  </div>
	  <?php get_template_part('templates/entry-meta-bottom'); ?>
	</article>

<?php elseif( is_search() ): ?>

	<article <?php post_class(); ?>>
		<?php if (has_post_thumbnail() ): ?>
			<div class="media">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		  			<?php the_post_thumbnail('search-featured'); ?>
				</a>
	  		</div>
		<?php endif ?>
	    <div class="description <?php echo ( has_post_thumbnail() ) ? 'small' : 'full' ?> ">
	    	<h2 class="entry-title no-margin-top"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	    	<div class="entry-summary">
		    <?php the_excerpt(); ?>
		  </div>
	    </div>
	    <div class="clearfix"></div>
	</article>

<?php endif ?>

