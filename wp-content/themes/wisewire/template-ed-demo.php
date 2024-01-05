<?php
/**
 * Template Name: Edgenuity Demo Items
 */

get_header(); ?>  

<?php $content = get_field('content'); ?>  
<section class="ww_b2b bg_white">  
<div class="container">
<h2 class="title-orange"><?php the_title(); ?></h2>
    <?php if ($content) { ?>
        <h5><?php echo $content; ?></h5>
    <?php } ?>
<p>Select an item to view a sample</p>
<ul style="list-style:none;"">
<li><a href="https://platform.wisewire.com/external/pod/fabe2f71-953f-497a-a636-6bdd1cf199ba" class="title-lightblue" target="_blank">G1 ELA Samples</a></li>
<li><a href="https://platform.wisewire.com/external/pod/6f361687-a83b-4c98-8fa9-bf30ac06225e" class="title-lightblue" target="_blank">G4 ELA Samples</a></li>
<li><a href="https://platform.wisewire.com/external/pod/89ec013f-a2e2-4721-8fcf-a8be98ba4b15" class="title-lightblue" target="_blank">G1 Math Samples</a></li>
<li><a href="https://platform.wisewire.com/external/pod/9e47c804-2900-4af1-b380-9ece527ebef5" class="title-lightblue" target="_blank">G5 Math Samples</a></li>
</ul>

</div>
</section>
<?php get_footer(); ?>
