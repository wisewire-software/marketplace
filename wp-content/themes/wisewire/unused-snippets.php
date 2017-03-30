    <?php
      
      // CPT - Get Testimonials
      $args = array(
        'post_type' => 'testimonial',
        'posts_per_page' => -1
      );
    
      $testimonial_query = new WP_Query( $args );
      
    ?>
    
    <?php if ( $testimonial_query->have_posts() ) : ?>
    
      <?php $i = 1; ?>
      
		  <?php while ( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); ?>    
      
        <?php
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
                <p class="district-name" role="button" data-toggle="collapse" href="#districtContent1" aria-expanded="false" aria-controls="districtContent1">
                	<?php echo $testimonials_district_name; ?> <span class="caret pull-right"></span>
                </p>
                <?php } ?>
                
                <?php if ($testimonials_district_description) { ?>
                <div class="district-text collapse" id="districtContent1">
                  <p>
                    <?php echo $testimonials_district_description; ?>
                  </p>                
                </div>
              </div>
              <?php } ?>
        	
              <?php if ($testimonials_download_pdf) { ?>   
              <p class="btn-cta">
                <a href="<?php echo $testimonials_download_pdf['url']; ?>" target="_blank">Download whitepaper ></a>
              </p>
              <?php } ?>
               
            </div>
          </div>
          
        </article><!-- /testimonial -->
        
      
        <?php $i++; ?>
    
      <?php endwhile; ?>
    
    <?php endif; wp_reset_query(); wp_reset_postdata(); ?> 
    
    
    
    
    
    
    
    
    <?php
      
      // CPT Partners
      $args = array(
        'post_type' => 'partner',
        'posts_per_page' => -1
      );
    
      $partner_query = new WP_Query( $args );
      
    ?>
    
    <?php if ( $partner_query->have_posts() ) : ?>
      
      <div class="partner-logos">
        
        <ul class="list-inline">
          
          <?php $i = 1; ?>
          
    		  <?php while ( $partner_query->have_posts() ) : $partner_query->the_post(); ?>  
    		         
            <?php
              
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
              <div 
                data-toggle="popover" 
                <?php if ($partner_quote) { ?>
                data-content="<?php echo $partner_quote; ?>"  	
                <?php } ?>
                title='<div class="author"><strong><?php if ($partner_author_email) { ?><a href="mailto:<?php echo $partner_author_email; ?>"><?php if ($partner_author_name) { echo $partner_author_name; } else { echo $partner_author_email; } ?></a> <?php } else { ?><?php if ($partner_author_name) { echo $partner_author_name; } ?><?php } ?><?php if ($partner_author_title) { ?>, <?php echo $partner_author_title; ?><?php } ?></strong> <?php if ($partner_author_district) { echo $partner_author_district; } ?></div><?php if ($partner_download_pdf) { ?><p class="download"><a href="<?php echo $partner_download_pdf['url']; ?>" target="_blank">Download Whitepaper ></a></p><?php } ?>'
              >
                <?php if ($partner_logo_or_text == 'logoimage') { ?>
                  <?php if ($partner_logo) { ?>
                  	<img src="<?php echo $partner_logo; ?>" alt="" class="img-responsive" />
                  <?php } ?>
                <?php } else { ?>
                  <?php if ($partner_text) { echo '<p>'. $partner_text .'</p>'; } ?>
                <?php } ?>

              </div>
            </li>  		              
          
            <?php $i++; ?>
        
          <?php endwhile; ?>
      
        </ul>
        
      </div><!-- /partner-logos -->
      
    <?php endif; wp_reset_query(); wp_reset_postdata(); ?> 