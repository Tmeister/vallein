<?php
    global $theme_options;
?>
<header class="banner default" role="banner">
    <section class="top-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <?php
                        if (has_nav_menu('top_left_navigation')){
                            wp_nav_menu(array('theme_location' => 'top_left_navigation', 'menu_class' => 'gp-top-nav'));
                        }
                    ?>
                </div>
                <div class="col-lg-6">
                    <?php
                        if (has_nav_menu('top_right_navigation')){
                            wp_nav_menu(array('theme_location' => 'top_right_navigation', 'menu_class' => 'gp-top-nav'));
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section class="main-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo-holder">
                        <a href="<?php echo home_url(); ?>">
                            <?php if ( !empty( $theme_options['site_logo']['url']) ): ?>
                                <img src="<?php echo $theme_options['site_logo']['url'] ?>" alt="<?php bloginfo('name'); ?>">
                            <?php else: ?>
                                <?php bloginfo('name'); ?>
                            <?php endif ?>
                        </a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <?php
                        if (has_nav_menu('primary_navigation')){
                            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'gp-main-nav','depth' => 3));
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
</header>