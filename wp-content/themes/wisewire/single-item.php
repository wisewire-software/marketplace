<?php
// To avoid error message
// Refused to display 'url' in a frame because it set 'X-Frame-Options' to 'SAMEORIGIN, SAMEORIGIN'.
require_once(ABSPATH . 'wp-includes/WiseWireApi.php');
get_header();
?>

<?php
// List all item content

$title = get_the_title();
$item_id = get_the_ID();
$item_object_id = get_field('item_object_id');
$item_object_id = $item_object_id ? $item_object_id : $item_id;

$item_main_image = get_field('item_main_image');
$item_publish_date = get_field('item_publish_date');

$item_for_sale = get_field('item_for_sale');
$item_price = get_field('item_price');

$item_cta_button = get_field('item_cta_button');
$item_cta_button_pdf = get_field('item_cta_button_pdf');
$item_cta_button_url = get_field('item_cta_button_url');

$item_content_type_icon = get_field('item_content_type_icon');
$item_grade_level = get_field('item_grade_level');
$item_object_type = get_field('item_object_type');
$item_contributor = get_field('item_contributor');
$item_ratings = get_field('item_ratings');
$item_standards = get_field('item_standards');
$item_dok = get_field('item_dok');
$item_standards_subtag = get_field('item_standards_subtag');

$item_license_type = get_field('item_license_type');
$item_license_url = get_field('item_license_url');

$item_language = get_field('item_language');
$item_long_description = get_field('item_long_description');
$item_read_more = get_field('item_read_more');

// Batch Uploads
$item_parent_object = get_field('item_parent_object');
$item_parent_object_child_objects = get_field('item_parent_object_child_objects');
$item_parent_object_next_in_sequence = get_field('item_parent_object_next_in_sequence');
$item_parent_object_previous_in_sequence = get_field('item_parent_object_previous_in_sequence');
$item_related_content = get_field('item_related_content');

// CMS
$item_cms_next_in_sequence = get_field('item_cms_next_in_sequence');
$item_cms_previous_in_sequence = get_field('item_cms_previous_in_sequence');
$item_cms_related_items = get_field('item_cms_related_items');

$item_preview = get_field('item_preview');
$item_demo_viewer_template = get_field('item_demo_viewer_template');
$item_object_url = get_field('item_object_url');
$item_preview_pdf = get_field('item_preview_pdf');
$item_carousel_images = get_field('item_carousel_images');
$item_demo_subhead = get_field('item_demo_subhead');

$item_instructional_time = get_field('item_instructional_time');
$item_level_of_rigor = get_field('item_level_of_rigor');

$is_hide_item = get_field('is_hide_item');

$inIframeAllowed = true;


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_HEADER => true,
    CURLOPT_NOBODY => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => $item_object_url));
$headers = explode("\n", curl_exec($curl));
curl_close($curl);

foreach ($headers as $key => $value) {
    if (trim($value) == "X-Frame-Options: SAMEORIGIN" || trim($value) == "X-Frame-Options: DENY") {
        $inIframeAllowed = false;
    }
}

// $item_tags = get_tags();
$item_standards = get_the_terms(get_the_ID(), 'Standards');

$item_discipline = $WWItems->get_discipline(get_the_ID());
$item_subdiscipline = $WWItems->get_subdiscipline(get_the_ID());

$item_related = get_the_terms(get_the_ID(), 'Related');

$item_grades = $WWItems->get_grades(get_the_ID(), false);

$grade = $WWItems::GetGradeName(array_keys($item_grades), true);

$item_grades = implode(', ', $item_grades);

if ($item_related):
    foreach ($item_related as $k => $v):
        $item_related[$k] = $v->name;
    endforeach;
endif;

$item_related = $WWItems->get_by_object_id($item_related, 4);


$item_next = false;
$item_prev = false;

if ($item_parent_object_next_in_sequence):
    $item_next = $WWItems->get_by_object_id($item_parent_object_next_in_sequence);
endif;

if ($item_parent_object_previous_in_sequence):
    $item_prev = $WWItems->get_by_object_id($item_parent_object_previous_in_sequence);
endif;

$pio = new PredictionIOController();
$pio->send_event('view', $item_object_id);

// Contributors - get them from the CMS as they are made as Custom Post Types
if ($item_contributor) {
    $post_contributor = get_page_by_title($item_contributor, OBJECT, 'contributor');
    if ($post_contributor) {
        $item_contributor_description = get_field('contributor_description', $post_contributor->ID);
        $item_contributor_email = get_field('contributor_email', $post_contributor->ID);
        $item_contributor_website = get_field('contributor_website', $post_contributor->ID);
        $item_contributor_image = get_field('contributor_image', $post_contributor->ID);
    } else {
        $item_contributor_description = '';
        $item_contributor_email = '';
        $item_contributor_website = '';
        $item_contributor_image = '';
    }
}

// License Type
$item_license_icon = '';
if ($item_license_type == 'CC BY') {
    $item_license_type_link = 'https://creativecommons.org/licenses/by/4.0/';
    $item_license_icon = 'by';
} else if ($item_license_type == 'CC BY-SA') {
    $item_license_type_link = 'https://creativecommons.org/licenses/by-sa/4.0/';
    $item_license_icon = 'by_sa';
} else if ($item_license_type == 'CC BY-ND') {
    $item_license_type_link = 'https://creativecommons.org/licenses/by-nd/4.0/';
    $item_license_icon = 'by_nd';
} else if ($item_license_type == 'CC0') {
    $item_license_type_link = 'https://creativecommons.org/publicdomain/zero/1.0/';
    $item_license_icon = 'public_domain_zero';
} else if ($item_license_type == 'CC BY-NC-SA') {
    $item_license_type_link = 'https://creativecommons.org/licenses/by-nc-sa/4.0/';
    $item_license_icon = 'by_nc_sa';
} else if ($item_license_type == 'CC BY-NC-ND') {
    $item_license_type_link = 'https://creativecommons.org/licenses/by-nc-nd/4.0/';
    $item_license_icon = 'by_nc_nd';
} else if ($item_license_type == 'Public Domain') {
    $item_license_type_link = 'https://creativecommons.org/publicdomain/mark/1.0/';
    $item_license_icon = 'public_domain';
} else if ($item_license_type == 'Read the fine print') {
    $item_license_type_link = $item_license_url;
} else if ($item_license_type == 'No information') {
    $item_license_type_link = '';
} else {
    $item_license_type_link = '';
}

