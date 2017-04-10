$(function () {

    var carouselHome = $('.lo-carousel-home .carousel'),
        carouselTestimonials = $('.testimonials .carousel'),
        carouselItems = $('.lo-carousel .carousel'),
        carouselFeaturedAuthors = $('.lo-authors .carousel'),
        contentAccordion = $('.content-accordion [data-toggle=tab]'),
        popoverTestimonials = $('.testimonials [data-toggle="popover"]'),
        popoverHeaderSearch = $('.btn-header-search[data-toggle="popover"]'),
        popoverPartnerLogos = $('.partner-logos [data-toggle="popover"]'),
        popoverBtnFavoriteNotLoggedIn = $('.btn-favorite-not-loggedin'),
        popoverBtnAddDashboardNotLoggedIn = $('.btn-add-dashboard-not-loggedin'),
        popoverBtnRateitNotLoggedIn = $('.btn-rateit-not-loggedin'),
        popoverBtnPublishNotLoggedIn = $('.btn-publish-not-loggedin'),
        popoverBtnHeaderFavorite = $('#btn-header-favorite'),
        navbarToggle = $('.navbar-toggle'),
        btnMore = $('.publish .more a, .detail article .more a, .custom-intro .more a'),
        btnShowMore = $('.detail .details-content .btn-details'),
        tooltipPostNav = $('.post-nav [data-toggle="tooltip"]'),
        btnRegister = $('#btn-register'),
    //btnGrid =  $('.items .options .grid a'),
    //sectionViewGrid = $('#section-view-grid'),
    //sectionViewList = $('#section-view-list'),
        btnFiltersOverlayOpen = $('#btn-filters-overlay-open'),
        btnFiltersOverlayClose = $('#btn-filters-overlay-close'),
        btnHeaderFiltersOverlayClose = $('#btn-header-filters-overlay-close'),
        filtersOverlay = $('#filters-overlay'),
        carouselDemoViewer = $('.modal-preview .carousel');

    function isUrlValid(url) {
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }

    // Redirect search form to search page (explore all page)
    $('#header').delegate('.searchform', 'submit', function (e) {
        e.preventDefault();

        if (isUrlValid($(this).find('[name="s"]').val())) {
            alert("Please enter a valid text.");
            return false;
        }

        location.href = '/explore/search/' + encodeURI($(this).find('[name="s"]').val()) + '/';
        return false;
    });
    $('.main-search').delegate('.searchform', 'submit', function (e) {
        e.preventDefault();

        if (isUrlValid($(this).find('[name="s"]').val())) {
            alert("Please enter a valid text.");
            return false;
        }

        location.href = '/explore/search/' + encodeURI($(this).find('[name="s"]').val()) + '/';
        return false;
    });

    // Smooth scrolling
    $('a.scroll[href*=#]:not([href=#])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 500);
                return false;
            }
        }
    });

    /*
     Slick - Content Carousel
     https://github.com/kenwheeler/slick/
     */

    carouselHome.slick({
        dots: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        accessibility: false,
        draggable: true,
        dots: false,
        lazyLoad: 'progressive',
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: true,
                    arrows: false
                }
            }
        ]
    });

    // Testimonials Carousel
    carouselTestimonials.slick({
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 4,
        accessibility: false,
        draggable: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    draggable: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    arrows: false
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: true,
                    arrows: false
                }
            }
        ]
    });

    // Items Carousel e.g. Explore Page
    carouselItems.slick({
        dots: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        accessibility: false,
        draggable: true,
        dots: false,
        infinite: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: true,
                    arrows: false
                }
            }
        ]
    });


    /*
     * This will show the carousel in the explore section, the carousel will work
     * automatically and will change every minute
     */
    carouselFeaturedAuthors.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        accessibility: false,
        draggable: true,
        autoplay: true,
        arrows: false,
        adaptiveHeight: true,
        autoplaySpeed: 60000,
        pauseOnHover: false
    });

    if (carouselFeaturedAuthors.length) {

        setInterval(function () {

            $.post('https://' + window.location.hostname + '/wp-admin/admin-ajax.php', {action: 'list_featured'}, function (data) {
                data = $.parseJSON(data);

                var authors_showing = [];

                $.each($(".carousel .wrapper"), function (index) {
                    var a = $(this).data("author").toString();
                    if (authors_showing.indexOf(a) == -1) {
                        authors_showing.push(a);
                    }
                });

                $.each(data, function (index, value) {
                    //verify if authors from database exist in the carousel, if not, add them
                    if (authors_showing.indexOf(value.id) == -1) {

                        carouselFeaturedAuthors.slick('slickAdd', '<div style="width:940px; height:340px" class="wrapper" data-author="' + value.id + '" ><a target="_blank" href="' + value.externalPreviewURL + '">' +
                            '<div class="img">             ' +
                            '<img width="940px" height="340px" src="https://wisewire.com/wp-content/uploads/2015/09/placeholder-content-type-2-940x340.png" class="img-responsive">' +
                            '</div>' +
                            '<div class="content">' +
                            '<h1>' + value.author + '</h1>' +
                            '<p>' + value.shortBio + '</p>' +
                            '</div>' +
                            '<div class="user_avatar">' +
                            '<img src="' + value.profilePicUrl + '" alt="">' +
                            '</div>' +
                            '<div class="text_featured">' +
                            '<div class="h3">Pending Wisewire Author.<br>Keep an eye on this one!</div>' +
                            'Congratulations on completing the process to become a Wisewire Author. As a Wisewire Author, you no longer have to wait for your items to be approved — they will become public as soon as you publish them. We are honored that you choose to join our respected authors to make high quality items available to the greater educational community.' +
                            '</div>' +
                            '</a></div>');
                    } else {
                        authors_showing.splice($.inArray(value.id, authors_showing), 1);
                    }

                });

                //Delete authors that aren't in the database
                if (authors_showing.length > 0) {

                    for (var i = 0; i < authors_showing.length; i++) {

                        if (authors_showing[i] != -1) {
                            index = $(".carousel .wrapper[data-author='" + authors_showing[i] + "']:not(.slick-cloned)").data("slick-index") + 1;

                            if ($(".carousel .wrapper").length > 1) {
                                if (!$(".carousel .wrapper[data-index='" + index + "']").hasClass("slick-active")) {
                                    carouselFeaturedAuthors.slick("slickRemove", index, true);
                                }
                            } else {
                                carouselFeaturedAuthors.slick("slickRemove", index, true);
                            }

                            var j = -1;
                            $(".lo-authors .slick-slide").each(function () {
                                $(this).attr("data-slick-index", j);
                                j++;
                            });
                        }

                    }
                }

                /*
                 * If there is no more featured authors to show, featured content must be showed
                 */
                if (data.length == 0) {
                    $(".featured_banner_pending_authors").hide();
                    $(".featured_content_home_logged_in").show();
                } else {
                    $(".featured_banner_pending_authors").show();
                    $(".featured_content_home_logged_in").hide();
                }

                $(window).trigger('resize');
                carouselFeaturedAuthors.slick('slickNext');

            });
        }, 60000);
    }
    ;

    // Demo Viewer Carousel
    $('#previewModal').on('shown.bs.modal', function () {
        carouselDemoViewer.slick({
            accessibility: false,
            draggable: true,
            slidesToShow: 1,
            adaptiveHeight: true,
            dots: true,
            arrows: true,
            responsive: [
                {
                    breakpoint: 480,
                    settings: {
                        dots: false,
                        arrows: false
                    }
                }
            ]
        });
    });

    // Allow to close an active tab
    contentAccordion.click(function () {
        var tab = $(this);
        if (tab.parent('li').hasClass('active')) {
            setTimeout(function () {
                $(".tab-pane").removeClass('active');
                tab.parent('li').removeClass('active');
            });
        } else {
            tab.tab('show');
        }
    });

    /*
     Popovers
     http://getbootstrap.com/javascript/#popovers
     */

    if (!Modernizr.touch) {
        popoverTestimonials.popover({
            container: 'body',
            html: true,
            placement: 'bottom',
            trigger: 'hover',
            template: '<div class="popover popover-quote" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div><div class="popover-title"></div></div></div>'
        });
    }

    popoverHeaderSearch.popover({
        container: '.navbar-nav',
        html: true,
        placement: 'bottom',
        trigger: 'click',
        template: '<div class="popover popover-search" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
    });
    popoverHeaderSearch.click(function (e) {
        e.preventDefault();
        $('#favoritePopover').hide();
        $('#logout').on('shown.bs.dropdown', function () {
            $('#logout').dropdown('toggle');
        });
    });

    popoverBtnFavoriteNotLoggedIn.popover({
        container: 'body',
        html: true,
        placement: 'bottom',
        trigger: 'click',
        template: '<div class="popover popover-favorite-notloggedin" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
    });

    popoverBtnFavoriteNotLoggedIn.click(function (e) {
        e.preventDefault();
        popoverBtnRateitNotLoggedIn.popover('hide');
    });

    popoverBtnRateitNotLoggedIn.popover({
        container: 'body',
        html: true,
        placement: 'bottom',
        trigger: 'click',
        template: '<div class="popover popover-favorite-notloggedin" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
    });

    popoverBtnRateitNotLoggedIn.click(function (e) {
        e.preventDefault();
        popoverBtnFavoriteNotLoggedIn.popover('hide');
    });

    popoverBtnPublishNotLoggedIn.popover({
        container: 'body',
        html: true,
        placement: 'bottom',
        trigger: 'click',
        template: '<div class="popover popover-favorite-notloggedin popover-publish" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
    });

    popoverBtnPublishNotLoggedIn.click(function (e) {
        e.preventDefault();
    });


    popoverBtnAddDashboardNotLoggedIn.popover({
        container: 'body',
        html: true,
        placement: 'bottom',
        trigger: 'click',
        template: '<div class="popover popover-favorite-notloggedin" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
    });

    popoverBtnAddDashboardNotLoggedIn.click(function (e) {
        e.preventDefault();
    });


    $('.menu-item-user').on('show.bs.dropdown', function () {
        popoverHeaderSearch.popover('hide');
        $('#favoritePopover').hide();
    });


    $('#header').delegate('#btn-header-favorite', 'click', function (e) {
        e.preventDefault();
        $('#favoritePopover').toggle();
        popoverHeaderSearch.popover('hide');
        $('#logout').on('shown.bs.dropdown', function () {
            $('#logout').dropdown('toggle');
        });
    });

    $('.btn-add-favorite').click(function (e) {
        e.preventDefault();
        var fthis = $(this);
        $.post('https://' + window.location.hostname + '/wp-admin/admin-ajax.php', {
            action: 'add_favorite',
            my_action: 'Favorites|action_add',
            item_id: $(this).data('item_id'),
            item_type: $(this).data('item_type'),
            item_source: $(this).data('item_source')
        }, function (data) {
            $('#header-favorites').replaceWith(data);

            fthis.popover({
                container: 'body',
                html: true,
                placement: 'bottom',
                trigger: 'click',
                template: '<div class="popover popover-favorite-notloggedin" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
            }).popover('show');
            setTimeout(function (i) {
                i.popover('hide');
            }, 2000, fthis);

            $('.btn-add-favorite').fadeOut(function () {
                $('.btn-remove-favorite').fadeIn();
            });
        });
    });

    $('.btn-remove-favorite').click(function (e) {
        e.preventDefault();
        var fthis = $(this);
        $.post('https://' + window.location.hostname + '/wp-admin/admin-ajax.php', {
            action: 'remove_favorite',
            my_action: 'Favorites|action_remove',
            item_id: $(this).data('item_id'),
            item_type: $(this).data('item_type')
        }, function (data) {
            $('#header-favorites').replaceWith(data);

            fthis.popover({
                container: 'body',
                html: true,
                placement: 'bottom',
                trigger: 'click',
                template: '<div class="popover popover-favorite-notloggedin" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
            }).popover('show');
            setTimeout(function (i) {
                i.popover('hide');
            }, 2000, fthis);

            $('.btn-remove-favorite').fadeOut(function () {
                $('.btn-add-favorite').fadeIn();
            });
        });
    });

    $('.rate-form').submit(function (e) {
        e.preventDefault();
        console.log('submit rate');
        var fthis = $(this);
        $.post('https://' + window.location.hostname + '/wp-admin/admin-ajax.php', fthis.serialize(), function (data) {
            console.log(data);
            $('.br-widget-medium').replaceWith(data.br_widget_medium);
            $('.rate-number').html(data.rate);
            $('#rateModal').modal('hide');
        }, 'json');
        return false;
    });


    $('.remove-rating').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var dataParams = $this.data();
        dataParams.action = 'do_rate';

        $.post('https://' + window.location.hostname + '/wp-admin/admin-ajax.php', dataParams, function (data) {
            $('.br-widget-medium').replaceWith(data.br_widget_medium);
            $('.rate-number').html('');
            $('#rateModal').modal('hide');
        }, 'json');
    });


    /*
     Rework so popover stays open on hover
     http://stackoverflow.com/a/19684440
     */
    popoverPartnerLogos.popover({
        container: 'body',
        html: true,
        placement: 'bottom',
        trigger: 'click',
        template: '<div class="popover popover-quote popover-partner-logos" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div><div class="popover-title"></div></div></div>'
    }).on("mouseenter", function () {
        var _this = this;
        $(this).popover("show");
        $(".popover").on("mouseleave", function () {
            $(_this).popover('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 150);
    });


    /*
     Mobile Header Menu
     */
    navbarToggle.on('click', function () {
        $('.body-overlay').toggle();
    });

    /*
     Read more / less
     Publish Page
     Detail Page
     */
    btnMore.click(function (e) {
        e.preventDefault();
        if ($(this).hasClass('hidemore')) {
            $(this).find('strong').text("Read more");
            $(this).removeClass('hidemore').addClass('showmore');
        } else {
            $(this).find('strong').text("Read less")
            $(this).removeClass('showmore').addClass('hidemore');
        }
    });

    /*
     Show more / less
     Details Content Button on the Detail Page
     */
    btnShowMore.click(function (e) {
        e.preventDefault();
        if ($(this).hasClass('hidemore')) {
            $(this).removeClass('hidemore').addClass('showmore');
        } else {
            $(this).removeClass('showmore').addClass('hidemore');
        }
    });

    /*
     Detail Page - Next / Previous Tooltips
     */
    if (!Modernizr.touch) {
        tooltipPostNav.tooltip();
    }

    /*
     Login
     Show create an account section
     */
    btnRegister.click(function (e) {
        e.preventDefault();
        $(this).hide();
        $('#create-account').show();
    });

    /*
     Back to top button
     Mobile / Explore Page
     When user scrolls beyond 1000 px, back to top button appears below
     */
    var $document = $(document),
        $element = $('#back-to-top'),
        className = 'back-show';

    $document.scroll(function () {
        if ($document.scrollTop() >= 800) {
            $element.addClass(className);
        } else {
            $element.removeClass(className);
        }
    });

    /*
     Bootstrap select
     https://github.com/silviomoreto/bootstrap-select
     */
    $('.select').selectpicker({
        style: 'btn-select'
    });

    /*
     Explore ALL
     Grid Button - View Grid or List
     */
    /*btnGrid.click(function(e) {
     e.preventDefault();

     var linkID = $(this).attr('id');

     $(this).parent('.grid').find('a').removeClass('active');
     $(this).toggleClass('active');

     if (linkID == 'btn-view-grid') {
     $('#section-view-list').hide();
     $('#section-view-grid').show();
     } else if (linkID == 'btn-view-list') {
     $('#section-view-grid').hide();
     $('#section-view-list').show();
     }
     });*/

    /*
     Explore All Page
     Button Filters Overlay - open an overlay
     */

    /*btnFiltersOverlayOpen.click(function(e) {
     e.preventDefault();
     filtersOverlay.addClass('active');
     });

     btnFiltersOverlayClose.click(function(e) {
     e.preventDefault();
     filtersOverlay.removeClass('active');
     });

     btnHeaderFiltersOverlayClose.click(function(e) {
     e.preventDefault();
     filtersOverlay.removeClass('active');
     });*/

    /*
     Ratings
     */
    $('.rating-write').barrating({
        wrapperClass: 'rate-stars'
    });

    /**
     * Other
     */
    function createCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function confirm(message, callback) {
        var $confirmModal =
            $("<div class='modal modal-confirm' tabindex='-1' role='dialog' aria-hidden='true'>" +
                "<div class='modal-dialog'>" +
                "<div class='modal-content'>" +
                "<div class='modal-body'>" +
                "<div>" + message + "</div>" +
                "</div>" +
                "<div class='modal-footer'>" +
                "<button data-wan-confirm='cancel' type='button' class='btn btn-default' data-dismiss='modal' >Cancel</button>" +
                "<button data-wan-confirm='ok' type='button' class='btn btn-primary'>OK</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");

        $confirmModal.find('.modal-body').append('<div class="wrapper-hide-confirm"><input  type="checkbox" value="1" /> Do not ask me again during this session.</div>');

        $confirmModal.find('button[data-wan-confirm="ok"]').click(function (e) {
            e.preventDefault();
            callback($confirmModal);
            $confirmModal.modal('hide');
        });

        $confirmModal.modal({
            backdrop: "static",
            keyboard: false,
            show: false
        });

        $confirmModal.modal('show');
    }

    $('.btn-confirm').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var isHideConfirm = readCookie('is_hide_dialog_favorite');

        if (!isHideConfirm) {
            confirm($this.attr('title'), function ($modal) {
                if ($modal.find('input:checkbox')[0].checked) {
                    createCookie('is_hide_dialog_favorite', 1);
                }
                window.location.href = $this.attr('href');
                //$.post($this.attr('href'), function (data) {
                //    window.location.reload();
                //});
            });
        } else {
            window.location.href = $this.attr('href');
            //$.post($this.attr('href'), function (data) {
            //    window.location.reload();
            //});
        }
    });

    /*
     IFrame on the detail page
     */
    $('a.btn-iframe').on('click', function (e) {
        var src = $(this).attr('data-src');

        var height = $(this).attr('data-height') || 500;

        var width = $(this).attr('data-width') || 1020;

        $("#previewModal iframe").attr({
            'src': src,
            'height': height,
            'width': width
        });

        if ($("#previewModalMerlot").length) {
            $("#previewModalMerlot iframe").attr({
                'src': src,
                'height': height,
                'width': width
            });
        }

    });

    /*
     IFrame on the tei demo gallery page
     */
    $('a.btn-iframe-tei-demo').on('click', function (e) {
        var src = $(this).attr('data-src');
        var title = $(this).parents('li').find('p').text();

        var height = $(this).attr('data-height') || 500;

        var width = $(this).attr('data-width') || 1020;

        $('#previewModal #subhead').text(title);
        $("#previewModal iframe").attr({
            'src': src,
            'height': height,
            'width': width
        });


    });

    // Accordion menu focus: when a accordion menu is expanded, focus should go to the start of the content

    $('.mobile-accordion, .content-accordion, .loggedin-accordion').on('shown.bs.collapse', function (e) {
        var offset = $(this).find('.collapse.in').prev('.panel-heading');
        if (offset) {
            $('html,body').animate({
                scrollTop: $(offset).offset().top
            }, 500);
        }
    });


});


