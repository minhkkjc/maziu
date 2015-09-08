jQuery(function($) {

    $(document).on('click', '.tf-toggle', function() {
        var t = $(this);
        var show = t.attr('data-show');

        if (show == 'true')
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
    $('.post-thumbnail .gallery, article .gallery').bxSlider({
        pager: false,
        nextText: '<span class="main-border-hover main-color-hover ease-transition"><i class="fa fa-angle-right"></i></span>',
        prevText: '<span class="main-border-hover main-color-hover ease-transition"><i class="fa fa-angle-left"></i></span>'
    });

    $(window).load(function() {
		$('#page-wrap').animate({'opacity' : 1}, 400);
		$('#loader-wrap').addClass('hide');
    });
	
	// Socials toggle
	$(document).on('click', '.socials-btn', function() {
		var toggle = $(this).data('toggle');
		var list = $(this).parent().find('ul.post-socials-list');
		var count = list.find('li').size();
		
		if (toggle == 0) {
			$(this).data('toggle', 1);
			$(this).addClass('main-border main-color');
			
			var i = 0;
			var displaySocials = setInterval(function() {
				list.find('li').eq(i).find('a').removeClass('transparent');
				i++;
				
				if (i == count) {
					clearInterval(displaySocials);
				}
			}, 100); 
		} else {
			$(this).data('toggle', 0);
			$(this).removeClass('main-border main-color');
			
			var i = count - 1;
			var displaySocials = setInterval(function() {
				list.find('li').eq(i).find('a').addClass('transparent');
				i--;
				
				if (i == -1) {
					clearInterval(displaySocials);
				}
			}, 100); 
		}
	});
	
	// Ajax submit comments
	$(window).load(function() {
		var commentForm = $('#commentform');
		
		commentForm.submit(function() {
			var author = commentForm.find('#author');
			var email = commentForm.find('#email');
			var comment = commentForm.find('#comment');
			
			if (author.hasClass('required')) {
				if (author.val() == '') {
					author.addClass('input-required');
					
					var comment_form = $('#respond').offset();
					$('html, body').animate({'scrollTop' : comment_form.top - 20});
					
					return false;
				}
			}
			
			if (email.hasClass('required')) {
				if (email.val() == '') {
					email.addClass('input-required');
					
					var comment_form = $('#respond').offset();
					$('html, body').animate({'scrollTop' : comment_form.top - 20});
					
					return false;
				}
			}
			
			if (comment.val() == '') {
				comment.addClass('input-required');
				
				var comment_form = $('#respond').offset();
				$('html, body').animate({'scrollTop' : comment_form.top - 20});
				
				return false;
			}
			
			return true;
		});
		
		commentForm.find('input[type="text"], textarea').focus(function() {
			$(this).removeClass('input-required');
		});
	});
	
});
