<?php
/**
 * Template Name: User Login
 */
?>


<?php get_header(); ?>  

    
    <?php
      // Fields
      $log_in_headline = get_field('log_in_headline');
      $log_in_description = get_field('log_in_description');
      $register_headline = get_field('register_headline');
      $register_description = get_field('register_description');
    ?>
    
    
    
    <?php
    
    /*
      Plugin Name: Custom Registration
      Description: Updates user rating based on number of posts.
      Version: 1.1
      Author: Tristan Slater w/ Agbonghama Collins
      Author URI: http://kanso.ca
     */
    
    /////////////////
    // PLUGIN CORE //
    /////////////////
    
    function cr(&$fields, &$errors) {
      
      // Check args and replace if necessary
      if (!is_array($fields))     $fields = array();
      if (!is_wp_error($errors))  $errors = new WP_Error;
      
      // Check for form submit
      if (isset($_POST['submit'])) {
        
        // Get fields from submitted form
        $fields = cr_get_fields();
        
        // Validate fields and produce errors
        if (cr_validate($fields, $errors)) {
          
          // If successful, register user
          // If successful, register user
          $id = wp_insert_user($fields);
          wp_set_current_user($id);
          wp_set_auth_cookie($id);
          
          // And display a message
          echo '<div class="alert alert-success">Registration complete. You can now login.</div>';
          ?>
          
          <script>
            document.getElementById("create-account").style.display = "block";
            document.getElementById("create-account-form").style.display = "none";
            document.getElementById("btn-register").style.display = "none";
          </script>

        <?php 

          if(!empty($_POST['redirect_to'])){
              
              wp_redirect( $_POST['redirect_to'] );

          }

        ?>
        
        <?php          
          // Clear field data
          $fields = array(); 
        }
      }
      
      // Santitize fields
      cr_sanitize($fields);
    
      // Generate form
      cr_display_form($fields, $errors);
    }
    
    function cr_sanitize(&$fields) {
      $fields['user_login']   =  isset($fields['user_email'])  ? sanitize_user($fields['user_email']) : '';
      $fields['user_pass']    =  isset($fields['user_pass'])   ? esc_attr($fields['user_pass']) : '';
      $fields['user_pass_confirm']    =  isset($fields['user_pass_confirm'])   ? esc_attr($fields['user_pass_confirm']) : '';
      $fields['user_email']   =  isset($fields['user_email'])  ? sanitize_email($fields['user_email']) : '';
      $fields['user_email_confirm']   =  isset($fields['user_email_confirm'])  ? sanitize_email($fields['user_email_confirm']) : '';
      $fields['first_name']   =  isset($fields['first_name'])  ? sanitize_text_field($fields['first_name']) : '';
      $fields['last_name']    =  isset($fields['last_name'])   ? sanitize_text_field($fields['last_name']) : '';
    }
    
    function cr_display_form($fields = array(), $errors = null) {
      
      // Check for wp error obj and see if it has any errors  
      if (is_wp_error($errors) && count($errors->get_error_messages()) > 0) {
        
        // Display errors
        ?><div class="alert alert-danger"><ul><?php
        foreach ($errors->get_error_messages() as $key => $val) {
          ?><li>
            <?php echo $val; ?>
          </li><?php
        }
        ?></ul></div><?php
      }
      
      // Disaply form
      
      ?>
      
               
      <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post" id="create-account-form">
        
        <div class="form-groups">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="First Name*" name="first_name" value="<?php echo (isset($fields['first_name']) ? $fields['first_name'] : '') ?>" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Last Name*" name="last_name" value="<?php echo (isset($fields['last_name']) ? $fields['last_name'] : '') ?>" required>
          </div>
        </div>
        
        <div class="form-groups">
          <div class="form-group">
            <input type="email" class="form-control" id="" placeholder="Email*" name="user_email" value="<?php echo (isset($fields['user_email']) ? $fields['user_email'] : '') ?>" required>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" id="" placeholder="Confirm Email*" name="user_email_confirm" value="<?php echo (isset($fields['user_email_confirm']) ? $fields['user_email_confirm'] : '') ?>" required>
          </div>
        </div>
        
        <div class="form-groups">
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password*" name="user_pass" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Confirm Password*" name="user_pass_confirm" required>
          </div>
        </div>    
        <?php
          $register_terms = get_field('register_terms');
        ?>
        <?php if ($register_terms) { ?>
        	<div class="terms">
          	<p><?php echo $register_terms; ?></p>
        	</div>
        <?php } ?>
       
         <?php  

        
          $redirect_to_item = false;
          if(isset($_GET['itemID']) && $_GET['itemType'] == 'item') {
            $itemID = $_GET["itemID"];
            $redirect_to_item = get_page_link($itemID);
          } else if(isset($_GET['itemID']) && $_GET['itemType'] == 'itemplatform') {
            $itemID = $_GET["itemID"];
            $redirect_to_item = '/item/' . $itemID;
          }
       

          if(!empty($_SERVER['HTTP_REFERER'])){
            $publish_url = home_url().'/create/'; 
            $redirect_to_publish = $publish_url == $_SERVER['HTTP_REFERER'] 
                                ? $publish_url."?scroll" : home_url();
          }

          $redirect_to_publish = isset($_GET["publish"])? home_url().'/create/?scroll':$redirect_to_publish;
          $redirect_to_publish = isset($_POST["redirect_to"])? $_POST["redirect_to"]:$redirect_to_publish;

        ?>
        <input type="hidden" name="redirect_to" value="<?php if ($redirect_to_item) { echo $redirect_to_item; } else { echo !empty($redirect_to_publish)  ? $redirect_to_publish : home_url(); } ?>">
        <button class="btn" type="submit" name="submit">CREATE ACCOUNT</button>
        
      </form>
        
        <?php
    }
    
    function cr_get_fields() {
      return array(
        'user_login'   =>  isset($_POST['user_email'])   ?  $_POST['user_email']   :  '',
        'user_pass'    =>  isset($_POST['user_pass'])    ?  $_POST['user_pass']    :  '',
        'user_pass_confirm'    =>  isset($_POST['user_pass_confirm'])    ?  $_POST['user_pass_confirm']    :  '',
        'user_email'   =>  isset($_POST['user_email'])   ?  $_POST['user_email']        :  '',
        'user_email_confirm'   =>  isset($_POST['user_email_confirm'])   ?  $_POST['user_email_confirm']        :  '',
        'first_name'   =>  isset($_POST['first_name'])   ?  $_POST['first_name']        :  '',
        'last_name'    =>  isset($_POST['last_name'])    ?  $_POST['last_name']        :  '',
        'redirect_to'    =>  isset($_POST['redirect_to'])    ?  $_POST['redirect_to']        :  '',
      );
    }
    
    function cr_validate(&$fields, &$errors) {
      
      // Make sure there is a proper wp error obj
      // If not, make one
      if (!is_wp_error($errors))  $errors = new WP_Error;
      
      // Validate form data

/*
      if (empty($fields['user_pass']) || empty($fields['user_email']) || empty($fields['first_name']) || empty($fields['last_name']) ) {
        $errors->add('field', 'Required form fields is missing');
      }
*/
   
/*
      if (strlen($fields['user_login']) < 4) {
        $errors->add('username_length', 'Username too short. At least 4 characters is required');
      }
*/
      
      if (empty($fields['first_name']) || empty($fields['last_name']) ) {
        $errors->add('first_name', 'First name is required');
      }
      
      if (empty($fields['last_name']) || empty($fields['last_name']) ) {
        $errors->add('last_name', 'Last name is required');
      }
            
      if (username_exists($fields['user_email']))
        $errors->add('email', 'Email already in use');   
    
      if (strlen($fields['user_pass']) < 6) {
        $errors->add('user_pass', 'Password length must be greater than 5');
      }
    
      if (!is_email($fields['user_email'])) {
        $errors->add('email_invalid', 'Email is not valid');
      }
    
/*
      if (email_exists($fields['user_email'])) {
        $errors->add('email', 'Email already in use');
      }
*/
      
      if ( ($fields['user_pass']) != $fields['user_pass_confirm']) {
        $errors->add('user_pass', 'Passwords do not match');
      }
      
      if ( ($fields['user_email']) != $fields['user_email_confirm']) {
        $errors->add('email', 'Emails do not match');
      }     
      
      
      // If errors were produced, fail
      if (count($errors->get_error_messages()) > 0) {
        ?>
        <script>
          document.getElementById("create-account").style.display = "block";
          document.getElementById("btn-register").style.display = "none";
        </script>
        <?php
        return false;
      }
      
      // Else, success!
      return true;
    }
    
    
    
    ///////////////
    // SHORTCODE //
    ///////////////
    
    // The callback function for the [cr] shortcode
    function cr_cb() {
      $fields = array();
      $errors = new WP_Error();
      
      // Buffer output
      ob_start();
      
      // Custom registration, go!
      cr($fields, $errors);
      
      // Return buffer
      return ob_get_clean();
    }
    add_shortcode('cr', 'cr_cb');
    
    ?>
         
              		
    <div class="login lo-shadow">
    
      <div class="container">
        
        <?php if ( is_user_logged_in() ) { ?>
          <?php wp_redirect( home_url() ); exit; ?>
        <?php } ?>   

        <div class="clearfix">
          
          <div class="col col-left col-login">
            
            <div class="box box-style-1">
              
              <?php if ($log_in_headline) { ?>
              	<h2><?php echo $log_in_headline; ?></h2>
              <?php } ?>
              
              <?php if ($log_in_description) { ?>
              	<p class="desc"><?php echo $log_in_description; ?></p>
              <?php } ?>
              
              <?php
                /*
                  Login functionality
                  We use also some WP hooks that are placed in /plugins/personalize-login/personalize-login.php
                */
              ?>
              
              <?php if(isset($_GET['login']) && $_GET['login'] == 'failed') { ?>
            		<div id="login-error" class="alert alert-danger">
            			<p>Invalid email and/or password, please try again.</p>
            		</div>
              <?php } ?>
              
              <?php
                $redirect_to_item = false;
                if(isset($_GET['itemID']) && $_GET['itemType'] == 'item') {
                  $itemID = $_GET["itemID"];
                  $redirect_to_item = get_page_link($itemID);
                } else if(isset($_GET['itemID']) && $_GET['itemType'] == 'itemplatform') {
                  $itemID = $_GET["itemID"];
                  $redirect_to_item = '/item/' . $itemID;
                } else if(isset($_GET["publish"])){
                  $redirect_to_item = home_url().'/create/?scroll';
                }
              ?>

              
              <form name="loginform" id="loginform" class="validate-form" action="<?php $_SERVER['REQUEST_URI'] ?>/wp-login.php" method="post">
                
                <div class="form-group">
                  <input type="email" name="log" id="user_login" class="form-control" id="" placeholder="Email*" required>
                </div>
                
                <div class="form-group">
                  <input type="password" name="pwd" id="user_pass" class="form-control" id="" placeholder="Password*" required>
                </div>

                <div class="form-group form-group-button">
                  <div class="forgot pull-left">
                    <a href="/my-account/lost-password/">Forgot password?</a>
                  </div>
                  <div class="pull-right">
                    <button class="btn" type="submit" name="wp-submit" id="wp-submit">Submit</button>
                    <?php
                    if(!empty($_SERVER['HTTP_REFERER'])){
                      $publish_url = home_url().'/create/';

                      $redirect_to_publish = $publish_url == $_SERVER['HTTP_REFERER']
                          ? $publish_url.'?scroll' : home_url();

                    }
                    ?>
                    <input type="hidden" name="redirect_to" value="<?php if ($redirect_to_item) { echo $redirect_to_item; } else { echo !empty($redirect_to_publish)  ? $redirect_to_publish : home_url(); } ?>">
                  </div>
                </div>
                <div class="clear"></div>
                <div class="required pull-right">* Required fields</div>
                <div class="clear"></div>
                <div class="form-group">
                  <?php echo do_shortcode("[wpoa_login_form  logged_out_title=\"\" icon_set=\"\"]"); ?>
                </div>
              </form>
              
            </div>
          
          </div>

          <div class="col col-right col-create">
            
            <div class="box">
              
              <?php if ($register_headline) { ?>
              	<h2><?php echo $register_headline; ?></h2>
              <?php } ?>
              
              <?php if ($register_description) { ?>
              	<p class="desc"><?php echo $register_description; ?></p>
              <?php } ?>
           
