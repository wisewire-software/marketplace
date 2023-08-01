<?php
/**
 * Template Name: Platform Demo Request
 */

require get_template_directory() . "/Controller/DemoPlatform.php";
$control = new Controller_Demo('/pod/math-sample-items-grades-3-high-school/57bd42bd-8774-4058-b5cd-0b8d00c10017/','request');

?>

<?php
  if($control->token != ""){
    $url = $control->redirect_location.$control->token;
    wp_redirect( $url );
    exit;
  }
?>

