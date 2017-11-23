<?php
/**
 * Template Name: Favorites
 */
?>

<?php

$fav_controller = new Controller_Favorites();
$favorites = $fav_controller->get_favorites();

// collect types summary
$summary = array();
if ($favorites): foreach ($favorites as $item):

    if (!isset($summary[$item->content_type_icon])) :
        $summary[$item->content_type_icon] = 0;
    endif;

    $summary[$item->content_type_icon]++;

endforeach; endif;

?>

<?php get_header(); ?>

    <div id="favorites-page">

        <div class="container">
            <div class="page-title page-title-alt">
                <h1>
                    Your favorites
                </h1>
            </div><!-- /page-title -->
        </div>


        <!-- Hidden on <768px -->

        <div class="hidden-xs<?php if ($fav_controller->recommendations) echo ' lo-shadow'; ?>">

            <div class="container">
                <div class="items-favorite">
                    <div class="row">
                        <div class="col-sm-3 col-nav">
                            <div class="nav-head">
                                <p>
                                    <?php echo sizeof($favorites) ?> <?php echo sizeof($favorites) > 1 ? 'items' : 'item' ?>
                                    selected
                                </p>
                            </div>
                            <div class="summary">
                                <p>
                                    Summary
                                </p>
                                <ul>
                                    <?php if ($summary): foreach ($summary as $k => $v): ?>
                                        <li><?php echo $k ?>&nbsp;<span><?php echo $v ?></span></li>
                                    <?php endforeach; endif; ?>
                                </ul>
                            </div>
                            <div class="total">
                                <ul>
                                    <li>Total<span><?php echo sizeof($favorites) ?></span></li>
                                </ul>
                            </div>
                            <p class="interested">
                                Interested in purchasing these items?
                            </p>
                            <p class="btn-contact">
                                <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a>
                            </p>
                        </div><!-- /col-nav -->

                        <div class="col-sm-9 col-items">

                            <section class="lo-items">

                                <div class="row row-no-margin">
                                    <?php if ($favorites): foreach ($favorites as $item): ?>
                                        <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">

                                            <?php if ($item->type != 'item'): ?>
                                                <a href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item->id ?>&amp;item_type=question"
                                                   title="Are you sure that you want to remove this from favorites?"
                                                   class="btn-close btn-confirm"></a>
                                            <?php else: ?>
                                                <a href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item->item_object_id ?>"
                                                   title="Are you sure that you want to remove this from favorites?"
                                                   class="btn-close btn-confirm"></a>
                                            <?php endif; ?>

                                            <a class="lo-item lo-item-col <?php echo $WWItems->get_color($item->content_type_icon) ?>"
                                               href="/item/<?php echo($item->type == 'item' ? $item->name : $item->id) ?>/" <?php echo add_rel_nofollow_to_item($item->id) ?> >


                                                <div class="img">
                                                    <?php
                                                    $item_main_image = $item->image_id;
                                                    if ($item_main_image):
                                                        $size = "thumbnail";
                                                        $image = wp_get_attachment_image_src($item_main_image, $size);
                                                        ?>
                                                        <img alt="" src="<?php echo $image[0]; ?>"
                                                             class="img-responsive"/>
                                                    <?php else: ?>
                                                        <?php echo $WWItems->get_thumbnail_by_discipline($item->id, $item->content_type_icon, 'thumb-related', $item->subdiscipline, $item->author, $item->title) ?>
                                                    <?php endif ?>
                                                    <?php if ($item->preview === 'Y'): ?>
                                                        <div class="ribbon"><span class="icon"></span> Preview</div>
                                                    <?php endif; ?>
                                                </div>

                                                <?php
                                                $code_label = $item->title;
                                                if ($item->type != 'item'): ?>
                                                    <?php
                                                    $array_object_type = array_map('trim', explode(',', $item->object_type));
                                                    if (!in_array("question", $array_object_type)) {
                                                        //if ($item->object_type != 'question') {

                                                        $level1_label = !empty($item->subdiscipline) ? $item->subdiscipline : '&nbsp;';
                                                        $level2_label = $item->content_type_icon;
                                                        $level3_label = null;
                                                        $description_label = null;
                                                        $code_label = $item->title;
                                                    } else {

                                                        $level1_label = !empty($item->level1_label) ? $item->level1_label : '&nbsp';
                                                        $level2_label = !empty($item->level2_label) ? $item->level2_label : '&nbsp';
                                                        $level3_label = !empty($item->level3_label) ? $item->level3_label : '&nbsp';
                                                        $description_label = $item->description_label;
                                                        $code_label = $item->code_label;
                                                    } ?>
                                                <?php endif ?>

                                                <div class="content">
                                                    <?php if ($item->type == 'item'): ?>
                                                        <div class="details">
                                                            <h3 class="sub-discipline">
                                                                <?php echo !empty($item->subdiscipline) ? $item->subdiscipline : '&nbsp;' ?>
                                                                <?php if (substr($item->preview, 0, 1) === 'Y'): ?>
                                                                    <div
                                                                            class="ribbon ribbon-list-layout">
                                                                        <span class="icon"></span>
                                                                        Preview
                                                                    </div>
                                                                <?php endif; ?>
                                                            </h3>
                                                            <p class="content-type">
                                                                <?php echo $item->content_type_icon ?>
                                                            </p>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="details">
                                                            <h3 class="sub-discipline">
                                                                <?php echo $level1_label ?>
                                                                <?php if (substr($item->preview, 0, 1) === 'Y'): ?>
                                                                    <div
                                                                            class="ribbon ribbon-list-layout">
                                                                        <span class="icon"></span>
                                                                        Preview
                                                                    </div>
                                                                <?php endif; ?>
                                                            </h3>
                                                            <p class="content-type">
                                                                <?php if ($item->source != 2) {
                                                                    echo $level2_label;
                                                                } ?>


                                                            </p>
                                                            <?php if ($level3_label !== null): ?>
                                                                <p class="content-type">
                                                                    <?php if ($item->source != 2) {
                                                                        echo $level3_label;
                                                                    } ?>
                                                                </p>
                                                            <?php endif ?>
                                                            <p class="grade-level">
                                                                <?php
                                                                $words_to_find = array("Question", "question");
                                                                $description_label = str_replace($words_to_find, "", $description_label);
                                                                ?>
                                                                <?php echo $description_label; ?>
                                                            </p>
                                                        </div>
                                                    <?php endif ?>

                                                    <div class="content-title">
                                                        <h3><?php echo $code_label ?></h3>
                                                        <div class="content-type-icon">
                                                            <svg
                                                                    class="svg-<?php echo $WWItems->get_icon($item->content_type_icon) ?>-dims">
                                                                <use
                                                                        xlink:href="#<?php echo $WWItems->get_icon($item->content_type_icon) ?>"></use>
                                                            </svg>
                                                        </div>
                                                    </div>


                                                </div>
                                            </a>
                                            <div class="lo-info lo-info-outside">
                                                <div class="date-rate">
                                                    <div class="date">
                                                        <?php if ($item->publish_date): ?>
                                                            <?php echo date_i18n('m-d-Y', strtotime($item->publish_date)); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="rate">
                                                        <?php rating_display_stars($item->ratings, '') ?>
                                                        <p class="number">
                                                            <?php echo $item->ratings ? $item->ratings : '' ?>
                                                        </p>
                                                        <?php do_action('product_tile_price', $item); ?>
                                                    </div>
                                                </div>
                                                <p class="object-type">
                                                    <?php echo str_replace("tei", "&nbsp;TEI&nbsp;", ucfirst($item->object_type)); ?>
                                                </p>
                                            </div>


                                        </div><!-- /col -->

                                    <?php endforeach; endif; ?>

                                </div><!-- /row -->
                            </section><!-- /lo-items -->
                        </div><!-- /col-items -->
                    </div><!-- /row -->
                </div><!-- /items-favorites -->
            </div><!-- /container -->
        </div><!-- /hidden-xs -->

        <!-- Hidden on <768px -->

        <div class="hidden-xs">
            <?php if ($fav_controller->recommendations): ?>
                <section class="lo-carousel lo-items">

                    <div class="container">

                        <div class="section-title">
                            <h3>
                                Recommended for you
                            </h3>
                        </div>

                        <div class="carousel">

                            <?php foreach ($fav_controller->recommendations as $k => $item): ?>
                                <div class="col-2-next">

                                    <?php $item_content_type_icon = get_post_field('item_content_type_icon', $item->ID); ?>
                                    <?php $item_preview = get_post_field('item_preview', $item->ID); ?>
                                    <?php $item_publish_date = get_post_field('item_publish_date', $item->ID); ?>
                                    <?php $item_ratings = get_post_field('item_ratings', $item->ID); ?>

                                    <a class="lo-item lo-item-col <?php echo $WWItems->get_color($item_content_type_icon) ?> <?php echo (substr($item_preview, 0, 1) === 'Y') ? 'has-preview' : '' ?>"
                                       href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?> >
                                        <div class="img">
                                            <?php
                                            $item_main_image = get_field('item_main_image', $item->ID);
                                            if ($item_main_image):
                                                $size = "thumbnail";
                                                $image = wp_get_attachment_image_src($item_main_image, $size);
                                                ?>
                                                <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                                            <?php else: ?>
                                                <?php echo $WWItems->get_thumbnail_by_discipline($item->ID, $item_content_type_icon) ?>
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
                                            </div>
                                            <div class="content-title">
                                                <h3><?php echo $item->post_title ?></h3>
                                                <div class="content-type-icon">
                                                    <svg class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
                                                        <use xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
                                                    </svg>
                                                </div>
                                            </div>
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
                                                <?php do_action('product_tile_price', $item); ?>
                                            </div>
                                        </div>
                                        <p class="object-type">
                                            <?php echo implode(', ', wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div><!-- /carousel -->
                    </div><!-- /container -->
                </section><!-- /lo-carousel -->
            <?php endif; ?>
        </div><!-- /hidden-xs -->

        <!-- Visible on <768px -->

        <div class="visible-xs-block items-favorite">
            <div class="mobile-accordion" id="lo-accordion-1" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="loItemHeading1">
                        <h4 class="panel-title panel-summary">
                            <a role="button" data-toggle="collapse" data-parent="#lo-accordion-1" href="#summarySection"
                               aria-expanded="true" aria-controls="summarySection" class="collapsed">
                                ITEM SUMMARY
                            </a>
                        </h4>
                    </div>
                    <div id="summarySection" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="loItemHeading1">
                        <div class="panel-body panel-summary-section">
                            <div class="nav-head">
                                <p>
                                    <?php echo sizeof($favorites) ?> <?php echo sizeof($favorites) > 1 ? 'items' : 'item' ?>
                                    selected
                                </p>
                            </div>
                            <div class="summary">
                                <ul>
                                    <?php if ($summary): foreach ($summary as $k => $v): ?>
                                        <li><?php echo $k ?><span><?php echo $v ?></span></li>
                                    <?php endforeach; endif; ?>
                                </ul>
                            </div>
                            <div class="total">
                                <ul>
                                    <li>Total<span><?php echo sizeof($favorites) ?></span></li>
                                </ul>
                            </div>
                            <p class="interested">
                                Interested in purchasing these items?
                            </p>
                            <p class="btn-contact">
                                <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">

                    <div class="panel-heading" role="tab" id="loItemHeading2">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#lo-accordion-1" href="#loItem2"
                               aria-expanded="true" aria-controls="loItem2" class="collapsed">
                                FAVORITES (<?php echo sizeof($favorites) ?>)
                            </a>
                        </h4>
                    </div>

                    <div id="loItem2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="loItemHeading2">
                        <div class="panel-body">
                            <?php if ($favorites): foreach ($favorites as $item): ?>
                                <article
                                        class="lo-item <?php echo $WWItems->get_color($item->content_type_icon) ?> <?php echo($item->type == 'item' ? '' : 'item-search') ?>">
                                    <a href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item->item_object_id ?>&amp;item_type=question"
                                       title="Are you sure that you want to remove this from favorites?"
                                       class="btn-close btn-confirm"></a>

                                    <?php if ($item->type != 'item'): ?>
                                        <?php if ($item->object_type != 'question') {

                                            $level1_label = !empty($item->subdiscipline) ? $item->subdiscipline : '&nbsp;';
                                            $level2_label = $item->content_type_icon;
                                            $level3_label = null;
                                            $description_label = null;
                                            $code_label = $item->title;
                                        } else {

                                            $level1_label = !empty($item->level1_label) ? $item->level1_label : '&nbsp';
                                            $level2_label = !empty($item->level2_label) ? $item->level2_label : '&nbsp';
                                            $level3_label = !empty($item->level3_label) ? $item->level3_label : '&nbsp';
                                            $description_label = $item->description_label;
                                            $code_label = $item->code_label;
                                        } ?>
                                    <?php endif ?>

                                    <a href="/item/<?php echo($item->type == 'item' ? $item->name : $item->id) ?>/" <?php echo add_rel_nofollow_to_item($item->id) ?>>
                                        <div class="content">
                                            <div class="details">
                                                <?php if ($item->type == 'item'): ?>
                                                    <h3 class="sub-discipline">
                                                        <?php echo !empty($item->subdiscipline) ? $item->subdiscipline : '&nbsp;' ?>
                                                        <?php if (substr($item->preview, 0, 1) === 'Y'): ?>
                                                            <div
                                                                    class="ribbon ribbon-list-layout">
                                                                <span class="icon"></span>
                                                                Preview
                                                            </div>
                                                        <?php endif; ?>
                                                    </h3>
                                                    <p class="content-type">
                                                        <?php echo $item->content_type_icon ?>
                                                    </p>

                                                    <p class="grade-level">
                                                        <?php
                                                        $words_to_find = array("Question", "question");
                                                        $description_label = str_replace($words_to_find, "", $description_label);
                                                        ?>
                                                        <?php echo $description_label; ?>
                                                    </p>
                                                <?php else: ?>
                                                    <h3 class="sub-discipline">
                                                        <?php echo $level1_label ?>
                                                    </h3>
                                                    <p class="content-type">
                                                        <?php if ($item->source != 2) {
                                                            echo $level2_label;
                                                        } ?>
                                                    </p>
                                                    <?php if ($level3_label !== null): ?>
                                                        <p class="content-type">
                                                            <?php if ($item->source != 2) {
                                                                echo $level3_label;
                                                            } ?>
                                                        </p>
                                                    <?php endif ?>
                                                    <p class="grade-level">
                                                        <?php
                                                        $words_to_find = array("Question", "question");
                                                        $description_label = str_replace($words_to_find, "", $description_label);
                                                        ?>
                                                        <?php echo $description_label; ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="more-info">
                                                <div class="content-title">
                                                    <h3><?php echo $item->title ?></h3>
                                                    <div class="content-type-icon">
                                                        <svg class="svg-<?php echo $WWItems->get_icon($item->content_type_icon) ?>-dims">
                                                            <use xlink:href="#<?php echo $WWItems->get_icon($item->content_type_icon) ?>"></use>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="rate">
                                                    <?php rating_display_stars($item->item_ratings, '') ?>
                                                    <p class="number">
                                                        <?php echo $item->item_ratings ? $item->item_ratings : '' ?>
                                                    </p>
                                                    <?php do_action('product_tile_price', $item); ?>
                                                </div>
                                            </div>
                                            <div class="lo-info">
                                                <div class="date-rate">
                                                    <p class="date">
                                                        <?php if ($item->item_publish_date): ?>
                                                            <?php echo date_i18n('m-d-Y', strtotime($item->item_publish_date)); ?>
                                                        <?php endif; ?>
                                                    </p>
                                                    <p class="object-type">
                                                        <?php echo ucfirst($item->object_type) ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php if ($item->preview === 'Y'): ?>
                                                <div class="ribbon"><span class="icon"></span> Preview</div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </article>
                            <?php endforeach; endif; ?>
                        </div><!-- /panel-body -->
                    </div>
                </div>

                <?php if ($fav_controller->recommendations): ?>
                    <div class="panel panel-default">

                        <div class="panel-heading" role="tab" id="loItemHeading3">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#lo-accordion-1" href="#loItem3"
                                   aria-expanded="true" aria-controls="loItem3" class="collapsed">
                                    recommended for you
                                </a>
                            </h4>
                        </div>

                        <div id="loItem3" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="loItemHeading3">
                            <div class="panel-body">

                                <?php foreach ($fav_controller->recommendations as $k => $item): ?>
                                    <?php $item_content_type_icon = get_post_field('item_content_type_icon', $item->ID); ?>
                                    <?php $item_preview = get_post_field('item_preview', $item->ID); ?>
                                    <?php $item_publish_date = get_post_field('item_publish_date', $item->ID); ?>
                                    <?php $item_ratings = get_post_field('item_ratings', $item->ID); ?>
                                    <article class="lo-item <?php echo $WWItems->get_color($item_content_type_icon) ?>">
                                        <a href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?> >
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
                                                            <svg class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
                                                                <use xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="rate">
                                                        <?php rating_display_stars($item_ratings, '') ?>
                                                        <p class="number">
                                                            <?php echo $item_ratings ? $item_ratings : '' ?>
                                                        </p>
                                                        <?php do_action('product_tile_price', $item); ?>
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
                                                    <div class="ribbon"><span class="icon"></span> Preview</div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    </article>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div><!-- /panel-group -->

        </div><!-- /vivible-xs-block -->

    </div><!-- #favorites-page -->


<?php get_footer();