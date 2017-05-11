<?php

require_once(ABSPATH . 'wp-includes/WiseWireApi.php');

global $WWItems, $fav_controller;

// Get an item title and pass it to header.php <title>
global $item_from_platform;
global $item_from_platform_title;
$item_from_platform = true;
?>

<?php

$item_object_id = $wp_query->query['item'];

// Load item
$item = $wpdb->get_row("SELECT p.*, m4.`meta_value` AS `item_ratings`, m5.`meta_value` AS `is_hide_item` "
    . "FROM `wp_apicache_items` p "
    . "LEFT JOIN `wp_apicache_meta` m4 ON m4.`itemId` = p.`itemId` AND m4.`meta_key` = 'item_ratings'"
    . "LEFT JOIN `wp_apicache_meta` m5 ON m5.`itemId` = p.`itemId` AND m5.`meta_key` = 'is_hide_item'"
    . "WHERE p.`itemId` = '" . esc_sql($item_object_id) . "';");

// If an item doesn't exist, send to 404 page
if (!$item) {
    wp_redirect(home_url('/404'));
    exit;
}

$title = $item->title;
$item_from_platform_title = $item->title;


?>

<?php get_header(); ?>

<?php

$item_id = $item->itemId;
$item_publish_date = date('m-d-Y', strtotime($item->created));
$item_preview_url = $item->previewURL;
$item_price = $item->price;

$item_preview = $item_preview_url != '' ? 'Y' : 'N';
$item_content_type_icon = 'Assessment';
//$item_grade_level = get_field('item_grade_level');
$item_object_type = $item->itemType;
$item_contributor = $item->userFullName;
/* ID: 2186, is for Open Stack */
$item_contributor_id = $item->userId;
$item_ratings = $item->item_ratings;
$is_hide_item = $item->is_hide_item;
$item_dok = $item->dok;
$item_type = $item->type;
$item_license_type = $item->license_type;
$item_license_type_link = '';
$item_license_icon = '';

if ($item_license_type == 1) {
    $item_license_type = 'ALL-RIGHTS-RESERVED';
} elseif ($item_license_type == 2) {
    $item_license_type = 'CC BY';
    $item_license_type_link = 'https://creativecommons.org/licenses/by/4.0/';
    $item_license_icon = 'by';
} elseif ($item_license_type == 3) {
    $item_license_type = 'CC BY-SA';
    $item_license_type_link = 'https://creativecommons.org/licenses/by-sa/4.0/';
    $item_license_icon = 'by_sa';
} elseif ($item_license_type == 4) {
    $item_license_type = 'CC BY-ND';
    $item_license_type_link = 'https://creativecommons.org/licenses/by-nd/4.0/';
    $item_license_icon = 'by_nd';
} elseif ($item_license_type == 5) {
    $item_license_type = 'CC BY-NC';
    $item_license_type_link = 'https://creativecommons.org/licenses/by-nc/4.0/';
    $item_license_icon = 'by_nc';
} elseif ($item_license_type == 6) {
    $item_license_type = 'CC BY-NC-SA';
    $item_license_type_link = 'https://creativecommons.org/licenses/by-nc-sa/4.0/';
    $item_license_icon = 'by_nc_sa';
} elseif ($item_license_type == 7) {
    $item_license_type = 'CC BY-NC-ND';
    $item_license_type_link = 'https://creativecommons.org/licenses/by-nc-nd/4.0/';
    $item_license_icon = 'by_nc_nd';
} else {
    $item_license_type = 'No information';
}


//$item_standards = get_the_terms(get_the_ID(),'Standards');

//We pass true as thrid parameter to indicate this is a merlot item
$is_merlot = $item->source == 1 ? false : true;
$item_grades = $WWItems->get_grades($item_id, false, $is_merlot);

$WWItems::GetGradeName(array_keys($item_grades), true);
$item_grades = implode(', ', $item_grades);
$item_discipline = $WWItems->get_discipline($item_id);

$item_related = false;

$grade = isset($wp_query->query['grade']) ? $wp_query->query['grade'] : 'elementary';

/*1: for platform, 2: for merlot */
$item_source = $item->source;


$item_next = false;
$item_prev = false;

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

$is_favorite = $fav_controller->is_favorite($item_object_id, 'pod');


?>

