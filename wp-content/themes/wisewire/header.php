<!doctype html>
<html <?php //language_attributes(); ?> dir="ltr">
  <head>
    <meta charset="UTF-8<?php //bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
      // Get an item title from single-item-platform.php
      global $item_from_platform;
      global $item_from_platform_title;
    ?>
    <?php if ($item_from_platform == true) { ?>
      <title><?php echo $item_from_platform_title; ?> - Wisewire</title>
    <?php } else { ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/explore.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/accordion.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/extra_styles.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>

    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr-2.8.3.min.js"></script>
    
    <!--[if gte IE 9]><style type="text/css">.gradient { filter: none; }</style><![endif]-->
           
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/img/favicons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/img/favicons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/img/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/img/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/img/favicons/manifest.json">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/img/favicons/mstile-144x144.png">
    <meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <?php

      global $post;
      global $current_page;  
      global $total_pages_seo; 
      global $url_link;
      
      if ( get_post_type( $post->ID ) == 'page' && ($post->post_name == 'explore-all' || $post->post_name == 'most-viewed' || $post->post_name == 'filtered')){    
       
        if ($current_page > 1) {       
            echo '<link rel="prev" href="'. $url_link . ($current_page-1) .'" />';      
        }
        if ($current_page < $total_pages_seo) {
            echo '<link rel="next" href="'. $url_link . ($current_page+1) .'" />';      
        }        
      } 
    ?>
    
    <?php wp_head(); ?>
    <script>var $ = jQuery.noConflict();</script>
    <?php if ( is_page('Log In')) { ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php } ?>
  </head>

<body <?php body_class(); ?>>
  
  <?php // Include SVG icons that are made as sprites ?>
  <?php get_template_part('parts/svg', 'icons'); ?>
  
  <?php 
    global $current_user, $WWItems;
    get_currentuserinfo();
  ?>
    <div class="body-overlay"></div>
    
    <header class="header <?php if ( is_page( $page = 'Partner Solutions' ) ) { ?> header_b2b_page <?php } ?> " id="header">

      <div class="container <?php if ( is_page( $page = 'Schedule Demo' ) or is_page( $page = 'Thank you' )) { ?> hidden-nav-s-demo <?php } ?>">
        
        <nav class="navbar visible-xs-block">
       
          <div class="navbar-header">
            
            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="logo"></span>education marketplace</a>
            
            <ul class="pull-right">
              <li class="menu-item-search">
                <a role="button" data-toggle="collapse" href="#header-search-mobile" aria-expanded="false" aria-controls="header-search-mobile" class="search collapsed"></a>                
              </li>
              <li class="menu-item-login">
                <a href="#" class="user" id="login" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></a>
                <ul class="dropdown-menu dropdown-logout dropdown-login" aria-labelledby="login">
                  <li><a href="/user-login">NON-STUDENT</a></li>
                  <?php if(WAN_TEST_ENVIRONMENT): ?>
                    <li><a href="https://test-platform.wisewire.com/login">Student</a></li>
                  <?php else: ?>
                    <li><a href="https://platform.wisewire.com/login">Student</a></li>
                  <?php endif ?>
                </ul>
              </li>   

              <!-- Start helloAri -->
              <li class="cartmenu">
                <?php echo do_shortcode('[wpmenucart]'); ?>
              </li>   
              <!-- End helloAri -->

              <li class="btn-menu">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                </button>                
              </li>
            </ul>
            
          </div>
          
          <div class="header-search-field search-mobile collapse" id="header-search-mobile">
            <form role="search" class="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="s" autofocus>
                <span class="input-group-btn">
                  <button type="submit" class="btn" type="button">
                    <span class="icon"></span>
                  </button>
                </span>
              </div>
            </form>            
          </div>
          
          <div id="navbar" class="navbar-collapse collapse">
            
            <ul class="navbar-nav navbar-right">
              <?php if ( is_user_logged_in() ) { ?>
              <li class="menu-item-user">
                <a href="#" id="logout" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="name">Hi, <?php echo $current_user->user_firstname; ?></span> <span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-logout" aria-labelledby="logout">
                  <li><a href="/my-account/">My Account</a></li>
                  <li><a target="_blank" href="/platform-publish/">My Dashboard</a></li>
                  <li><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
                </ul>
              </li> 
              <?php } ?>              
              <li class="menu-item-explore">
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Explore <span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-logout" aria-labelledby="explore">
                  <li <?php echo $WWItems::$grade_name == 'elementary' && !isset($wp_query->query['search']) ? 'class="active"' : '' ?>>
                    <a href="<?php echo get_site_url(); ?>/explore/elementary/" >Elementary 1</a>
                  </li>
                  <li <?php echo $WWItems::$grade_name == 'middle' && !isset($wp_query->query['search']) ? 'class="active"' : '' ?>>
                    <a href="<?php echo get_site_url(); ?>/explore/middle/" >Middle</a>
                  </li>
                  <li <?php echo $WWItems::$grade_name == 'high-school' && !isset($wp_query->query['search']) ? 'class="active"' : '' ?>>
                    <a href="<?php echo get_site_url(); ?>/explore/high-school/" >High School</a>
                  </li>
                  <li <?php echo $WWItems::$grade_name == 'higher-education' && !isset($wp_query->query['search']) ? 'class="active"' : '' ?>>
                    <a href="<?php echo get_site_url(); ?>/explore/higher-education/">Higher Education</a>
                  </li>
                </ul>
              </li>           
              <?php if ( is_user_logged_in() ) { ?>
              <li class="menu-item-favorites">
				  <?php
					    global $fav_controller;
					    $favorites = $fav_controller->get_favorites(); ?>
                      <a href="/favorites">Favorites <?php echo $favorites ? '('.sizeof($favorites).')' : '' ?></a>
              </li>
              <?php } ?>
              <li class="menu-item-publish">
                <a href="/create">Create</a>
              </li>
              <li class="menu-item-custom">
                <a href="/partnership-solutions">Partner</a>
              </li>
              <li class="menu-item-testimonials">
                <a href="/testimonials">Testimonials</a>
              </li>
            </ul>
            
            <!-- Reuse from footer -->
            <?php get_template_part('parts/social', 'buttons'); ?>
            
          </div>
          
        </nav>
      
        <nav class="navbar hidden-xs">
                
          <div class="navbar-header">            
            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="logo"></span>education marketplace</a>
          </div>
          
          <div>
            <ul class="navbar-nav navbar-right">
              <li class="menu-item-explore">
                <a href="/explore">Explore</a>
              </li>
              <li class="menu-item-publish header-links-space">
                <a href="/create">Create</a>
              </li>
              <li class="menu-item-custom header-links-space">
                <a href="/partnership-solutions">Partner</a>
              </li>
              <?php if ( is_user_logged_in() ) { ?>
              <li class="menu-item-user header-links-space">
                <a href="#" id="logout" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="name">Hi, <?php echo $current_user->user_firstname; ?></span> <span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-logout" aria-labelledby="logout">
                  <li><a href="/my-account/">My Account</a></li>
                  <li><a target="_blank" href="/platform-publish/">My Dashboard</a></li>
                  <li><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
                </ul>
              </li>              	
              <?php } ?>
            <?php if ( is_user_logged_in() ) { ?>
              <?php get_template_part('parts/favorites', 'menu'); ?>           	
            <?php } else { ?>
            <li class="menu-item-login">
              <a href="#" id="login" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Log In</a>
              <ul class="dropdown-menu dropdown-logout dropdown-login" aria-labelledby="login">
                <li><a href="/user-login">NON-STUDENT</a></li>
                <?php if(WAN_TEST_ENVIRONMENT): ?>
                  <li><a href="https://test-platform.wisewire.com/login">Student</a></li>
                <?php else: ?>
                  <li><a href="https://platform.wisewire.com/login">Student</a></li>
                <?php endif ?>
              </ul>
            </li>
            <?php } ?>

            <!-- Start helloAri -->
              <li class="cartmenu">
                <?php echo do_shortcode('[wpmenucart]'); ?>
              </li>   
              <!-- End helloAri -->  
          
              <li class="menu-item-search">
                <a href="#" 
                  class="btn-header-search"
                  data-toggle="popover" 
                  data-content='
                  <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="input-group header-search-field"><input type="text" name="s" class="form-control" placeholder="Search" autofocus><span class="input-group-btn"><button type="submit" class="btn" type="button"><span class="icon"></span></button></span></div>
                  </form>
                  '
                  >
                    <span class="icon"></span>
                  </a>
                <div class="popover" role="tooltip">
                  <div class="arrow"></div>
                  <div class="popover-content">
                    <input type="text" class="form-control" placeholder="Search" autofocus>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          
        </nav><!-- /navbar -->
        
      </div><!-- /container -->
      
    </header><!-- /header -->
