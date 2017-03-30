<?php
/**
 * Template Name: Openstax Request
 */

require get_template_directory() . "/Controller/BecomeAuthor.php";

$itemId = isset($_REQUEST["itemId"])? $_REQUEST["itemId"]:"";
$itemType = isset($_REQUEST["itemType"])? ( ($_REQUEST["itemType"]=='item')? "question": $_REQUEST["itemType"]):"";

$control = new Controller_BecomeAuthor('favorite',$itemId, $itemType );

?>

<?php
  if($control->token != ""){
    $url = $control->redirect_location.$control->token;
    wp_redirect( $url );
    exit;
  }
?>

