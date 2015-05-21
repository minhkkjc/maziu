jQuery(function($) {

    /*
        Load subsets for google font
     */
    $(document).on('change', '.google-font-family', function() {
        var t = $(this);
        var $font_val = t.val();

        $.ajax({
            method : 'GET',
            url : 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBgzCr9pt5xS09me72S91tTaCmLtAzWkOE',
            data: {},
            success: function(response) {
                var $subsets = response.items[$font_val].subsets;
                var $subsets_html = '';

                for ($key in $subsets)
                {
                    $subsets_html += '<option value="' + $key + '">' + $subsets[$key] + '</option>';
                }

                t.closest('table').find('.google-font-subset').html($subsets_html);
            },
        });
    });
});
