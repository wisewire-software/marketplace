<?php
/*
Template Name: Regular Page
*/
 get_header(); ?> 
 
 <div class="container">
      <div class="page-title">
        <h1>
          <?php the_title(); ?>
        </h1>
      </div> 
      
      
      <?php if ( have_posts() ) : ?>
    
		<?php while ( have_posts() ) : the_post(); ?>
    
    
			<?php the_content(); ?>
     
		<?php endwhile; ?>
    
	<?php endif; ?>  
           
    </div>
<!-- BalkanOutsource 2016-06-06 - Google Analytics event tracking --> 
<script type="text/javascript">
  $('.checkout-button').on('mousedown', function(){
    ga('send', 'event', 'Checkout', 'Click');
  });
</script>
	   

<?php get_footer(); ?>