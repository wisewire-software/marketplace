<?php
/**
 * Template Name: Explore
 */

session_start();

require get_template_directory() . "/Controller/Explore.php";
$control = new Controller_Explore();

// Get the grade level from the URL
$grade = isset($wp_query->query['grade']) ? $wp_query->query['grade'] : 'middle';

// Redirect to homepage in case grade level doesn't match
if (sizeof($control->grades_ids) > 0) {

} else {
    wp_redirect(home_url());
    exit;
}
?>

<?php get_header(); ?>  



    <!-- Visible on <768px -->
    <div class="customize-link-mobile visible-xs-block">
        <div class="container">
            <p>
                <a href="#" data-toggle="modal" data-target="#customizeModal">CUSTOMIZE CONTENT ></a>
            </p>
        </div>
    </div>

    <!-- Visible on <768px -->
    <section class="nav-grades-mobile visible-xs-block">
        <div class="container">
            <p>
                <?php echo strtoupper($control->grade) ?>
            </p>
        </div>
    </section>

<?php get_template_part('parts/grades', 'explorenavigation' . (WiseWireApi::get_option('gradelevels_nav') == 'full' ? '' : '_1')); ?>


<?php $featured_items = array();
$featured_item = false ?>

<?php if (have_rows('featured_item')): ?>

    <?php while (have_rows('featured_item')): the_row(); ?>

        <?php $featured_grade_level = get_sub_field('featured_grade_level'); ?>

        <?php if ($grade === $featured_grade_level) { ?>

            <?php if (have_rows('featured_repeater')): ?>

                <?php while (have_rows('featured_repeater')): the_row(); ?>

                    <?php
                    // Fields
                    $featured_publish_date_from = get_sub_field('featured_publish_date_from');
                    list($fm, $fd, $fy) = explode('-', $featured_publish_date_from ? $featured_publish_date_from : date('m-d-Y'));
                    $featured_publish_date_to = get_sub_field('featured_publish_date_to');
                    list($tm, $td, $ty) = explode('-', $featured_publish_date_to ? $featured_publish_date_to : date('m-d-Y'));

                    if (strtotime($fy . '-' . $fm . '-' . $fd . ' 00:00:00') > time()) continue;
                    if (strtotime($ty . '-' . $tm . '-' . $td . ' 23:59:59') < time()) continue;

                    $featured_items [] = get_sub_field('featured_item');
                    ?>

                <?php endwhile; ?>

            <?php endif; ?>
        <?php } ?>

    <?php endwhile ?>
    
  <?php endif; ?>

<?php if (sizeof($featured_items)): ?>
    <?php $featured_item = $featured_items[array_rand($featured_items)] ?>
<?php endif; ?>
<?php if ($featured_item): ?>
    <?php foreach ($featured_item as $post): ?>
        <section class="feature-banner <?php echo $WWItems->get_color($post->content_type_icon); ?>">
            <?php
            $is_merlot = $post->source === 'MERLOT' ? true : false;
            $title = $post->title;
            $item_main_image_attributes = wp_get_attachment_image_src($post->image_id, 'featured');
            $item_source = $post->source;
            $item_preview = $post->preview;
            $item_demo_viewer_template = '';
            $item_object_url = '';
            $item_preview_pdf = '';
            $item_carousel_images = array();
            $item_demo_subhead = '';

            if ($item_source == 'CMS') {
                $item_demo_viewer_template = get_field('item_demo_viewer_template', $post->id);
                $item_object_url = get_field('item_object_url', $post->id);
                $item_preview_pdf = get_field('item_preview_pdf', $post->id);
                $item_carousel_images = get_field('item_carousel_images', $post->id);
                $item_demo_subhead = get_field('item_demo_subhead');
            } elseif ($item_source == 'PLATFORM' || $item_source == 'MERLOT') {
                $item_demo_viewer_template = 'Iframe';
                $item_object_url = $post->preview_url;
            }
            ?>

            <div class="container">
                <div class="wrapper">
                    <div class="img">
                        <a href="/item/<?php echo($post->type == 'item' ? $post->name : $post->id) ?>/" <?php echo add_rel_nofollow_to_item($post->id) ?> >
                            <?php
                            if ($item_main_image_attributes):?>
                                <img alt="" src="<?php echo $item_main_image_attributes[0]; ?>" class="img-responsive"/>
                                <?php
                            else:
                                echo $WWItems->get_thumbnail($post->content_type_icon, 'featured');
                            endif;
                            ?>
                        </a>
                    </div>
                    <div class="content">
                        <a href="/item/<?php echo($post->type == 'item' ? $post->name : $post->id); ?>"  <?php echo add_rel_nofollow_to_item($post->id) ?> >
                            <h3>
                                <?php $discipline = $WWItems->get_discipline($post->id) ?>
                                <?php if ($discipline):
                                    echo $discipline['name'];
                                endif; ?>
                            </h3>
                            <p>
                                <?php echo $title ?>
                            </p>
                        </a>
                        <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                            <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                                <a href="#" class="ribbon btn-iframe" data-toggle="modal" data-target="#previewModal"
                                   data-src="<?php echo $item_object_url; ?>"><span class="icon"></span> Preview</a>
                            <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                                <a href="<?php echo $item_preview_pdf; ?>" class="ribbon" target="_blank"><span
                                        class="icon"></span> Preview</a>
                            <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                                <a href="#" class="ribbon" data-toggle="modal" data-target="#previewModal"><span
                                        class="icon"></span> Preview</a>
                            <?php } ?>
                        <?php } ?>
                        <?php include( locate_template( 'parts/modal-preview.php', false, false ) ); ?>
                    </div>
                </div>
            </div>
        </section><!-- /feature-banner -->
    <?php endforeach; ?>
