jQuery(function($) {

    // Like post ajax
    $(document).on('click', '.post-like', function() {
        var pid = $(this).data('pid');
        var t = $('.post-like-' + pid);

        t.attr('class', 'fa fa-refresh fa-spin main-color post-like post-like-' + pid);

        $.post(
            likeAjax.ajaxurl,
            {
                'action': 'like_ajax',
                'pid' : pid,
            },
            function(response){
                //console.log(response); return;
                var result = $.parseJSON(response);
                if (!result.error) {
                    t.parent().find('.like-count').html(result.likes);

                    if (result.liked == 1) {
                        t.removeClass('fa-refresh fa-spin').addClass('fa-heart-o');
                    } else {
                        t.removeClass('fa-refresh fa-spin').addClass('fa-heart');
                    }
                }
            }
        );
    });
});