<?php

/*
  TODO
  Retina Images for Intro, Banner 1 and Banner 2
*/

global $WWItems;

/* Intro */
$intro_desktop_image = get_field('intro_desktop_image');
$intro_desktop_text_image = get_field('intro_desktop_text_image');
$intro_desktop_image_retina = get_field('intro_desktop_image_retina');
$intro_desktop_text_image_retina = get_field('intro_desktop_text_image_retina');

$intro_mobile_image = get_field('intro_mobile_image');
$intro_mobile_text_image = get_field('intro_mobile_text_image');
$intro_mobile_image_retina = get_field('intro_mobile_image_retina');
$intro_mobile_text_image_retina = get_field('intro_mobile_text_image_retina');

$intro_mobile_content_text = get_field('intro_mobile_content_text');

/* Search */
$search_text = get_field('search_text');
$search_headline_1 = get_field('search_headline_1');
$search_headline_2 = get_field('search_headline_2');
$search_headline_3 = get_field('search_headline_3');

/* Carousel */
$carousel_headline = get_field('carousel_headline');
$carousel_secondary_headline = get_field('carousel_secondary_headline');
$carousel_secondary_headline_link = get_field('carousel_secondary_headline_link');

/* Banner 1 */
$banner_1_desktop_image = get_field('banner_1_desktop_image');
$banner_1_desktop_text_image = get_field('banner_1_desktop_text_image');
$banner_1_desktop_image_retina = get_field('banner_1_desktop_image_retina');
$banner_1_desktop_text_image_retina = get_field('banner_1_desktop_text_image_retina');
$banner_1_mobile_image = get_field('banner_1_mobile_image');
$banner_1_mobile_text_image = get_field('banner_1_mobile_text_image');
$banner_1_mobile_image_retina = get_field('banner_1_mobile_image_retina');
$banner_1_mobile_text_image_retina = get_field('banner_1_mobile_text_image_retina');
$banner_1_mobile_text = get_field('banner_1_mobile_text');
$banner_1_content_text = get_field('banner_1_content_text');
$banner_1_link_text = get_field('banner_1_link_text');
$banner_1_link_url = get_field('banner_1_link_url');

/* Banner 2 */
$banner_2_desktop_image = get_field('banner_2_desktop_image');
$banner_2_desktop_text_image = get_field('banner_2_desktop_text_image');
$banner_2_desktop_image_retina = get_field('banner_2_desktop_image_retina');
$banner_2_desktop_text_image_retina = get_field('banner_2_desktop_text_image_retina');
$banner_2_mobile_image = get_field('banner_2_mobile_image');
$banner_2_mobile_text_image = get_field('banner_2_mobile_text_image');
$banner_2_mobile_image_retina = get_field('banner_2_mobile_image_retina');
$banner_2_mobile_text_image_retina = get_field('banner_2_mobile_text_image_retina');
$banner_2_mobile_text = get_field('banner_2_mobile_text');
$banner_2_content_text = get_field('banner_2_content_text');
$banner_2_link_text = get_field('banner_2_link_text');
$banner_2_link_url = get_field('banner_2_link_url');
?>


