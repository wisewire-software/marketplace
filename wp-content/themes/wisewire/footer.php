    
  <?php
    /*
      Define Theme Options  
    */
    
    // General
    $options_google_analytics_code = (!WAN_TEST_ENVIRONMENT)? get_field('options_google_analytics_code', 'option') : "###"; 
    
    // Footer
    $options_terms_and_usage_rights_pdf = get_field('options_terms_and_usage_rights_pdf', 'option');
  ?>
  
      <footer class="footer footer-b2b <?php if ( is_page( $page = 'Schedule Demo' ) or is_page( $page = 'Thank you' ) ) { ?> footer-sdemo <?php } ?>">
      
      <div class="container">
        
        <div class="hidden-xs hidden-footer-sdemo">
          
          <div class="row">
            
            <div class="col-sm-8 nav-footer">
              <ul>
                <li><a href="/explore">Explore</a></li>
                <li><a href="/create">Create</a></li>
                <li><a href="/partnership-solutions">Partner Solutions</a></li>
                <li><a target="_blank" href="https://blog.wisewire.com/">Blog</a></li>
                <li><a href="/careers">Careers</a></li>
                <li><a href="/press">Press</a></li>
              </ul>
              
               <ul>
                <!--<li><a href="http://wordsandnumbers.com/blog/" target="_blank">Blog</a></li>-->
                <li><a href="#" data-toggle="modal" data-target="#contactModal" >Contact us</a></li>
                 <li><a href="/testimonials">Testimonials</a></li>
                 <li><a href="/sellwithus">Sell With US</a></li>
                 <li><a href="/testimonials">Client Testimonials</a></li>
                 <li><a href="/technology-enhanced-assessment-bank">Sample Learning Resources</a></li>
                 <li><a href="/schedule-demo">Schedule Demo</a></li>
              </ul>
            </div>
            
            <div class="col-sm-4">
              
              <?php
                /*
                  Address and telephone numbers will not be visible for launch. Keep cells available for data to be added in a later phase
                
              <div class="col col-1">
                <p>
                  2050 Rockrose Avenue<br>
                  Baltimore, MD 21211Z<br>
                  <a href="mailto:info@wisewire.com">info@wisewire.com</a>
                </p>
              </div>
              
              <div class="col col-2">
                <p>
                  (410) 467-7835<br>
                  (410) 951-0419
                </p>
              </div>
              */ ?>
              
              <div class="col col-3">
                <?php get_template_part('parts/social', 'buttons'); ?>
              </div>
              
            </div>

          </div><!-- /row -->
          
         </div><!-- /hidden-xs -->
         
        <div class="row">
          <div class="col-xs-12 col-copy">
            <p>
              <span>&copy; Copyright <?php echo date('Y'); ?> Wisewire, Inc.</span> <span class="hidden-xs sep">|</span> 
              <a href="<?php echo $options_terms_and_usage_rights_pdf; ?>" target="_blank">Terms and Usage Rights</a> 
            </p>
          </div>
        </div>
        
      </div>
      
    </footer><!-- /footer -->
             
    
    <?php // Include Modals ?>
    <?php get_template_part('parts/modals', 'all'); ?>       

    
    <!-- JS -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/bootstrap.min.js"></script>
    
    <!-- 3rd Party Plugins -->
    <!-- 
      Slick - Content Carousel
      https://github.com/kenwheeler/slick/
    -->
    <link href="<?php echo get_template_directory_uri(); ?>/js/vendor/slick/slick.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/js/vendor/slick/slick-theme.css" rel="stylesheet">
    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/slick/slick.min.js"></script>
    
    <!--
      matchHeight
      a responsive equal heights plugin for jQuery
    -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery.matchHeight-min.js"></script>

    <!--
      Bootstrap select
      https://github.com/silviomoreto/bootstrap-select
    -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/select/bootstrap-select.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/select/defaults-en_US.min.js"></script>
    <link href="<?php echo get_template_directory_uri(); ?>/js/vendor/select/bootstrap-select.min.css" rel="stylesheet">
    
    <!--
      Ratings
      https://github.com/antennaio/jquery-bar-rating
    -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery.barrating.min.js"></script>
    
    <script type="text/javascript" src="<?php echo is_ssl()? 'https': 'http' ?>://storage.uplynk.com/js/swfobject.js"></script>
    <script type="text/javascript" src="<?php echo is_ssl()? 'https': 'http' ?>://storage.uplynk.com/js/uplynk.js"></script>

    <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/explore.js"></script>
   

    

      <?php 
        $app_id = WAN_TEST_ENVIRONMENT? "vekhwzrt":"umjqwdw0";

        if (  is_user_logged_in() ){   

          $user_id = get_current_user_id();
          $user_info = get_userdata($user_id);
          $email = $user_info->user_email;

          ?>

          <script>
            window.intercomSettings = {
              app_id: "<?php echo $app_id; ?>",
              name: "<?php echo $user_info->first_name." ".$user_info->last_name ?>", // Full name
              email: "<?php echo $email ?>", // Email address
              created_at: "<?php echo $user_info->user_registered ?>"  // Signup date as a Unix timestamp
            };
          </script>  

      <?php 
        } else { 
      ?> 

          <script>
            window.intercomSettings = {
              app_id: "<?php echo $app_id; ?>"
            };
          </script>  
      <?php } ?>

        <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/<?php echo $app_id; ?>';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>    
    
        
		<?php wp_footer(); ?>

	</body>
</html>