<?php if (!is_front_page() ): ?>
	<div class="page-title">
		<div class="container">
			<h2>
				<?php if (is_search()): ?>
					<?php echo __('Search Results: ', 'roots') ?>
					<?php the_search_query(); ?>
				<?php elseif(is_archive() && !is_category()): ?>
					<?php echo __('Archives: ', 'roots') ?>
					<?php echo single_month_title(' '); ?>
				<?php elseif( is_archive() && is_category() ): ?>
					<?php echo __('Category: ', 'roots') ?>
					<?php echo single_cat_title(''); ?>
				<?php elseif( is_blog_home() ): ?>
					<?php echo "Some Ideas" ?>
				<?php elseif( is_404() ): ?>
					<?php echo __('Woops a 404', 'roots') ?>
				<?php else: ?>
					<?php the_title(); ?>
				<?php endif ?>
			</h2>
		</div>
	</div>
<?php endif ?>