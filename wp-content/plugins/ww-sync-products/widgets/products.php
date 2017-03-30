<?php
/**
 * ClearAdmitProducstWidget Class
 */
class ClearAdmitProductsWidget extends WP_Widget {
    /** constructor */
    function ClearAdmitProductsWidget() {
        parent::WP_Widget(false, $name = 'Clear Admit Products Widget');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
	
		
		$id = apply_filters('widget_title', $instance['id']);
		$showposts = apply_filters('widget_title', $instance['showposts']);
		$title = apply_filters('widget_title', $instance['title']);
        ?>
                        
          <!-- Add anything you want below this -->              
			<?php wp_reset_query(); ?>
                 <?php 
                       global $wpdb;
					   
					  global $wp_query;
					  $post_id = $wp_query->post->ID;
					  
					 // $post_id;
					  
					  $schoolterms = wp_get_post_terms($post_id, 'schools', array("fields" => "all"));
	
					  
					  $school_slug = array();
					  
					  
					  foreach($schoolterms as $schoolterm){
						  
						  $school_slug[] = $schoolterm->slug;
					  }
					  
					  $school_slug = implode($school_slug);
					  
					 // echo $school_slug;
	
				
				?>

				<?php 
		

						
						
						 $prodsq = "SELECT DISTINCT (wp_posts.ID), wp_posts.post_title, wp_posts.post_date, wp_posts.comment_count
							FROM wp_posts
							LEFT JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id )
							LEFT JOIN wp_term_relationships ON ( wp_posts.ID = wp_term_relationships.object_id )
							INNER JOIN wp_term_taxonomy ON ( wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id )
							INNER JOIN wp_terms ON ( wp_terms.term_id = wp_term_taxonomy.term_id )
							WHERE (
							wp_posts.post_type = 'ca-products'
							AND wp_posts.post_status = 'publish'
							AND wp_term_taxonomy.taxonomy = 'schools'
							AND wp_terms.slug = '$school_slug'
							)
							ORDER BY wp_posts.post_title ASC
							LIMIT $showposts"; 
	
						$prodsaltq = "SELECT DISTINCT (wp_posts.ID), wp_posts.post_title, wp_posts.post_date, wp_posts.comment_count
							FROM wp_posts
							LEFT JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id )
							LEFT JOIN wp_term_relationships ON ( wp_posts.ID = wp_term_relationships.object_id )
							INNER JOIN wp_term_taxonomy ON ( wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id )
							INNER JOIN wp_terms ON ( wp_terms.term_id = wp_term_taxonomy.term_id )
							WHERE (
							wp_posts.post_type = 'ca-products'
							AND wp_posts.post_status = 'publish'
							)
							ORDER BY wp_posts.post_title ASC
							LIMIT $showposts";  
	
					
					// The Query
					$prods = $wpdb->get_results($prods, OBJECT); 
					$prodsaltq = $wpdb->get_results($prodsaltq, OBJECT); 
					
					// echo $num;
					if(empty($prods)){
						$prods = $prodsaltq;
					}
					
					?>
                
                
        
			   <?php  if ($prods): ?>
              
                                  
                            <?php if ( !empty( $title ) )
									echo $before_title . $title . $after_title;
							?>
                            <div class="widget">
                            
								  <?php
                                        foreach ($prods as $post): 
                                            setup_postdata($post); ?>
                                
                                  <div class="sidebar-product">
                                  	<div class="product-thumb">
                                    	<?php the_post_thumbnail('sidebar-product'); ?>
                                    </div>
									
                                 <?php $terms = get_the_terms( $post->ID , 'ca-product-cats' );
												 $count = count($terms);
												 if($count > 0)
													 {
														 echo '<span class="productCat">';
														 foreach ($terms as $term) 
															 {
																 echo $term->name;
															 }
														 echo '</span> ';
													 }
								
								?><br />
								<a href="<?php echo get_blog_permalink(1, get_the_ID()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><br />
                                <p class="porduct-price">
                                
                                	<?php $price = get_field('price'); ?>
                                	<?php if(is_numeric($price)){ ?>
                                		$<?php }  ?>
									<?php echo $price; ?>
                                
                                </p>
                                	<div class="product-button-container">
                                            
                                            <a class="smaller-button smalleryellow"  href="<?php the_field('product_link'); ?>">
                                                <span>Download Now +</span>
                                            </a>
                                            
                                            <a class="smaller-button smalleryellow"  href="<?php echo get_blog_permalink(1, get_the_ID()); ?>">
                                                <span>Learn More &raquo;</span>
                                            </a>
                                            
                                  		<div class="clear"></div>
                                  	</div>
                                  </div>
 <?php endforeach; ?>
              
                              <div align="center"><a href="<?php bloginfo('url'); ?>/products">view all products</a></div>
                                  
                             
     						
                          <?php else: ?>
        
                             <!-- The very first "if" tested to see if there were any Posts to -->
                             <!-- display.  This "else" part tells what do if there weren't any. -->
                            
                             <br />
                             <p>Sorry, there are no products for this school.</p>
                            
                             <!-- REALLY stop The Loop. -->
                             
                         <?php endif; ?>                
          
		
                  
                  
          		<!-- Ok, Ok, you can stop adding stuff now -->
          
              
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
		$id = esc_attr($instance['id']);
		$showposts = esc_attr($instance['showposts']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input size="30" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            
             <p><label for="<?php echo $this->get_field_id('showposts'); ?>"><?php _e('# of Products:'); ?> <input size="2" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo $showposts; ?>" /></label></p>
            
        <?php 
    }

} // class ClearAdmitProducstWidget

// register ClearAdmitProducstWidget widget
add_action('widgets_init', create_function('', 'return register_widget("ClearAdmitProductsWidget");'));

?>