$is_favorite = $fav_controller->is_favorite($item_object_id, 'item');

?>

<!-- Visible on <768px -->

<!--<div class="customize-link-mobile visible-xs-block">
  <div class="container">
    <p>
      <a href="#" data-toggle="modal" data-target="#customizeModal">CUSTOMIZE CONTENT ></a>
    </p>
  </div>
</div>-->


<!-- Visible on <768px -->

<section class="nav-grades-mobile visible-xs-block">
    <div class="container">
        <p>
            <?php echo strtoupper($WWItems::$grade_name) ?>
        </p>
    </div>
</section>


<!-- Hidden on <768px -->

<?php get_template_part('parts/grades', 'navigation' . (WiseWireApi::get_option('gradelevels_nav') == 'full' ? '' : '_1')); ?>

<section class="detail">

    <div class="container">

        <?php do_action('woocommerce_before_my_page'); // helloAri ?>

        <div class="btn-back hidden-xs">
            <a href="javascript: history.back();">&lt; Back</a>
        </div>

        <div class="metadata">

            <?php if (isset($item_discipline['name'])): ?>
                <h1>
                    <?php echo $item_discipline['name'] ?>
                </h1>
                <a href="/explore/<?php echo $grade ?>/<?php echo $item_discipline['slug'] ?>/">
                    VIEW ALL <?php echo $item_discipline['name'] ?>
                </a>
            <?php endif; ?>
            <h2>
                <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><?php echo $title ?></span>
            </h2>
        </div><!-- /detail-info -->

    </div>

    <!-- Visible on <768px -->
    <div class="visible-xs-block">

        <div class="container">
            <div class="img">


                <?php
                if ($item_main_image):
                    $size = "detail";
                    $image = wp_get_attachment_image_src($item_main_image, $size);
                    ?>

                    <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                    <?php if ($item_demo_viewer_template == "Iframe") { ?>

                        <?php if ($item_object_url) : ?>
                            <a href="<?php echo $item_object_url; ?>" class="btn-iframe" target="_blank" rel="nofollow">
                                <span class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                               class="img-responsive"/>
                            </a>
                        <?php else: ?>
                            <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                        <?php endif; ?>

                    <?php } else if ($item_demo_viewer_template == "PDF") { ?>

                        <?php if ($item_preview_pdf) : ?>
                            <a href="<?php echo $item_preview_pdf; ?>" class="" target="_blank"><span
                                        class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                                 class="img-responsive"/></a>
                        <?php else: ?>
                            <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                        <?php endif; ?>

                    <?php } else if ($item_demo_viewer_template == "Carousel") { ?>

                        <?php if ($item_carousel_images) : ?>
                            <a href="#" class="" data-toggle="modal" data-target="#previewModal"><span
                                        class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                                 class="img-responsive"/></a>
                        <?php else: ?>
                            <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                        <?php endif; ?>

                    <?php } ?>
                <?php } else { ?>
                    <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                <?php } ?>


                <?php else: ?>

                    <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                        <?php if ($item_demo_viewer_template == "Iframe") { ?>

                            <?php if ($item_object_url) : ?>
                                <a href="<?php echo $item_object_url; ?>" class="btn-iframe" rel="nofollow"
                                   target="_blank">
                                    <span class="icon"></span><?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                </a>
                            <?php else: ?>
                                <?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                            <?php endif; ?>

                        <?php } else if ($item_demo_viewer_template == "PDF") { ?>

                            <?php if ($item_preview_pdf) : ?>
                                <a href="<?php echo $item_preview_pdf; ?>" class="" target="_blank"><span
                                            class="icon"></span><?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                </a>
                            <?php else: ?>
                                <?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                            <?php endif; ?>

                        <?php } else if ($item_demo_viewer_template == "Carousel") { ?>

                            <?php if ($item_carousel_images) : ?>
                                <a href="#" class="" data-toggle="modal" data-target="#previewModal"><span
                                            class="icon"></span><?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                </a>
                            <?php else: ?>
                                <?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                            <?php endif; ?>

                        <?php } ?>
                    <?php } else { ?>
                        <?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                    <?php } ?>


                <?php endif; ?>

                <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                    <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url) && $inIframeAllowed) { ?>
                        <a href="<?php echo $item_object_url; ?>" class="ribbon ribbon-xl btn-iframe preview_detail"
                           target="_blank" rel="nofollow">
                            <span class="icon"></span> Preview
                        </a>
                    <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                        <a href="<?php echo $item_preview_pdf; ?>" class="ribbon ribbon-xl preview_detail"
                           target="_blank"><span class="icon"></span> Preview</a>
                    <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                        <a href="#" class="ribbon ribbon-xl preview_detail" data-toggle="modal"
                           data-target="#previewModal"><span class="icon"></span> Preview</a>
                    <?php } ?>
                <?php } ?>

            </div>
        </div>

        <div class="product-info">


            <div class="container">

                <?php if ($item_cta_button == 'Contact Us') { ?>
                    <p class="interested">
                        Interested in purchasing<br>this item?
                    </p>
                <?php } ?>

                <div class="buttons">

                    <?php
                    /* ---------------------------  Start helloAri  -------------------- */
                    if ($item_for_sale == 'Y' && $item_price > 0) { ?>

                        <?php do_action('ww_add_to_cart'); ?>
                        <!-- BalkanOutsource Google Analytics Event -->
                    <?php } else {

                        if ($item_for_sale == 'N' && $item_price > 0) { ?>
                            <span style="display: block; margin-bottom: 10px;font-size: 1.5em;">
							<?php
                            $price_formatted = number_format((float)$item_price, 2, '.', '');
                            echo $price_formatted;
                            ?>
							</span>
                        <?php } else if ($item_for_sale == 'N' && $item_price == 0) { ?>
                            <!-- <p class="add_to_cart_inline"><span class="amount">FREE</span></p> -->
                        <?php } ?>
                        <?php if ($item_cta_button == 'Contact Us') { ?>
                            <p class="interested">
                                Interested in purchasing<br>this item?
                            </p>
                        <?php } ?>

                        <?php if (($item_cta_button == 'Download') && ($item_cta_button_pdf)) { ?>
                            <p class="btn-contact">
                                <a href="<?php echo $item_cta_button_pdf; ?>" target="_blank" class="btn">Download</a>
                            </p>
                        <?php } else if (($item_cta_button == 'Visit Website') && ($item_cta_button_url)) { ?>
                            <p class="btn-contact">
                                <a <?php if (strpos($item_cta_button_url, 'wisewire.com') == false): ?> data-rel="nofollow" <?php endif; ?>
                                        data-href="<?php echo $item_cta_button_url; ?>" data-toggle="modal"
                                        data-target="#accessExternalConfirm" class="btn">Visit Website</a>
                                <!--<a href="<?php echo $item_cta_button_url; ?>" target="_blank" class="btn">Visit Website</a>-->
                            </p>
                        <?php } else if ($item_cta_button == 'Contact Us') { ?>
                            <p class="btn-contact">
                                <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a>
                                <!--<a href="javascript:Intercom('show')" class="btn">Contact us</a>-->
                            </p>
                        <?php } ?>

                        <?php
                        /* ---------------------------  End helloAri  -------------------- */
                    } ?>

                    <?php if (is_user_logged_in()) { ?>

                        <?php // ADD to favorites ?>
                        <p class="btn-favorites">

                            <a <?php echo $is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item_object_id ?>"
                                    data-item_id="<?php echo $item_object_id ?>" class="btn btn-alt btn-remove-favorite"
                                    data-toggle="popover"
                                    data-content='
                     <p class="info info-added">Item removed from favorites</p>
                     '>REMOVE FAVORITE</a>

                            <a <?php echo !$is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_add&amp;item_id=<?php echo $item_object_id ?>"
                                    data-item_id="<?php echo $item_object_id ?>" class="btn btn-alt btn-add-favorite"
                                    data-toggle="popover"
                                    data-content='
                     <p class="info info-added">Item added to favorites</p>
                     '>ADD TO FAVORITES</a>

                        </p>
                        <?php if (current_user_can('administrator')): ?>
                            <p class="btn-favorites">
                                <a data-name="action_hide_items" data-item_id="<?php echo $item_id ?>"
                                   data-status="<?php echo $is_hide_item; ?>" href="#"
                                   class="btn btn-alt"><?php echo $is_hide_item == 1 ? 'SHOW' : 'HIDE'; ?> ITEM</a>
                            </p>
                        <?php endif ?>

                    <?php } else { ?>

                        <p class="btn-favorites">
                            <a href="#"
                               class="btn btn-alt btn-favorite-not-loggedin"
                               data-toggle="popover"
                               data-content='
                    <p class="info">You must be logged in to create favorites</p><p class="clearfix"><a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=item" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=item" class="btn">Create account</a></p>
                    '
                            >ADD TO FAVORITES</a>
                        </p>

                    <?php } ?>

                </div>

                <div class="rate-section">
                    <div class="side-rate">
                        <?php rating_display_stars($item_ratings, 'medium') ?>
                        <span class="number rate-number"><?php echo $item_ratings ? $item_ratings : '' ?></span>
                    </div>
                    <?php if (is_user_logged_in()) { ?>

                        <?php // Allow to rate an item ?>
                        <p class="rateit">
                            <a href="#" data-toggle="modal" data-target="#rateModal">RATE THIS &gt;</a>
                        </p>

                        <?php if (current_user_can('administrator')): ?>
                            <p class="rateit">
                                <a data-my_action="Ratings|action_remove" data-item-type=""
                                   data-id="<?php echo $item_id ?>" data-item-id="<?php echo $item_object_id ?>"
                                   href="#" class="remove-rating">Remove Rating</a>
                            </p>
                        <?php endif; ?>

                    <?php } else { ?>

                        <p class="rateit">
                            <a href="#"
                               class="btn-rateit-not-loggedin"
                               data-toggle="popover"
                               data-content='
                    <p class="info">You must be logged in to rate an item</p><p class="clearfix"><a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=item" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=item" class="btn">Create account</a></p>
                    '
                            >RATE THIS &gt;</a>
                        </p>

                    <?php } ?>

                </div>

                <?php if ($item_contributor !== '') : ?>
                    <div class="contributor">
                        <p>
                            <strong>Contributor</strong>
                            <span>
                <?php if ($item_contributor_description != '') { ?>
                    <a href="#" data-toggle="modal"
                       data-target="#contributorDetailsModal"><?php echo $item_contributor ?></a>
                <?php } else { ?>
                    <?php echo $item_contributor ?>
                <?php } ?>
                </span>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (is_user_logged_in()) : ?>
                    <div class="buttons">
                        <p class="btn-contact">
                            <a href="#" class="btn btn-alt" data-toggle="modal"
                               data-target="#feedbackModal">Feedback</a>
                        </p>
                    </div>
                <?php endif ?>

            </div>

        </div>

        <div class="mobile-accordion" id="mobile-accordion-1" role="tablist" aria-multiselectable="true">

            <div class="panel panel-default">

                <div class="panel-heading" role="tab" id="viewDetailsHeading1">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#mobile-accordion-1" href="#viewDetails"
                           aria-expanded="true" aria-controls="viewDetails" class="collapsed">
                            View Details
                        </a>
                    </h4>
                </div>

                <div id="viewDetails" class="panel-collapse collapse view-details" role="tabpanel"
                     aria-labelledby="viewDetailsHeading1">
                    <div class="panel-body">

                        <div class="panel-content details-content-more">

                            <dl class="dl-horizontal">
                                <dt>Update</dt>
                                <dd><?php echo $item_publish_date; ?></dd>

                                <?php if ($item_content_type_icon !== ''): ?>
                                    <dt>Content Type</dt>
                                    <dd><?php echo $item_content_type_icon ?></dd>
                                <?php endif ?>

                                <dt>Grade Level</dt>
                                <dd><?php echo $item_grades ?></dd>

                                <?php if ($item_object_type !== ''): ?>
                                    <dt>Object Type</dt>
                                    <dd><?php echo str_replace("tei", "&nbsp;TEI&nbsp;", ucfirst($item_object_type)) ?></dd>
                                <?php endif; ?>

                                <?php if ($item_license_type !== ''): ?>
                                    <dt>License</dt>
                                    <dd>
                                        <?php if ($item_license_type_link !== '') { ?>
                                            <a rel="license" href="<?php echo $item_license_type_link; ?>"
                                               target="_blank">
                                                <?php if ($item_license_icon): ?>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/cc-license/<?php echo $item_license_icon ?>.png"/>
                                                <?php else: ?>
                                                    <?php echo $item_license_type; ?>
                                                <?php endif ?>
                                            </a>
                                        <?php } else { ?>
                                            <?php echo $item_license_type; ?>
                                        <?php } ?>
                                    </dd>
                                <?php endif; ?>

                            </dl>

                        </div>

                    </div>
                </div>
            </div>

            <div class="panel panel-default">

                <div class="panel-heading" role="tab" id="descriptionHeading1">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#mobile-accordion-1"
                           href="#descriptionPanel" aria-expanded="true" aria-controls="descriptionPanel"
                           class="collapsed">
                            Description
                        </a>
                    </h4>
                </div>

                <div id="descriptionPanel" class="panel-collapse collapse accordion-description" role="tabpanel"
                     aria-labelledby="descriptionHeading3">
                    <div class="panel-body">

                        <div class="panel-content">

                            <?php if ($item_long_description): ?>
                                <?php echo $item_long_description; ?>
                            <?php endif; ?>

                            <?php if ($item_read_more): ?>
                                <div class="collapse" id="detailMobileReadMore1">
                                    <div class="content-more">
                                        <?php echo $item_read_more; ?>
                                    </div>
                                </div>
                                <p class="more">
                                    <a role="button" data-toggle="collapse" href="#detailMobileReadMore1"
                                       aria-expanded="false" aria-controls="detailMobileReadMore1"><strong>Read
                                            more</strong> <span class="caret"></span></a>
                                </p>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>

        </div><!-- /mobile-accordion -->

        <div class="container">

            <ul class="post-nav">
                <?php if ($item_cms_previous_in_sequence) { ?>
                    <?php
                    foreach ($item_cms_previous_in_sequence as $post):
                        setup_postdata($post); // variable must be called $post (IMPORTANT)
                        ?>

                        <li class="previous">
                            <a href="<?php the_permalink(); ?>" data-toggle="tooltip" data-placement="right"
                               title="<?php the_title(); ?>">&lt; previous IN THIS SERIES</a>
                        </li>

                    <?php endforeach;
                    wp_reset_postdata(); ?>

                <?php } else if ($item_prev) { ?>
                    <li class="previous">
                        <a href="<?php echo get_permalink($item_prev[0]) ?>" data-toggle="tooltip"
                           data-placement="right"
                           title="<?php echo esc_html($item_prev[0]->post_title) ?>" <?php echo add_rel_nofollow_to_item($item_prev[0]->ID) ?> >
                            &lt;
                            previous IN THIS SERIES</a>
                    </li>
                <?php } ?>

                <?php if ($item_cms_next_in_sequence) { ?>
                    <?php
                    foreach ($item_cms_next_in_sequence as $post):
                        setup_postdata($post); // variable must be called $post (IMPORTANT)
                        ?>

                        <li class="next">
                            <a href="<?php the_permalink(); ?>" data-toggle="tooltip" data-placement="left"
                               title="<?php the_title(); ?>">next IN THIS SERIES &gt;</a>
                        </li>

                    <?php endforeach;
                    wp_reset_postdata(); ?>

                <?php } else if ($item_next) { ?>
                    <li class="next">
                        <a href="<?php echo get_permalink($item_next[0]) ?>" data-toggle="tooltip" data-placement="left"
                           title="<?php echo esc_html($item_next[0]->post_title) ?>" <?php echo add_rel_nofollow_to_item($item_next[0]->ID) ?> >next
                            IN THIS SERIES &gt;</a>
                    </li>
                <?php } ?>
            </ul>

        </div>


        <?php if ($item_cms_related_items) { ?>

            <div class="accordion-style">

                <h3 class="title">Related Items</h3>

                <?php foreach ($item_cms_related_items as $post):
                    setup_postdata($post); // variable must be called $post (IMPORTANT)
                    ?>

                    <article class="lo-item <?php echo $WWItems->get_color($post->item_content_type_icon) ?>">

                        <a href="<?php echo get_permalink($post) ?>" <?php echo add_rel_nofollow_to_item($post->ID) ?> >
                            <div class="content">
                                <div class="details">
                                    <h3 class="sub-discipline">
                                        <?php echo $WWItems->get_subdiscipline($post->ID) ?>
                                    </h3>

                                </div>
                                <div class="content-title">
                                    <h3><?php echo $post->post_title ?></h3>
                                    <div class="content-type-icon">
                                        <svg
                                                class="svg-<?php echo $WWItems->get_icon($post->item_content_type_icon) ?>-dims">
                                            <use
                                                    xlink:href="#<?php echo $WWItems->get_icon($post->item_content_type_icon) ?>"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>

                <?php endforeach;
                wp_reset_postdata(); ?>
            </div><!-- accordion-style -->

        <?php } else if ($item_related) { ?>
            <div class="accordion-style">

                <h3 class="title">Related Items</h3>

                <?php foreach ($item_related as $item): ?>
                    <article class="lo-item <?php echo $WWItems->get_color($item->item_content_type_icon) ?>">
                        <a href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?>>
                            <div class="content">
                                <div class="details">
                                    <h3 class="sub-discipline">
                                        <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                    </h3>

                                </div>
                                <div class="content-title">
                                    <h3><?php echo $item->post_title ?></h3>
                                    <div class="content-type-icon">
                                        <svg
                                                class="svg-<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>-dims">
                                            <use
                                                    xlink:href="#<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div><!-- accordion-style -->
        <?php } ?>

    </div><!-- /visible-xs-block -->


    <!-- Hidden on <768px -->
    <div class="hidden-xs">

        <div class="container">

            <div class="col-left">

                <div class="img">

                    <?php
                    if ($item_main_image):
                        $size = "detail";
                        $image = wp_get_attachment_image_src($item_main_image, $size);
                        ?>

                        <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                        <?php if ($item_demo_viewer_template == "Iframe") { ?>

                            <?php if ($item_object_url): ?>
                                <a href="<?php echo $item_object_url; ?>" class="btn-iframe" target="_blank"
                                   rel="nofollow">
                                    <span class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                                   class="img-responsive"/>
                                </a>
                            <?php else: ?>
                                <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                            <?php endif; ?>

                        <?php } else if ($item_demo_viewer_template == "PDF") { ?>

                            <?php if ($item_preview_pdf): ?>
                                <a href="<?php echo $item_preview_pdf; ?>" class="" target="_blank"><span
                                            class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                                     class="img-responsive"/></a>
                            <?php else: ?>
                                <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                            <?php endif; ?>

                        <?php } else if ($item_demo_viewer_template == "Carousel") { ?>

                            <?php if ($item_carousel_images): ?>
                                <a href="#" class="" data-toggle="modal" data-target="#previewModal"><span
                                            class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                                     class="img-responsive"/></a>
                            <?php else: ?>
                                <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                            <?php endif; ?>

                        <?php } ?>
                    <?php } else { ?>
                        <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                    <?php } ?>

                    <?php else: ?>

                        <?php if (substr($item_preview, 0, 1) === 'Y') { ?>

                            <?php if ($item_demo_viewer_template == "Iframe") { ?>

                                <?php if ($item_object_url): ?>
                                    <a href="<?php echo $item_object_url; ?>" class="btn-iframe" rel="nofollow"
                                       target="_blank"><span
                                                class="icon"></span><?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                    </a>
                                <?php else: ?>
                                    <?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                <?php endif; ?>

                            <?php } else if ($item_demo_viewer_template == "PDF") { ?>

                                <?php if ($item_preview_pdf): ?>
                                    <a href="<?php echo $item_preview_pdf; ?>" class="" target="_blank"><span
                                                class="icon"></span><?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                    </a>
                                <?php else: ?>
                                    <?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                <?php endif; ?>

                            <?php } else if ($item_demo_viewer_template == "Carousel") { ?>

                                <?php if ($item_carousel_images): ?>
                                    <a href="#" class="" data-toggle="modal" data-target="#previewModal"><span
                                                class="icon"></span><?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                    </a>
                                <?php else: ?>
                                    <?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                                <?php endif; ?>

                            <?php } ?>

                        <?php } else { ?>
                            <?php echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title); ?>
                        <?php } ?>

                    <?php endif; ?>


                    <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                        <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url) && $inIframeAllowed) { ?>
                            <a href="<?php echo $item_object_url; ?>" class="ribbon ribbon-xl btn-iframe preview_detail"
                               target="_blank" rel="nofollow">
                                <span class="icon"></span> Preview
                            </a>
                        <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                            <a href="<?php echo $item_preview_pdf; ?>" class="ribbon ribbon-xl preview_detail"
                               target="_blank"><span class="icon"></span> Preview</a>
                        <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                            <a href="#" class="ribbon ribbon-xl preview_detail" data-toggle="modal"
                               data-target="#previewModal"><span class="icon"></span> Preview</a>
                        <?php } ?>
                    <?php } ?>

                </div>

                <article>

                    <?php if ($item_long_description) { ?>
                        <?php echo $item_long_description; ?>
                    <?php } ?>

                    <?php if ($item_read_more) { ?>
                        <div class="collapse" id="detailReadMore1">
                            <div class="content-more">
                                <?php echo $item_read_more; ?>
                            </div>
                        </div>
                        <p class="more">
                            <a role="button" data-toggle="collapse" href="#detailReadMore1" aria-expanded="false"
                               aria-controls="detailReadMore1"><strong>Read more</strong> <span
                                        class="caret"></span></a>
                        </p>
                    <?php } ?>
                </article>

                <ul class="post-nav">
                    <?php if ($item_cms_previous_in_sequence) { ?>
                        <?php
                        foreach ($item_cms_previous_in_sequence as $post):
                            setup_postdata($post); // variable must be called $post (IMPORTANT)
                            ?>

                            <li class="previous">
                                <a href="<?php the_permalink(); ?>" data-toggle="tooltip" data-placement="right"
                                   title="<?php the_title(); ?>">&lt; previous IN THIS SERIES</a>
                            </li>

                        <?php endforeach;
                        wp_reset_postdata(); ?>

                    <?php } else if ($item_prev) { ?>
                        <li class="previous">
                            <a href="<?php echo get_permalink($item_prev[0]) ?>" data-toggle="tooltip"
                               data-placement="right"
                               title="<?php echo esc_html($item_prev[0]->post_title) ?>" <?php echo add_rel_nofollow_to_item($item_prev[0]->ID) ?>>
                                &lt;
                                previous IN THIS SERIES</a>
                        </li>
                    <?php } ?>

                    <?php if ($item_cms_next_in_sequence) { ?>
                        <?php
                        foreach ($item_cms_next_in_sequence as $post):
                            setup_postdata($post); // variable must be called $post (IMPORTANT)
                            ?>

                            <li class="next">
                                <a href="<?php the_permalink(); ?>" data-toggle="tooltip" data-placement="left"
                                   title="<?php the_title(); ?>">next IN THIS SERIES &gt;</a>
                            </li>

                        <?php endforeach;
                        wp_reset_postdata(); ?>

                    <?php } else if ($item_next) { ?>
                        <li class="next">
                            <a href="<?php echo get_permalink($item_next[0]) ?>" data-toggle="tooltip"
                               data-placement="left"
                               title="<?php echo esc_html($item_next[0]->post_title) ?>" <?php echo add_rel_nofollow_to_item($item_next[0]->ID) ?> >next
                                IN
                                THIS SERIES &gt;</a>
                        </li>
                    <?php } ?>
                </ul>

            </div>

            <div class="col-right">

                <div class="sidebar">

                    <?php

                    /* ---------------------------  Start helloAri  -------------------- */
                    if ($item_for_sale == 'Y' && $item_price > 0) { ?>

                        <?php do_action('ww_add_to_cart'); ?>

                    <?php } else {

                        if ($item_for_sale == 'N' && $item_price > 0) { ?>
                            <span style="display: block; margin-bottom: 10px;font-size: 1.5em;">
							<?php
                            $price_formatted = number_format((float)$item_price, 2, '.', '');
                            echo $price_formatted;
                            ?>
							</span>
                        <?php } else if ($item_for_sale == 'N' && $item_price == 0) { ?>
                            <!-- <p class="add_to_cart_inline"><span class="amount">FREE</span></p> -->
                        <?php } ?>
                        <?php if ($item_cta_button == 'Contact Us') { ?>
                            <p class="interested">
                                Interested in purchasing<br>this item?
                            </p>
                        <?php } ?>

                        <?php if (($item_cta_button == 'Download') && ($item_cta_button_pdf)) { ?>
                            <p class="btn-contact">
                                <a href="<?php echo $item_cta_button_pdf; ?>" target="_blank" class="btn">Download</a>
                            </p>
                        <?php } else if (($item_cta_button == 'Visit Website') && ($item_cta_button_url)) { ?>
                            <p class="btn-contact">
                                <a <?php if (strpos($item_cta_button_url, 'wisewire.com') == false): ?> data-rel="nofollow" <?php endif; ?>
                                        data-href="<?php echo $item_cta_button_url; ?>" data-toggle="modal"
                                        data-target="#accessExternalConfirm" class="btn">Visit Website</a>
                            </p>
                        <?php } else if ($item_cta_button == 'Contact Us') { ?>
                            <p class="btn-contact">
                                <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a>
                                <!--<a href="javascript:Intercom('show')" class="btn">Contact us</a>-->
                            </p>
                        <?php } ?>

                        <?php
                        /* ---------------------------  End helloAri  -------------------- */
                    } ?>
                    <?php if (is_user_logged_in()) { ?>

                        <?php // ADD to favorites ?>
                        <p class="btn-favorites">

                            <a <?php echo $is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item_object_id ?>"
                                    data-item_id="<?php echo $item_object_id ?>" class="btn btn-alt btn-remove-favorite"
                                    data-toggle="popover"
                                    data-content='
                     <p class="info info-added">Item removed from favorites</p>
                     '>REMOVE FAVORITE</a>

                            <a <?php echo !$is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_add&amp;item_id=<?php echo $item_object_id ?>"
                                    data-item_id="<?php echo $item_object_id ?>"
                                    class="btn btn-alt btn-add-favorite"
                                    data-toggle="popover"
                                    data-content='<p class="info info-added">Item added to favorites</p>'>ADD TO
                                FAVORITES</a>
                        </p>

                        <?php if (current_user_can('administrator')): ?>
                            <p class="btn-favorites">
                                <a data-name="action_hide_items" data-item-id="<?php echo $item_id ?>"
                                   data-status="<?php echo $is_hide_item; ?>" href="#"
                                   class="btn btn-alt"><?php echo $is_hide_item == 1 ? 'SHOW' : 'HIDE'; ?> ITEM</a>
                            </p>
                        <?php endif; ?>

                    <?php } else { ?>

                        <?php
                        // In case user is not logged in we send itemURL with permalink to the login form, so the user can come back to an item detail page once logged in
                        ?>

                        <p class="btn-favorites">
                            <a href="#"
                               class="btn btn-alt btn-favorite-not-loggedin"
                               data-toggle="popover"
                               data-content='
                    <p class="info">You must be logged in to create favorites</p><p class="clearfix"><a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=item" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=item" class="btn">Create account</a></p>
                    '
                            >ADD TO FAVORITES</a>
                        </p>

                    <?php } ?>

                    <div class="side-rate">
                        <?php rating_display_stars($item_ratings, 'medium') ?>
                        <span class="number rate-number"><?php echo $item_ratings ? $item_ratings : '' ?></span>
                    </div>
                    <?php if (is_user_logged_in()) { ?>

                        <?php // Allow to rate an item ?>
                        <p class="rateit">
                            <a href="#" data-toggle="modal" data-target="#rateModal">RATE THIS &gt;</a>
                        </p>
                        <?php if (current_user_can('administrator')): ?>
                            <p class="rateit">
                                <a data-my_action="Ratings|action_remove" data-item-type=""
                                   data-id="<?php echo $item_id ?>" data-item-id="<?php echo $item_object_id ?>"
                                   href="#" class="remove-rating">Remove Rating</a>
                            </p>
                        <?php endif; ?>
                    <?php } else { ?>

                        <p class="rateit">
                            <a href="#"
                               class="btn-rateit-not-loggedin"
                               data-toggle="popover"
                               data-content='
                    <p class="info">You must be logged in to rate an item</p><p class="clearfix"><a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=item" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=item" class="btn">Create account</a></p>
                    '
                            >RATE THIS &gt;</a>
                        </p>

                    <?php } ?>
                    <div class="details-content">
                        <a role="button" data-toggle="collapse" href="#detailsContentReadMore1" aria-expanded="false"
                           aria-controls="detailsContentReadMore1" class="btn-details"><strong>View details</strong>
                            <span class="caret"></span></a>
                        <div class="collapse" id="detailsContentReadMore1">
                            <div class="details-content-more">

                                <dl>
                                    <dt>Update</dt>
                                    <dd><?php echo $item_publish_date; ?></dd>

                                    <?php if ($item_content_type_icon !== ''): ?>
                                        <dt>Content Type</dt>
                                        <dd><?php echo $item_content_type_icon ?></dd>
                                    <?php endif ?>

                                    <dt>Grade Level</dt>
                                    <dd><?php echo $item_grades ?></dd>

                                    <?php if ($item_object_type !== ''): ?>
                                        <dt>Object Type</dt>
                                        <dd><?php echo str_replace("tei", "&nbsp;TEI&nbsp;", ucfirst($item_object_type)) ?></dd>
                                    <?php endif; ?>

                                    <?php if ($item_license_type !== ''): ?>
                                        <dt>License</dt>
                                        <dd>
                                            <?php if ($item_license_type_link !== '') { ?>
                                                <a rel="license" href="<?php echo $item_license_type_link; ?>"
                                                   target="_blank">
                                                    <?php if ($item_license_icon): ?>
                                                        <img src="<?php echo get_template_directory_uri(); ?>/img/cc-license/<?php echo $item_license_icon ?>.png"/>
                                                    <?php else: ?>
                                                        <?php echo $item_license_type; ?>
                                                    <?php endif ?>
                                                </a>
                                            <?php } else { ?>
                                                <?php echo $item_license_type; ?>
                                            <?php } ?>
                                        </dd>
                                    <?php endif; ?>

                                </dl>

                            </div>
                        </div>
                    </div>

                    <?php if ($item_contributor !== ''): ?>
                        <div class="contributor">
                            <p>
                                <strong>Contributor</strong>
                                <span>
                <?php if ($item_contributor_description != '') { ?>
                    <a xmlns:cc="https://creativecommons.org/ns#" property="cc:attributionName" rel="cc:attributionURL"
                       href="#" data-toggle="modal"
                       data-target="#contributorDetailsModal"><?php echo $item_contributor ?></a>
                <?php } else { ?>
                    <span xmlns:cc="https://creativecommons.org/ns#"
                          property="cc:attributionName"><?php echo $item_contributor ?></span>
                <?php } ?>
    					</span>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (is_user_logged_in()) : ?>
                        <div class="buttons">
                            <p class="btn-favorites">
                                <a href="#" class="btn btn-alt" data-toggle="modal" data-target="#feedbackModal">Feedback</a>
                            </p>
                        </div>
                    <?php endif ?>


                </div>

            </div>

        </div><!-- /hidden-xs -->


