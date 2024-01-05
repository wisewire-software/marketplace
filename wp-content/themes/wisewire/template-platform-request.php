<?php
/**
 * Template Name: Platform Request
 */

require get_template_directory() . "/Controller/BecomeAuthor.php";
$control = new Controller_BecomeAuthor('request');

?>

<?php
  if($control->token != ""){
    $url = $control->redirect_location.$control->token;
    wp_redirect( $url );
    exit;
  }
?>

