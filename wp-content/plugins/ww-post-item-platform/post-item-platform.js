(function ($) {
    var $switchHideItem = $('.switch_hide_item');
    $switchHideItem.lc_switch('YES', 'NO');

    var $switchRelNoFollow = $('.switch_is_rel_nofollow');
    $switchRelNoFollow.lc_switch('YES', 'NO');

    $(document).on('lcs-statuschange', '.switch_hide_item, .switch_is_rel_nofollow', function () {
        var $this = $(this);
        var status = ($(this).is(':checked')) ? 1 : 0;
        var $switch;
        var data = {'item_id': this.value};

        if ($this.hasClass('switch_is_rel_nofollow')) {
            $switch = $switchRelNoFollow;
            data['action'] = 'post_item_platform_rel_nofollow';
            data['is_rel_nofollow'] = status;
        } else {
            $switch = $switchHideItem;
            data['action'] = 'post_item_platform_hide_page';
            data['status'] = status;
        }

        $switch.lcs_destroy();
        $switch.prop('disabled', true).lc_switch('YES', 'NO');

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            dataType: 'json'
        }).done(function (response) {
            if (response.success) {
                $switch.lcs_destroy();
                $switch.prop('disabled', false).lc_switch('YES', 'NO');
            }
        });
    });


})(jQuery);