</section><!-- /detail -->

<?php get_template_part('parts/modal', 'previewdetail'); ?>

<div class="modal fade modal-rate" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="modal-title">
                    <h3>
                        Rate this item
                    </h3>
                </div>

                <div class="clearfix">

                    <div class="col-left">
                        <article class="lo-item lo-item-col <?php echo $WWItems->get_color($item_content_type_icon) ?>">
                            <div class="img">
                                <?php
                                if ($item_main_image):
                                    $size = "detail";
                                    $image = wp_get_attachment_image_src($item_main_image, $size);
                                    ?>
                                    <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                                    <?php
                                else:
                                    echo $WWItems->get_thumbnail_by_discipline($item_id, $item_content_type_icon, 'detail', $item_subdiscipline, $item_contributor, $title);
                                endif;
                                ?>
                            </div>
                            <div class="content">
                                <div class="details">
                                    <h3 class="sub-discipline">
                                        <?php echo $WWItems->get_subdiscipline(get_the_ID()) ?>
                                    </h3>
                                    <p class="content-type">
                                        <?php echo $WWItems->get_type($item_content_type_icon) ?>
                                    </p>
                                    <p class="grade-level">
                                        <?php echo $item_grades ?>
                                    </p>
                                </div>
                                <div class="content-title">
                                    <h3><span xmlns:dct="http://purl.org/dc/terms/"
                                              property="dct:title"><?php echo $title ?></span>
                                    </h3>
                                    <div class="content-type-icon">
                                        <svg class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
                                            <use
                                                    xlink:href="#<?php echo $WWItems->get_icon($item_content_type_icon) ?>"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-right">
                        <form action="" method="POST" class="rate-form">

                            <input type="hidden" name="my_action" value="Ratings|action_add">
                            <input type="hidden" name="item_id" value="<?php echo $item_object_id ?>">
                            <input type="hidden" name="item_type" value="">
                            <input type="hidden" name="id" value="<?php echo $item_id; ?>">
                            <!-- wp ajax -->
                            <input type="hidden" name="action" value="do_rate">

                            <div class="current-rating">
                                <p class="current">
                                    Current rating
                                </p>
                                <div class="rate">
                                    <?php rating_display_stars($item_ratings, 'medium') ?>
                                    <p class="number rate-number"><?php echo $item_ratings ? $item_ratings : '' ?></p>
                                </div>
                            </div>

                            <div class="rate-function">
                                <select name="rate" class="rating-write">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <button class="btn" type="submit">Submit</button>
                        </form>
                    </div>

                </div>


            </div><!-- /modal-body -->
        </div>
    </div>