<?php endif; ?>

<?php if (have_rows('grade_repeater')): ?>
    <div class="hidden-xs">
        <?php while (have_rows('grade_repeater')): the_row(); ?>
            <?php $grade_cms = get_sub_field('grade'); ?>
            <?php if ($grade === $grade_cms) { ?>

                <?php if (have_rows('carousel_repeater')): ?>

                    <?php while (have_rows('carousel_repeater')): the_row(); ?>

                        <?php $category_name = get_sub_field('section_category'); ?>

                        <section class="lo-carousel lo-items lo-shadow">

                            <div class="container">

                                <div class="section-title">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h3>
                                                <?php echo $category_name->name; ?>
                                            </h3>
                                        </div>
                                        <div class="col-sm-6 viewall">
                                            <a href="/explore/<?php echo $grade; ?>/<?php echo $category_name->slug; ?>">
                                                View all
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <?php $posts = get_sub_field('section_items'); ?>
                                <?php if ($posts): ?>
                                    <div class="carousel">
                                        <?php foreach ($posts as $post): ?>
                                            <?php
                                            $item_id = $post->id;
                                            $title = $post->title;
                                            $item_main_image_attributes = wp_get_attachment_image_src($post->image_id, 'thumbnail');
                                            $item_publish_date = date('m-d-Y', strtotime($post->publish_date));
                                            $item_preview = $post->preview;
                                            ?>

                                            <div class="col-2-next">
                                                <a data-itemtitle="<?php echo $title; ?>"
                                                   class="lo-item lo-item-col <?php echo $WWItems->get_color($post->content_type_icon); ?> has-preview"
                                                   href="/item/<?php echo($post->type == 'item' ? $post->name : $post->id) ?>/" <?php echo add_rel_nofollow_to_item($post->id) ?> >
                                                    <div class="img">
                                                        <?php
                                                        if ($item_main_image_attributes):?>
                                                            <img alt=""
                                                                 src="<?php echo $item_main_image_attributes[0]; ?>"
                                                                 class="img-responsive"/>
                                                        <?php else: ?>
                                                            <?php echo $WWItems->get_thumbnail($post->content_type_icon, 'thumbnail'); ?>
                                                        <?php endif ?>
                                                        <?php if ($item_preview == 'Y'): ?>
                                                            <div class="ribbon"><span class="icon"></span> Preview</div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="content">
                                                        <div class="details">
                                                            <h3 class="sub-discipline">
                                                                <?php echo $post->subdiscipline; ?>
                                                            </h3>
                                                            <p class="content-type">
                                                                <?php echo $post->content_type_icon; ?>
                                                            </p>
                                                        </div>
                                                        <div class="content-title">
                                                            <h3><?php echo $title; ?></h3>
                                                            <div class="content-type-icon">
                                                                <svg
                                                                    class="svg-<?php echo $WWItems->get_icon($post->content_type_icon); ?>-dims">
                                                                    <use
                                                                        xlink:href="#<?php echo $WWItems->get_icon($post->content_type_icon); ?>"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>

                                                <div class="lo-info lo-info-outside">
                                                    <div class="date-rate">
                                                        <p class="date">
                                                            <?php if ($item_publish_date): ?>
                                                                <?php echo $item_publish_date; ?>
                                                            <?php endif; ?>
                                                        </p>
                                                        <div class="rate">
                                                            <?php rating_display_stars($post->ratings, '') ?>
                                                            <p class="number">
                                                                <?php echo $post->ratings ? $post->ratings : '' ?>
                                                            </p>
                                                            <?php do_action('product_tile_price', $post); // helloAri  ?>
                                                        </div>
                                                    </div>
                                                    <p class="object-type">
                                                        <?php echo str_replace("tei", "&nbsp;TEI&nbsp;", ucfirst($post->object_type)) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div><!-- /container -->

                        </section><!-- /lo-carousel -->

                    <?php endwhile; ?>

                <?php endif; ?>

            <?php } ?>

        <?php endwhile; ?>

    </div><!-- /hidden-xs -->

