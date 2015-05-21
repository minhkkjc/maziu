<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">
        <title><?php wp_title('-', true, 'right') ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div id="page-wrap">

            <header id="page-header">

                <div id="top-header">
                    <div class="content">
                        <div class="row">
                            <div class="container-fluid">

                                <div id="th-left" class="col-md-6 col-sm-6">
                                    <ul class="clearfix">
                                        <li>
											<div>
												<label for="language"><?php echo __('Language', 'maziu'); ?>:</label>
												<select id="language">
													<option>English</option>
													<option>Vietnamese</option>
												</select>
												<i class="fa fa-sort-desc"></i>
											</div>
                                        </li>
                                        <li>
											<div>
												<label for="currency"><?php echo __('Currency', 'maziu'); ?>:</label>
												<select id="currency">
													<option>USD</option>
													<option>VND</option>
												</select>
												<i class="fa fa-sort-desc"></i>
											</div>
                                        </li>
                                    </ul>
                                </div><!-- #th-left -->

                                <div id="th-right" class="col-md-6 col-sm-6">
                                    <div id="site-search-box"><?php get_search_form(); ?></div>
                                    <div id="site-social"><?php echo do_shortcode('[socials class="main-color-hover"]'); ?></div>
                                </div><!-- #th-right -->

                            </div>
                        </div>
                    </div>
                </div><!-- #top-header -->

				<div id="logo">
					<div class="content">
						<div class="row">
                            <div class="container-fluid">
                                <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" />
                                </a>
                            </div>
						</div>
					</div>
				</div><!-- #logo -->
				
                <div id="main-menu-wrap">
                    <div class="content">
                        <div class="row">
                            <div class="container-fluid">
                                <nav>
                                    <?php wp_nav_menu( array( 'theme_location' => 'mainmenu', 'menu_class' => 'nav-menu clearfix', 'menu_id' => 'main-menu')) ?>
                                </nav><!-- #main-menu -->
                            </div>
						</div>
                    </div>
                </div><!-- #main-menu-wrap -->
            </header><!-- #page-header -->