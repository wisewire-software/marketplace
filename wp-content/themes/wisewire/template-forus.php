<?php
/**
 * Template Name: Page For US
 */

?>

<?php get_header(); ?>

<section class="container-forus forus-custom-color-1">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>Create Computer-Based Assessments</h3>
                <div class="forus-description">
                    Our technology-enhanced item templates enable you to easily create, clone, and differentiate your
                    formative assessments. Build your own items, assemble them into assessments, assign to your student
                    groups, and track your students' progress on our platform - <span>Free</span>.
                </div>
                <div class="forus-actions">
                    <a href="<?php echo get_site_url(); ?>/user-login/" class="btn">Sign UP</a>
                    <a href="<?php echo get_site_url(); ?>/user-login/" class="btn">Log In</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container-forus forus-custom-color-2">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-10">
                        <div id="publishVideoIframe2" style="width:100%; height:375px"></div>
                        <div class="forus-description">Our item templates enable you to easily create formative
                            assessments, including tech-enhanced
                            items,
                            and deploy assignments straight to your students.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container-forus forus-custom-color-3">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>Create</h3>
                <div class="forus-description">
                    Create-your-own assessments using any of your 30+ technology enhanced templates designed to help you
                    prepare your students for the rigors of computer-based testing.

                    <ul>
                        <li><span class="icon-forus forus-clone"></span><span class="forus-text">Clone existing questions to take advantage of pre-populated templates and save valuable time.</span>
                        </li>
                        <li><span class="icon-forus forus-sample"></span><span class="forus-text">We've even given you 12 sample questions to start.</span></li>
                    </ul>
                </div>
                <div class="forus-images">
                    <div class="row">
                        <div class="col-md-6"><img
                                    src="<?php bloginfo('template_url'); ?>/img/for-us/for-us-create-1.png" alt="">
                        </div>
                        <div class="col-md-6 text-center"><img
                                    src="<?php bloginfo('template_url'); ?>/img/for-us/for-us-create-2.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>Assemble</h3>
                <div class="forus-description">
                    Easily assemble your created items into unique and differentiated assessments.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>Assign</h3>
                <div class="forus-description">
                    Create a student group with our Manage Groups feature using your students' emails. Or generate a group
                    code for students to join an already created group.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>Track</h3>
                <div class="forus-description">Track your students' progress on your dashboard.</div>
                <div class="forus-images">
                    <div class="row">
                        <div class="col-md-6"><img
                                    src="<?php bloginfo('template_url'); ?>/img/for-us/for-us-track-1.png" alt=""></div>
                        <div class="col-md-6 text-center"><img
                                    src="<?php bloginfo('template_url'); ?>/img/for-us/for-us-track-2.jpg" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container-forus forus-custom-color-4">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>Share your brilliance with others</h3>
                <div class="forus-description">
                    We make it simple to create content and publish it directly into the hands of other instructors,
                    students, and publishers. Our item templates enable you to easily create formative assessments, including
                    tech-enhanced items, and deploy assignments straight to your students.
                </div>
                <div class="forus-actions">
                    <a href="<?php echo get_site_url(); ?>/create" class="btn">Become an author</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>

<script type="text/javascript">

//    if ($(window).width() > 768) {
//        $('#publishVideoIframe2').player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');
//
//        $('#publishVideoIframe2').bind(uplynk.events.PLAYER_ERROR, function (e, arg) {
//            console.log(e, arg);
//        });
//    } else {
//        $('#publishVideoIframe').player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');
//    }
//
//
//    $(window).resize(function () {
//        if ($(window).width() > 768) {
//            $('#publishVideoIframe2').player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');
//
//        } else {
//            $('#publishVideoIframe').player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');
//        }
//    });



    $("#publishVideoIframe").html('<embed id="player" name="player" ' +
        'src="https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8" ' +
        'width="100%" height="100%" scale="ToFit" bgcolor="#000000" ' +
        'enablejavascript="true" type="video/quicktime" ' +
        'pluginspage="http://www.apple.com/quicktime/download/">' +
        '</embed>');


</script>
