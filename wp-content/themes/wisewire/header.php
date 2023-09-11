<!doctype html>
<html dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
// Get an item title from single-item-platform.php

// check current user
// check page

// Set Title for Item
global $item_from_platform;
global $item_from_platform_title;
?>
    <?php if ($item_from_platform == true) {?>
    <title>
        <?php echo $item_from_platform_title; ?> - Wisewire</title>
    <?php } else {?>
    <title>
        <?php wp_title('|', true, 'right');?>
    </title>
    <?php }

// Set up Viewport and other header boilerplate
?>


    <?php $ww_image_dir = get_template_directory_uri();?>




    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url');?>">

    <?php // Include critical css ?>



    <!-- <link href='https://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'> -->

    <!--[if lt IE 9 ]>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" integrity="sha256-0rguYS0qgS6L4qVzANq4kjxPLtvnp5nn2nB5G1lWRv4=" crossorigin="anonymous"></script>
   <![endif]-->

    <!--[if gte IE 9]><style type="text/css">.gradient { filter: none; }</style><![endif]-->


    <link rel="apple-touch-icon" sizes="57x57" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$ww_image_dir?>/img/favicons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="<?=$ww_image_dir?>/img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?=$ww_image_dir?>/img/favicons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="<?=$ww_image_dir?>/img/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="<?=$ww_image_dir?>/img/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="<?=$ww_image_dir?>/img/favicons/manifest.json">
    <link rel="shortcut icon" href="<?=$ww_image_dir?>/img/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="<?=$ww_image_dir?>/img/favicons/mstile-144x144.png">
    <meta name="msapplication-config" content="<?=$ww_image_dir?>/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script>
    dataLayer = [];
    </script>

    <?php

global $post;
global $current_page;
global $total_pages_seo;
global $url_link;

if (get_post_type($post->ID) == 'page' && ($post->post_name == 'explore-all' || $post->post_name == 'most-viewed' || $post->post_name == 'filtered')) {

    if ($current_page > 1) {
        echo '<link rel="prev" href="' . $url_link . ($current_page - 1) . '" />';
    }
    if ($current_page < $total_pages_seo) {
        echo '<link rel="next" href="' . $url_link . ($current_page + 1) . '" />';
    }
}
?>

    <?php wp_head();?>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800|Noto+Sans:400,500,600,700,800"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
        integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        integrity="sha256-4hqlsNP9KM6+2eA8VUT0kk4RsMRTeS7QGHIM+MZ5sLY=" crossorigin="anonymous" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">



    <link rel="stylesheet" href="<?=$ww_image_dir?>/css/main-02-11-2019-8.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/explore.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/accordion.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/extra_styles-02-11-2019.css">
    <link rel="stylesheet" href="<?=$ww_image_dir?>/css/opm-update-02-11-2019-2.css">

    <script>
    var $ = jQuery.noConflict();
    </script>

</head>

<body <?php body_class();?>>
    <!-- fire teacher log in event to Google Tag Manager -->
    <?php if ($_SESSION['teacher_loggedin_form_event']) {?>
    <script>
    dataLayer.push({
        'event': 'teacherLogInFormSubmitted'
    });
    </script>
    <?php $_SESSION['teacher_loggedin_form_event'] = false;?>
    <?php }?>

    <!-- fire teacher registration event to Google Tag Manager -->
    <?php if ($_SESSION['teacher_reg_form_event']) {?>
    <script>
    dataLayer.push({
        'event': 'teacherRegFormSubmitted'
    });
    </script>
    <?php $_SESSION['teacher_reg_form_event'] = false;?>
    <?php }?>

    <?php // Include SVG icons that are made as sprites ?>
    <?php get_template_part('parts/svg', 'icons');?>

    <?php
global $current_user, $WWItems;
get_currentuserinfo();

