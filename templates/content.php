<?php if ( is_search()  || is_archive() ): ?>

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


<?php else : ?>

	<article <?php post_class(); ?>>
	  <header>
	  	<?php if (has_post_thumbnail() ): ?>
	  		<div class="media">
		  		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		  			<?php the_post_thumbnail('blog-featured'); ?>
		  			<?php if (is_sticky() ) : ?>
						<span class="is_sticky">
							<?php echo __('Sticky Post', 'roots'); ?>
						</span>
					<?php endif ?>
				</a>
			</div>
	  	<?php endif ?>
	    <div class="meta-info">
	    	<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	    	<?php get_template_part('templates/entry-meta'); ?>
	    </div>
	  </header>
	  <div class="entry-summary">
	    <?php the_content(); ?>
	  </div>
	  <?php get_template_part('templates/entry-meta-bottom'); ?>
	</article>


<?php endif ?>

