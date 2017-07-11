    <?php
      
      // Get fields
      
      // Contact
      $modal_contact_title = get_field('modal_contact_title', 'option');
      $modal_contact_description = get_field('modal_contact_description', 'option');
      
      // Customize
      $modal_customize_title = get_field('modal_customize_title', 'option');
      $modal_customize_description = get_field('modal_customize_description', 'option');
      
      // Help
      $modal_help_title = get_field('modal_help_title', 'option');
      $modal_help_description = get_field('modal_help_description', 'option');
      $modal_help_text = get_field('modal_help_text', 'option');
      $modal_help_link_text = get_field('modal_help_link_text', 'option');
      $modal_help_link_url = get_field('modal_help_link_url', 'option');
    ?>

    <?php if ( is_user_logged_in() && strpos($_SERVER['REQUEST_URI'], '/item/')===0 ): ?> 
    <?php 
      $modal_feedback_title = get_field('modal_feedback_title', 'option');
      $modal_feedback_description = get_field('modal_feedback_description', 'option');
    ?>    
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <?php if ($modal_feedback_title) { ?>
            <div class="modal-title">
              <h3><?php echo $modal_feedback_title; ?></h3>
            </div>
            <?php } ?>
            
            <?php if ($modal_feedback_description) { ?>
              <div class="modal-desc">
                <?php echo $modal_feedback_description; ?>
              </div>
            <?php } ?>
            
            <div class="container-fluid container-form">
              
              <?php echo do_shortcode('[contact-form-7 id="14415" title="Feedback Form"]'); ?>
              
            </div>

          </div><!-- /modal-body -->
        </div>
      </div>
    </div> 
    <?php endif?>  
    
    
    <div class="modal fade" id="accessPlatformConfirm" tabindex="-1"  aria-labelledby="customizeModalLabel">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">              
              <div class="modal-desc">                
                You are about to access our assessment platform where you can use and create content.
              </div>
            
            <div class="container-fluid container-form">
                            
              <a href="#" class="btn go-link" rel="nofollow" target="_blank">Take me to the platform!</a>
              <a href="#" class="close" data-dismiss="modal" aria-label="Close">No Thanks.</a>
              
            </div>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>

    <div class="modal fade" id="accessExternalConfirm" tabindex="-1"  aria-labelledby="customizeModalLabel">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">              
              <div class="modal-desc">                
                You are about to access a resource that is not owned by Wisewire.
              </div>
            
            <div class="container-fluid container-form">
                            
              <a href="#" class="btn go-link" rel="nofollow" target="_blank">Yes, take me to this content!</a>
              <a href="#" class="close" data-dismiss="modal" aria-label="Close">No Thanks.</a>
              
            </div>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>
    
    
    <div class="modal fade" id="customizeModal" tabindex="-1" role="dialog" aria-labelledby="customizeModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <?php if ($modal_customize_title) { ?>
            <div class="modal-title">
              <h3><?php echo $modal_customize_title; ?></h3>
            </div>
            <?php } ?>
            
            <?php if ($modal_customize_description) { ?>
            	<div class="modal-desc">
              	<?php echo $modal_customize_description; ?>
            	</div>
            <?php } ?>
            
            <div class="container-fluid container-form">
                            
              <?php echo do_shortcode('[contact-form-7 id="188" title="Customize"]'); ?>
              
            </div>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>  
  
    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <?php if ($modal_contact_title) { ?>
            <div class="modal-title">
              <h3><?php echo $modal_contact_title; ?></h3>
            </div>
            <?php } ?>
            
            <?php if ($modal_contact_description) { ?>
            	<div class="modal-desc">
              	<?php echo $modal_contact_description; ?>
            	</div>
            <?php } ?>
            
            <div class="container-fluid container-form">            

              <?php echo do_shortcode('[contact-form-7 id="190" title="Contact"]'); ?>
              <?php 
                if (  is_user_logged_in() ){      
                  $user_id = get_current_user_id();
                  $user_info = get_userdata($user_id);
                } 
              ?>

              <?php if($user_info->first_name) { ?>
                  <script>
                    contact_first_name = "<?php echo $user_info->first_name; ?>";
                    $("#contactModal .first-name input").val(contact_first_name);
                  </script>
              <?php } ?>

              <?php if($user_info->user_email) { ?>
                  <script>
                    contact_user_email = "<?php echo $user_info->user_email; ?>";
                    $("#contactModal .email input").val(contact_user_email);
                  </script>
              <?php } ?>

              <?php if($user_info->last_name) { ?>
                  <script>
                    contact_last_name = "<?php echo $user_info->last_name; ?>";
                    $("#contactModal .last-name input").val(contact_last_name);
                  </script>
              <?php } ?>
                
              
            </div>

          </div><!-- /modal-body -->
        </div>
      </div>
    </div> 

    <div class="modal fade" id="homeVideoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
      <div class="modal-dialog" role="document" style="width:100%; max-width: 700px; ">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">           

            <div id="homevideoIframe" style="width:100%"><iframe width="560" height="315" src="https://www.youtube.com/embed/EAdiFWDYzz8" frameborder="0" allowfullscreen></iframe></div>
            
          </div>
        </div>
      </div>
    </div> 

	<?php
					
	global $WWItems;

	$pio = new PredictionIOController(); 

	$recommendations = $pio->get_recommendations(3);

	$recommended = array();

	if ($recommendations->itemScores) {

		foreach ($recommendations->itemScores as $item) {
			$recommended []= $item->item;
		}
	}

	$sql = "SELECT p.* FROM `wp_posts` p INNER JOIN `wp_postmeta` pm ON pm.`meta_key` = 'item_object_id' AND pm.`post_id` = p.`ID` "
		. "AND pm.`meta_value` IN ('".implode('\',\'',$recommended)."') "
		. "WHERE p.`post_status` = 'publish' LIMIT 4;";

	$recommendations = $wpdb->get_results($sql);

	?>

	<?php if ($recommendations): ?>
    <div class="modal fade modal-help" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <?php if ($modal_help_title) { ?>
            <div class="modal-title">
              <h3><?php echo $modal_help_title; ?></h3>
            </div>
            <?php } ?>
            
            <div class="container-fluid">
              
              <div class="lo-container">
                
                <?php if ($modal_help_description) { ?>
                	<h3 class="headline-title">
                  	<?php echo $modal_help_description; ?>
                	</h3>
                <?php } ?>
                
                <div class="hidden-xs">
                  
                  <section class="lo-items">
                      
					<?php if ($recommendations): ?>
                    <div class="row row-no-margin">
                      
					  <?php foreach ($recommendations as $k => $item): ?>
				
					  <?php $item_content_type_icon = get_post_field('item_content_type_icon', $item->ID); ?>
					  <?php $item_preview = get_post_field('item_preview', $item->ID); ?>
					  <?php $item_publish_date = get_post_field('item_publish_date', $item->ID); ?>
					  <?php $item_ratings = get_post_field('item_ratings', $item->ID); ?>	
					  <?php  $item_main_image = get_post_field('item_main_image', $item->ID); ?>
                      <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                        
                        <article class="lo-item lo-item-col <?php echo $WWItems->get_color( $item_content_type_icon ) ?>" >
                            <a href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?> >
                            <div class="img">
              <?php
              $item_main_image = get_field('item_main_image', $item->ID);
              if ($item_main_image):
                $size = "thumb-vertical"; 
                $image = wp_get_attachment_image_src( $item_main_image, $size );
              ?>
              <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive" />
              <?php else: ?>
								<?php echo $WWItems->get_thumbnail($item_content_type_icon) ?>
							<?php endif ?>
                            
                          </div>
                          <div class="content">
                            <div class="details">
                              <h3 class="sub-discipline">
                                <?php echo $WWItems->get_subdiscipline( $item->ID ) ?>
                              </h3>
                              <p class="content-type">
                                <?php echo $item_content_type_icon ?>
                              </p>
                              <p class="grade-level">
                                <?php echo $WWItems->get_grades( $item->ID ) ?>
                              </p>
                            </div>
                            <div class="content-title">
                              <h3><?php echo $item->post_title ?></h3>
                              <div class="content-type-icon">
                                <svg class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
									<use xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
								  </svg>
                              </div>
                            </div>
                          </div>
                            </a>
                        </article>
                        
                        <div class="lo-info lo-info-outside">
                          <div class="date-rate">
                            <p class="date">
                              <?php if ($item_publish_date): ?>
								<?php echo date_i18n( 'm-d-Y', strtotime( $item_publish_date ) ); ?>
								<?php endif; ?>
                            </p>
                            <div class="rate">
                              <?php rating_display_stars($item_ratings,'') ?>
								<p class="number">
								  <?php echo $item_ratings ? $item_ratings : '' ?>
								</p>
                            </div>
                          </div>
                          <p class="object-type">
                            <?php echo implode(', ',wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                          </p>
                        </div>                       
                                          
                      </div>
					  <?php endforeach; ?>
						
                    </div><!-- /row -->
					<?php endif; ?>
                    
                  </section><!-- /lo-items -->
                      
                </div><!-- /hidden-xs -->
                
                <div class="visible-xs-block">
                  
				  <?php if ($recommendations): ?>
                  <div class="mobile-accordion">
                    
					<?php foreach ($recommendations as $k => $item): ?>
				
					<?php $item_content_type_icon = get_post_field('item_content_type_icon', $item->ID); ?>
					<?php $item_preview = get_post_field('item_preview', $item->ID); ?>
					<?php $item_publish_date = get_post_field('item_publish_date', $item->ID); ?>
					<?php $item_ratings = get_post_field('item_ratings', $item->ID); ?>	
                    <article class="lo-item <?php echo $WWItems->get_color( $item_content_type_icon ) ?>" >
                      <a href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?>>
                        <div class="content">
                        <div class="details">
                          <h3 class="sub-discipline">
                            <?php echo $WWItems->get_subdiscipline( $item->ID ) ?>
                          </h3>
                          <p class="content-type">
                            <?php echo $item_content_type_icon ?>
                          </p>
                          <p class="grade-level">
                            <?php echo $WWItems->get_grades( $item->ID ) ?>
                          </p>
                        </div>
                        <div class="more-info">
                          <div class="content-title">
                            <h3><?php echo $item->post_title ?></h3>
                            <div class="content-type-icon">
                              <svg class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
								<use xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
							  </svg>
                            </div>
                          </div>
                          <div class="rate">
                            <?php rating_display_stars($item_ratings,'') ?>
							<p class="number">
							  <?php echo $item_ratings ? $item_ratings : '' ?>
							</p>
                          </div>                                                                
                        </div>
                        <div class="lo-info">
                          <div class="date-rate">
                            <p class="date">
                              <?php if ($item_publish_date): ?>
								<?php echo date_i18n( 'm-d-Y', strtotime( $item_publish_date ) ); ?>
								<?php endif; ?>
                            </p>
                            <p class="object-type">
                              <?php echo implode(', ',wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                            </p>                      
                          </div>
                        </div>           
						<?php if (substr($item_preview,0,1) === 'Y'): ?>
                        <div class="ribbon"><span class="icon"></span> Preview</div>                 
						<?php endif; ?>
                      </div>
                      </a>
                    </article>
                    <?php endforeach; ?>
                                                                                  
                  </div><!-- /mobile-accordion -->
                  <?php endif; ?>
                  
                </div><!-- /visible-xs-block -->
                
              </div><!-- /lo-container -->
              
            </div>
            
            <?php if ($modal_help_text) { ?>
            <p class="help-text">
            	<?php echo $modal_help_text; ?>
            </p>
            <?php } ?>

            <?php if (($modal_help_link_text) && ($modal_help_link_url)) { ?>
            	<a href="<?php echo $modal_help_link_url; ?>" class="btn"><?php echo $modal_help_link_text; ?></a>
            <?php } ?>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>
	<?php endif; ?>
	
	<?php
	if(is_page(53894) || is_page('sellwithus')){
	?>
    
    <div class="modal fade" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="customizeModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <?php if ($modal_customize_title) { ?>
            <div class="modal-title">
              <h3>Become A Seller</h3>
            </div>
            <?php } ?>
            
            <?php if ($modal_customize_description) { ?>
            	<div class="modal-desc">
              	<p>Have a great digital learning product to sell?  We’d love it in our marketplace!<br />
Complete the form below to apply to be a seller with us.</p>
            	</div>
            <?php } ?>
            
            <div class="container-fluid container-form">
                            
              <?php echo do_shortcode('[contact-form-7 id="56762" title="Vendor Registration"]'); ?>
              
            </div>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>  
    
    <?php
	}
	?>