$ww_is_search = isset($wp_query->query['search']);
$ww_isactive = 'class="active"';
$ww_home_url = esc_url(home_url('/'));
?>

    <div class="body-overlay"></div>

    <style>
    div.wpmenucart-shortcode {
        margin-top: 2px;
    }

    @media (max-width: 991px) {

        .cartmenu .wpmenucart-icon-shopping-cart-0 {
            font-size: 12pt;
        }
    }

    @media (min-width: 992px) {

        .cartmenu .wpmenucart-icon-shopping-cart-0 {
            font-size: 8pt;
        }
    }
    </style>

    <header class="header b2b-bg-header" id="header">
        <div class="container-fluid">

            <!-- ** mb 02-10-2019 mobile menu   -->

            <nav class="navbar visible-xs-block">

                <div class="navbar-header">

                    <a class="navbar-brand" href="<?=$ww_home_url?>"><span class="logo"></span></a>

                    <ul class="pull-right">
                        <li class="menu-item-search">
                            <a role="button" data-toggle="collapse" href="#header-search-mobile" aria-expanded="false"
                                aria-controls="header-search-mobile" class="search collapsed"></a>
                        </li>
                    
			    <li class="menu-item-login">

                            <a href="#" class="user" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="true"></a>
                       <?php if (is_user_logged_in()) {?>
                            <ul class="dropdown-menu dropdown-logout dropdown-login" aria-labelledby="logout">
                                <li><a href="/my-account/">My Account</a></li>
                                <li><a target="_blank" href="/platform-publish/">My Dashboard</a></li>
                                <li><a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></li>
                            </ul>
                        </li>
                        <?php } else {?>
                        <ul class="dropdown-menu dropdown-logout dropdown-login" aria-labelledby="login">
                            <li><a href="/user-login">NON-STUDENT</a></li>
                            <li><a href="https://platform.wisewire.com/login">Student</a></li>
                        </ul>
                        <?php }?>                       

                        <!-- Start helloAri -->
                        <li class="cartmenu">
                            <?php echo do_shortcode('[wpmenucart]'); ?>
                        </li>
                        <!-- End helloAri -->

                        <li class="btn-menu">
                            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                                aria-expanded="false" aria-controls="navbar">
                            </button>
                        </li>
                    </ul>

                </div>

                <div class="header-search-field search-mobile collapse" id="header-search-mobile">
                    <form role="search" class="searchform" method="get" action="https://www.wisewire.com/">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="s">
                            <span class="input-group-btn">
                                <button type="submit" class="btn">
                                    <span class="icon"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

                <div id="navbar" class="navbar-collapse collapse">

                    <ul class="navbar-nav navbar-right">

                        <li class="menu-item-explore">
                            <!--<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Marketplace
                                <span class="caret"></span></a>-->
                            <ul class="dropdown-menu dropdown-logout">
                                <li>
                                    <a href="/explore/">Explore</a>
                                </li>
                                <li>
                                    <a href="/technology-enhanced-assessment-bank/">Sample Resources</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                           <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Explore AI<span
                                    class="caret"></span></a> 
                            <ul class="dropdown-menu dropdown-mobile-higher">
                            <li>
                                    <a href="/for-explore-ai/">Explore AI</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">K&ndash;12<span
                                    class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-mobile-k12">
                                <li>
                                    <a href="/for-administrators/">Administrators</a>
                                </li>
                                <li>
                                    <a href="/for-teachers/">Teachers</a>
                                </li>
                                <li>
                                    <a href="/for-curriculum-providers/">Curriculum<br /> Developers</a>
                                </li>
                                <!-- <li>
                                    <a href="/sellwithus/">Sell With Us</a>
                                </li> -->
                            </ul>
                        </li>
                        <li class="menu-item-custom">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Higher ED<span
                                    class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-mobile-higher">
                                <li>
                                    <a href="/online-program-management-for-higher-ed/">Online Program<br />
                                        Management</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-testimonials">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Career
                                Training<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-mobile-higher">
                                <li>
                                    <a href="/digital-skills-courses/">Bootcamps</a>
                                </li>
                                <li>
                                    <a href="/corporate-learning/">Corporate Programs</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Reuse from footer -->
                    <ul class="social">
                        <li><a target="_blank" href="https://twitter.com/WisewireEd" class="twitter"></a></li>
                        <li><a target="_blank" href="https://www.linkedin.com/company/wisewire-education-marketplace"
                                class="linkedin"></a></li>
                        <li><a target="_blank" href="https://www.facebook.com/WisewireEd/" class="facebook"></a></li>

                        <li><a target="_blank" href="https://www.pinterest.com/wisewire/" class="pinterest"></a></li>
                    </ul>


                </div>

            </nav>
            <!-- ** end mb 02-10-2019 mobile menu **   -->

            <nav class="navbar hidden-xs">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="logo"></span></a>
                </div>

                <ul class="navbar-nav navbar-right navbar-small">

                    <?php if (is_user_logged_in()) {?>
                    <li class="menu-item-user">
                        <a href="#" id="logout" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span
                                class="name">Hi, <?php echo $current_user->user_firstname; ?></span> <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-logout" aria-labelledby="logout">
                            <li><a href="/my-account/">My Account</a></li>
                            <li><a target="_blank" href="/platform-publish/">My Dashboard</a></li>
                            <li><a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></li>
                        </ul>
                    </li>
                    <?php } else {?>

                    <li><a href="/user-login/" id="login">Login</a></li>
                    <?php }?>




                    <!-- Start helloAri -->
                    <li class="cartmenu">
                        <?php echo do_shortcode('[wpmenucart]'); ?>
                    </li>
                    <!-- End helloAri -->

                    <li class="menu-item-search">
                        <a href="#" class="btn-header-search" data-toggle="popover"
                            data-content='
                  <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
                                <div class="input-group header-search-field"><input type="text" name="s" class="form-control"
                                        placeholder="Search" autofocus><span class="input-group-btn"><button type="submit"
                                            class="btn" type="button"><span class="icon"></span></button></span></div>
                                </form>
                                '>
                            <i class="fas fa-search"></i>
                        </a>
                        <div class="popover" role="tooltip">
                            <div class="arrow"></div>
                            <div class="popover-content">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                        </div>
                    </li>

                </ul>
                <ul class="navbar-nav navbar-right" style="margin-right: -130px; margin-top: 40px;">
                    <li class="dropdown">
                        <!--<a href="#" id="marketplace" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">Marketplace</a>-->
                        <ul class="dropdown-menu dropdown-marketplace" aria-labelledby="marketplace">
                            <li>
                                <a href="/explore/">Explore</a>
                            </li>
                            <li>
                            <li>
                                <a href="/technology-enhanced-assessment-bank/">Sample Resources</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                    <a href="#" id="career-training" class="dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">Explore AI</a>
                        <ul class="dropdown-menu dropdown-career" aria-labelledby="career-training">
                        <li>
                                <a href="/for-explore-ai/">Explore AI</a>
                        </li> 
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" id="k12" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">K-12</a>
                        <ul class="dropdown-menu dropdown-k12" aria-labelledby="k12">
                            <li>
                                <a href="/for-administrators/">Administrators</a>
                            </li>
                            <li class="menu-item">
                                <a href="/for-teachers/">Teachers</a>
                            </li>
                            <li>
                                <a href="/for-curriculum-providers/">Curriculum Developers</a>
                            </li>
                            <!--<li>
                                <a href="/sellwithus/">Sell With Us</a>
                            </li>-->
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" id="higher-ed" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">Higher
                            Ed</a>
                        <ul class="dropdown-menu dropdown-higher" aria-labelledby="higher-ed">
                            <li>
                                <a href="/online-program-management-for-higher-ed/">Online Program
                                    Management</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" id="career-training" class="dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">Career
                            Training</a>
                        <ul class="dropdown-menu dropdown-career" aria-labelledby="career-training">
                            <li>
                                <a href="/digital-skills-courses/">Bootcamps</a>
                            </li>
                            <li>
                                <a href="/corporate-learning/">Corporate Programs</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </nav><!-- /navbar -->

        </div><!-- /container-fluid -->

    </header><!-- /header -->
