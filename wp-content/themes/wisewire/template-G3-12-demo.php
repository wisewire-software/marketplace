<?php
/**
 * Template Name: Grade 3-12 Math and ELA  Demo Items
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
<li><a href="https://platform.wisewire.com/external/pod/57bd42bd-8774-4058-b5cd-0b8d00c10017" class="title-lightblue" target="_blank">Grade 3-12 Sample Math Items</a></li>
<li><a href="https://platform.wisewire.com/external/pod/0f76c575-64ab-4a39-aedd-31734460e0b2" class="title-lightblue" target="_blank">Grade 3-12 Sample ELA Items</a></li>
<li><a href="" class="title-lightblue" target="_blank"></a></li>
</ul>

</div>
</section>
<?php get_footer(); ?>
