<?php
	global $theme_options;
?>
<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
 	<header>
		<?php if (has_post_thumbnail() ): ?>
	  		<div class="media">
	  			<?php the_post_thumbnail('blog-featured'); ?>
	  			<?php if (is_sticky() ) : ?>
					<span class="is_sticky">
						<?php echo __('Sticky Post', 'roots'); ?>
					</span>
				<?php endif ?>
			</div>
	  	<?php endif ?>
    </header>
    <div class="entry-content">
		<?php the_content(); ?>
		<div>
			<span class="cats"><?php the_category(' '); ?></span>
		</div>
    </div>
    <footer>
		<?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
		<?php get_template_part('templates/entry-meta-bottom'); ?>
		<div class="posts-nav">
			<div class="previous nav">
				<?php previous_post_link('<i class="fa fa-long-arrow-left"></i> %link'); ?>
			</div>
			<div class="next nav">
				<?php next_post_link('%link <i class="fa fa-long-arrow-right"></i>'); ?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
    </footer>
	<?php if ($theme_options['show_author_bio'] == 'yes'): ?>
		<div class="post-author">
	    	<h3><?php echo __('About Post Author', 'roots'); ?></h3>
	    	<div class="post-author-avatar col-sm-2 no-padding-left no-padding-right"><?php echo get_avatar( get_the_author_meta( 'ID' ), 180 ); ?></div>
	    	<div class="author-info col-sm-10 no-padding-right">
	    		<div class="post-author-name">
		    		<h4 class="no-margin-top"><?php the_author_posts_link(); ?></h4>
		    	</div>
		    	<div class="post-author-description">
		    		<?php echo get_the_author_meta('description'); ?>
		    	</div>
	    	</div>
	    	<div class="clearfix"></div>
	    </div>
		<div class="clearfix"></div>
	<?php endif ?>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