<?php endif; ?>


<?php if (have_rows('grade_repeater')): ?>

    <!-- Visible on <768px -->

    <div class="visible-xs-block">

        <div class="mobile-accordion" id="lo-accordion-1" role="tablist" aria-multiselectable="true">

            <?php $k = 1; ?>
            <?php while (have_rows('grade_repeater')): the_row(); ?>

                <?php $grade_cms = get_sub_field('grade'); ?>

                <?php if ($grade === $grade_cms) { ?>


                    <?php if (have_rows('carousel_repeater')): ?>

                        <?php while (have_rows('carousel_repeater')): the_row(); ?>

                            <?php $category_name = get_sub_field('section_category'); ?>


                            <div class="panel panel-default">

                                <div class="panel-heading" role="tab" id="loItemHeading<?php echo $k ?>">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#lo-accordion-1"
                                           href="#loItem<?php echo $k ?>" aria-expanded="true" aria-controls="loItem1"
                                           class="collapsed">
                                            <?php echo $category_name->name; ?>
                                        </a>
                                    </h4>
                                </div>

                                <div id="loItem<?php echo $k ?>" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="loItemHeading<?php echo $k ?>">
                                    <div class="panel-body">
                                        <?php $posts = get_sub_field('section_items'); ?>
                                        <?php if ($posts): ?>
                                            <?php foreach ($posts as $post): ?>
                                                <?php
                                                $item_id = $post->id;
                                                $title = $post->title;
                                                $item_main_image_attributes = wp_get_attachment_image_src($post->image_id, 'thumbnail');
                                                $item_publish_date = date('m-d-Y', strtotime($post->publish_date));
                                                $item_preview = $post->preview;
                                                ?>

                                                <article
                                                    class="lo-item <?php echo $WWItems->get_color($post->content_type_icon); ?>"
                                                    data-itemtitle="<?php echo $title; ?>">
                                                    <a href="/item/<?php echo($post->type == 'item' ? $post->name : $post->id) ?>/" <?php echo add_rel_nofollow_to_item($post->id) ?>>
                                                        <div class="content">
                                                            <div class="details">
                                                                <h3 class="sub-discipline">
                                                                    <?php echo $post->subdiscipline; ?>
                                                                </h3>
                                                                <p class="content-type">
                                                                    <?php echo $post->content_type_icon; ?>
                                                                </p>
                                                            </div>
                                                            <div class="more-info">
                                                                <div class="content-title">
                                                                    <h3><?php echo $title; ?></h3>
                                                                    <div class="content-type-icon">
                                                                        <svg
                                                                            class="svg-<?php echo $WWItems->get_icon($post->content_type_icon) ?>-dims">
                                                                            <use
                                                                                xlink:href="#<?php echo $WWItems->get_icon($post->content_type_icon) ?>"></use>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <div class="rate">
                                                                    <?php rating_display_stars($post->ratings, '') ?>
                                                                    <p class="number">
                                                                        <?php echo $post->ratings ? $post->ratings : '' ?>
                                                                    </p>
                                                                    <?php do_action('product_tile_price', $post); // helloAri  ?>
                                                                </div>
                                                            </div>
                                                            <div class="lo-info">
                                                                <div class="date-rate">
                                                                    <p class="date">
                                                                        <?php if ($item_publish_date): ?>
                                                                            <?php echo date_i18n('m-d-Y', strtotime($item_publish_date)); ?>
                                                                        <?php endif; ?>
                                                                    </p>
                                                                    <p class="object-type">
                                                                        <?php echo str_replace("tei", "&nbsp;TEI&nbsp;", ucfirst($post->object_type)) ?>
                                                                    </p>

                                                                </div>
                                                            </div>
                                                            <?php if ($item_preview == 'Y'): ?>
                                                                <div class="ribbon"><span class="icon"></span> Preview</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </a>
                                                </article>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <div class="view-more-link">
                                            <a href="/explore/<?php echo $grade; ?>/<?php echo $category_name->slug; ?>">View
                                                all</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php $k++; ?>

                        <?php endwhile; ?>

                    <?php endif; ?>

                <?php } ?>

            <?php endwhile; ?>

        </div><!-- /mobile-accordion -->

    </div><!-- /visible-xs-block -->

<?php endif; ?>

<!-- SEO improvements -->
<div class="container">
    <div class="row container-seo">
        <div class="col-md-9">
            <h1 class="title-page">
                <?php echo nl2br($control->title); ?>
            </h1>
            <div class="meta-description-page">
                <?php echo nl2br($control->meta_description) ?>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<div class="back-to-top" id="back-to-top">
    <a href="#header" class="scroll">Back to top</a>
</div>
<?php get_footer(); ?>