<section class="intro banner-responsive">
    <div class="hidden-xs">
        <?php if ($intro_desktop_image) { ?>
            <img src="<?php echo $intro_desktop_image; ?>" alt=""
                 srcset="<?php echo $intro_desktop_image; ?> 1x <?php if ($intro_desktop_image_retina) {
                     echo ',' . $intro_desktop_image_retina . ' 2x';
                 } ?>" class="img-responsive img-bg"/>
        <?php } ?>

        <?php if ($intro_desktop_text_image) { ?>
            <img src="<?php echo $intro_desktop_text_image; ?>" alt=""
                 srcset="<?php echo $intro_desktop_text_image; ?> 1x <?php if ($intro_desktop_text_image_retina) {
                     echo ',' . $intro_desktop_text_image_retina . ' 2x';
                 } ?>" class="img-responsive img-content"/>
        <?php } ?>
    </div>

    <div class="visible-xs-block">
        <?php if ($intro_mobile_image) { ?>
            <img src="<?php echo $intro_mobile_image; ?>" alt=""
                 srcset="<?php echo $intro_mobile_image; ?> 1x <?php if ($intro_mobile_image_retina) {
                     echo ',' . $intro_mobile_image_retina . ' 2x';
                 } ?>" class="img-responsive img-bg"/>
        <?php } ?>
        <?php if ($intro_mobile_text_image) { ?>
            <img src="<?php echo $intro_mobile_text_image; ?>" alt=""
                 srcset="<?php echo $intro_mobile_text_image; ?> 1x <?php if ($intro_mobile_text_image_retina) {
                     echo ',' . $intro_mobile_text_image_retina . ' 2x';
                 } ?>" class="img-responsive img-content"/>
        <?php } ?>

        <?php if ($intro_mobile_content_text) { ?>
            <div class="text">
                <p>
                    <?php echo $intro_mobile_content_text; ?>
                </p>
            </div>
        <?php } ?>
    </div>
</section><!-- /intro -->


<section class="main-search">

    <div class="container">

        <form role="search" method="get" id="searchform" class="searchform"
              action="<?php echo esc_url(home_url('/')); ?>">

            <?php if ($search_text) { ?>
                <div class="visible-xs-block">
                    <p class="mobile-search-intro">
                        <?php echo $search_text; ?>
                    </p>
                </div>
            <?php } ?>

            <div class="input-group">

                <input type="text" class="form-control" name="s" placeholder="<?php if ($search_text) {
                    echo $search_text;
                } ?>">
              <span class="input-group-btn">
                <button type="submit" class="btn" type="button">
                    <span class="icon"></span>
                </button>
              </span>

            </div>

            <div class="subheads hidden-xs">
                <div class="row">
                    <div class="col-1 col-sm-4">
                        <?php if ($search_headline_1) { ?>
                            <h3>
                                <a href="/filtered/?filter=object_type&filter_value=tei&nogrades=1"
                                   title=""><?php echo $search_headline_1; ?></a>
                            </h3>
                        <?php } ?>
                    </div>
                    <div class="col-2 col-sm-4">
                        <?php if ($search_headline_2) { ?>
                            <h3>
                                <a href="/explore/search/playlist/?sepllcheck=1"
                                   title=""><?php echo $search_headline_2; ?></a>
                            </h3>
                        <?php } ?>
                    </div>
                    <div class="col-3 col-sm-4">
                        <?php if ($search_headline_3) { ?>
                            <h3>
                                <a href="/filtered/?filter=content_type&filter_value=student resource&nogrades=1"
                                   title=""><?php echo $search_headline_3; ?></a>
                            </h3>
                        <?php } ?>
                    </div>
                </div>

            </div>

        </form>

    </div><!-- /container -->

</section><!-- /main-search -->


<section class="section-headline">
    <div class="container">
        <?php if ($carousel_headline) { ?>
            <h3><?php echo $carousel_headline; ?></h3>
        <?php } ?>
        <?php if (($carousel_secondary_headline) && ($carousel_secondary_headline_link)) { ?>
            <p>
                <a href="<?php echo $carousel_secondary_headline_link; ?>"><?php echo $carousel_secondary_headline; ?></a>
            </p>
        <?php } ?>
    </div><!-- /container -->
</section><!-- /people-viewing -->