function arrowsCarousel() {
    /*
     Learning Objects Carousel
     Fix arrow position and set it to be in the middle of the image
     */
    if (Modernizr.mq('(min-width: 480px)')) {
        var imgH = $('.lo-carousel-home .carousel .lo-item img').height();
        $('.lo-carousel-home .carousel .slick-arrow').css('top', (imgH / 2) - 10);
    }
}


// https://css-tricks.com/snippets/jquery/done-resizing-event/
var resizeTimer;
$(window).on('resize', function (e) {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {

        $('#tabs-list-1 li, #tabs-list-2 li, .lo-carousel-home .lo-item, .testimonial .col-left, .testimonial .col-right').matchHeight();

        arrowsCarousel();

    }, 250);

});

$(window).load(function () {

    /*
     matchHeight
     equal columns
     https://github.com/liabru/jquery-match-height
     */
    $('#tabs-list-1 li, #tabs-list-2 li, .lo-carousel-home .lo-item, .testimonial .col-left, .testimonial .col-right').matchHeight();

    arrowsCarousel();
});


$(window).resize(function () {

    $('.loggedin-accordion .panel-collapse').removeAttr('style');
});

$('#accessPlatformConfirm').on('show.bs.modal', function (e) {
    $href = $(e.relatedTarget).attr('href');
    $(this).find('.modal-body .go-link').prop('href', $href);
});