</div>

<?php if ($item_contributor !== '') { ?>
    <div class="modal fade modal-contributor" id="contributorDetailsModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="modal-title modal-title-border">
                        <h3>
                            Contributor Details
                        </h3>
                    </div>

                    <div class="clearfix">
                        <div class="col col-left">
                            <div class="option-logo">
                                <?php if ($item_contributor_image !== ''): ?>
                                    <img src="<?php echo $item_contributor_image; ?>" alt="" class="img-responsive"/>
                                <?php endif; ?>

                                <?php if ($item_contributor_website !== ''): ?>
                                    <a href="<?php echo esc_url($item_contributor_website) ?>" class="btn"
                                       target="_blank">Website</a>
                                <?php endif; ?>

                                <?php if ($item_contributor_email !== ''): ?>
                                    <a href="#" data-toggle="modal" data-target="#contributorContactModal" class="btn"
                                       data-dismiss="modal">Contact</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col col-right">
                            <?php if ($item_contributor_description !== '') { ?>
                                <?php echo $item_contributor_description ?>
                            <?php } ?>
                        </div>
                    </div>

                </div><!-- /modal-body -->
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($item_contributor !== '') { ?>
    <div class="modal fade" id="contributorContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="modal-title">
                        <h3>
                            Contact Contributor
                        </h3>
                    </div>

                    <?php if ($item_contributor_description) { ?>
                        <div class="modal-desc">
                            <p>
                                <?php echo $item_contributor_description; ?>
                            </p>
                        </div>
                    <?php } ?>

                    <div class="container-fluid">

                        <?php echo do_shortcode('[contact-form-7 id="191" title="Contact Contributor"]'); ?>

                    </div>

                </div><!-- /modal-body -->
            </div>
        </div>
    </div>
<?php } ?>


<?php if ($item_cms_related_items) { ?>


    <div class="hidden-xs">

        <section class="lo-items lo-shadow lo-last lo-related">

            <div class="container">

                <div class="section-title">
                    <h3>
                        RELATED ITEMS
                    </h3>
                </div>

                <div class="row row-no-margin">


                    <?php foreach ($item_cms_related_items as $post):
                        setup_postdata($post); // variable must be called $post (IMPORTANT)
                        ?>


                        <div class="col-sm-3 col-no-space col-2-next">
                            <article
                                    class="lo-item lo-item-col <?php echo $WWItems->get_color($post->item_content_type_icon) ?>">

                                <a href="<?php echo get_permalink($post) ?>" <?php echo add_rel_nofollow_to_item($post->ID) ?>>
                                    <div class="img">
                                        <?php
                                        $item_main_image = get_field('item_main_image', $post->ID);
                                        if ($item_main_image):
                                            $size = "detail";
                                            $image = wp_get_attachment_image_src($item_main_image, $size);
                                            ?>
                                            <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                                            <?php
                                        else:
                                            echo $WWItems->get_thumbnail_by_discipline($post->ID, $post->item_content_type_icon, 'thumb-related', $WWItems->get_subdiscipline($post->ID), get_field('item_contributor', $post->ID), get_the_title($post->ID));
                                        endif;
                                        ?>
                                    </div>
                                    <div class="content">
                                        <div class="details">
                                            <h3 class="sub-discipline">
                                                <?php echo $WWItems->get_subdiscipline($post->ID) ?>
                                            </h3>
                                        </div>
                                        <div class="content-title">
                                            <h3><?php echo $post->post_title ?></h3>
                                            <div class="content-type-icon">
                                                <svg
                                                        class="svg-<?php echo $WWItems->get_icon($post->item_content_type_icon) ?>-dims">
                                                    <use
                                                            xlink:href="#<?php echo $WWItems->get_icon($post->item_content_type_icon) ?>"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        </div>

                    <?php endforeach;
                    wp_reset_postdata(); ?>

                </div><!-- /row -->

            </div><!-- /container -->

        </section><!-- /lo-items lo-recommended -->

    </div><!-- /hidden-xs -->


<?php } else if ($item_related) { ?>
    <div class="hidden-xs">

        <section class="lo-items lo-shadow lo-last lo-related">

            <div class="container">

                <div class="section-title">
                    <h3>
                        RELATED ITEMS
                    </h3>
                </div>

                <div class="row row-no-margin">

                    <?php foreach ($item_related as $item): ?>
                        <div class="col-sm-3 col-no-space col-2-next">

                            <article
                                    class="lo-item lo-item-col <?php echo $WWItems->get_color($item->item_content_type_icon) ?>">
                                <a href="<?php echo get_permalink($item) ?>" <?php echo add_rel_nofollow_to_item($item->ID) ?>>
                                    <div class="img">
                                        <?php
                                        $item_main_image = get_field('item_main_image', $item->ID);
                                        if ($item_main_image):
                                            $size = "detail";
                                            $image = wp_get_attachment_image_src($item_main_image, $size);
                                            ?>
                                            <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                                            <?php
                                        else:
                                            echo $WWItems->get_thumbnail_by_discipline($item->ID, $item->item_content_type_icon, 'thumb-related', $WWItems->get_subdiscipline($item->ID), get_field('item_contributor', $item->ID), get_the_title($item->ID));
                                        endif;
                                        ?>
                                    </div>
                                    <div class="content">
                                        <div class="details">
                                            <h3 class="sub-discipline">
                                                <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                            </h3>
                                        </div>
                                        <div class="content-title">
                                            <h3><?php echo $item->post_title ?></h3>
                                            <div class="content-type-icon">
                                                <svg
                                                        class="svg-<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>-dims">
                                                    <use
                                                            xlink:href="#<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </article>

                        </div>
                    <?php endforeach; ?>

                </div><!-- /row -->

            </div><!-- /container -->

        </section><!-- /lo-items lo-recommended -->

    </div><!-- /hidden-xs -->
<?php } ?>

<div itemtype="http://schema.org/Review" itemscope>
    <meta itemprop="name" content="<?php echo $title; ?>">
    <div itemtype="http://schema.org/Rating" itemscope itemprop="reviewRating">
        <meta content="<?php echo $item_ratings ? $item_ratings : 0 ?>" itemprop="ratingValue"/>
    </div>
</div>

<script>
    $(function () {

        $('a[data-name="action_hide_items"]').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var statusItem = $this.data('status') == 1 ? 0 : 1;

            $.ajax({
                type: "POST",
                url: 'https://' + window.location.hostname + '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'post_item_hide_page',
                    'item_id': $this.data('itemId'),
                    'status': statusItem
                },
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.success) {
                        $this.text((statusItem == 1 ? 'SHOW' : 'HIDE') + ' ITEM');
                        $this.data('status', statusItem);
                    }
                });
        });
    });
</script>
<?php get_footer(); ?>