<?php
/* Allow client to select what should be shown on the home page carousel by CMS */
$posts = get_field('lo_carousel');
if ($posts): ?>
    <section class="lo-carousel-home">
        <div class="container-fluid">
            <div class="row">
                <div class="carousel">
                    <?php foreach ($posts as $post): ?>
                        <?php
                        $is_merlot = $post->source === 'MERLOT' ? true : false;
                        $item_main_image_attributes = wp_get_attachment_image_src($post->image_id, 'home-carousel');
                        ?>

                        <a class="lo-item <?php echo $WWItems->get_color($post->content_type_icon) ?>"
                           href="/item/<?php echo($post->type == 'item' ? $post->name : $post->id) ?>/">
                            <div class="img">
                                <?php if ($item_main_image_attributes): ?>
                                    <img src="<?php echo $item_main_image_attributes[0]; ?>" alt=""
                                         class="img-responsive">
                                <?php else: ?>
                                    <?php echo $WWItems->get_thumbnail($post->content_type_icon, 'home-carousel') ?>
                                <?php endif ?>
                            </div>
                            <div class="content">
                                <div class="details">
                                    <h3 class="sub-discipline">
                                        <?php echo $post->subdiscipline; ?>
                                    </h3>
                                    <p class="content-type">
                                        <?php echo $post->content_type_icon; ?>
                                    </p>
                                    <p class="grade-level">
                                        <?php echo $WWItems->get_grades($post->id, true, $is_merlot); ?>
                                    </p>
                                </div>
                                <div class="content-title">
                                    <h3><?php echo $post->title; ?></h3>
                                    <div class="content-type-icon">
                                        <svg
                                            class="svg-<?php echo $WWItems->get_icon($post->content_type_icon) ?>-dims">
                                            <use
                                                xlink:href="#<?php echo $WWItems->get_icon($post->content_type_icon) ?>"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div><!-- /carousel -->
            </div><!-- /row -->
        </div><!-- /container-fluid-->
    </section><!-- /lo-carousel-home -->
<?php endif; ?>

<section class="banner banner-responsive">

    <div class="hidden-xs">
        <?php if ($banner_1_desktop_image) { ?>
            <img src="<?php echo $banner_1_desktop_image; ?>" alt=""
                 srcset="<?php echo $banner_1_desktop_image; ?> 1x <?php if ($banner_1_desktop_image_retina) {
                     echo ',' . $banner_1_desktop_image_retina . ' 2x';
                 } ?>" class="img-responsive img-bg"/>
        <?php } ?>
        <?php if ($banner_1_desktop_text_image) { ?>
            <img src="<?php echo $banner_1_desktop_text_image; ?>" alt=""
                 srcset="<?php echo $banner_1_desktop_text_image; ?> 1x <?php if ($banner_1_desktop_text_image_retina) {
                     echo ',' . $banner_1_desktop_text_image_retina . ' 2x';
                 } ?>" class="img-responsive img-content"/>
        <?php } ?>
    </div>

    <div class="visible-xs-block">
        <?php if ($banner_1_mobile_image) { ?>
            <img src="<?php echo $banner_1_mobile_image; ?>" alt=""
                 srcset="<?php echo $banner_1_mobile_image; ?> 1x <?php if ($banner_1_mobile_image_retina) {
                     echo ',' . $banner_1_mobile_image_retina . ' 2x';
                 } ?>" class="img-responsive img-bg"/>
        <?php } ?>
        <?php if ($banner_1_mobile_text_image) { ?>
            <img src="<?php echo $banner_1_mobile_text_image; ?>" alt=""
                 srcset="<?php echo $banner_1_mobile_text_image; ?> 1x <?php if ($banner_1_mobile_text_image_retina) {
                     echo ',' . $banner_1_mobile_text_image_retina . ' 2x';
                 } ?>" class="img-responsive img-content"/>
        <?php } ?>
        <?php if ($banner_1_mobile_text) { ?>
            <div class="text">
                <p>
                    <?php echo $banner_1_mobile_text; ?>
                </p>
            </div>
        <?php } ?>
    </div>

    <div class="container">
        <div class="content">
            <?php if ($banner_1_content_text) { ?>
                <p><?php echo $banner_1_content_text; ?></p>
            <?php } ?>
            <?php if ($banner_1_link_text) { ?>
                <p class="more">
                    <a href="#" data-toggle="modal" data-target="#homeVideoModal"><?php echo $banner_1_link_text; ?></a>
                </p>
            <?php } ?>
        </div>
    </div>
</section><!-- /banner -->