$('#accessExternalConfirm').on('show.bs.modal', function (e) {
    $href = $(e.relatedTarget).attr('href');
    $(this).find('.modal-body .go-link').prop('href', $href);
});

$("#accessExternalConfirm .go-link, #accessPlatformConfirm .go-link").on('click', function () {
    setTimeout(function () {
        $('.modal').modal('hide');
    }, 200);
})


if ($('#homevideoIframe').length) {
    $('#homevideoIframe').player('load', 'https://content.uplynk.com/3ddf769715c94004b998107d9225d8bd.m3u8');
}

$('#homeVideoModal').on('hidden.bs.modal', function () {
    $('#homevideoIframe').player('pause');
})

if ($('#publishVideoIframe2').length) {

    var swfURL = 'http://storage.uplynk.com/client/latest_upLynkPlayer.swf';
    var expressInstall = 'expressInstall.swf';
    var params = {
        'bgcolor': '#000000',
        'wmode': 'opaque'
    };
    var attrs = {};
    $('#publishVideoIframe2').player({
        swfURL: swfURL,
        exressInstall: expressInstall,
        params: params,
        attributes: attrs
    }, function () {
        $(this).player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');
    });

    //$('#teiVideoIframe').player('load', 'https://content.uplynk.com/3481cd8a05704e7b8ecd52693380856a.m3u8');
}

