<?php
/**
 * Template Name: Refer Administrator Create Style Template
 */
?>
<?php get_header();?>
<style>
.b2b_form {
    padding: 20px;
}

.b2b_sample {
    padding: 20px;
}
</style>


<section class="ww_b2b_banner new-banner refer-admin-banner">
    <div class="mask"></div>
    <div class="container">
        <div class="jumbotron">
            <!-- <div class="jumbotron new-banner opm-banner"> -->
            <div class="headline">
                <h1>Register Your School by Referring Your Administrator to Wisewire</h1>
                <h5>Earn a $50 Coupon While You’re At It.</h5>
            </div>
        </div>
    </div>
</section>

<!-- Spacer not needed for pages without banner sub-headings <section
    class="ww_b2b bg_gray ww_b2b_sm_spacer visible-xs">
    <div>
        <br />
    </div>
    </section>
    -->

<?php

$last_name_value = '';
$first_name_value = '';

$current_user = wp_get_current_user();
if ($current_user->exists()) {
    $first_name_value = $current_user->user_firstname;
    $last_name_value = $current_user->user_lastname;
    update_user_meta($current_user, 'ww_show_refer_modal', "false");
}

if (!$current_user->exists()) {
    $option = get_option('wpcf7');
    $site_key = array_values($option['recaptcha'])[0];
    $site_key = "6LfIxjYUAAAAADuR77YyaEq4ZA2C0gYi0kwJZN7p";
    ?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php
}
?>
<section id="register" class="ww_b2b bg_lightgray">
    <div class="container">
        <div class="row">
            <h2 class="title-orange hidden-xs">Fill out the form to the left to send your
                administrator the email to the right.</h2>
            <h2 class="title-orange visible-xs">Fill out the form to send your administrator the email below.</h2>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="b2b_form">
                    <form class="form-horizontal" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                        method="post">
                        <input type="hidden" name="action" value="refer_admin_form">
                        <?php wp_nonce_field("refer_admin_form", "_ww_wp_nonce")?>
                        <?php
if (!$current_user->exists()) {?>
                        <div class="form-group ">
                            <label class="control-label col-3" for="first_name_input">
                                Your First Name
                            </label>
                            <div class="col-3">
                                <input class="form-control" id="first_name_input" name="first_name_input"
                                    value="<?php echo $first_name_value ?>" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-3" for="last_name_input">
                                Your Last Name
                            </label>
                            <div class="col-3">
                                <input class="form-control" id="last_name_input" name="last_name_input"
                                    value="<?php echo $last_name_value ?>" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-3" for="teacher_email_input">
                                Your Email Address
                            </label>
                            <div class="col-3">
                                <input class="form-control" id="teacher_email_input" name="teacher_email_input" value=""
                                    type="text" />
                            </div>
                        </div>

                        <?php
}
?>
                        <div class="form-group ">
                            <label class="control-label col-3" for="admin_name_input">
                                Your Administrator&rsquo;s First Name
                            </label>
                            <div class="col-3">
                                <input class="form-control" id="admin_name_input" name="admin_name_input" type="text"
                                    value="" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-3" for="admin_lastname_input">
                                Your Administrator&rsquo;s Last Name
                            </label>
                            <div class="col-3">
                                <input class="form-control" id="admin_lastname_input" name="admin_lastname_input"
                                    type="text" value="" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-3" for="admin_email_input">
                                Your Administrator&rsquo;s Email Address
                            </label>
                            <div class="col-3">
                                <input class="form-control" id="admin_email_input" name="admin_email_input" type="text"
                                    value="" />
                            </div>
                        </div>
                        <?php
if (!$current_user->exists()) {
    ?>
                        <div class="form-group ">
                            <div class="col-3">
                                <div class="g-recaptcha" data-sitekey="6LfIxjYUAAAAADuR77YyaEq4ZA2C0gYi0kwJZN7p"
                                    data-callback="enableBtn"></div>
                            </div>
                        </div>
                        <?php
}
?>
                        <div class="form-group">
                            <div class="col-3 col-offset-3">
                                <button class="btn btn-primary" id="submit" name="submit" type="submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="b2b_sample">
                    <p>
                        <script>
                        <?php if (!$current_user->exists()) {echo ("$('#submit').prop('disabled', true); \n");}?>
                        var enableBtn = function() {
                            $('#submit').prop('disabled', false);
                        }
                        $("#first_name_input").on("input", function(e) {
                            var input = $(this);
                            var val = input.val();

                            if (input.data("lastval") != val) {
                                input.data("lastval", val);

                                //your change action goes here
                                console.log(val);
                                $('.first_name').text(val);
                            }

                        });

                        $("#last_name_input").on("input", function(e) {
                            var input = $(this);
                            var val = input.val();

                            if (input.data("lastval") != val) {
                                input.data("lastval", val);

                                //your change action goes here
                                console.log(val);
                                $('.last_name').text(val);
                            }

                        });

                        $("#admin_name_input").on("input", function(e) {
                            var input = $(this);
                            var val = input.val();

                            if (input.data("lastval") != val) {
                                input.data("lastval", val);

                                //your change action goes here
                                console.log(val);
                                $('.admin_name').text(val);
                            }

                        });

                        $("#admin_email_input").on("input", function(e) {
                            var input = $(this);
                            var val = input.val();

                            if (input.data("lastval") != val) {
                                input.data("lastval", val);

                                //your change action goes here
                                console.log(val);
                                $('.admin_email').text(val);
                            }

                        });

                        function isValidEmailAddress(emailAddress) {
                            var pattern =
                                /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                            return pattern.test(emailAddress);
                        }

                        $("#admin_email_input").on("input", function(e) {
                            var input = $(this);
                            var val = input.val();
                            if (isValidEmailAddress(val)) {
                                $("#submit").removeClass("disabled");
                                $("#submit").tooltip('destroy');
                                // $("#submit").tootip('destroy');
                            } else {
                                $("#submit").addClass("disabled");

                                $("#submit").tooltip();
                                // $("#submit").tooltip('enable');
                            }
                        });

                        validate_form = function() {

                            if (!$("#admin_email_input").val) {
                                return false;
                            }

                            if (!$("#admin_email_input").val) {
                                return false;
                            }

                            if (!$("#admin_email_input").val) {
                                return false;
                            }

                            if (!$("#admin_email_input").val) {
                                return false;
                            }

                        };
                        </script>
                        <?php
