<?php
/**
 * Plugin Name:       Personalize Login
 * Description:       A plugin that replaces the WordPress login flow with a custom page.
 * Version:           1.0.0
 * Author:            Jarkko Laine
 * License:           GPL-2.0+
 * Text Domain:       personalize-login
 */

class Personalize_Login_Plugin {

	/**
	 * Initializes the plugin.
	 *
	 * To keep the initialization fast, only add filter and action
	 * hooks in the constructor.
	 */
	public function __construct() {

		// Redirects
		// add_action( 'login_form_login', array( $this, 'redirect_to_custom_login' ) );
		// add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );
		// add_filter( 'login_redirect', array( $this, 'redirect_after_login' ), 10, 3 );
		// add_action( 'wp_logout', array( $this, 'redirect_after_logout' ) );

		add_action( 'login_form_register', array( $this, 'redirect_to_custom_register' ) );
		add_action( 'admin_init', array( $this, 'restrict_admin') );
    add_action( 'wp_login_failed', array( $this, 'login_failed') );
    add_action( 'authenticate', array( $this, 'blank_login') );
		
		add_action( 'login_form_lostpassword', array( $this, 'redirect_to_custom_lostpassword' ) );
		add_action( 'login_form_rp', array( $this, 'redirect_to_custom_password_reset' ) );
		add_action( 'login_form_resetpass', array( $this, 'redirect_to_custom_password_reset' ) );

		// Handlers for form posting actions
		add_action( 'login_form_lostpassword', array( $this, 'do_password_lost' ) );
		add_action( 'login_form_rp', array( $this, 'do_password_reset' ) );
		add_action( 'login_form_resetpass', array( $this, 'do_password_reset' ) );

		// Other customizations
		add_filter( 'retrieve_password_message', array( $this, 'replace_retrieve_password_message' ), 10, 4 );

		// Shortcodes
		add_shortcode( 'custom-password-lost-form', array( $this, 'render_password_lost_form' ) );
		add_shortcode( 'custom-password-reset-form', array( $this, 'render_password_reset_form' ) );
	}


	/**
	 * Plugin activation hook.
	 *
	 * Creates all WordPress pages needed by the plugin.
	 */
	public static function plugin_activated() {
		// Information needed for creating the plugin's pages
		$page_definitions = array(
			'user-password-lost' => array(
				'title' => __( 'Forgot Your Password?', 'personalize-login' ),
				'content' => '[custom-password-lost-form]'
			),
			'user-password-reset' => array(
				'title' => __( 'Pick a New Password', 'personalize-login' ),
				'content' => '[custom-password-reset-form]'
			)
		);

		foreach ( $page_definitions as $slug => $page ) {
			// Check that the page doesn't exist already
			$query = new WP_Query( 'pagename=' . $slug );
			if ( ! $query->have_posts() ) {
				// Add the page using the data from the array above
				wp_insert_post(
					array(
						'post_content'   => $page['content'],
						'post_name'      => $slug,
						'post_title'     => $page['title'],
						'post_status'    => 'publish',
						'post_type'      => 'page',
						'ping_status'    => 'closed',
						'comment_status' => 'closed',
					)
				);
			}
		}
	}

	//
	// REDIRECT FUNCTIONS
	//

	/**
	 * Redirect the user to the custom login page instead of wp-login.php.
	 */
	public function redirect_to_custom_login() {
		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user();
				exit;
			}

			// The rest are redirected to the login page
			$login_url = home_url( 'user-login' );
			if ( ! empty( $_REQUEST['redirect_to'] ) ) {
				$login_url = add_query_arg( 'redirect_to', $_REQUEST['redirect_to'], $login_url );
			}

			if ( ! empty( $_REQUEST['checkemail'] ) ) {
				$login_url = add_query_arg( 'checkemail', $_REQUEST['checkemail'], $login_url );
			}

