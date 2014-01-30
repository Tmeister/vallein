<?php while (have_posts()) : the_post(); ?>

  <div class="row">
  	<div class="col-lg-5">
		<?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
			<div class="edd_download_image">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'shop-single' ); ?>
			</div>
		<?php endif; ?>
  	</div>
  	<div class="col-lg-7 description">
  		<h2 class="no-margin-top entry-title"><?php the_title(); ?></h2>
  		<div class="excerpt">
  			<?php the_excerpt(); ?>
  			<hr>
			<?php echo do_shortcode( '[purchase_link id="'.get_the_ID().'" color="flat"]' );?>
  		</div>
  	</div>
  </div>
  <div class="row">
  	<div class="col-lg-12">
  		<div class="full-description">
  			<div class="row">
  				<div class="col-lg-5">
			  		<div class="tab">
			  			<ul class="no-margin no-padding">
			  				<li><?php echo __('Product Description','eclang') ?></li>
			  			</ul>
			  		</div>
		  		</div>
	  		</div>
	  		<div class="row">
	  			<div class="col-lg-12">
	  				<div class="divider"></div>
	  			</div>
	  		</div>
	  		<div class="row">
	  			<div class="col-lg-12">
			  		<div class="product-description">
			  			<div class="inner">
			  				<?php the_content(); ?>
			  			</div>

			  		</div>
			  	</div>
			</div>
  		</div>
  	</div>
  </div>
<?php endwhile; ?>