<section class="content-accordion accordion-theme-1">

    <!-- Visible on <768px -->

    <?php if (have_rows('accordion_1_repeater')): ?>

        <div class="visible-xs-block">

            <div class="panels" id="accordion-1" role="tablist" aria-multiselectable="true">

                <?php $i = 1; ?>
                <?php while (have_rows('accordion_1_repeater')): the_row();

                    // Sub fields
                    $accordion_1_title = get_sub_field('accordion_1_title');
                    $accordion_1_icon = get_sub_field('accordion_1_icon');
                    $accordion_1_content = get_sub_field('accordion_1_content');

                    ?>

                    <div class="panel">
                        <div class="panel-heading" role="tab" id="accordion-1-heading-<?php echo $i; ?>">
                            <h4>
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-1"
                                   href="#accordion-1-collapse-<?php echo $i; ?>" aria-expanded="false"
                                   aria-controls="accordion-1-collapse-<?php echo $i; ?>">
                    <span class="icon-wrapper">
                      <img src="<?php echo $accordion_1_icon; ?>" alt=""/>
                    </span>
                                    <?php echo $accordion_1_title; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="accordion-1-collapse-<?php echo $i; ?>" class="panel-content collapse" role="tabpanel"
                             aria-labelledby="accordion-1-heading-<?php echo $i; ?>">
                            <div class="panel-body">
                                <p><?php echo $accordion_1_content; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php $i++; ?>
                <?php endwhile; ?>

            </div><!-- /panels -->

        </div><!-- /visible-xs-block -->

    <?php endif; ?>


    <!-- Hidden on <768px -->

    <?php if (have_rows('accordion_1_repeater')): ?>

    <div class="hidden-xs">

        <div class="tabs-list" id="tabs-list-1">

            <div class="container">

                <ul class="row" role="tablist">

                    <?php $i = 1; ?>
                    <?php while (have_rows('accordion_1_repeater')): the_row();

                        // Sub fields
                        $accordion_1_title = get_sub_field('accordion_1_title');
                        $accordion_1_icon = get_sub_field('accordion_1_icon');
                        ?>

                        <li role="presentation" class="col-sm-3">
                            <a href="#accordion-1-tab-<?php echo $i; ?>"
                               aria-controls="accordion-1-tab-<?php echo $i; ?>" role="tab" data-toggle="tab">
                  <span class="icon-wrapper">
                    <img src="<?php echo $accordion_1_icon; ?>" alt=""/>
                  </span>
                                <?php echo $accordion_1_title; ?>
                            </a>
                        </li>

                        <?php $i++; ?>
                    <?php endwhile; ?>

                </ul>

            </div>

        </div><!-- /tabs-list -->

        <?php endif; ?>


        <div class="tabs-panes">

            <div class="tab-content container">

                <?php $i = 1; ?>
                <?php while (have_rows('accordion_1_repeater')): the_row();

                    // Sub fields
                    $accordion_1_title = get_sub_field('accordion_1_title');
                    $accordion_1_content = get_sub_field('accordion_1_content');
                    ?>

                    <div role="tabpanel" class="tab-pane fade" id="accordion-1-tab-<?php echo $i; ?>">
                        <p>
                            <?php echo $accordion_1_content; ?>
                        </p>
                    </div>

                    <?php $i++; ?>
                <?php endwhile; ?>

            </div><!-- /tab-content -->

        </div><!-- /tabs-panes -->

    </div><!-- /hidden-xs -->

</section><!-- /content-accordion -->


