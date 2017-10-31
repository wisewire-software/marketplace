<?php
/**
 * Template Name: Thank you
 */

?>

<?php get_header(); ?>

<div class="container">
    <div class="logo-sdemo-thankyou">
        <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="logo"></span>education marketplace</a>
    </div>
</div>
<section class="section-thank-you">
    <div class="container text-center">
        <div class="row">
            <img src="<?php echo get_template_directory_uri(); ?>/img/b2b_pages/icon_check.png">
            <h1 class="title-thank-you">Thank You For Contacting Wisewire</h1>
            <p class="lead description-ty first-description-ty">
                One of our representatives will call you shortly.
            </p>
            <p class="lead description-ty">
                In the meantime, feel free to browse our marketplace, read our blog,
                or interact with our social community!
            </p>
        </div>
    </div>
    <div class="container content-links-ty text-center">
        <div class="col-links">
            <a href="https://www.wisewire.com/" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/img/b2b_pages/btn_wisewire.png">
            </a>
            <a href="https://blog.wisewire.com/" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/img/b2b_pages/btn_blog.png">
            </a>
            <a href="https://www.linkedin.com/company/wisewire-education-marketplace" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/img/b2b_pages/btn_linkedin.png">
            </a>
            <a href="https://www.facebook.com/WisewireEd/" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/img/b2b_pages/btn_facebook.png">
            </a>
            <a href="https://twitter.com/wisewireed" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/img/b2b_pages/btn_twitter.png">
            </a>
            <a href="https://www.pinterest.com/WisewireEd/" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/img/b2b_pages/btn_pinterest.png">
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
