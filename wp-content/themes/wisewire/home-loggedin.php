<?php

session_start();

global $WWItems;

require get_template_directory() . "/Controller/Home.php";

$control = new Controller_Home();

?>

<?php $featured_items = array();
$featured_item = false ?>

<?php if (have_rows('featured_item')): ?>

    <?php while (have_rows('featured_item')): the_row();
        // Fields
        $publish_date_from = get_sub_field('publish_date_from');
        list($fm, $fd, $fy) = explode('-', $publish_date_from ? $publish_date_from : date('m-d-Y'));
        $publish_date_to = get_sub_field('publish_date_to');
        list($tm, $td, $ty) = explode('-', $publish_date_to ? $publish_date_to : date('m-d-Y'));

        if (strtotime($fy . '-' . $fm . '-' . $fd . ' 00:00:00') > time()) continue;
        if (strtotime($ty . '-' . $tm . '-' . $td . ' 23:59:59') < time()) continue;

        $featured_items [] = get_sub_field('lo_item');
        ?>
    <?php endwhile ?>
<?php endif; ?>

<?php if (sizeof($featured_items)): ?>
    <?php $featured_item = $featured_items[array_rand($featured_items)] ?>
<?php endif; ?>

<!-- BEGIN featured Auhtors Carousel-->
<section class="lo-featured featured_banner_pending_authors"
         style="<?php echo (count($control->featured_authors) > 0) ? '' : 'display:none' ?>   ">

    <!-- BEGIN Pending authors -->
    <div class="feature-banner featured_banner_pending_authors" style="margin:0">
        <div class="container">
            <section class="lo-items lo-shadow lo-authors">

                <div class="carousel">

                    <?php if (count($control->featured_authors) > 0): ?>
                        <?php foreach ($control->featured_authors as $k => $v): ?>

                            <?php
                            // Fields
                            $id = $v["id"];
                            $title = $v["title"];
                            $externalPreviewURL = $v["externalPreviewURL"];
                            $profilePicUrl = $v["profilePicUrl"];
                            $author = $v["author"];
                            $shortBio = $v["shortBio"];
                            $itemType = $v["itemType"];
                            $date_creation = $v["date_creation"];
                            ?>

                            <a href="<?php echo $externalPreviewURL ?>" style="display:block" target="_blank">
                                <div class="wrapper" data-author="<?php echo $id ?>">
                                    <div class="img">
                                        <img
                                            src="http://wisewire.com/wp-content/uploads/2015/09/placeholder-content-type-2-940x340.png"
                                            class="img-responsive">
                                    </div>
                                    <div class="content">
                                        <h3><?php echo $author ?></h3>
                                        <p><?php echo $shortBio ?></p>
                                    </div>
                                    <div class="user_avatar">
                                        <img src="<?php echo $profilePicUrl ?>" alt="">
                                    </div>
                                    <div class="text_featured">
                                        <div class="h3">Pending Wisewire Author.<br>Keep an eye on this one!</div>
                                        Congratulations on completing the process to become a Wisewire Author. As a
                                        Wisewire Author, you no longer have to wait for your items to be approved — they
                                        will become public as soon as you publish them. We are honored that you choose
                                        to join our respected authors to make high quality items available to the
                                        greater educational community.
                                    </div>
                                </div>
                            </a>

                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>

            </section>
        </div>
    </div>
    <!-- END Pending authors -->
</section>
<!-- END featured Auhtors Carousel -->

<?php
$item_demo_viewer_template = '';
$item_object_url = '';
$item_preview_pdf = '';
$item_carousel_images = array();
?>