			wp_redirect( $login_url );
			exit;
		}
	}

	/**
	 * Redirect the user after authentication if there were any errors.
	 *
	 * @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
	 * @param string            $username   The user name used to log in.
	 * @param string            $password   The password used to log in.
	 *
	 * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
	 */
	public function maybe_redirect_at_authenticate( $user, $username, $password ) {
		// Check if the earlier authenticate filter (most likely,
		// the default WordPress authentication) functions have found errors
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			if ( is_wp_error( $user ) ) {
				$error_codes = join( ',', $user->get_error_codes() );

				$login_url = home_url( 'user-login' );
				$login_url = add_query_arg( 'login', $error_codes, $login_url );

				wp_redirect( $login_url );
				exit;
			}
		}

		return $user;
	}

	/**
	 * Returns the URL to which the user should be redirected after the (successful) login.
	 *
	 * @param string           $redirect_to           The redirect destination URL.
	 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
	 *
	 * @return string Redirect URL
	 */
	public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {
		$redirect_url = home_url();

		if ( ! isset( $user->ID ) ) {
			return $redirect_url;
		}

		if ( user_can( $user, 'edit_others_pages' ) ) {
			// Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
			if ( $requested_redirect_to == '' ) {
				$redirect_url = admin_url();
			} else {
				$redirect_url = $redirect_to;
			}
		} else {
			// Non-admin users always go to their account page after login
			$redirect_url = home_url( 'member-account' );
		}

		return wp_validate_redirect( $redirect_url, home_url() );
	}

	/**
	 * Redirect to custom login page after the user has been logged out.
	 */
	public function redirect_after_logout() {
		$redirect_url = home_url( 'user-login?logged_out=true' );
		wp_redirect( $redirect_url );
		exit;
	}

	/**
	 * Redirects the user to the custom registration page instead
	 * of wp-login.php?action=register.
	 */
	public function redirect_to_custom_register() {
		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user();
			} else {
				wp_redirect( home_url( 'user-login' ) );
			}
			exit;
		}
	}
	
  /*
    Restrict Access To Admin Area To Only Admin Users
    http://www.paulund.co.uk/create-your-own-wordpress-login-page
  */
  
  public function restrict_admin() {
  	if ( ! current_user_can( 'edit_others_pages' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) { 
      wp_redirect( site_url() );
  	}
  }

  public function login_failed( $user ) {
    // check what page the login attempt is coming from
    $referrer = $_SERVER['HTTP_REFERER'];
  
    	// check that were not on the default login page
  	if ( !empty($referrer) && !strstr($referrer,'wwlogin') && !strstr($referrer,'wwlogin') && $user!=null ) {
  		// make sure we don't already have a failed login attempt
  		if ( strstr($referrer, '?itemID' )) {
  			// Redirect to the login page and append a querystring of login failed
        wp_redirect( $referrer . '&login=failed');
      } else if ( !strstr($referrer, 'login=failed' )) {
  			// Redirect to the login page and append a querystring of login failed
      	if ( strstr($referrer, '?' )) {
      		wp_redirect( $referrer . '&login=failed');
      	} else{
      		wp_redirect( $referrer . '?login=failed');
      	}
        
      } else {
        wp_redirect( $referrer );
      }
      exit;
    }
  }
  
  
  
  public function blank_login( $user ){
  	// check what page the login attempt is coming from
  	if (isset($_SERVER['HTTP_REFERER'])) {
    	$referrer = $_SERVER['HTTP_REFERER'];
  	}
  
  	$error = false;
  
  	if( isset($_POST['log']) == '' ||  isset($_POST['pwd']) == '') {
  		$error = true;
  	}
  
  	// check that were not on the default login page
  	if ( !empty($referrer) && !strstr($referrer,'wwlogin') && !strstr($referrer,'wwlogin') && $error ) {
  
  		// make sure we don't already have a failed login attempt
    	if ( !strstr($referrer, '?login=failed') ) {
    		// Redirect to the login page and append a querystring of login failed
        wp_redirect( $referrer . '?login=failed' );
      } else {
        wp_redirect( $referrer );
      }
  
      exit;
  
  	}
  }



	/**
	 * Redirects the user to the custom "Forgot your password?" page instead of
	 * wp-login.php?action=lostpassword.
	 */
	public function redirect_to_custom_lostpassword() {
		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user();
				exit;
			}

			wp_redirect( home_url( 'user-password-lost' ) );
			exit;
		}
	}

	/**
	 * Redirects to the custom password reset page, or the login page
	 * if there are errors.
	 */
	public function redirect_to_custom_password_reset() {
		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
			// Verify key / login combo
			$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
			if ( ! $user || is_wp_error( $user ) ) {
				if ( $user && $user->get_error_code() === 'expired_key' ) {
					wp_redirect( home_url( 'user-password-reset?login=expiredkey' ) );
				} else {
					wp_redirect( home_url( 'user-password-reset?login=invalidkey' ) );
				}
				exit;
			}

			$redirect_url = home_url( 'user-password-reset' );
			$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
			$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

			wp_redirect( $redirect_url );
			exit;
		}
	}


	//
	// FORM RENDERING SHORTCODES
	//

	/**
	 * A shortcode for rendering the form used to initiate the password reset.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function render_password_lost_form( $attributes, $content = null ) {
		// Parse shortcode attributes
		$default_attributes = array( 'show_title' => false );
		$attributes = shortcode_atts( $default_attributes, $attributes );

		if ( is_user_logged_in() ) {
			return __( 'You are already signed in.', 'personalize-login' );
		} else {
			// Retrieve possible errors from request parameters
			$attributes['errors'] = array();
			if ( isset( $_REQUEST['errors'] ) ) {
				$error_codes = explode( ',', $_REQUEST['errors'] );

				foreach ( $error_codes as $error_code ) {
					$attributes['errors'] []= $this->get_error_message( $error_code );
				}
			}
			
      // Check if the user just requested a new password
		  $attributes['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';		
			
			return $this->get_template_html( 'password_lost_form', $attributes );
		}
	}

	/**
	 * A shortcode for rendering the form used to reset a user's password.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function render_password_reset_form( $attributes, $content = null ) {
		// Parse shortcode attributes
		$default_attributes = array( 'show_title' => false );
		$attributes = shortcode_atts( $default_attributes, $attributes );

		if ( is_user_logged_in() ) {
			return __( 'You are already signed in.', 'personalize-login' );
		} else {
	  	// Check if user just updated password
  		  		
			if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
				$attributes['login'] = $_REQUEST['login'];
				$attributes['key'] = $_REQUEST['key'];

				// Error messages
				$errors = array();
				if ( isset( $_REQUEST['error'] ) ) {
					$error_codes = explode( ',', $_REQUEST['error'] );

					foreach ( $error_codes as $code ) {
						$errors []= $this->get_error_message( $code );
					}
				}
				$attributes['errors'] = $errors;

				return $this->get_template_html( 'password_reset_form', $attributes );
			} else if ( isset( $_REQUEST['password'] ) && $_REQUEST['password'] ){
  			$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';	
  			return __( '<div class="alert alert-success">Your password has been changed. You can <a href="/user-login">log in now</a>.</div>', 'personalize-login' );
  		} else {
				return __( '<div class="alert alert-danger">Invalid password reset link.</div>', 'personalize-login' );
			}
		}
	}

	/**
	 * Renders the contents of the given template to a string and returns it.
	 *
	 * @param string $template_name The name of the template to render (without .php)
	 * @param array  $attributes    The PHP variables for the template
	 *
	 * @return string               The contents of the template.
	 */
	private function get_template_html( $template_name, $attributes = null ) {
		if ( ! $attributes ) {
			$attributes = array();
		}

		ob_start();

		do_action( 'personalize_login_before_' . $template_name );

		require( 'templates/' . $template_name . '.php');

		do_action( 'personalize_login_after_' . $template_name );

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}


	//
	// ACTION HANDLERS FOR FORMS IN FLOW
	//

	/**
	 * Initiates password reset.
	 */
	public function do_password_lost() {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$errors = retrieve_password();
			if ( is_wp_error( $errors ) ) {
				// Errors found
				$redirect_url = home_url( 'user-password-lost' );
				$redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
			} else {
				// Email sent
				$redirect_url = home_url( 'user-password-lost' );
				$redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
				if ( ! empty( $_REQUEST['redirect_to'] ) ) {
					$redirect_url = $_REQUEST['redirect_to'];
				}
			}
			
			wp_safe_redirect( $redirect_url );
			exit;
		}
	}

	/**
	 * Resets the user's password if the password reset form was submitted.
	 */
	public function do_password_reset() {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$rp_key = $_REQUEST['rp_key'];
			$rp_login = $_REQUEST['rp_login'];

			$user = check_password_reset_key( $rp_key, $rp_login );

			if ( ! $user || is_wp_error( $user ) ) {
				if ( $user && $user->get_error_code() === 'expired_key' ) {
					wp_redirect( home_url( 'user-password-reset?login=expiredkey' ) );
				} else {
					wp_redirect( home_url( 'user-password-reset?login=invalidkey' ) );
				}
				exit;
			}

			if ( isset( $_POST['pass1'] ) ) {
				if ( $_POST['pass1'] != $_POST['pass2'] ) {
					// Passwords don't match
					$redirect_url = home_url( 'user-password-reset' );

					$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
					$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

					wp_redirect( $redirect_url );
					exit;
				}

				if ( empty( $_POST['pass1'] ) ) {
					// Password is empty
					$redirect_url = home_url( 'user-password-reset' );

					$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
					$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

					wp_redirect( $redirect_url );
					exit;

				}
				
				if ( strlen( $_POST['pass1'] )  < 6 ) {
					// Password is empty
					$redirect_url = home_url( 'user-password-reset' );

					$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
					$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_long', $redirect_url );

					wp_redirect( $redirect_url );
					exit;

				}
							

				// Parameter checks OK, reset password
				reset_password( $user, $_POST['pass1'] );
				wp_redirect( home_url( 'user-password-reset?password=changed' ) );
			} else {
				echo '<div class="alert alert-danger">Invalid request.</div>';
			}

			exit;
		}
	}


	//
	// OTHER CUSTOMIZATIONS
	//

	/**
	 * Returns the message body for the password reset mail.
	 * Called through the retrieve_password_message filter.
	 *
	 * @param string  $message    Default mail message.
	 * @param string  $key        The activation key.
	 * @param string  $user_login The username for the user.
	 * @param WP_User $user_data  WP_User object.
	 *
	 * @return string   The mail message to send.
	 */
	public function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {
		// Create new message
		$msg  = __( 'Hello!', 'personalize-login' ) . "\r\n\r\n";
		$msg .= sprintf( __( 'You asked us to reset your password for your account using the email address %s.', 'personalize-login' ), $user_login ) . "\r\n\r\n";
		$msg .= __( "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.", 'personalize-login' ) . "\r\n\r\n";
		$msg .= __( 'To reset your password, visit the following address:', 'personalize-login' ) . "\r\n\r\n";
		$msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
		$msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";

		return $msg;
	}


	//
	// HELPER FUNCTIONS
	//

	/**
	 * Redirects the user to the correct page depending on whether he / she
	 * is an admin or not.
	 *
	 * @param string $redirect_to   An optional redirect_to URL for admin users
	 */
	private function redirect_logged_in_user( $redirect_to = null ) {
		$user = wp_get_current_user();
		if ( user_can( $user, 'edit_others_pages' ) ) {
			if ( $redirect_to ) {
				wp_safe_redirect( $redirect_to );
			} else {
				wp_redirect( admin_url() );
			}
		} else {
			wp_redirect( home_url( 'member-account' ) );
		}
	}

	/**
	 * Finds and returns a matching error message for the given error code.
	 *
	 * @param string $error_code    The error code to look up.
	 *
	 * @return string               An error message.
	 */
	private function get_error_message( $error_code ) {
		switch ( $error_code ) {
			// Login errors

			case 'empty_username':
				return __( 'Email is required', 'personalize-login' );

			case 'empty_password':
				return __( 'You need to enter a password to login.', 'personalize-login' );

			case 'invalid_username':
				return __(
					"We don't have any users with that email address. Maybe you used a different one when signing up?",
					'personalize-login'
				);

			case 'incorrect_password':
				$err = __(
					"The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
					'personalize-login'
				);
				return sprintf( $err, wp_lostpassword_url() );

			// Registration errors

			case 'email':
				return __( 'The email address you entered is not valid.', 'personalize-login' );

			case 'email_exists':
				return __( 'An account exists with this email address.', 'personalize-login' );

			case 'closed':
				return __( 'Registering new users is currently not allowed.', 'personalize-login' );

			case 'captcha':
				return __( 'The Google reCAPTCHA check failed. Are you a robot?', 'personalize-login' );

			// Lost password

			case 'empty_username':
				return __( 'You need to enter your email address to continue.', 'personalize-login' );

			case 'invalid_email':
			case 'invalidcombo':
				return __( 'There are no users registered with this email address.', 'personalize-login' );

			// Reset password

			case 'expiredkey':
			case 'invalidkey':
				return __( 'The password reset link you used is not valid anymore.', 'personalize-login' );

			case 'password_reset_mismatch':
				return __( "The two passwords you entered don't match.", 'personalize-login' );

			case 'password_reset_empty':
				return __( "Sorry, we don't accept empty passwords.", 'personalize-login' );
				
				case 'password_reset_long':
				return __( "The password should be at least six characters long.", 'personalize-login' );

			default:
				break;
		}

		return __( 'An unknown error occurred. Please try again later.', 'personalize-login' );
	}

}

// Initialize the plugin
$personalize_login_pages_plugin = new Personalize_Login_Plugin();

// Create the custom pages at plugin activation
register_activation_hook( __FILE__, array( 'Personalize_Login_Plugin', 'plugin_activated' ) );