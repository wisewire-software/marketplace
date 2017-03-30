<?php
/**
 * Template Name: Home
 */
?>

<?php get_header(); ?>  

  <?php if ( is_user_logged_in() ) { ?>
    <?php get_template_part( 'home', 'loggedin' ); ?>
  <?php } else { ?>
  	<?php get_template_part( 'home', 'notloggedin' ); ?>
  <?php } ?>

<?php get_footer(); ?>