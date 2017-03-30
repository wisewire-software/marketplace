(function ($) {
    //$('.switch_hide_item').lc_switch('YES', 'NO');
    //
    //$(document).on('lcs-statuschange', '.switch_hide_item', function () {
    //    var status = ($(this).is(':checked')) ? 1 : 0;
    //    var $this = $(this);
    //    $this.lcs_destroy();
    //    $this.prop('disabled', true).lc_switch('YES', 'NO');
    //
    //    $.ajax({
    //            type: "POST",
    //            url: ajaxurl,
    //            data: {
    //                'action': 'post_item_hide_page',
    //                'item_id': this.value,
    //                'status': status
    //            },
    //            dataType: 'json'
    //        })
    //        .done(function (response) {
    //            if(response.success){
    //                $this.lcs_destroy();
    //                $this.prop('disabled', false).lc_switch('YES', 'NO');
    //            }
    //        });
    //});


    var $switchHideItem = $('.switch_hide_item');
    $switchHideItem.lc_switch('YES', 'NO');

    $(document).on('lcs-statuschange', '.switch_hide_item', function () {
        var status = ($(this).is(':checked')) ? 1 : 0;

        $switchHideItem.lcs_destroy();
        $switchHideItem.prop('disabled', true).lc_switch('YES', 'NO');

        $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action': 'post_item_hide_page',
                    'item_id': this.value,
                    'status': status
                },
                dataType: 'json'
            })
            .done(function (response) {
                if(response.success){
                    $switchHideItem.lcs_destroy();
                    $switchHideItem.prop('disabled', false).lc_switch('YES', 'NO');
                }
            });
    });


})(jQuery);