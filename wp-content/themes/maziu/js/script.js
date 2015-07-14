jQuery(function($) {

    $(document).on('click', '.tf-toggle', function() {
        var t = $(this);
        var $show = t.attr('data-show');

        if ($show == 'true')
        {
            t.attr('data-show', 'false');
            t.parent().addClass('tf-close');
        } else {
            t.attr('data-show', 'true');
            t.parent().removeClass('tf-close');
        }
    });
	
	// Search toggle
	$(document).on('click', '#site-search-box .search-button', function() {
		$(this).closest('form').find('.search-modal').addClass('show');
	});
	
	$(document).on('click', '.search-modal-inner .fa-times', function() {
		$(this).closest('.search-modal').removeClass('show');
	});
	
	$(document).on('click', '.search-input-wrap .fa-search', function() {
		$(this).closest('form').submit();
	});

    // Gallery post slide
    $('article > .gallery').bxSlider({
        pager: false,
        nextText: '<span class="main-border-hover main-color-hover ease-transition"><i class="fa fa-angle-right main-color-hover main-border-hover ease-transition"></i></span>',
        prevText: '<span class="main-border-hover main-color-hover ease-transition"><i class="fa fa-angle-left main-color-hover main-border-hover ease-transition"></i></span>'
    });
	
});
