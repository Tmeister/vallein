<article <?php post_class(); ?>>
  <header>
  	<?php if (has_post_thumbnail() ): ?>
  		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
  			<?php the_post_thumbnail(); ?>
		</a>
  	<?php endif ?>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
    <?php the_content(); ?>
  </div>
</article>
