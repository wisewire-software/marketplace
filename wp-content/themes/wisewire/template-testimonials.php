<?php
/**
 * Template Name: Testimonials
 */
?>

<?php get_header(); ?>  


    <div class="container">
      <div class="page-title">
        <h1>
          <?php the_title(); ?>
        </h1>
      </div>      
    </div>
    
    <?php 
      $testimonials_description = get_field('testimonials_description');
      $pdf_file = get_field('pdf_file');
    ?>
    
    <?php if ($testimonials_description):?>
    <div class="container">             
      <div class="testimonials-description">

        <?php

          $link_download = "<a target='_blank' href='".$pdf_file."'>here</a>";
          $testimonials_description = str_replace('here', $link_download, $testimonials_description); 
          echo $testimonials_description;
        ?>
      </div>
    </div>    
    <?php endif?>

    <div class="container">

    <?php 
      // Show Testimonials using Relationshp field from ACF
      $testimonial_posts = get_field('testimonials');
      if( $testimonial_posts ):
        $i = 1;
        foreach( $testimonial_posts as $post):  
          setup_postdata($post); // variable must be called $post (IMPORTANT) 

          // Fields
          $testimonials_color_theme = get_field('testimonials_color_theme');
          $testimonials_quote = get_field('testimonials_quote'); 
          $testimonials_author_name = get_field('testimonials_author_name');
          $testimonials_author_title = get_field('testimonials_author_title');
          $testimonials_author_district = get_field('testimonials_author_district');
          $testimonials_author_email = get_field('testimonials_author_email');
          $testimonials_district_name = get_field('testimonials_district_name');
          $testimonials_district_description = get_field('testimonials_district_description');
          $testimonials_download_pdf = get_field('testimonials_download_pdf');

        ?>
  
          <article class="testimonial testimonial-style-<?php echo $testimonials_color_theme; ?>">
              
            <div class="col-left">
              <div class="quote">
                <div class="content">
                  <p>
                    <?php if ($testimonials_quote) { ?>
                    	<?php echo $testimonials_quote; ?>
                    <?php } ?>
                  </p>
                </div>
                <p class="author">
                  
                  <strong>
                  <?php if ($testimonials_author_email) { ?>
                    <a href="mailto:<?php echo $testimonials_author_email; ?>">
                      <?php if ($testimonials_author_name) { echo $testimonials_author_name; } else { echo $testimonials_author_email; } ?>
                    </a> 
                  <?php } else { ?>         
                    <?php if ($testimonials_author_name) { echo $testimonials_author_name; } ?>
                  <?php } ?>
                            
                  <?php if ($testimonials_author_title) { ?>
                  	, <?php echo $testimonials_author_title; ?>
                  <?php } ?>
                  </strong>
                  
                  <?php if ($testimonials_author_district) { echo $testimonials_author_district; } ?>
                </p>
              </div>
            </div>
    
            <div class="col-right">
              <div class="details">
                <div class="district-content">
                  
                  <?php if ($testimonials_district_name) { ?>
                  <p class="district-name" role="button" data-toggle="collapse" href="#districtContent<?php echo $i; ?>" aria-expanded="false" aria-controls="districtContent<?php echo $i; ?>">
                  	<?php echo $testimonials_district_name; ?> <span class="caret pull-right"></span>
                  </p>
                  <?php } ?>
                  
                  <?php if ($testimonials_district_description) { ?>
                  <div class="district-text collapse" id="districtContent<?php echo $i; ?>">
                    <p>
                      <?php echo $testimonials_district_description; ?>
                    </p>                
                  </div>
                </div>
                <?php } ?>
          	
                <?php if ($testimonials_download_pdf) { ?>   
                <p class="btn-cta<?php if ((!$testimonials_district_name) && (!$testimonials_district_description)) echo " btn-cta-alone"; ?>">
                  <a href="<?php echo $testimonials_download_pdf['url']; ?>" target="_blank">Download whitepaper ></a>
                </p>
                <?php } ?>
                 
              </div>
            </div>
            
          </article><!-- /testimonial -->
          
          <?php $i++; ?>     
        <?php endforeach; ?>
      <?php endif; wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
    
        
            
      <?php 
        // Show Partner Logos using Relationshp field from ACF
        $partners_posts = get_field('partners');
        if( $partners_posts ):
      ?>
      
        <div class="partner-logos">
          
          <ul class="list-inline">
            
          <?php    
          foreach( $partners_posts as $post):  
            setup_postdata($post); // variable must be called $post (IMPORTANT) 
  
            // Fields
            $partner_logo_or_text = get_field('partner_logo_or_text');     
            $partner_logo = get_field('partner_logo');
            $partner_text = get_field('partner_text');   
            $partner_quote = get_field('partner_quote');
            $partner_author_name = get_field('partner_author_name');
            $partner_author_title = get_field('partner_author_title');
            $partner_author_district = get_field('partner_author_district');
            $partner_author_email = get_field('partner_author_email');
            $partner_download_pdf = get_field('partner_download_pdf');
            
          ?>
        		         
            <li>
            <?php if ($partner_quote) { ?>
              <div 
                data-toggle="popover" 
                data-content="<?php echo $partner_quote; ?>"  	
                title='<?php if ($partner_author_name) { ?><div class="author"><strong><?php } else { ?><div><?php } ?><?php if ($partner_author_email) { ?><a href="mailto:<?php echo $partner_author_email; ?>"><?php if ($partner_author_name) { echo $partner_author_name; } else { echo $partner_author_email; } ?></a> <?php } else { ?><?php if ($partner_author_name) { echo $partner_author_name; } ?><?php } ?><?php if ($partner_author_title) { ?>, <?php echo $partner_author_title; ?><?php } ?></strong> <?php if ($partner_author_district) { echo $partner_author_district; } ?></div><?php if ($partner_download_pdf) { ?><p class="download"><a href="<?php echo $partner_download_pdf['url']; ?>" target="_blank">Download Whitepaper ></a></p><?php } ?>'
              >
            <?php } else { ?>
              <div>
            <?php } ?>
              <?php if ($partner_logo_or_text == 'logoimage') { ?>
                <?php if ($partner_logo) { ?>
                <?php
                  $size = "partner-logos"; // (thumbnail, medium, large, full or custom size)
                  $image = wp_get_attachment_image_src( $partner_logo, $size );
                  ?>
                  <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive" />
                <?php } ?>
              <?php } else { ?>
                <?php if ($partner_text) { echo '<p>'. $partner_text .'</p>'; } ?>
              <?php } ?>
              </div>
            </li>  		              
  
          <?php endforeach; ?>
          
          </ul>
          
        </div><!-- /partner-logos -->
                
      <?php endif; wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>      

      
    </div><!-- /container -->
    
   

<?php get_footer(); ?>