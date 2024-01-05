<?php
/**
 * Template Name: User Password Lost
 */
?>

<?php get_header(); ?>  


    <div class="login lost-password">
      
      <?php
        /*
          We use plugin for this
          http://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-3-password-reset--cms-23811
        */
      ?>
      

      <div class="container">
        
        <div class="clearfix">
                  
        <?php if ( is_user_logged_in() ) { ?>
        	            
          <div class="page-title">
            <h1>
              You are already signed in.
            </h1>
          </div>

        <?php } else { ?>
        	
          <div class="col col-left">
            
            <div class="box">
              
              <h2>
                RESET PASSWORD
              </h2>
              
              <p class="desc">
                Please enter the email address associated with your Wisewire account. We’ll send you a link to reset your password.
              </p>
              
              <?php echo do_shortcode("[custom-password-lost-form]"); ?>
              
            </div>
            
            <div class="required">* Required fields</div>
              
          </div>
                	
        <?php } ?>
             
      </div>
      
    </div><!-- /login -->
 

<?php get_footer(); ?>