<?php
/**
 * Template Name: Platform Publish
 */

require get_template_directory() . "/Controller/BecomeAuthor.php";
$control = new Controller_BecomeAuthor('publish');

?>

<?php
  if($control->token != ""){
    $url = $control->redirect_location.$control->token;
    wp_redirect( $url );
    exit;
  }
?>