<section class="testimonials">

    <div class="container">

        <?php
        // Show Partner Logos using Relationshp field from ACF
        $partners_posts = get_field('partners');
        if ($partners_posts):
        ?>

        <div class="carousel">

            <?php
            foreach ($partners_posts as $post):
            setup_postdata($post); // variable must be called $post (IMPORTANT)

            // Fields
            $partner_logo_or_text = get_field('partner_logo_or_text');
            $partner_logo = get_field('partner_logo');
            $partner_text = get_field('partner_text');
            $partner_quote = get_field('partner_quote');
            $partner_author_name = get_field('partner_author_name');
            $partner_author_title = get_field('partner_author_title');
            $partner_author_district = get_field('partner_author_district');
            $partner_author_email = get_field('partner_author_email');
            ?>

        <?php if ($partner_quote) { ?>
            <div
                data-toggle="popover"
                data-content="<?php echo $partner_quote; ?>"
                title='<?php if ($partner_author_name) { ?><div class="author"><strong><?php } else { ?><div><?php } ?><?php if ($partner_author_email) { ?><a href="mailto:<?php echo $partner_author_email; ?>"><?php if ($partner_author_name) {
                    echo $partner_author_name;
                } else {
                    echo $partner_author_email;
                } ?></a> <?php } else { ?><?php if ($partner_author_name) {
                    echo $partner_author_name;
                } ?><?php } ?><?php if ($partner_author_title) { ?>, <?php echo $partner_author_title; ?><?php } ?></strong> <?php if ($partner_author_district) {
                    echo $partner_author_district;
                } ?></div>'
            >
                <?php } else { ?>
                <div>
                    <?php } ?>
                    <?php if ($partner_logo_or_text == 'logoimage') { ?>
                        <?php if ($partner_logo) { ?>
                            <?php
                            $size = "partner-logos"; // (thumbnail, medium, large, full or custom size)
                            $image = wp_get_attachment_image_src($partner_logo, $size);
                            ?>
                            <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive"/>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($partner_text) {
                            echo '<p>' . $partner_text . '</p>';
                        } ?>
                    <?php } ?>

                </div>

                <?php endforeach; ?>

            </div>

            <?php endif;
            wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>

            <?php
            $partners_link_name = get_field('partners_link_name');
            $partners_link_url = get_field('partners_link_url');
            ?>

            <?php if ($partners_link_name) { ?>
                <p class="extra-content">
                    <?php if ($partners_link_url) { ?>
                        <a href="<?php echo $partners_link_url; ?>"><?php echo $partners_link_name; ?></a>
                    <?php } else { ?>
                        <?php echo $partners_link_name; ?>
                    <?php } ?>
                </p>
            <?php } ?>

        </div>

</section><!-- /testimonials -->


<section class="banner banner-responsive banner-long">
    <div class="hidden-xs">
        <?php if ($banner_2_desktop_image) { ?>
            <img src="<?php echo $banner_2_desktop_image; ?>" alt=""
                 srcset="<?php echo $banner_2_desktop_image; ?> 1x <?php if ($banner_2_desktop_image_retina) {
                     echo ',' . $banner_2_desktop_image_retina . ' 2x';
                 } ?>" class="img-responsive img-bg"/>
        <?php } ?>
        <?php if ($banner_2_desktop_text_image) { ?>
            <img src="<?php echo $banner_2_desktop_text_image; ?>" alt=""
                 srcset="<?php echo $banner_2_desktop_text_image; ?> 1x <?php if ($banner_2_desktop_text_image_retina) {
                     echo ',' . $banner_2_desktop_text_image_retina . ' 2x';
                 } ?>" class="img-responsive img-content"/>
        <?php } ?>
    </div>

    <div class="visible-xs-block">
        <?php if ($banner_2_mobile_image) { ?>
            <img src="<?php echo $banner_2_mobile_image; ?>" alt=""
                 srcset="<?php echo $banner_2_mobile_image; ?> 1x <?php if ($banner_2_mobile_image_retina) {
                     echo ',' . $banner_2_mobile_image_retina . ' 2x';
                 } ?>" class="img-responsive img-bg"/>
        <?php } ?>
        <?php if ($banner_2_mobile_text_image) { ?>
            <img src="<?php echo $banner_2_mobile_text_image; ?>" alt=""
                 srcset="<?php echo $banner_2_mobile_text_image; ?> 1x <?php if ($banner_2_mobile_text_image_retina) {
                     echo ',' . $banner_2_mobile_text_image_retina . ' 2x';
                 } ?>" class="img-responsive img-content"/>
        <?php } ?>
        <?php if ($banner_2_mobile_text) { ?>
            <div class="text">
                <p>
                    <?php echo $banner_2_mobile_text; ?>
                </p>
            </div>
        <?php } ?>
    </div>

    <div class="container">
        <div class="content">
            <?php if ($banner_2_content_text) { ?>
                <p><?php echo $banner_2_content_text; ?></p>
            <?php } ?>
            <?php if ($banner_2_link_text) { ?>
                <p class="more">
                    <a href="<?php if ($banner_2_link_url) {
                        echo $banner_2_link_url;
                    } ?>"><?php echo $banner_2_link_text; ?></a>
                </p>
            <?php } ?>
        </div>
    </div>
