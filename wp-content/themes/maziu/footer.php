        <footer id="page-footer">

            <div id="footer-sidebar">
                <div class="content">
                    <div class="content-inner clearfix">
						<?php dynamic_sidebar('sidebar-2'); ?>
                    </div><!-- .content-inner -->
                </div><!-- .content -->
            </div><!-- #footer-sections -->
			
			<div id="footer-bottom">
				<div id="bottom-menu-wrap">
					<div class="content">
						<div class="content-inner">
							<nav>
								<?php wp_nav_menu(array('theme_location' => 'mainmenu', 'menu_class' => 'nav-menu clearfix', 'menu_id' => 'bottom-menu')) ?>
							</nav>
						</div><!-- .content-inner -->
					</div><!-- .content -->
				</div><!-- #bottom-menu -->
			
				<div id="page-copyright">
					<div class="content">
						<div class="content-inner">
							<p>Copyright © 2015 Maziu.com<br />Design by <a href="#">MIGTheme</a></p>
						</div><!-- .content-inner -->
					</div><!-- .content -->
				</div><!-- #page-copyright -->
			</div><!-- #bottom-menu -->
        </footer><!-- #page-footer -->

    </div>
	
	<div id="loader-wrap" class="ease-transition">
		<div id="loader-img"></div>
	</div><!-- #loader-wrap -->

    <?php wp_footer(); ?>

</body>
