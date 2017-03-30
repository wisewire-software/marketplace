<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(is_user_logged_in()){
require get_template_directory() . "/Controller/BecomeAuthor.php";
$control = new Controller_BecomeAuthor('request');
if($control->token != ""){


	
	
	if(WAN_TEST_ENVIRONMENT){	
			$url = 'http://test-platform.wisewire.com/oauth2/token/'.$control->token;
    	} else{
    		$url = 'http://platform.wisewire.com/auth/token/'.$control->token;
    	}
	?>
    <iframe id="frame" src="" style="width:0px;height:0px; display:none;"></iframe>
<script type="text/javascript">

    jQuery("#frame").attr("src", "<?php echo $url; ?>");

</script>
<?php
    
  } else{
	'Platform authentication failed.';  
  }
}
 
?>

<p class="myaccount_user">
	<?php
	printf(
		__( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', 'woocommerce' ) . ' ',
		$current_user->display_name,
		wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
	);

	/*
	 printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>.', 'woocommerce' ),
		wc_customer_edit_account_url()
	);
	*/
	?>
</p>

<?php do_action( 'woocommerce_before_my_account' ); 

if($_GET['e']){
	if($_GET['e'] == 404){
		echo '<div class="woocommerce-error">File not found. Please contact us at <a href="mailto:support@wisewire.com">support@wisewire.com</a>.</div>';
	}
}
 
?>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php // wc_get_template( 'myaccount/my-address.php' ); ?>

<?php  do_action( 'woocommerce_after_my_account' ); ?>
