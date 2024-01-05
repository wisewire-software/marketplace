<?php
/**
 * Template Name: Page Press
 */

?>

<?php get_header(); ?>
    <div id="press-page">
        <?php if (have_rows('repeater_parent')): ?>
            <?php while (have_rows('repeater_parent')): the_row(); ?>
                <?php $title_header = get_sub_field('title_header'); ?>
                <div class="wrapper-press">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-3"><h2><?php echo($title_header ? $title_header : ''); ?></h2></div>
                            <div class="col-sm-9">
                                <?php if (have_rows('repeater_child')): ?>
                                    <?php while (have_rows('repeater_child')): the_row(); ?>
                                        <?php
                                        $title = get_sub_field('title');
                                        $description = get_sub_field('description');
                                        $read_more_label = get_sub_field('read_more_label');
                                        $read_more_url = get_sub_field('read_more_url');
                                        ?>
                                        <h3><?php echo($title ? $title : ''); ?></h3>
                                        <p>
                                            <?php echo($description ? $description : ''); ?>
                                        </p>
                                        <?php if ($read_more_url && $read_more_label): ?>
                                            <a target="_blank"
                                               href="<?php echo $read_more_url; ?>"><?php echo $read_more_label ?></a>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
<?php get_footer(); ?>