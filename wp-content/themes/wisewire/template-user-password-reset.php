<?php
/**
 * Template Name: User Password Reset
 */
?>

<?php get_header(); ?>  

<?php /*
  Reset password template needs to be created
  https://pippinsplugins.com/change-password-form-short-code/
*/
?>

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
                Enter a new password to access your Wisewire account.
              </p>
              
              <?php echo do_shortcode("[custom-password-reset-form]"); ?>
              
            </div>
            
            <div class="required">* Required fields</div>
              
          </div>
                	
        <?php } ?>
             
      </div>
      
    </div><!-- /login -->
 

<?php get_footer(); ?>