<?php /*
              <?php if(isset($_GET['register']) && $_GET['register'] == 'failed') { ?>
                <div class="create-account" id="create-account">              
              <?php } else { ?>
                <p class="register">
                  <a href="#" id="btn-register">Register</a> [TODO - show / hide register box]
                </p>
                <div class="create-account" id="create-account" style="display:none;">                  
              <?php } ?>
*/ ?>

                                          
              <p class="register"<?php if(isset($_GET['action']) && $_GET['action'] == 'create-account') echo ' style="display:none;"'; ?>>
                <a href="#" id="btn-register">Register</a>
              </p>
              
              <div class="create-account" id="create-account"<?php if(isset($_GET['action']) && $_GET['action'] == 'create-account') { echo ' style="display:block;"'; } else { echo ' style="display:none;"'; } ?>>
                
                <?php
                  /*
                    Register functionality
                    The code is placed above + some WP hooks /plugins/personalize-login/personalize-login.php
                  */
                ?>
                <?php echo do_shortcode("[cr]"); ?>
                
              </div>
              
            </div>
            
            
          </div>
          
        </div>
        
      </div>
      
    </div><!-- /login -->

<?php get_footer(); ?>

  <?php // http://blueashes.com/2013/web-development/html5-form-validation-fallback/ ?>
  <script>
    $(function() {
      function hasHtml5Validation () {
       return typeof document.createElement('input').checkValidity === 'function';
      }
      if (hasHtml5Validation()) {
       $('.validate-form').submit(function (e) {
         if (!this.checkValidity()) {
           // Prevent default stops form from firing
           e.preventDefault();
           alert ("Invalid email and/or password, please try again.");
         } else {
      
         }
       });
      }
    });
  </script>
  