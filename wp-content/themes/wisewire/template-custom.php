<?php
/**
 * Template Name: Custom Content
 */

?>

<?php get_header(); ?>  

  <?php
    // Fields
    $custom_headline = get_field('custom_headline');
    $custom_description = get_field('custom_description');
    $services_title = get_field('services_title');
    $cta_paragraph_text = get_field('cta_paragraph_text');
    $cta_button_text = get_field('cta_button_text');
  ?>

    <div class="container">
      <div class="page-title">
        <h1>
          <?php the_title(); ?>
        </h1>
      </div>      
    </div>


    <section class="custom-intro">
      <div class="container">
        <?php if ($custom_headline) { ?>
        	<h2><?php echo $custom_headline; ?></h2>
        <?php } ?>
        
        <?php if ($custom_description) { ?>
          <?php echo $custom_description; ?>
        <?php } ?>
         
      </div>
    </section><!-- /custom-intro -->


    <?php if( have_rows('section_repeater') ): ?>

    	<?php while( have_rows('section_repeater') ): the_row(); 
    
    		// vars
    		$section_color_theme = get_sub_field('section_color_theme');
    		$section_headline = get_sub_field('section_headline');
    		$section_content = get_sub_field('section_content');
    		$section_image = get_sub_field('section_image');
    		
    		
    
      ?>
              
      <section class="custom-item custom-color-<?php echo $section_color_theme; ?>">
        <div class="container">
          <div class="row">
          
              <div class="col-sm-6 col-left <?php echo ($section_image)? "":"col-large"; ?>">
                <?php if ($section_headline) { ?>
                	<h2><?php echo $section_headline; ?></h2>
                <?php } ?>
                <?php if ($section_content) { ?>
                	<?php echo $section_content; ?>
                <?php } ?>
              </div>
              
              <?php if ($section_image) { ?>
              <div class="col-sm-6 col-right">
                <img src="<?php echo $section_image; ?>" alt="" class="img-responsive" />
              </div>        
              <?php } ?>

          </div>
        </div>
    </section><!-- /custom-item -->
    
      <?php endwhile; ?>
    
    <?php endif; ?>

    
    <?php if ($services_title) { ?>
    <div class="services-title">
      <div class="container">
      	<h2><?php echo $services_title; ?></h2>
      </div>
    </div>
    <?php } ?>

    
    
    <?php if( have_rows('services_repeater') ): ?>
    
    <!-- Visible on <768px -->
    
    <div class="visible-xs-block">
      
      <div class="services">
        
        <div class="mobile-accordion" id="service-accordion-1" role="tablist" aria-multiselectable="true">
          
        <?php $i = 1; ?>
        <?php while( have_rows('services_repeater') ): the_row(); ?>
    	 
      	<?php
        	// Fields
          $services_tab_title = get_sub_field('services_tab_title');	
          $tab_content = get_sub_field('tab_content');
        ?>
        
          <div class="panel panel-default">
            
            <?php if ($services_tab_title) { ?>        
            <div class="panel-heading" role="tab" id="serviceItemHeading<?php echo $i; ?>">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#service-accordion-1" href="#serviceItem<?php echo $i; ?>" aria-expanded="true" aria-controls="serviceItem<?php echo $i; ?>" class="collapsed">
                  <?php echo $services_tab_title; ?>
                </a>
              </h4>
            </div>
            <?php } ?>
            
            <div id="serviceItem<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="serviceItemHeading<?php echo $i; ?>">
              <div class="panel-body">

              <?php if ($tab_content) { ?>
              	<?php echo $tab_content; ?>
              <?php } ?>
     
              </div>
            </div>
          </div>
         
          <?php $i++ ;?>
      	<?php endwhile; ?>

        </div><!-- /panel-group -->
        
      </div><!-- /services -->
              
    </div><!-- /visible-xs-block -->
    
    <?php endif; ?>
    
    
    
    
    
    <?php if( have_rows('services_repeater') ): ?>
    
    <!-- Hidden on <768px -->
    
    <section class="nav-grades services hidden-xs">
      
      <div class="container">
         <!-- 
        <ul class="lo-nav" role="tablist">
          
          <?php $i = 1; ?>
          <?php while( have_rows('services_repeater') ): the_row(); ?>
      	 
        	<?php
          	// Fields
            $services_tab_title = get_sub_field('services_tab_title');	
            $tab_content = get_sub_field('tab_content');
          ?>
            
          <?php if ($services_tab_title) { ?>
            <li role="presentation" <?php if($i==1) echo 'class="active"';?>><a href="#nav-<?php echo $i; ?>" aria-controls="nav-<?php echo $i; ?>" role="tab" data-toggle="tab"><?php echo $services_tab_title; ?></a></li>
          <?php } ?>  
          
            <?php $i++; ?>
        	<?php endwhile; ?>
      	
        </ul>
        -->
        <!-- Tab panes -->
        <div class="tab-content">
          
          <?php $i = 1; ?>
          <?php while( have_rows('services_repeater') ): the_row(); ?>
      	 
        	<?php
          	// Fields
            $services_tab_title = get_sub_field('services_tab_title');	
            $tab_content = get_sub_field('tab_content');
          ?>
            
            <div role="tabpanel" class="tab-pane<?php if($i==1) echo ' active';?>" id="nav-<?php echo $i; ?>">
              <?php if ($tab_content) { ?>
              	<?php echo $tab_content; ?>
              <?php } ?>             
            </div>
                      
            <?php $i++; ?>
        	<?php endwhile; ?>   
        	
        </div>         
                    
      </div>
      
    </section><!-- /hidden-xs -->
    
    <?php endif; ?>    
    
    <!-- Hidden on <768px -->
    

    <?php if ($cta_paragraph_text) { ?>
    	
    <div class="container services-more">
      <div class="learning-more">
        <p><?php echo $cta_paragraph_text; ?></p>
        <?php if ($cta_button_text) { ?>
        	<a href="#" class="btn" data-toggle="modal" data-target="#contactModal"><?php echo $cta_button_text; ?></a>
        <?php } ?>
      </div>
    </div>
    <?php } ?>




<?php get_footer(); ?>