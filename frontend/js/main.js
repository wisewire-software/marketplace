$(function () {
  
  var carouselHome = $('.lo-carousel-home .carousel'),
      carouselTestimonials = $('.testimonials .carousel'),
      carouselItems = $('.lo-carousel .carousel'),
      contentAccordion = $('.content-accordion [data-toggle=tab]'),
      popoverTestimonials = $('.testimonials [data-toggle="popover"]'),
      popoverHeader =  $('.btn-header-search[data-toggle="popover"]'),
      popoverPartnerLogos = $('.partner-logos [data-toggle="popover"]'),
      popoverBtnFavoriteNotLoggedIn = $('.btn-favorite-not-loggedin'),
      popoverBtnHeaderFavorite = $('#btn-header-favorite'),
      navbarToggle = $('.navbar-toggle'),
      btnMore = $('.publish .more a, .detail article .more a, .custom-intro .more a'),
      btnShowMore = $('.detail .details-content .btn-details'),
      tooltipPostNav = $('.post-nav [data-toggle="tooltip"]'),
      btnRegister = $('#btn-register'),
      btnGrid =  $('.items .options .grid a'),
      sectionViewGrid = $('#section-view-grid'),
      sectionViewList = $('#section-view-list'),
      btnFiltersOverlayOpen = $('#btn-filters-overlay-open'),
      btnFiltersOverlayClose = $('#btn-filters-overlay-close'),
      btnHeaderFiltersOverlayClose = $('#btn-header-filters-overlay-close'),
      filtersOverlay = $('#filters-overlay'),
      carouselDemoViewer = $('.modal-preview .carousel');
  
	// Smooth scrolling
  $('a.scroll[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
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
  contentAccordion.click(function() {
    var tab = $(this);
    if(tab.parent('li').hasClass('active')) {
      setTimeout(function(){
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
    Only for not touchable devices
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
  
  if (!Modernizr.touch) {
    popoverHeader.popover({
      container: '.navbar-nav',
      html: true,
      placement: 'bottom',
      trigger: 'click',
      template: '<div class="popover popover-search" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
    });
    popoverHeader.click(function(e) {
      e.preventDefault();
    });      
  }  
  
  popoverBtnFavoriteNotLoggedIn.popover({
    container: 'body',
    html: true,
    placement: 'bottom',
    trigger: 'click',
    template: '<div class="popover popover-favorite-notloggedin" role="tooltip"><div class="arrow"></div><div class="wrapper"><div class="popover-content"></div></div></div>'
  });
  
  popoverBtnFavoriteNotLoggedIn.click(function(e) {
    e.preventDefault();
  });   
  
  popoverBtnHeaderFavorite.click(function(e) {
    e.preventDefault();
    $('#favoritePopover').toggle();
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
  navbarToggle.on('click', function(){
    $('.body-overlay').toggle();
  });
  
  /*
    Read more / less
    Publish Page
    Detail Page
  */
  btnMore.click(function(e) {
    e.preventDefault();
    if ( $(this).hasClass('hidemore')) {
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
  btnShowMore.click(function(e) {
    e.preventDefault();
    if ( $(this).hasClass('hidemore')) {
      $(this).removeClass('hidemore').addClass('showmore');
    } else {
      $(this).removeClass('showmore').addClass('hidemore');
    }
  });
  
  /* iframe on the detail page */
  $('a.btn-iframe').on('click', function(e) {
    var src = $(this).attr('data-src');
    $("#previewModal iframe").attr({'src':src});
  });
  
  /* iframe on the tei demo gallery page */
  $('a.btn-iframe-tei-demo').on('click', function(e) {
    var src = $(this).attr('data-src');
    var title = $(this).parents('li').find('p').text();

    var height = $(this).attr('data-height') || 600;
    var width = $(this).attr('data-width') || 1020;

    $('#previewModal #subhead').text(title);
    $("#previewModal iframe").attr({'src':src,
                               'height': height,
                               'width': width});
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
  btnRegister.click(function(e) {
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
  
  $document.scroll(function() {
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
  btnGrid.click(function(e) {
    e.preventDefault();  
    
    var linkID = $(this).attr('id');

    $(this).parent('.grid').find('a').removeClass('active');
    $(this).toggleClass('active');
    
    if (linkID == 'btn-view-grid') {
      sectionViewList.hide();
      sectionViewGrid.show();
    } else if (linkID == 'btn-view-list') {
      sectionViewGrid.hide();
      sectionViewList.show();
    }
  });
  
  /*
    Explore All Page
    Button Filters Overlay - open an overlay
  */
  
  btnFiltersOverlayOpen.click(function(e) {
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
  });    
  
  /*
    Ratings
  */
  $('.rating-write').barrating({
    wrapperClass: 'rate-stars'
  });  
  
});


function arrowsCarousel() {
  /*
    Learning Objects Carousel
    Fix arrow position and set it to be in the middle of the image
  */
  if (Modernizr.mq('(min-width: 480px)')) {
    var imgH = $('.lo-carousel-home .carousel .lo-item img').height();
    $('.lo-carousel-home .carousel .slick-arrow').css('top', (imgH/2)-10);
  }   
}


// https://css-tricks.com/snippets/jquery/done-resizing-event/
var resizeTimer;
$(window).on('resize', function(e) {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {
  
    $('#tabs-list-1 li, #tabs-list-2 li, .lo-carousel-home .lo-item, .testimonial .col-left, .testimonial .col-right').matchHeight();
    
    arrowsCarousel();
      
  }, 250);

});

$(window).load(function() {
  
  /*
    matchHeight
    equal columns
    https://github.com/liabru/jquery-match-height
  */
  $('#tabs-list-1 li, #tabs-list-2 li, .lo-carousel-home .lo-item, .testimonial .col-left, .testimonial .col-right').matchHeight();
          
  arrowsCarousel();
 
});