<?php if ($item->source == 1): ?>

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

    <section class="detail detail-platform">

        <div class="container">

            <?php do_action('woocommerce_before_my_page'); // helloAri ?>

            <div class="btn-back hidden-xs">
                <a href="javascript: history.back();">&lt; Back</a>
            </div>

            <div class="metadata">

                <h1>
                    <?php echo isset($item_discipline['name']) ? $item_discipline['name'] : '&nbsp;' ?>
                </h1>
                <a href="/explore/<?php echo $grade ?>/<?php echo isset($item_discipline['slug']) ? $item_discipline['slug'] . '/' : '' ?>">VIEW
                    ALL <?php echo isset($item_discipline['name']) ? $item_discipline['name'] : '' ?></a>

                <h2>
                    <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><?php echo $title ?></span>
                </h2>
            </div><!-- /detail-info -->

        </div>

        <!-- Visible on <768px -->
        <div class="visible-xs-block">

            <?php if ($item_preview == 'Y') { ?>

                <div class="iframe-content">
                    <iframe src="<?php echo $item_preview_url; ?>" frameborder="0" width="1020" height="600"></iframe>
                </div>

            <?php } ?>

            <div class="product-info">

                <div class="container">

                    <?php if ($item_price != '0.00') { ?>
                        <div class="col">
                            <?php do_action('ww_add_to_cart_platform'); // helloAri ?>
                        </div>
                    <?php } ?>

                    <?php if ($item_price == '0.00' && $item_contributor_id != '2186'): ?>
                        <p class="interested">
                            Interested in purchasing this item?
                        </p>

                    <?php endif; ?>

                    <div class="buttons">
                        <p class="btn-contact">
                            <?php if ($item_contributor_id == '2186'): ?>


                                <?php if (is_user_logged_in()): ?>
                                    <!--<a href="<?php echo $item_preview_url; ?>" data-toggle="modal" data-target="#accessPlatformConfirm" class="btn">Add to dashboard</a>-->

                                <?php else: ?>
                                    <!--<a href="<?php echo $item_preview_url; ?>" class="btn">Add to dashboard</a>-->

                                    <?php if ($item_price == '0.00') { ?>

                                        <a href="#" class="btn btn-add-dashboard-not-loggedin" data-toggle="popover"
                                           data-content='
                          <p class="info">You must be logged in to Add to dashboard</p><p class="clearfix">
                          <a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn btn-login">
                          Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn">
                          Create account</a></p>'>Add to dashboard</a>
                                    <?php } ?>
                                <?php endif; ?>
                            <?php else: ?>

                                <?php if (is_user_logged_in()): ?>
                                    <!--<a href="<?php echo $item_preview_url; ?>" data-toggle="modal" data-target="#accessPlatformConfirm" class="btn">Add to dashboard</a>-->
                                    <?php if ($item_price == '0.00') { ?>
                                        <a href="/add-openstax?itemId=<?php echo $item_id; ?>&itemType=<?php echo $item_type ?>"
                                           target="_blank" class="btn">Add to dashboard</a>
                                    <?php } ?>


                                <?php else: ?>
                                    <!--<a href="<?php echo $item_preview_url; ?>" class="btn">Add to dashboard</a>-->

                                    <?php if ($item_price == '0.00') { ?>

                                        <a href="#" class="btn btn-add-dashboard-not-loggedin" data-toggle="popover"
                                           data-content='
                          <p class="info">You must be logged in to Add to dashboard</p><p class="clearfix">
                          <a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn btn-login">
                          Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn">
                          Create account</a></p>'>Add to dashboard</a>
                                    <?php } ?>
                                <?php endif; ?>

                                <!-- <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a> -->
                            <?php endif; ?>


                        </p>

                        <?php if (is_user_logged_in()) { ?>

                            <?php // ADD to favorites ?>
                            <p class="btn-favorites">

                                <a <?php echo $is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item_object_id ?>&amp;item_type=question"
                                    data-item_type="question" data-item_id="<?php echo $item_object_id ?>"
                                    class="btn btn-alt btn-remove-favorite"
                                    data-toggle="popover"
                                    data-content='
                     <p class="info info-added">Item removed from favorites</p>
                     '>REMOVE FAVORITE</a>

                                <a <?php echo !$is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_add&amp;item_id=<?php echo $item_object_id ?>&amp;item_type=question"
                                    data-item_type="question" data-item_id="<?php echo $item_object_id ?>"
                                    class="btn btn-alt btn-add-favorite"
                                    data-toggle="popover"
                                    data-content='
                   <p class="info info-added">Item added to favorites</p>
                   '>ADD TO FAVORITES</a>

                            </p>
                            <?php  if( current_user_can('administrator')): ?>
                                <p class="btn-favorites">
                                    <a data-name="action_hide_items"  data-item-id="<?php echo $item_id ?>" data-status="<?php echo $is_hide_item; ?>" href="#" class="btn btn-alt"><?php echo $is_hide_item == 1 ? 'SHOW': 'HIDE'; ?> ITEM</a>
                                </p>
                            <?php endif ?>

                        <?php } else { ?>

                            <p class="btn-favorites">
                                <a href="#"
                                   class="btn btn-alt btn-favorite-not-loggedin"
                                   data-toggle="popover"
                                   data-content='
                    <p class="info">You must be logged in to create favorites</p><p class="clearfix"><a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn">Create account</a></p>
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

                            <?php  if( current_user_can('administrator')): ?>
                                <p class="rateit">
                                    <a data-my_action="Ratings|action_remove" data-id="<?php echo $item_id ?>"  data-item-type="question" data-item-id="<?php echo $item_object_id ?>" href="#" class="remove-rating">Remove Rating</a>
                                </p>
                            <?php endif; ?>

                        <?php } else { ?>

                            <p class="rateit">
                                <a href="#"
                                   class="btn-rateit-not-loggedin"
                                   data-toggle="popover"
                                   data-content='
                    <p class="info">You must be logged in to rate an item</p><p class="clearfix"><a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn">Create account</a></p>
                    '
                                >RATE THIS &gt;</a>
                            </p>

                        <?php } ?>

                    </div>

                    <?php if ($item_contributor !== ''): ?>
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
                                <a href="#" class="btn btn-alt" data-toggle="modal" data-target="#feedbackModal">Feedback</a>
                            </p>
                        </div>
                    <?php endif ?>

                </div>

            </div>

            <div class="mobile-accordion" id="mobile-accordion-1" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">

                    <div class="panel-heading" role="tab" id="viewDetailsHeading1">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#mobile-accordion-1"
                               href="#viewDetails" aria-expanded="true" aria-controls="viewDetails" class="collapsed">
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
                                    <dd><?php echo $item_publish_date ?></dd>

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
                                        <dt>License Type</dt>
                                        <dd>
                                            <?php if ($item_license_type_link !== '') { ?>
                                                <a rel="license" href="<?php echo $item_license_type_link; ?>"
                                                   target="_blank">
                                                    <?php if($item_license_icon): ?>
                                                        <img src="<?php echo get_template_directory_uri(); ?>/img/cc-license/<?php echo $item_license_icon ?>.png" />
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

            </div><!-- /mobile-accordion -->

            <div class="container">

                <ul class="post-nav">
                    <?php if ($item_prev): ?>
                        <li class="previous">
                            <a href="<?php echo get_permalink($item_prev[0]) ?>" data-toggle="tooltip"
                               data-placement="right" title="<?php echo esc_html($item_prev[0]->post_title) ?>">&lt;
                                previous IN THIS SERIES</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($item_next): ?>
                        <li class="next">
                            <a href="<?php echo get_permalink($item_next[0]) ?>" data-toggle="tooltip"
                               data-placement="left" title="<?php echo esc_html($item_next[0]->post_title) ?>">next IN
                                THIS SERIES &gt;</a>
                        </li>
                    <?php endif; ?>
                </ul>

            </div>


            <?php if ($item_related): ?>
                <div class="accordion-style">

                    <h3 class="title">Related Items</h3>

                    <?php foreach ($item_related as $item): ?>
                        <article class="lo-item <?php echo $WWItems->get_color($item->item_content_type_icon) ?>"
                                 onclick="location.href='<?php echo get_permalink($item) ?>';">
                            <div class="content">
                                <div class="details">
                                    <h3 class="sub-discipline">
                                        <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                    </h3>
                                </div>
                                <div class="content-title">
                                    <h1><?php echo $item->post_title ?></h1>
                                    <div class="content-type-icon">
                                        <svg
                                            class="svg-<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>-dims">
                                            <use
                                                xlink:href="#<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div><!-- accordion-style -->
            <?php endif ?>

        </div><!-- /visible-xs-block -->

        <!-- Hidden on <768px -->

        <div class="hidden-xs">

            <div class="container">

                <div class="detail-info">
                    <?php if ($item_price != '0.00') { ?>
                        <div class="col">
                            <?php do_action('ww_add_to_cart_platform'); // helloAri ?>
                        </div>
                    <?php } ?>

                    <div class="col">
                        <?php if ($item_price == '0.00' && $item_contributor_id != '2186'): ?>
                            <p class="interested">
                                Interested in purchasing this item?
                            </p>

                        <?php endif; ?>
                        <?php $margin_class = ($item_contributor_id == '2186') ? "" : "btn-favorites"; ?>
                        <p class="btn-contact">
                            <?php if ($item_contributor_id == '2186'): ?>

                                <?php if (is_user_logged_in()): ?>
                                    <!--<a href="<?php echo $item_preview_url; ?>" data-toggle="modal" data-target="#accessPlatformConfirm" class="btn">Add to dashboardsss</a>-->
                                    <?php if ($item_price == '0.00') { ?>
                                        <a href="/add-openstax?itemId=<?php echo $item_id; ?>&itemType=<?php echo $item_type ?>"
                                           target="_blank" class="btn ">Add to dashboard</a>
                                    <?php } ?>
                                <?php else: ?>
                                    <!--<a href="<?php echo $item_preview_url; ?>" class="btn">Add to dashboard</a>-->
                                    <?php if ($item_price == '0.00') { ?>
                                        <a href="#" class="btn btn-add-dashboard-not-loggedin" data-toggle="popover"
                                           data-content='
                          <p class="info">You must be logged in to Add to dashboard</p><p class="clearfix">
                          <a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn btn-login">
                          Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn">
                          Create account</a></p>'>Add to dashboard</a>
                                    <?php } ?>
                                <?php endif; ?>
                            <?php else: ?>

                                <?php if (is_user_logged_in()): ?>
                                    <!--<a href="<?php echo $item_preview_url; ?>" data-toggle="modal" data-target="#accessPlatformConfirm" class="btn">Add to dashboard</a>-->
                                    <?php if ($item_price == '0.00') { ?>
                                        <a href="/add-openstax?itemId=<?php echo $item_id; ?>&itemType=<?php echo $item_type ?>"
                                           target="_blank" class="btn">Add to dashboard</a>
                                    <?php } ?>


                                <?php else: ?>
                                    <!--<a href="<?php echo $item_preview_url; ?>" class="btn">Add to dashboard</a>-->

                                    <?php if ($item_price == '0.00') { ?>

                                        <a href="#" class="btn btn-add-dashboard-not-loggedin" data-toggle="popover"
                                           data-content='
                          <p class="info">You must be logged in to Add to dashboard</p><p class="clearfix">
                          <a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn btn-login">
                          Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn">
                          Create account</a></p>'>Add to dashboard</a>
                                    <?php } ?>
                                <?php endif; ?>

                                <!-- <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a> -->

                            <?php endif; ?>
                        </p>
                    </div>

                    <?php if (is_user_logged_in()) { ?>

                        <?php // ADD to favorites ?>
                        <p class="col <?php echo $margin_class ?>">

                            <a <?php echo $is_favorite ? '' : 'style="display: none;"' ?>
                                href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item_object_id ?>&amp;item_type=question"
                                data-item_type="question" data-item_id="<?php echo $item_object_id ?>"
                                class="btn btn-alt btn-remove-favorite"
                                data-toggle="popover"
                                data-content='
                   <p class="info info-added">Item removed from favorites</p>
                   '>REMOVE FAVORITE</a>

                            <a <?php echo !$is_favorite ? '' : 'style="display: none;"' ?>
                                href="?my_action=Favorites|action_add&amp;item_id=<?php echo $item_object_id ?>&amp;item_type=question"
                                data-item_type="question" data-item_id="<?php echo $item_object_id ?>"
                                class="btn btn-alt btn-add-favorite"
                                data-toggle="popover"
                                data-content='
                     <p class="info info-added">Item added to favorites</p>
                     '>ADD TO FAVORITES</a>

                        </p>
                        <?php  if( current_user_can('administrator')): ?>
                            <p class="col <?php echo $margin_class ?>">
                                <a data-name="action_hide_items" data-item-id="<?php echo $item_id ?>" data-status="<?php echo $is_hide_item; ?>" href="#" class="btn btn-alt"><?php echo $is_hide_item == 1 ? 'SHOW': 'HIDE'; ?> ITEM</a>
                            </p>
                        <?php endif ?>

                    <?php } else { ?>

                        <p class="col <?php echo $margin_class ?>">
                            <a href="#"
                               class="btn btn-alt btn-favorite-not-loggedin"
                               data-toggle="popover"
                               data-content='
                  <p class="info">You must be logged in to create favorites</p><p class="clearfix"><a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn">Create account</a></p>
                  '
                            >ADD TO FAVORITES</a>
                        </p>

                    <?php } ?>
                    <div class="col">
                        <div class="side-rate"
                             style="<?php echo ($item_contributor_id == '2186') ? "margin-top:0" : ""; ?>">
                            <?php rating_display_stars($item_ratings, 'medium') ?>
                            <span class="number rate-number"><?php echo $item_ratings ? $item_ratings : '' ?></span>
                        </div>
                        <?php if (is_user_logged_in()) { ?>

                            <?php // Allow to rate an item ?>
                            <p class="rateit">
                                <a href="#" data-toggle="modal" data-target="#rateModal">RATE THIS &gt;</a>
                            </p>

                            <?php  if( current_user_can('administrator')): ?>
                                <p class="rateit">
                                    <a data-my_action="Ratings|action_remove" data-id="<?php echo $item_id ?>"  data-item-type="question" data-item-id="<?php echo $item_object_id ?>" href="#" class="remove-rating">Remove Rating</a>
                                </p>
                            <?php endif; ?>

                        <?php } else { ?>

                            <p class="rateit">
                                <a href="#"
                                   class="btn-rateit-not-loggedin"
                                   data-toggle="popover"
                                   data-content='
                    <p class="info">You must be logged in to rate an item</p><p class="clearfix"><a href="/user-login/?itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&itemID=<?php echo $item_id; ?>&itemType=itemplatform" class="btn">Create account</a></p>
                    '
                                >RATE THIS &gt;</a>
                            </p>

                        <?php } ?>

                    </div>

                    <?php if (is_user_logged_in()) : ?>
                        <div class="col col-last">
                            <div class="<?php echo $margin_class ?>">
                                <a href="#" class="btn btn-alt" data-toggle="modal" data-target="#feedbackModal">Feedback</a>
                            </div>
                        </div>
                    <?php endif ?>

                </div>

            </div>

            <?php if ($item_preview == 'Y') { ?>
                <div class="iframe-container">

                    <div class="iframe-content">
                        <iframe src="<?php echo $item_preview_url; ?>" frameborder="0" width="1020"
                                height="600"></iframe>
                    </div>

                </div>
            <?php } ?>

            <div class="container">

                <div class="detail-info">

                    <div class="col details-content">
                        <a role="button" data-toggle="collapse" href="#detailsContentReadMore1" aria-expanded="false"
                           aria-controls="detailsContentReadMore1" class="btn-details"><strong>View details</strong>
                            <span class="caret"></span></a>
                        <div class="collapse" id="detailsContentReadMore1">
                            <div class="details-content-more">

                                <dl>
                                    <dt>Update</dt>
                                    <dd><?php echo $item_publish_date ?></dd>

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
                                        <dt>License Type</dt>
                                        <dd>
                                            <?php if ($item_license_type_link !== '') { ?>
                                                <a rel="license" href="<?php echo $item_license_type_link; ?>"
                                                   target="_blank">
                                                    <?php if($item_license_icon): ?>
                                                        <img src="<?php echo get_template_directory_uri(); ?>/img/cc-license/<?php echo $item_license_icon ?>.png" />
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
                        <div class="col contributor">
                            <p>
                                <strong>Contributor</strong>
      					<span>
                            <?php if ($item_contributor_description != '') { ?>
                                <a xmlns:cc="https://creativecommons.org/ns#" property="cc:attributionName" rel="cc:attributionURL"
                                   href="#" data-toggle="modal" data-target="#contributorDetailsModal"><?php echo $item_contributor ?></a>
                            <?php } else { ?>
                                <span xmlns:cc="https://creativecommons.org/ns#" property="cc:attributionName"><?php echo $item_contributor ?></span>
                            <?php } ?>
      					</span>
                            </p>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>

        </div><!-- /hidden-xs -->


    </section><!-- /detail -->


    <div class="modal fade modal-rate" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="modal-title">
                        <h1>
                            Rate this item
                        </h1>
                    </div>

                    <div class="clearfix">

                        <div class="col-left">
                            <article
                                class="lo-item lo-item-col <?php echo $WWItems->get_color($item_content_type_icon) ?>">
                                <div class="img">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'detail')[0]; ?>
                                        <img src="<?php echo $image_url; ?>" alt="" class="img-responsive">
                                    <?php else: ?>
                                        <?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail') ?>
                                    <?php endif ?>
                                </div>
                                <div class="content">
                                    <div class="details">
                                        <h3 class="sub-discipline">
                                            <?php echo $WWItems->get_subdiscipline($item_id) ?>
                                        </h3>
                                        <p class="content-type">
                                            <?php echo $WWItems->get_type($item_content_type_icon) ?>
                                        </p>
                                        <p class="grade-level">
                                            <?php echo $item_grades ?>
                                        </p>
                                    </div>
                                    <div class="content-title">
                                        <h1><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><?php echo $title ?></span></h1>
                                        <div class="content-type-icon">
                                            <svg
                                                class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
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
                                <input type="hidden" name="item_type" value="question">
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

                                <button class="btn" type="submit">
                                    Submit
                                </button>
                            </form>
                        </div>

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
                            <h1>
                                Contributor Details
                            </h1>
                        </div>

                        <div class="clearfix">
                            <div class="col col-left">
                                <div class="option-logo">
                                    <?php if ($item_contributor_image !== ''): ?>
                                        <img src="<?php echo $item_contributor_image; ?>" alt=""
                                             class="img-responsive"/>
                                    <?php endif; ?>

                                    <?php if ($item_contributor_website !== ''): ?>
                                        <a href="<?php echo esc_url($item_contributor_website) ?>" class="btn"
                                           target="_blank">Website</a>
                                    <?php endif; ?>

                                    <?php if ($item_contributor_email !== ''): ?>
                                        <a href="#" data-toggle="modal" data-target="#contributorContactModal"
                                           class="btn" data-dismiss="modal">Contact</a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col col-right">
                                <?php if ($item_contributor_description !== ''): ?>
                                    <?php echo $item_contributor_description ?>
                                <?php else: ?>
                                    No description.
                                <?php endif ?>
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
                            <h1>
                                Contact Contributor
                            </h1>
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


    <?php if ($item_related): ?>
        <div class="hidden-xs">

            <section class="lo-items lo-shadow lo-last lo-related">

                <div class="container">

                    <div class="section-title">
                        <h1>
                            RELATED ITEMS
                        </h1>
                    </div>

                    <div class="row row-no-margin">

                        <?php foreach ($item_related as $item): ?>
                            <div class="col-sm-3 col-no-space col-2-next">

                                <article
                                    class="lo-item lo-item-col <?php echo $WWItems->get_color($item->item_content_type_icon) ?>"
                                    onclick="location.href='<?php echo get_permalink($item) ?>';">
                                    <div class="img">
                                        <?php if (has_post_thumbnail($item->ID)): ?>
                                            <?php
                                            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($item->ID), 'thumbnail')[0]; ?>
                                            <img src="<?php echo $image_url; ?>" alt="" class="img-responsive">
                                        <?php else: ?>
                                            <?php echo $WWItems->get_thumbnail($item->item_content_type_icon) ?>
                                        <?php endif ?>
                                    </div>
                                    <div class="content">
                                        <div class="details">
                                            <h3 class="sub-discipline">
                                                <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                            </h3>
                                        </div>
                                        <div class="content-title">
                                            <h1><?php echo $item->post_title ?></h1>
                                            <div class="content-type-icon">
                                                <svg
                                                    class="svg-<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>-dims">
                                                    <use
                                                        xlink:href="#<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                            </div>
                        <?php endforeach; ?>

                    </div><!-- /row -->

                </div><!-- /container -->

            </section><!-- /lo-items lo-recommended -->

        </div><!-- /hidden-xs -->

    <?php endif; ?>