<?php if ($featured_item): ?>
    <?php foreach ($featured_item as $post): // variable must be called $post (IMPORTANT) ?>
        <?php
        $is_merlot = $post->source === 'MERLOT' ? true : false;
        $title = $post->title;
        $item_main_image_attributes = wp_get_attachment_image_src($post->image_id, 'home');
        $item_source = $post->source;
        $item_preview = $post->preview;
        if ($item_source == 'CMS') {
            $item_demo_viewer_template = get_field('item_demo_viewer_template', $post->id);
            $item_object_url = get_field('item_object_url', $post->id);
            $item_preview_pdf = get_field('item_preview_pdf', $post->id);
            $item_carousel_images = get_field('item_carousel_images', $post->id);
        } elseif ($item_source == 'PLATFORM' || $item_source == 'MERLOT') {
            $item_demo_viewer_template = 'Iframe';
            $item_object_url = $post->preview_url;
        }
        ?>

        <section class="lo-featured featured_content_home_logged_in"
                 data="<?php echo count($control->featured_authors) ?>"
                 style="<?php echo (count($control->featured_authors) > 0) ? 'display:none' : ''; ?> ">

            <div class="container">
                <h3 style="width:940px; color:#fff;font-size: 20px; line-height: 1.1; margin:0 auto 20px">FEATURED
                    ITEM</h3>
                <article
                    class="lo-item lo-item-featured <?php // echo $WWItems->get_color($post->content_type_icon) ?>">
                    <div class="img">
                        <a href="/item/<?php echo($post->type == 'item' ? $post->name : $post->id) ?>/"  <?php //echo add_rel_nofollow_to_item($post->id) ?>>
                            <?php
                            if ($item_main_image_attributes):?>
                                <img alt="" src="<?php echo $item_main_image_attributes[0]; ?>" class="img-responsive"/>
                                <?php
                            else:
                               // echo $WWItems->get_thumbnail_by_discipline($post->id, $post->content_type_icon, 'home');
                            endif;
                            ?>
                        </a>
                        <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                            <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                                <a href="<?php echo $item_object_url; ?>" class="ribbon btn-iframe" target="_blank" rel="nofollow"><span class="icon"></span> Preview</a>
                            <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                                <a href="<?php echo $item_preview_pdf; ?>" class="ribbon" target="_blank"><span
                                        class="icon"></span> Preview</a>
                            <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                                <a href="#" class="ribbon" data-toggle="modal" data-target="#previewModal"><span
                                        class="icon"></span> Preview</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="content">
                        <a href="/item/<?php echo($post->type == 'item' ? $post->name : $post->id) ?>/" <?php //echo add_rel_nofollow_to_item($post->id) ?> >
                            <div class="details">
                                <h3 class="sub-discipline">
                                    <?php //$discipline = $WWItems->get_discipline($post->id) ?>
                                    <?php //if ($discipline):
                                        //echo $discipline['name'];
                                    //endif; ?>
                                </h3>
                                <p class="content-type">
                                    <?php echo $post->content_type_icon; ?>
                                </p>
                                <p class="grade-level">
                                    <?php //echo $WWItems->get_grades($post->id, true, $is_merlot) ?>
                                </p>
                            </div>
                            <div class="content-title">
                                <h3><?php echo $post->title; ?></h3>
                                <div class="content-type-icon">
                                    <svg
                                        class="svg-<?php //echo $WWItems->get_icon($post->content_type_icon) ?> -dims">
                                        <use
                                            xlink:href="#<?php //echo $WWItems->get_icon($post->content_type_icon) ?>">
					</use>
                                    </svg>
                                </div>
                            </div>
                            <div class="lo-info">
                                <div class="date-rate">
                                    <p class="date">
                                        <?php if ($post->publish_date): ?>
                                            <?php date('m-d-Y', strtotime($post->publish_date)); ?>
                                        <?php endif; ?>
                                    </p>
                                    <div class="rate">
                                        <?php //rating_display_stars($post->ratings, '') ?>
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
                        </a>
                    </div>
                </article>

            </div><!-- /container -->

        </section><!-- /featured-object -->


        <?php if (substr($item_preview, 0, 1) === 'Y') { ?>

            <?php if (($item_demo_viewer_template == "Carousel") || ($item_demo_viewer_template == "Iframe")) { ?>

                <div
                    class="modal fade modal-preview<?php if ($item_demo_viewer_template == "Iframe") echo ' detail-iframe'; ?>"
                    id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div
                                    class="modal-title <?php if (!$item_demo_subhead) echo "modal-title-no-subhead"; ?>">

                                    <h3><?php echo $title ?></h3>
                                    <?php if ($item_demo_subhead) { ?>
                                        <h2><?php echo $item_demo_subhead; ?></h2>
                                    <?php } ?>

                                </div>

                                <?php if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>

                                    <div class="carousel">
                                        <?php foreach ($item_carousel_images as $image) { ?>
                                            <li>
                                                <img src="<?php echo $image['url']; ?>"
                                                     alt="<?php echo $image['alt']; ?>" class="img-responsive"/>
                                            </li>
                                        <?php } ?>
                                    </div>

                                <?php } else if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                                    <div class="iframe-container">
                                        <iframe src="" frameborder="0" webkitAllowFullScreen mozallowfullscreen
                                                allowFullScreen></iframe>
                                    </div>

                                <?php } ?>
                                <div style="width: 100%; color: #777; font-size:12px; padding-top: 10px">
                                    Your preview may not load properly due to 3rd party or browser restrictions.
                                </div>
                            </div><!-- /modal-body -->
                        </div>
                    </div>
                </div><!-- /modal -->
            <?php } ?>
        <?php } ?>
    <?php endforeach; ?>
