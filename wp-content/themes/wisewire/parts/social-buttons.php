
<?php
  /*
    Define Theme Options  
  */
  
  // General
  $options_google_analytics_code = get_field('options_google_analytics_code', 'option'); 
  
  // Footer
  $options_footer_copyrights = get_field('options_footer_copyrights', 'option');
  $options_footer_social_twitter_url = get_field('options_footer_social_twitter_url', 'option');
  $options_footer_social_linkedin_url = get_field('options_footer_social_linkedin_url', 'option');
  $options_footer_social_facebook_url = get_field('options_footer_social_facebook_url', 'option');
  $options_footer_social_pinterest_url = get_field('options_footer_social_pinterest_url', 'option');
?>
  
 <!--
  <ul class="social">
    <?php if ($options_footer_social_twitter_url) { ?>
    	<li><a target="_blank" href="<?php echo $options_footer_social_twitter_url; ?>" class="twitter"></a></li>
    <?php } ?>
    <?php if ($options_footer_social_linkedin_url) { ?>
    	<li><a target="_blank" href="<?php echo $options_footer_social_linkedin_url; ?>" class="linkedin"></a></li>
    <?php } ?>
    <?php if ($options_footer_social_facebook_url) { ?>
    	<li><a target="_blank" href="<?php echo $options_footer_social_facebook_url; ?>" class="facebook"></a></li>
    <?php } ?> 
    <?php if ($options_footer_social_pinterest_url) { ?>
		<li><a target="_blank" href="<?php echo $options_footer_social_pinterest_url; ?>" class="pinterest"></a></li> 
	<?php } ?>
  </ul>
    -->