<?php else: ?>

    <?php

    $item_long_description = str_replace('״', '"', $item->description);
    //$item_long_description = str_replace('<a', '<a target="_blank" ',  $item_long_description);

    $item_long_description = preg_replace('/<a href="(.*?)">(.*?)<\/a>/', "\\2", $item_long_description);

    $item_contributor = "<a href='http://www.merlot.org' target='_blank'>www.merlot.org</a>";
    $item_license_type_link = "";
    $item_license_type = "Merlot";
    $item_cta_button = 'Visit Website';
    $item_cta_button_url = $item->previewURL;
    $item_preview = 'Y';
    $item_demo_viewer_template = "Iframe";
    $item_object_url = $item->previewURL;
    $item_content_type_icon = $item->contentType;

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

            <div class="btn-back hidden-xs">
                <a href="javascript: history.back();">&lt; Back</a>
            </div>

            <div class="metadata">

                <h1>
                    <?php echo $item_discipline['name'] ?>
                </h1>
                <a href="/explore/<?php echo $grade ?>/<?php echo $item_discipline['slug'] ?>/">VIEW
                    ALL <?php echo $item_discipline['name'] ?></a>

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
                        <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                            <a href="#" class="btn-iframe" data-toggle="modal" data-target="#previewModalMerlot"
                               data-src="<?php echo $item_object_url; ?>"><span class="icon"></span><img alt=""
                                                                                                         src="<?php echo $image[0]; ?>"
                                                                                                         class="img-responsive"/></a>
                        <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                            <a href="<?php echo $item_preview_pdf; ?>" class="" target="_blank"><span
                                    class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                             class="img-responsive"/></a>
                        <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                            <a href="#" class="" data-toggle="modal" data-target="#previewModalMerlot"><span
                                    class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                             class="img-responsive"/></a>
                        <?php } ?>
                    <?php } else { ?>
                        <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                    <?php } ?>


                    <?php else: ?>
                        <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                            <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                                <a href="#" class="btn-iframe" data-toggle="modal" data-target="#previewModalMerlot"
                                   data-src="<?php echo $item_object_url; ?>"><span
                                        class="icon"></span><?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail'); ?>
                                </a>
                            <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                                <a href="<?php echo $item_preview_pdf; ?>" class="" target="_blank"><span
                                        class="icon"></span><?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail'); ?>
                                </a>
                            <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                                <a href="#" class="" data-toggle="modal" data-target="#previewModalMerlot"><span
                                        class="icon"></span><?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail'); ?>
                                </a>
                            <?php } ?>
                        <?php } else { ?>
                            <?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail'); ?>
                        <?php } ?>


                    <?php endif; ?>

                    <?php
                    if (substr($item_preview, 0, 1) === 'Y') {
                        ?>
                        <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                            <a href="#" class="ribbon ribbon-xl btn-iframe preview_detail" data-toggle="modal"
                               data-target="#previewModalMerlot" data-src="<?php echo $item_object_url; ?>"><span
                                    class="icon"></span> Preview</a>
                        <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                            <a href="<?php echo $item_preview_pdf; ?>" class="ribbon ribbon-xl preview_detail"
                               target="_blank"><span class="icon"></span> Preview</a>
                        <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                            <a href="#" class="ribbon ribbon-xl preview_detail" data-toggle="modal"
                               data-target="#previewModalMerlot"><span class="icon"></span> Preview</a>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>

            <div class="product-info">


                <div class="container">

                    <?php if ($item_price != '0.00') { ?>
                        <?php do_action('ww_add_to_cart_platform'); // helloAri ?>
                    <?php } ?>

                    <?php if ($item_cta_button == 'Contact Us') { ?>
                        <p class="interested">
                            Interested in purchasing<br>this item?
                        </p>
                    <?php } ?>

                    <div class="buttons">

                        <?php if (($item_cta_button == 'Download') && ($item_cta_button_pdf)) { ?>
                            <p class="btn-contact">
                                <a href="<?php echo $item_cta_button_pdf; ?>" target="_blank" class="btn">Download</a>
                            </p>
                        <?php } else if (($item_cta_button == 'Visit Website') && ($item->previewURL)) { ?>
                            <p class="btn-contact">
                                <!--<a href="<?php echo $item->previewURL; ?>" target="_blank" class="btn">Visit Website</a>-->
                                <a href="<?php echo $item_preview_url; ?>" data-toggle="modal"
                                   data-target="#accessExternalConfirm" class="btn">Visit Website</a>

                            </p>
                        <?php } else if ($item_cta_button == 'Contact Us') { ?>
                            <p class="btn-contact">
                                <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a>
                            </p>
                        <?php } ?>

                        <?php if (is_user_logged_in()) { ?>

                            <?php // ADD to favorites ?>
                            <p class="btn-favorites">

                                <a <?php echo $is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item_object_id ?>&amp;item_type=question&item_source=merlot"
                                    data-item_source="merlot" data-item_type="question"
                                    data-item_id="<?php echo $item_object_id ?>" class="btn btn-alt btn-remove-favorite"
                                    data-toggle="popover"
                                    data-content='
                     <p class="info info-added">Item removed from favorites</p>
                     '>REMOVE FAVORITE</a>

                                <a <?php echo !$is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_add&amp;item_id=<?php echo $item_object_id ?>&amp;item_type=question&item_source=merlot"
                                    data-item_source="merlot" data-item_type="question"
                                    data-item_id="<?php echo $item_object_id ?>" class="btn btn-alt btn-add-favorite"
                                    data-toggle="popover"
                                    data-content='
                     <p class="info info-added">Item added to favorites</p>
                     '>ADD TO FAVORITES</a>

                            </p>
                            <?php  if( current_user_can('administrator')): ?>
                                <p class="btn-favorites">
                                    <a data-name="action_hide_items"  data-item-id="<?php echo $item_id ?>" data-status="<?php echo $is_hide_item; ?>" href="#" class="btn btn-alt"><?php echo $is_hide_item == 1 ? 'SHOW': 'HIDE'; ?> ITEM</a>
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

                            <?php  if( current_user_can('administrator')): ?>
                                <p class="rateit">
                                    <a data-my_action="Ratings|action_remove" data-id="<?php echo $item_id ?>"  data-item-source="merlot" data-item-type="question" data-item-id="<?php echo $item_object_id ?>" href="#" class="remove-rating">Remove Rating</a>
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
                                <a href="#" class="btn btn-alt" data-toggle="modal" data-target="#feedbackModal">Feedback</a>
                            </p>
                        </div>
                    <?php endif ?>

                </div>

            </div>

            <div class="mobile-accordion" id="mobile-accordion-1" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default">

                    <div class="panel-heading" role="tab" id="viewDetailsHeading1">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#mobile-accordion-1"
                               href="#viewDetails" aria-expanded="true" aria-controls="viewDetails" class="collapsed">
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
                                                    <?php if($item_license_icon): ?>
                                                        <img src="<?php echo get_template_directory_uri(); ?>/img/cc-license/<?php echo $item_license_icon ?>.png" />
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
                               data-placement="right" title="<?php echo esc_html($item_prev[0]->post_title) ?>">&lt;
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
                               data-placement="left" title="<?php echo esc_html($item_next[0]->post_title) ?>">next IN
                                THIS SERIES &gt;</a>
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

                        <article class="lo-item <?php echo $WWItems->get_color($post->item_content_type_icon) ?>"
                                 onclick="location.href='<?php echo get_permalink($post) ?>';">
                            <div class="content">
                                <div class="details">
                                    <h3 class="sub-discipline">
                                        <?php echo $WWItems->get_subdiscipline($post->ID) ?>
                                    </h3>

                                </div>
                                <div class="content-title">
                                    <h1><?php echo $post->post_title ?></h1>
                                    <div class="content-type-icon">
                                        <svg
                                            class="svg-<?php echo $WWItems->get_icon($post->item_content_type_icon) ?>-dims">
                                            <use
                                                xlink:href="#<?php echo $WWItems->get_icon($post->item_content_type_icon) ?>"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </article>

                    <?php endforeach;
                    wp_reset_postdata(); ?>
                </div><!-- accordion-style -->

            <?php } else if ($item_related) { ?>
                <div class="accordion-style">

                    <h3 class="title">Related Items</h3>

                    <?php foreach ($item_related as $item): ?>
                        <article class="lo-item <?php echo $WWItems->get_color($item->item_content_type_icon) ?>"
                                 onclick="location.href='<?php echo get_permalink($item) ?>';">
                            <div class="content">
                                <div class="details">
                                    <h3 class="sub-discipline">
                                        <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                                    </h3>

                                </div>
                                <div class="content-title">
                                    <h1><?php echo $item->post_title ?></h1>
                                    <div class="content-type-icon">
                                        <svg
                                            class="svg-<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>-dims">
                                            <use
                                                xlink:href="#<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
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
                            <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                                <a href="#" class="btn-iframe" data-toggle="modal" data-target="#previewModalMerlot"
                                   data-src="<?php echo $item_object_url; ?>"><span class="icon"></span><img alt=""
                                                                                                             src="<?php echo $image[0]; ?>"
                                                                                                             class="img-responsive"/></a>
                            <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                                <a href="<?php echo $item_preview_pdf; ?>" class="" target="_blank"><span
                                        class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                                 class="img-responsive"/></a>
                            <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                                <a href="#" class="" data-toggle="modal" data-target="#previewModalMerlot"><span
                                        class="icon"></span><img alt="" src="<?php echo $image[0]; ?>"
                                                                 class="img-responsive"/></a>
                            <?php } ?>
                        <?php } else { ?>
                            <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                        <?php } ?>


                        <?php else: ?>

                            <?php if (substr($item_preview, 0, 1) === 'Y') { ?>
                                <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                                    <a href="#" class="btn-iframe" data-toggle="modal" data-target="#previewModalMerlot"
                                       data-src="<?php echo $item_object_url; ?>"><span
                                            class="icon"></span><?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail'); ?>
                                    </a>
                                <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                                    <a href="<?php echo $item_preview_pdf; ?>" class="" target="_blank"><span
                                            class="icon"></span><?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail'); ?>
                                    </a>
                                <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                                    <a href="#" class="" data-toggle="modal" data-target="#previewModalMerlot"><span
                                            class="icon"></span><?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail'); ?>
                                    </a>
                                <?php } ?>
                            <?php } else { ?>
                                <?php echo $WWItems->get_thumbnail($item_content_type_icon, 'detail'); ?>
                            <?php } ?>

                        <?php endif; ?>

                        <?php

                        if (substr($item_preview, 0, 1) === 'Y') { ?>
                            <?php if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>
                                <a href="#" class="ribbon ribbon-xl btn-iframe preview_detail" data-toggle="modal"
                                   data-target="#previewModalMerlot" data-src="<?php echo $item_object_url; ?>"><span
                                        class="icon"></span> Preview</a>
                            <?php } else if (($item_demo_viewer_template == "PDF") && ($item_preview_pdf)) { ?>
                                <a href="<?php echo $item_preview_pdf; ?>" class="ribbon ribbon-xl preview_detail"
                                   target="_blank"><span class="icon"></span> Preview</a>
                            <?php } else if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>
                                <a href="#" class="ribbon ribbon-xl preview_detail" data-toggle="modal"
                                   data-target="#previewModalMerlot"><span class="icon"></span> Preview</a>
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
                                   data-placement="right" title="<?php echo esc_html($item_prev[0]->post_title) ?>">&lt;
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
                                   data-placement="left" title="<?php echo esc_html($item_next[0]->post_title) ?>">next
                                    IN THIS SERIES &gt;</a>
                            </li>
                        <?php } ?>
                    </ul>

                </div>

                <div class="col-right">

                    <div class="sidebar">

                        <?php if ($item_price != '0.00') { ?>
                            <?php do_action('ww_add_to_cart_platform'); // helloAri ?>
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
                                <!--<a href="<?php echo $item_cta_button_url; ?>" target="_blank" class="btn">Visit Website</a>-->
                                <a href="<?php echo $item_preview_url; ?>" data-toggle="modal"
                                   data-target="#accessExternalConfirm" class="btn">Visit Website</a>
                            </p>
                        <?php } else if ($item_cta_button == 'Contact Us') { ?>
                            <p class="btn-contact">
                                <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a>
                            </p>
                        <?php } ?>


                        <?php if (is_user_logged_in()) { ?>

                            <?php // ADD to favorites ?>
                            <p class="btn-favorites">

                                <a <?php echo $is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $item_object_id ?>&amp;item_type=question&item_source=merlot"
                                    data-item_source="merlot" data-item_type="question"
                                    data-item_id="<?php echo $item_object_id ?>" class="btn btn-alt btn-remove-favorite"
                                    data-toggle="popover"
                                    data-content='
                     <p class="info info-added">Item removed from favorites</p>
                     '>REMOVE FAVORITE</a>

                                <a <?php echo !$is_favorite ? '' : 'style="display: none;"' ?>
                                    href="?my_action=Favorites|action_add&amp;item_id=<?php echo $item_object_id ?>&amp;item_type=question&item_source=merlot"
                                    data-item_source="merlot" data-item_type="question"
                                    data-item_id="<?php echo $item_object_id ?>" class="btn btn-alt btn-add-favorite"
                                    data-toggle="popover"
                                    data-content='
                     <p class="info info-added">Item added to favorites</p>
                     '>ADD TO FAVORITES</a>

                            </p>
                            <?php  if( current_user_can('administrator')): ?>
                                <p class="btn-favorites">
                                    <a data-name="action_hide_items"  data-item-id="<?php echo $item_id ?>" data-status="<?php echo $is_hide_item; ?>" href="#" class="btn btn-alt"><?php echo $is_hide_item == 1 ? 'SHOW': 'HIDE'; ?> ITEM</a>
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

                            <?php  if( current_user_can('administrator')): ?>
                                <p class="rateit">
                                    <a data-my_action="Ratings|action_remove" data-id="<?php echo $item_id ?>"  data-item-source="merlot" data-item-type="question" data-item-id="<?php echo $item_object_id ?>" href="#" class="remove-rating">Remove Rating</a>
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
                            <a role="button" data-toggle="collapse" href="#detailsContentReadMore1"
                               aria-expanded="false" aria-controls="detailsContentReadMore1"
                               class="btn-details"><strong>View details</strong> <span class="caret"></span></a>
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
                                                        <?php if($item_license_icon): ?>
                                                            <img src="<?php echo get_template_directory_uri(); ?>/img/cc-license/<?php echo $item_license_icon ?>.png" />
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
                        <h1>
                            Rate this item
                        </h1>
                    </div>

                    <div class="clearfix">

                        <div class="col-left">
                            <article
                                class="lo-item lo-item-col <?php echo $WWItems->get_color($item_content_type_icon) ?>">
                                <div class="img">
                                    <?php
                                    if ($item_main_image):
                                        $size = "detail";
                                        $image = wp_get_attachment_image_src($item_main_image, $size);
                                        ?>
                                        <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                                        <?php
                                    else:
                                        echo $WWItems->get_thumbnail($item_content_type_icon, 'detail');
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
                                        <h1><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><?php echo $title ?></span></h1>
                                        <div class="content-type-icon">
                                            <svg
                                                class="svg-<?php echo $WWItems->get_icon($item_content_type_icon) ?>-dims">
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
                                <input type="hidden" name="item_type" value="question">
                                <input type="hidden" name="item_source" value="merlot">
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

                                <button class="btn" type="submit">
                                    Submit
                                </button>
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
                            <h1>
                                Contributor Details
                            </h1>
                        </div>

                        <div class="clearfix">
                            <div class="col col-left">
                                <div class="option-logo">
                                    <?php if ($item_contributor_image !== ''): ?>
                                        <img src="<?php echo $item_contributor_image; ?>" alt=""
                                             class="img-responsive"/>
                                    <?php endif; ?>

                                    <?php if ($item_contributor_website !== ''): ?>
                                        <a href="<?php echo esc_url($item_contributor_website) ?>" class="btn"
                                           target="_blank">Website</a>
                                    <?php endif; ?>

                                    <?php if ($item_contributor_email !== ''): ?>
                                        <a href="#" data-toggle="modal" data-target="#contributorContactModal"
                                           class="btn" data-dismiss="modal">Contact</a>
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
                            <h1>
                                Contact Contributor
                            </h1>
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
                        <h1>
                            RELATED ITEMS
                        </h1>
                    </div>

                    <div class="row row-no-margin">


                        <?php foreach ($item_cms_related_items as $post):
                            setup_postdata($post); // variable must be called $post (IMPORTANT)
                            ?>


                            <div class="col-sm-3 col-no-space col-2-next">

                                <article
                                    class="lo-item lo-item-col <?php echo $WWItems->get_color($post->item_content_type_icon) ?>"
                                    onclick="location.href='<?php echo get_permalink($post) ?>';">
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
                                            echo $WWItems->get_thumbnail($post->item_content_type_icon);
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
                                            <h1><?php echo $post->post_title ?></h1>
                                            <div class="content-type-icon">
                                                <svg
                                                    class="svg-<?php echo $WWItems->get_icon($post->item_content_type_icon) ?>-dims">
                                                    <use
                                                        xlink:href="#<?php echo $WWItems->get_icon($post->item_content_type_icon) ?>"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
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
                        <h1>
                            RELATED ITEMS
                        </h1>
                    </div>

                    <div class="row row-no-margin">

                        <?php foreach ($item_related as $item): ?>
                            <div class="col-sm-3 col-no-space col-2-next">

                                <article
                                    class="lo-item lo-item-col <?php echo $WWItems->get_color($item->item_content_type_icon) ?>"
                                    onclick="location.href='<?php echo get_permalink($item) ?>';">
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
                                            echo $WWItems->get_thumbnail($item->item_content_type_icon);
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
                                            <h1><?php echo $item->post_title ?></h1>
                                            <div class="content-type-icon">
                                                <svg
                                                    class="svg-<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>-dims">
                                                    <use
                                                        xlink:href="#<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                            </div>
                        <?php endforeach; ?>

                    </div><!-- /row -->

                </div><!-- /container -->

            </section><!-- /lo-items lo-recommended -->

        </div><!-- /hidden-xs -->
    <?php } ?>


    <?php if (substr($item_preview, 0, 1) === 'Y') { ?>

        <?php if (($item_demo_viewer_template == "Carousel") || ($item_demo_viewer_template == "Iframe")) { ?>

            <div
                class="modal fade modal-preview<?php if ($item_demo_viewer_template == "Iframe") echo ' detail-iframe'; ?>"
                id="previewModalMerlot" tabindex="-1" role="dialog" aria-labelledby="previewModalMerlot">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="modal-title <?php if (!$item_demo_subhead) echo "modal-title-no-subhead"; ?>">

                                <h1><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><?php echo $title ?></span></h1>
                                <?php if ($item_demo_subhead) { ?>
                                    <h3><?php echo $item_demo_subhead; ?></h3>
                                <?php } ?>

                            </div>

                            <?php if (($item_demo_viewer_template == "Carousel") && ($item_carousel_images)) { ?>

                                <div class="carousel">
                                    <?php foreach ($item_carousel_images as $image) { ?>
                                        <li>
                                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"
                                                 class="img-responsive"/>
                                        </li>
                                    <?php } ?>
                                </div>

                            <?php } else if (($item_demo_viewer_template == "Iframe") && ($item_object_url)) { ?>

                                <div class="iframe-container">
                                    <iframe src="" frameborder="0" webkitAllowFullScreen mozallowfullscreen
                                            allowFullScreen></iframe>
                                </div>

                            <?php } ?>
                            <div style="width: 100%; color: #777; font-size:12px; padding-top: 10px;">
                                Your preview may not load properly due to 3rd party or browser restrictions.
                            </div>
                        </div><!-- /modal-body -->

                    </div>
                </div>
            </div><!-- /modal -->

        <?php } ?>

    <?php } ?>


<?php endif; ?>


<?php get_footer(); ?>

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
                        'action': 'post_item_platform_hide_page',
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