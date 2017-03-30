<?php
/**
 * Template Name: Page Item demo featured
 */

?>

<?php get_header(); ?>
<?php $featured_items =  array(); ?>
<?php if( have_rows('test_featured_item') ): ?>

    <?php while( have_rows('test_featured_item') ): the_row();


        $featured_items []= get_sub_field('test_lo_items');
        ?>

    <?php endwhile ?>

<?php endif; ?>

<?php
print_r("<pre>");
var_dump($featured_items);
print_r("</pre>");
?>


<?php get_footer(); ?>