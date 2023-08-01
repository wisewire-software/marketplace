<?php
/**
 * Template Name: AP Demo Items
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
<ul style="list-style: none">
<li><a href="https://platform.wisewire.com/question/ap-eng-lit-r-8-item-01-mc/e6b4c22d-9564-45be-bea9-7a63e68b6d9f" class="title-lightblue" target="_blank">AP English Literature</a></li>
<li><a href="https://platform.wisewire.com/question/ap-ush-8-2-ii-a-item-03-mc/72194a93-4a27-45bd-80ce-f61962922b1e" class="title-lightblue" target="_blank">AP US History</a></li>
<li><a href="https://platform.wisewire.com/question/ap-eng-lang-r-4-item-04-mc/21e4ee6c-cf9e-4c4e-b711-3c0b6abbf0b8" class="title-lightblue" target="_blank">AP English Language and Composition</a></li>
<li><a href="https://platform.wisewire.com/question/ap-eng-lang-w-10-item-02-mc/0abc36a2-a0fb-4900-a3b9-e11d4109e94f" class="title-lightblue" target="_blank">AP English Language and Composition</a></li>
</ul>
</div>
</section>
<?php get_footer(); ?>
