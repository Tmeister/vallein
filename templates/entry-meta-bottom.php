<div class="entry-meta-bottom">
	<div class="posted-on">
		<span>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_date(); ?></a>
		</span>
	</div>
	<div class="tags-links">
		<?php if (get_the_tag_list()): ?>
			<span>
				<?php echo __('Tagged:', 'roots'); ?> <?php echo get_the_tag_list( '', ', ', '' ); ?>
			</span>
		<?php endif ?>
	</div>
	<div class="comments-link">
		<span>
			<a href="<?php comments_link(); ?>">
			    <?php echo __('Comments', 'roots'); ?>
			</a>
		</span>
	</div>
	<div class="clearfix"></div>
</div>