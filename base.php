<?php
	global $theme_options;
	get_template_part('templates/head');
?>
<body <?php body_class(); ?>>
	<!--[if lt IE 8]>
		<div class="alert alert-warning">
			<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
		</div>
	<![endif]-->

	<?php if ($theme_options['layout'] == 'boxed'): ?>
		<div class="container boxed">
	<?php endif ?>

 	<?php
		do_action('get_header');
		get_template_part('templates/header-' . $theme_options['site_header_style']);
	?>

  	<div class="wrap" role="document">
  		<?php get_template_part('templates/titles'); ?>
  		<?php if (is_page()): ?>
  			<div class="content">
  				<div class="inner">
  		<?php else: ?>
  			<div class="content container">
  				<div class="inner bloged">
  		<?php endif ?>
				<main class="main <?php echo roots_main_class(); ?> no-padding" role="main">
					<?php include roots_template_path(); ?>
				</main><!-- /.main -->

				<?php if (roots_display_sidebar() ) : ?>
					<aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
						<div class="sidebar-holder-right">
							<?php include roots_sidebar_path(); ?>
						</div>
					</aside><!-- /.sidebar -->
				<?php endif; ?>

			</div><!-- /.inner -->
		</div><!-- /.content -->
	</div><!-- /.wrap -->

	<?php get_template_part('templates/footer'); ?>

	<?php if ($theme_options['layout'] == 'boxed'): ?>
		</div><!-- /.boxed -->
	<?php endif ?>

</body>
</html>
