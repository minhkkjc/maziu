<form method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="search-modal easeout-transition">
		<div class="search-modal-inner">
			<i class="fa fa-times"></i>
			<div class="search-input-wrap">
				<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Enter Type & Hit Enter..', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
				<i class="fa fa-search main-color"></i>
			</div><!-- .search-input-wrap -->
		</div><!-- .search-modal-inner -->
	</div><!-- .search-modal -->
	
	<div class="search-button main-bg-hover-child">
		<input type="button" class="search-submit easeout-transition" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
	</div><!-- .search-button -->
</form><!-- .search-form -->