<?php endif; ?>


<section class="learn-more">
    <div class="container">
        <div class="item-icon">
            <div class="icon"></div>
        </div>
        <div class="content">
            <p class="title">
                Not able to find what you're looking for? We build custom content, too.
            </p>
            <p class="more">
                <a href="/custom-content">Learn more</a>
            </p>
        </div>
    </div>
</section><!-- /learn-more -->

<!-- Hidden on <768px -->

<div class="loggedin-accordion" id="lo-accordion-1" role="tablist" aria-multiselectable="true">


    <?php if ($control->recommendations): ?>
        <div class="panel panel-default">

            <div class="panel-heading" role="tab" id="loItemHeading0">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#lo-accordion-1" href="#loItem0"
                       aria-expanded="true" aria-controls="loItem0" class="collapsed">
                        Recommended for you
                    </a>
                </h4>
            </div>

            <div id="loItem0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="loItemHeading0">

                <div class="panel-body">

                    <section class="lo-items lo-shadow">

                        <div class="container">

                            <div class="section-title">
                                <h3>
                                    Recommended for you
                                </h3>
                            </div>

                            <div class="row row-no-margin col-1-item-2-vertical">

                                <div class="col-sm-6 col-no-space col-1-item">
                                    <?php foreach ($control->recommendations as $k => $item): ?>

                                    <?php if ($k == 1): ?>
                                </div>
                                <div class="col-sm-6 col-no-space col-2-vertical">
                                    <?php endif; ?>

                                    <?php $item_content_type_icon = get_post_field('item_content_type_icon', $item->ID); ?>
                                    <?php $item_preview = get_post_field('item_preview', $item->ID); ?>
                                    <?php $item_publish_date = get_post_field('item_publish_date', $item->ID); ?>
                                    <?php $item_ratings = get_post_field('item_ratings', $item->ID); ?>
                                    <?php $item_main_image = get_post_field('item_main_image', $item->ID); ?>


                                    <?php if ($k == 0): ?>
                                        <a class="lo-item <?php echo $WWItems->get_color($item_content_type_icon) ?> lo-item-col-2"
                                           href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?>>

                                            <div class="img">
                                                <?php
                                                $item_main_image = get_field('item_main_image', $item->ID);
                                                if ($item_main_image):
                                                    $size = "thumb-vertical";
                                                    $image = wp_get_attachment_image_src($item_main_image, $size);
                                                    ?>
                                                    <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                                                <?php else: ?>
                                                    <?php echo $WWItems->get_thumbnail_by_discipline($item->ID, $item_content_type_icon, 'thumb-vertical') ?>
                                                <?php endif ?>
                                                <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                    <div class="ribbon"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="content">
                                                <div class="details">
                                                    <h3 class="sub-discipline">
                                                        <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                                    </h3>
                                                    <p class="content-type">
                                                        <?php echo $item_content_type_icon ?>
                                                    </p>
                                                    <p class="grade-level">
                                                        <?php echo $WWItems->get_grades($item->ID) ?>
                                                    </p>
                                                </div>
                                                <div class="more-info">
                                                    <div class="content-title">
                                                        <h3><?php echo $item->post_title ?></h3>
                                                        <div class="content-type-icon">
                                                            <svg
                                                                class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
                                                                <use
                                                                    xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="rate">
                                                        <?php rating_display_stars($item_ratings, '') ?>
                                                        <p class="number">
                                                            <?php echo $item_ratings ? $item_ratings : '' ?>
                                                        </p>
                                                        <?php do_action('product_tile_price', $item); // helloAri  ?>
                                                    </div>
                                                </div>
                                                <div class="lo-info">
                                                    <div class="date-rate">
                                                        <p class="date">
                                                            <?php if ($item_publish_date): ?>
                                                                <?php echo date_i18n('m-d-Y', strtotime($item_publish_date)); ?>
                                                            <?php endif; ?>
                                                        </p>
                                                        <div class="rate">
                                                            <?php rating_display_stars($item_ratings, '') ?>
                                                            <p class="number">
                                                                <?php echo $item_ratings ? $item_ratings : '' ?>
                                                            </p>
                                                            <?php do_action('product_tile_price', $item); // helloAri  ?>
                                                        </div>
                                                        <p class="object-type">
                                                            <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                                        </p>
                                                    </div>
                                                    <p class="object-type">
                                                        <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                                    </p>
                                                </div>
                                                <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                    <div class="ribbon short"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    <?php else: ?>
                                        <a class="lo-item lo-list-view <?php echo $WWItems->get_color($item_content_type_icon) ?>"
                                           href='<?php echo get_permalink($item) ?>' <?php echo add_rel_nofollow_to_item($item->ID) ?>>
                                            <div class="content">
                                                <div class="details">
                                                    <h3 class="sub-discipline">
                                                        <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                                        <div class="ribbon"><span class="icon"></span> Preview</div>
                                                    </h3>
                                                    <p class="content-type">
                                                        <?php echo $item_content_type_icon ?>
                                                    </p>
                                                    <p class="grade-level">
                                                        <?php echo $WWItems->get_grades($item->ID) ?>
                                                    </p>
                                                </div>
                                                <div class="more-info">
                                                    <div class="content-title">
                                                        <h3><?php echo $item->post_title ?></h3>
                                                        <div class="content-type-icon">
                                                            <svg
                                                                class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
                                                                <use
                                                                    xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="rate">
                                                        <?php rating_display_stars($item_ratings, '') ?>
                                                        <p class="number">
                                                            <?php echo $item_ratings ? $item_ratings : '' ?>
                                                        </p>
                                                        <?php do_action('product_tile_price', $item); // helloAri  ?>
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
                                                            <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                    <div class="ribbon short"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>

                            </div><!-- /row -->

                        </div><!-- /container -->

                    </section><!-- /lo-items lo-recommended -->

                </div>

            </div>

        </div>
    <?php endif ?>


    <?php if ($control->recently_viewed): ?>

        <div class="panel panel-default">

            <div class="panel-heading" role="tab" id="loItemHeading1">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#lo-accordion-1" href="#loItem1"
                       aria-expanded="true" aria-controls="loItem1" class="collapsed">
                        Recently viewed by you
                    </a>
                </h4>
            </div>

            <div id="loItem1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="loItemHeading1">

                <div class="panel-body">

                    <section class="lo-items lo-shadow">

                        <div class="container">

                            <div class="section-title">
                                <h3>
                                    Recently viewed by you
                                </h3>
                            </div>

                            <div class="row row-no-margin">

                                <div class="col-sm-12 col-md-6 col-no-space col-2-vertical">
                                    <?php foreach ($control->recently_viewed as $k => $item): ?>

                                    <?php $item_content_type_icon = get_post_field('item_content_type_icon', $item->ID); ?>
                                    <?php $item_preview = get_post_field('item_preview', $item->ID); ?>
                                    <?php $item_publish_date = get_post_field('item_publish_date', $item->ID); ?>
                                    <?php $item_ratings = get_post_field('item_ratings', $item->ID); ?>

                                    <?php if ($k >= 2): ?>
                                </div>

                                <div class="col-sm-6 col-md-3 col-no-space col-2-next">
                                    <?php endif; ?>

                                    <?php if ($k < 2): ?>
                                        <a class="lo-item lo-list-view <?php echo $WWItems->get_color($item_content_type_icon) ?>"
                                           href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?> >
                                            <div class="content">
                                                <div class="details">
                                                    <h3 class="sub-discipline">
                                                        <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                                        <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                            <div class="ribbon"><span class="icon"></span> Preview</div>
                                                        <?php endif; ?>
                                                    </h3>
                                                    <p class="content-type">
                                                        <?php echo $item_content_type_icon ?>
                                                    </p>
                                                    <p class="grade-level">
                                                        <?php echo $WWItems->get_grades($item->ID) ?>
                                                    </p>
                                                </div>
                                                <div class="more-info">
                                                    <div class="content-title">
                                                        <h3><?php echo $item->post_title ?></h3>
                                                        <div class="content-type-icon">
                                                            <svg
                                                                class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
                                                                <use
                                                                    xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="rate">
                                                        <?php rating_display_stars($item_ratings, '') ?>
                                                        <p class="number">
                                                            <?php echo $item_ratings ? $item_ratings : '' ?>
                                                        </p>
                                                        <?php do_action('product_tile_price', $item); // helloAri  ?>
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
                                                            <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                    <div class="ribbon short"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>

                                    <?php else: ?>

                                        <a class="lo-item lo-item-col <?php echo $WWItems->get_color($item_content_type_icon) ?>"
                                           href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?>>
                                            <div class="img">
                                                <?php
                                                $item_main_image = get_field('item_main_image', $item->ID);
                                                if ($item_main_image):
                                                    $size = "thumb-vertical";
                                                    $image = wp_get_attachment_image_src($item_main_image, $size);
                                                    ?>
                                                    <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                                                <?php else: ?>
                                                    <?php echo $WWItems->get_thumbnail_by_discipline($item->ID, $item_content_type_icon, 'thumb-vertical') ?>
                                                <?php endif ?>
                                                <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                    <div class="ribbon"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="content">
                                                <div class="details">
                                                    <h3 class="sub-discipline">
                                                        <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                                    </h3>
                                                    <p class="content-type">
                                                        <?php echo $item_content_type_icon ?>
                                                    </p>
                                                    <p class="grade-level">
                                                        <?php echo $WWItems->get_grades($item->ID) ?>
                                                    </p>
                                                </div>
                                                <div class="more-info">
                                                    <div class="content-title">
                                                        <h3><?php echo $item->post_title ?></h3>
                                                        <div class="content-type-icon">
                                                            <svg
                                                                class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
                                                                <use
                                                                    xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="rate">
                                                        <?php rating_display_stars($item_ratings, '') ?>
                                                        <p class="number">
                                                            <?php echo $item_ratings ? $item_ratings : '' ?>
                                                        </p>
                                                        <?php do_action('product_tile_price', $item); // helloAri  ?>
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
                                                            <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                    <div class="ribbon short"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>

                                        <div class="lo-info lo-info-outside">
                                            <div class="date-rate">
                                                <p class="date">
                                                    <?php if ($item_publish_date): ?>
                                                        <?php echo date_i18n('m-d-Y', strtotime($item_publish_date)); ?>
                                                    <?php endif; ?>
                                                </p>
                                                <div class="rate">
                                                    <?php rating_display_stars($item_ratings, '') ?>
                                                    <p class="number">
                                                        <?php echo $item_ratings ? $item_ratings : '' ?>
                                                    </p>
                                                    <?php do_action('product_tile_price', $item); // helloAri  ?>
                                                </div>
                                            </div>
                                            <p class="object-type">
                                                <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                            </p>
                                        </div>

                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>

                            </div><!-- /row -->

                        </div><!-- /container -->

                    </section><!-- /lo-items lo-recommended -->

                </div>

            </div>

        </div>
    <?php endif; ?>


    <?php if ($control->other_viewed): ?>
        <div class="panel panel-default">

            <div class="panel-heading" role="tab" id="loItemHeading2">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#lo-accordion-1" href="#loItem2"
                       aria-expanded="true" aria-controls="loItem2" class="collapsed">
                        What people are viewing
                    </a>
                </h4>
            </div>

            <div id="loItem2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="loItemHeading2">

                <div class="panel-body">

                    <section class="lo-items lo-shadow lo-last">

                        <div class="container">

                            <div class="section-title">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3>
                                            What people are viewing
                                        </h3>
                                    </div>
                                    <div class="col-sm-6 viewall">
                                        <a href="<?php echo esc_url(home_url('/')); ?>most-viewed">View all</a>
                                    </div>
                                </div>

                            </div>

                            <div class="row row-no-margin">

                                <?php foreach ($control->other_viewed as $k => $item): ?>

                                    <?php $item_content_type_icon = get_post_field('item_content_type_icon', $item->ID); ?>
                                    <?php $item_preview = get_post_field('item_preview', $item->ID); ?>
                                    <?php $item_publish_date = get_post_field('item_publish_date', $item->ID); ?>
                                    <?php $item_ratings = get_post_field('item_ratings', $item->ID); ?>

                                    <div class="col-sm-3 col-no-space col-2-next">

                                        <a class="lo-item lo-item-col <?php echo $WWItems->get_color($item_content_type_icon) ?>"
                                           href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?> >
                                            <div class="img">
                                                <?php
                                                $item_main_image = get_field('item_main_image', $item->ID);
                                                if ($item_main_image):
                                                    $size = "thumb-vertical";
                                                    $image = wp_get_attachment_image_src($item_main_image, $size);
                                                    ?>
                                                    <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                                                <?php else: ?>
                                                    <?php echo $WWItems->get_thumbnail_by_discipline($item->ID, $item_content_type_icon, 'thumb-vertical') ?>
                                                <?php endif ?>
                                                <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                    <div class="ribbon"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="content">
                                                <div class="details">
                                                    <h3 class="sub-discipline">
                                                        <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                                    </h3>
                                                    <p class="content-type">
                                                        <?php echo $item_content_type_icon ?>
                                                    </p>
                                                    <p class="grade-level">
                                                        <?php echo $WWItems->get_grades($item->ID) ?>
                                                    </p>
                                                </div>
                                                <div class="more-info">
                                                    <div class="content-title">
                                                        <h3><?php echo $item->post_title ?></h3>
                                                        <div class="content-type-icon">
                                                            <svg
                                                                class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
                                                                <use
                                                                    xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="rate">
                                                        <?php rating_display_stars($item_ratings, '') ?>
                                                        <p class="number">
                                                            <?php echo $item_ratings ? $item_ratings : '' ?>
                                                        </p>
                                                        <?php do_action('product_tile_price', $item); // helloAri  ?>
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
                                                            <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php if (substr($item_preview, 0, 1) === 'Y'): ?>
                                                    <div class="ribbon short"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>

                                        <div class="lo-info lo-info-outside">
                                            <div class="date-rate">
                                                <p class="date">
                                                    <?php if ($item_publish_date): ?>
                                                        <?php echo date_i18n('m-d-Y', strtotime($item_publish_date)); ?>
                                                    <?php endif; ?>
                                                </p>
                                                <div class="rate">
                                                    <?php rating_display_stars($item_ratings, '') ?>
                                                    <p class="number">
                                                        <?php echo $item_ratings ? $item_ratings : '' ?>
                                                    </p>
                                                    <?php do_action('product_tile_price', $item); // helloAri  ?>
                                                </div>
                                            </div>
                                            <p class="object-type">
                                                <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="view-more-link">
                                    <a href="<?php echo esc_url(home_url('/')); ?>most-viewed">View all</a>
                                </div>
                            </div><!-- /row -->

                        </div><!-- /container -->

                    </section><!-- /lo-items lo-recommended -->

                </div>

            </div>

        </div>
    <?php endif; ?>

</div>
                

   