</section><!-- /banner -->


<section class="content-accordion accordion-theme-2">

    <!-- Visible on <768px -->

    <?php if (have_rows('accordion_2_repeater')): ?>

        <div class="visible-xs-block">

            <div class="panels" id="accordion-2" role="tablist" aria-multiselectable="true">

                <?php $i = 1; ?>
                <?php while (have_rows('accordion_2_repeater')): the_row();

                    // Sub fields
                    $accordion_2_title = get_sub_field('accordion_2_title');
                    $accordion_2_icon = get_sub_field('accordion_2_icon');
                    $accordion_2_content = get_sub_field('accordion_2_content');

                    ?>

                    <div class="panel">
                        <div class="panel-heading" role="tab" id="accordion-2-heading-<?php echo $i; ?>">
                            <h4>
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-2"
                                   href="#accordion-2-collapse-<?php echo $i; ?>" aria-expanded="false"
                                   aria-controls="accordion-2-collapse-<?php echo $i; ?>">
                    <span class="icon-wrapper">
                      <img src="<?php echo $accordion_2_icon; ?>" alt=""/>
                    </span>
                                    <strong><?php echo $accordion_2_title; ?></strong>
                                </a>
                            </h4>
                        </div>
                        <div id="accordion-2-collapse-<?php echo $i; ?>" class="panel-content collapse" role="tabpanel"
                             aria-labelledby="accordion-2-heading-<?php echo $i; ?>">
                            <div class="panel-body">
                                <p><?php echo $accordion_2_content; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php $i++; ?>
                <?php endwhile; ?>

            </div><!-- /panels -->

        </div><!-- /visible-xs-block -->

    <?php endif; ?>


    <!-- Hidden on <768px -->

    <?php if (have_rows('accordion_2_repeater')): ?>

    <div class="hidden-xs">

        <div class="tabs-list" id="tabs-list-2">

            <div class="container">

                <ul class="row" role="tablist">

                    <?php $i = 1; ?>
                    <?php while (have_rows('accordion_2_repeater')): the_row();

                        // Sub fields
                        $accordion_2_title = get_sub_field('accordion_2_title');
                        $accordion_2_icon = get_sub_field('accordion_2_icon');
                        ?>

                        <li role="presentation" class="col-sm-3">
                            <a href="#accordion-2-tab-<?php echo $i; ?>"
                               aria-controls="accordion-2-tab-<?php echo $i; ?>" role="tab" data-toggle="tab">
                  <span class="icon-wrapper">
                    <img src="<?php echo $accordion_2_icon; ?>" alt=""/>
                  </span>
                                <strong><?php echo $accordion_2_title; ?></strong>
                            </a>
                        </li>

                        <?php $i++; ?>
                    <?php endwhile; ?>

                </ul>

            </div>

        </div><!-- /tabs-list -->

        <?php endif; ?>


        <div class="tabs-panes">

            <div class="tab-content container">

                <?php $i = 1; ?>
                <?php while (have_rows('accordion_2_repeater')): the_row();

                    // Sub fields
                    $accordion_2_title = get_sub_field('accordion_2_title');
                    $accordion_2_content = get_sub_field('accordion_2_content');
                    ?>

                    <div role="tabpanel" class="tab-pane fade" id="accordion-2-tab-<?php echo $i; ?>">
                        <p>
                            <?php echo $accordion_2_content; ?>
                        </p>
                    </div>

                    <?php $i++; ?>
                <?php endwhile; ?>

            </div><!-- /tab-content -->

        </div><!-- /tabs-panes -->

    </div><!-- /hidden-xs -->


</section><!-- /content-accordion -->