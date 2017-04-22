<?php
/**
 * Template Name: About Us
 */

?>

<?php get_header(); ?>
<?php while(have_posts()): the_post();?>
<?php 
$first_sec_img = get_field('who_we_image',get_the_ID());
$first_sec_heading = get_field('who_we_heading',get_the_ID());
$first_sec_content = get_field('who_we_content',get_the_ID());
?>
<section class="abou-widget" style="background: url(<?php echo $first_sec_img; ?>) no-repeat left top;">
    <div class="container">
        <h2><?php echo $first_sec_heading; ?></h2>
        <?php echo $first_sec_content; ?>
    </div>
</section>
<?php 
$second_sec_heading = get_field('who_we_for_heading',get_the_ID());
$first_box_image = get_field('first_box_image',get_the_ID());
$first_box_heading = get_field('first_box_heading',get_the_ID());
$first_box_content = get_field('first_box_content',get_the_ID());
$second_box_image = get_field('second_box_image',get_the_ID());
$second_box_heading = get_field('second_box_heading',get_the_ID());
$second_box_content = get_field('second_box_content',get_the_ID());
$third_box_image = get_field('third_box_image',get_the_ID());
$third_box_heading = get_field('third_box_heading',get_the_ID());
$third_box_content = get_field('third_box_content',get_the_ID());
?>

<section class="for-widget">
    <div class="container">
        <h2><?php echo $second_sec_heading; ?></h2>
        <ul class="for-listing">
            <li>
                <figure><img src="<?php echo $first_box_image; ?>" alt=""></figure>
                <h4><?php echo $first_box_heading; ?></h4>
                <?php echo $first_box_content; ?>
            </li>
            <li>
                <figure><img src="<?php echo $second_box_image; ?>" alt=""></figure>
                <h4><?php echo $second_box_heading; ?></h4>
                <?php echo $second_box_content; ?>
            </li>
            <li>
                <figure><img src="<?php echo $third_box_image; ?>" alt=""></figure>
                <h4><?php echo $third_box_heading; ?></h4>
                <?php echo $third_box_content; ?>
            </li>
        </ul>
    </div>
</section>
<?php 
$left_side_image = get_field('left_side_image',get_the_ID());
$left_side_content = get_field('left_side_data',get_the_ID());
$right_side_image = get_field('right_side_image',get_the_ID());
$right_side_content = get_field('right_side_data',get_the_ID());

?>
<section class="figure-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xm-12">
                <div class="figure-widget figure-border">
                    <span class="figure-img"><img src="<?php echo $left_side_image; ?>" alt=""></span>
                   
            <div class="figure-text">
                <?php foreach($left_side_content as $leftdata):?>
                    <dl><h3><?php echo $leftdata['left_figure']; ?></h3><p><?php echo $leftdata['left_figure_text']; ?></p></dl>
                <?php endforeach;?>
            </div>
            <p>See <a href="#">our press</a></p>
 <?php // echo $left_side_content;?>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xm-12">
                <div class="figure-widget">
                    <span class="figure-img"><img src="<?php echo $right_side_image; ?>" alt=""></span>
                    <div class="figure-text">
                        <?php foreach($right_side_content as $rightdata): ?>
                        <dl><h3><?php echo $rightdata['right_figure']; ?></h3><p><?php echo $rightdata['right_figure_text']; ?></p></dl>
                        <?php endforeach; ?>
                    </div>
                    <?php // echo $right_side_content; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $testimonial_data = get_field('testimonial_data',get_the_ID()); if($testimonial_data): ?>
<section class="testimonial">
    <div class="container">
       
        <ul class="testimonial-slider">
            <?php foreach($testimonial_data as $testimonial_id): ?>
            <li>
                <h2><?php echo substr(get_field('testimonials_quote',$testimonial_id->ID),0,90); ?></h2>
                <em><?php echo get_field('testimonials_author_name',$testimonial_id->ID); ?> , <?php echo get_field('testimonials_author_title',$testimonial_id->ID); ?> <?php echo get_field('testimonials_author_district',$testimonial_id->ID); ?></em>
                <p>See <a href="<?php echo get_permalink($testimonial_id->ID)?>">what people are saying</a></p>
            </li>
            <?php endforeach; ?>
           
        </ul>
    </div>
</section>
<?php endif; ?>
<?php $team_data = get_field('team_data',get_the_ID()); if($team_data): ?>
<section class="team-section">
    <div class="container">
        <h2>WE ARE...</h2>
        <ul class="team-list">
            <?php foreach($team_data as $team_id): ?>
                <li>
                    <?php 
                        $member_image = get_field('member_image',$team_id->ID);
                        $member_name = get_field('member_name',$team_id->ID);
                        $member_description = get_field('member_description',$team_id->ID);
                    ?>    
                    <figure><img src="<?php echo $member_image; ?>" alt=""></figure>
                    <figcaption>
                        <h4><?php echo $member_name; ?></h4>
                        <span><?php echo get_the_title($team_id->ID);?></span>
                        <i class="down-arrow"><img src="<?php echo get_template_directory_uri(); ?>/img/down-arrow.png" alt=""></i>
                        <div class="team-bio">
                            <?php echo $member_description; ?>
                            <i class="down-arrow"><img src="<?php echo get_template_directory_uri(); ?>/img/up-arrow.png" alt=""></i>
                        </div>
                    </figcaption>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<?php endif; ?>
<?php endwhile;?>
<?php get_footer(); ?>