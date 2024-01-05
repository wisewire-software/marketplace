    
  <?php
    /*
      Define Theme Options  
    */
    
    // General
   // $options_google_analytics_code = (!WAN_TEST_ENVIRONMENT)? get_field('options_google_analytics_code', 'option') : "###";  
    
    // Footer
    $options_terms_and_usage_rights_pdf = get_field('options_terms_and_usage_rights_pdf', 'option');
  ?>
  
      <footer class="footer footer-b2b <?php if ( is_page( $page = 'Schedule Demo' ) or is_page( $page = 'Thank you' ) ) { ?> footer-sdemo <?php } ?>">
      
      <div class="container">
        
        <div class="hidden-xs hidden-footer-sdemo">
          
          <div class="row">
            
            <div class="col-sm-12 nav-footer">
                <ul>
                    <li><a href="/schedule-demo">Schedule Demo</a></li>
                    <li><a href="/partnership-solutions">Partner</a></li>
                    <li><a href="/testimonials">Testimonials</a></li>
                </ul>
                <ul>
		    <li><a href="/technology-enhanced-assessment-bank">Sample Resources</a></li>
		     <li><a href="/press">Press</a></li>
                    <li><a href="/explore">Explore</a></li>
                                      
                </ul>
                <ul>
                    <li><a href="/careers">Careers</a></li>		    
                    <li><a href="/press">Press</a></li>
            </ul>
		<ul>
	 <li><a href="/sellwithus">Sell With US</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#contactModal" >Contact us</a></li>

		 </ul>
            </div>  <!-- End of col-sm-12 -->
	<!--   <div class="col-sm-4">
              
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
    
<script type="text/javascript">
    document.addEventListener('wpcf7mailsent', function(event) {
        // alert("document: " + event.detail.contactFormId);
        if ('190' == event.detail.contactFormId) { // if you want to identify the form
            // do something
            setTimeout(function() {
                $('#contactModal').modal('hide');
            }, 3000);

        }

        if ('68065' == event.detail.contactFormId) { // if you want to identify the form
            // do something
            setTimeout(function() {
                $('#myModal1').modal('hide');
            }, 3000);

        }

    }, true);
</script>
         
    
    <?php // Include Modals ?>
    <?php get_template_part('parts/modals', 'all'); ?>       

<!--[if gt IE 8]><!-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" integrity="sha256-0rguYS0qgS6L4qVzANq4kjxPLtvnp5nn2nB5G1lWRv4=" crossorigin="anonymous"></script>
<!--<![endif]-->
    
    <!-- JS -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 
    <!-- 3rd Party Plugins -->
    <!-- 
      Slick - Content Carousel
      https://github.com/kenwheeler/slick/
    -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha256-4hqlsNP9KM6+2eA8VUT0kk4RsMRTeS7QGHIM+MZ5sLY=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script> 
    <!--
      matchHeight
      a responsive equal heights plugin for jQuery
    -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js" integrity="sha256-+oeQRyZyY2StGafEsvKyDuEGNzJWAbWqiO2L/ctxF6c=" crossorigin="anonymous"></script>
    <!--
      Bootstrap select
      https://github.com/silviomoreto/bootstrap-select
    -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    
    <!--
      Ratings
      https://github.com/antennaio/jquery-bar-rating
    -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js" integrity="sha256-4G5fW5q6We2bsDSgLCwkfKMFvGx/SbRsZkiNZbhXCvM=" crossorigin="anonymous"></script> 

    <script src="<?php echo get_template_directory_uri(); ?>/js/main2.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/explore.js"></script>

<!-- <?php if ($_SESSION['show_linkedin_modal']) {?>
<script>
    $(document).ready( function() {
    setTimeout(function() {
        $('#linkedinModal').modal();
        }, 13000);
    });
</script>
<?php
}?>-->


	<?php wp_footer(); ?>


	</body>
</html>