if (!$current_user->exists()) {
    $last_name_value = '[Your Last Name]';
    $first_name_value = '[Your First Name]';
}
?>
                        <b>Here is the email that will be sent to <span class="admin_email"><i>your administrator's
                                    email address</i></span></b> <br />
                        <p>Hi <span class="admin_name">[Your Administrator’s First Name]</span>,</p>
                        <p><span class="first_name">
                                <?php echo $first_name_value ?></span> <span class="last_name">
                                <?php echo $last_name_value ?></span> wanted you to know that they’ve had a great
                            experience using Wisewire’s learning resources in their classroom.
                            Wisewire has made tremendous traction on impacting learning through our custom content
                            creation with schools and districts just like yours.</p>
                        <p>A partnership with Wisewire can help you create:</p>
                        <ul>
                            <li>Project Based Learning (PBL)</li>
                            <li>Assessments in Math, ELA, Science, History, and AP</li>
                            <li>ELL Programs</li>
                            <li>Instructional Design Support</li>
                            <li>Course Development</li>
                        </ul>

                        <p>I’d love to schedule a short to call to show you how we have successfully revolutionized
                            content creation for three leading schools.</p>
                        All the Best,<br />
                         Cathy Steinbrenner | VP, Business Solutions | Wisewire<br />
                         csteinbrenner@wisewire.com | <a href="tel:410-800-4708">(410) 800-4708</a><br />
                        Wisewire.com<br />
                        <br />

                </div>
            </div>
        </div>
    </div>
</section>

<section class="ww_b2b bg_white">
    <div class="container testimonial">
        <blockquote>
            <h5>
                Wisewire&apos;s
                ELA assessments
                allow students to prepare for the cognitive and technology
                demands of high stakes assessments.
                They allow students to address different media forms as stated by the CCSS and be more
                engaged in the content itself.</h5>
            <p class="author"> <strong>Phong Thai, M.Ed., Instructional Specialist.</strong> Southeast Middle School</a>
        </blockquote>
    </div>
</section>


<section class="ww_b2b bg_lightgray">
    <div class="container">
        <h2 class="title-orange text-center">The Wisewire You Have Grown to Love Just Got Even Better</h2>
        <p>If your administrator brings Wisewire to your school you will have more perks
            than ever before.
            Here’s what you and every teacher in your school would get:</p>
    </div>
</section>

<section class="ww_b2b bg_lightgray">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <h3 class="title-lightblue">Free Access to Resources</h3>
                <p>Free access to all Wisewire created resources (you can still use your personal account to do this).
                </p>
            </div>
            <div class="col-xs-12 col-sm-6">
            </div>

            <div class="col-xs-12 col-sm-6">
                <h3 class="title-lightblue">Access to New Resources</h3>
                <p>Access to new, never before seen resources containing brand new materials available only to your
                    school.</p>
            </div>
            <div class="col-xs-12 col-sm-6">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <h3 class="title-lightblue">Provide Feedback to Your Administrator</h3>
                <p>A chance to provide your feedback to your administrator and have new Wisewire resources created as a
                    result of that feedback.</p>
            </div>
            <div class="col-xs-12 col-sm-6">
            </div>

            <div class="col-xs-12 col-sm-6">
                <h3 class="title-lightblue">Collaborate with Other Teachers</h3>
                <p>Collaborate with fellow teachers and gain insight into which resources work best.</p>
            </div>
            <div class="col-xs-12 col-sm-6">
            </div>
        </div>
        <div class="row">
            <p><a href="#register" class="btn btn-primary" style="color:white; ">Register Your School</a></p>
        </div>
        <br />
    </div>

</section>




<script>
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
});

$(function() {
    $('[data-toggle="popover"]').popover()
})
</script>


<?php get_footer();?>
