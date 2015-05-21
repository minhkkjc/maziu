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

});
