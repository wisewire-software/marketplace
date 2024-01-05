<?php
/**
 * Template Name: Home message banner under search
 */
?>
<?php get_header();?>

<style>
.home-jumbotron {
    background: #00abc6;
    padding-top: 0px;
    padding-bottom: 0px;
}

@media (min-width: 768px) {
.right-hero-content {
    margin: 40px 100px 50px 100px;
}

.right-hero-content > h2 {

font-size: 18px;

}

@media (min-width: 1200px) {
.right-hero-content {
    margin: 60px 100px 50px 100px;
}
}

}
</style>


<div class="jumbotron home-jumbotron">
    <div class="container-fluid home-hero">
        <div class="row home-hero equal">
            <div class="col-sm-6 left-hero">
                <div class="left-hero-content">
                    <div class="left-hero-text">
                        <div class="hero-text-shade">
                            <h2>Wisewire is a learning design company dedicated to engineering revolutionary materials
                                to achieve
                                your school's vision.</h2>
                            <p class="lead">
                                <a class="btn btn-primary btn-pink" style="color: #FFF;" href="/schedule-demo"
                                    role="button">Schedule A
                                    Demo</a>
                            </p>
                        </div>
                        <div class="hero-jump-down text-center hidden-xs">
                            <a href="#quality"><i class="hero-jump-down-icon fas fas fa-chevron-down"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 right-hero">
                <div class="right-hero-content">
                    <div class="row">
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="/explore/high-school/">
                                <img src="/wp-content/themes/wisewire/img/b2b_pages/svg/icon_digital_skills.svg"
                                    class="market-grid-icon" alt="Bootcamps">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption">High School</span>
                            </a>
                        </div>
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="/explore/higher-education/">
                                <img src="/wp-content/themes/wisewire/img/b2b_pages/svg/icon_college.svg"
                                    class="market-grid-icon" alt="World Languages">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption">College</span>
                            </a>
                        </div>
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="/digital-skills/">
                                <img src="/wp-content/themes/wisewire/img/b2b_pages/svg/preof_dev_icon-new.svg"
                                    class="market-grid-icon" alt="Professional Development">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption">Certification</span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="/technology-enhanced-assessment-bank/">
                                <img src="/wp-content/themes/wisewire/img/b2b_pages/svg/interactive_assesments_icon.svg"
                                    class="market-grid-icon" alt="Interactive Assessments">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption text-center"
                                    style="padding-left:5px;">Interactive<br>Assessments</span>
                            </a>
                        </div>
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="/explore/search/playlist?sepllcheck=1">
                                <img src="/wp-content/themes/wisewire/img/b2b_pages/svg/learning_playlist_icon.svg"
                                    class="market-grid-icon" alt="Learning Playlists">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption">Learning<br>Playlists</span>
                            </a>
                        </div>
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="/filtered/?filter=content_type&filter_value=student%20resource&nogrades=1">
                                <img src="/wp-content/themes/wisewire/img/b2b_pages/svg/homework_practice_icon.svg"
                                    class="market-grid-icon" alt="Homework Practice">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption">Homework<br>Practice</span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="explore/middle/ela-reading/">
                                <img src="https://static.wisewire.com/wp-content/themes/wisewire/img/home-icons/ela_reading_icon.svg"
                                    class="market-grid-icon" alt="ELA/Reading">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption">ELA/Reading<br> </span>
                            </a>
                        </div>
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="explore/middle/mathematics/">
                                <img src="https://static.wisewire.com/wp-content/themes/wisewire/img/home-icons/math_icon.svg"
                                    class="market-grid-icon" alt="Mathematics">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption">Mathematics</span><br>
                                <span class="hero-icon-caption"> </span>
                            </a>
                        </div>
                        <div class="col-xs-4 hero-icon text-center">
                            <a href="explore/middle/science/">
                                <img src="https://static.wisewire.com/wp-content/themes/wisewire/img/home-icons/science_icon.svg"
                                    class="market-grid-icon" alt="Science">
                                <div class="hero-icon-spacer" style="height: 10px;"></div>
                                <span class="hero-icon-caption">Science<br> </span>
                            </a>
                        </div>
                    </div>

                    <div class="row" id="main-search-2">
                        <div class="header-search-field">
                            <form role="search" method="get" id="searchform" class="searchform"
                                action="<?php echo esc_url(home_url('/') . '/explore/search/'); ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control home-search-input" name="search"
                                        placeholder="Search Our Learning Object Marketplace">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn home-search-btn">
                                            <span class="icon"></span>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 15px;padding-bottom: 15px;padding-top: 10px;margin-top: 0px;">
                       <h2 style="font-size:20pt;text-transform: uppercase;">Free Course On Moving Online <a href="#" class="btn btn-pink" style="color:white;">Available Now</a></h2>
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- Jumbotron -->
<a id="quality"></a>

<section class="ww_b2b bg_white">
    <div class="container">
        <h2 class="title-orange text-center">Building World Class Learning&ndash;Objects</h2>
        <h5> Our DNA at Wisewire is learner-centered design and
            development. Our learning materials have been adopted by 48% of institutions in the United States and are
            used by 2.2 million students.
        </h5>
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <img class="img-responsive center-block image-approach"
                    src="https://static.wisewire.com/wp-content/themes/wisewire/img/pedagogy.png" alt="Our Approach">
            </div>
            <div class="col-sm-6 col-xs-12">
                <h3 class="title-lightblue">Wisewire&apos;s Course Frameworks</h3>
                <p>
                    This unique approach jumpstarts foundational course development.
                    It's faster to market and helps students achieve career goals thru industry recognized learning
                    paths.
                </p>
                <h3 class="title-lightblue">Learning Centered Design</h3>
                <p>
                    We believe the learning experience is as important as student progress; therefore, we design for the
                    best experience possible while still optimizing for data and reports.
                </p>
                <h3 class="title-lightblue">World-Class Learning Science Experts</h3>
                <p>
                    Dedicated to engineering revolutionary learning materials, the Wisewire team consists of over 2,500
                    subject matter experts, data scientists, learning architects, and interaction designers who all
                    work together toward a common goal.
                </p>
            </div>
        </div>
</section>

<section class="ww_b2b bg_orange">
    <div class="container">
        <h2 class="title-white text-center">What Makes Us Different?</h2>
    </div>
</section>
<section class="ww_b2b home-approach">
    <div class="container bg_white">
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-4">
                <h3 class="title-lightblue">Our Approach</h3>
                <p>
                    Learning environments are not the same across institutions. As such, our materials are
                    designed to adapt to your model with the best student experience and learning-data
                    fidelity.
                </p>
                <p>
                    <strong>K&ndash;12, AP:</strong>
                    We have designed next-generation learning materials that provide
                    everything needed for project-based learning (PBL) and assessments in math, ELA,
                    science, and history.
                </p>
                <p>
                    <strong>College-Level Courses:</strong>
                    We provide course frameworks to jumpstart development.
                    Frameworks consist of competencies and objectives, content, assessments, and
                    learning resources.
                </p>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-8">
                <img class="img-responsive visible-xs hidden-sm pull-right"
                    src="https://static.wisewire.com/wp-content/themes/wisewire/img/banner2a_xs.jpeg"
                    alt="Our Approach">
                <img class="img-responsive hidden-xs visible-sm pull-right"
                    src="https://static.wisewire.com/wp-content/themes/wisewire/img/banner2a_sm.jpeg"
                    style="padding-right:0px; margin-right: 0px;" alt="Our Approach">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <a class="btn btn-primary btn-pink" href="/schedule-demo" role="button">Let's Talk</a>
            </div>
        </div>
</section>

<section class="ww_b2b bg_lightgray">
    <div class="container">
        <h2 class="title-orange text-center">Built for Efficient Learning</h2>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <p>
                    We know that providing an engaging experience and getting <strong>reliable evidence</strong> of
                    learning
                    are key. Each
                    learning object is designed to be an efficient bridge from the objective to the assessment.
                </p>
            </div>
            <div class="col-xs-12 col-sm-12">
                <img class="img-responsive hidden-xs center-block"
                    src="https://static.wisewire.com/wp-content/themes/wisewire/img/b2b_pages/3_BFEL_m_1.png"
                    alt="Built for Efficient Learning">
                <img class="img-responsive visible-xs-inline-block"
                    src="https://static.wisewire.com/wp-content/themes/wisewire/img/b2b_pages/3_BFEL2_m_1.png"
                    alt="Built for Efficient Learning">
            </div>
            <div class="col-xs-12 col-sm-12">
                <div class="lead content-description">
                    <p>
                        <a class="btn btn-primary btn-pink" href="/partnership-solutions" role="button">View
                            Case
                            Studies</a>
                    </p>
                </div>
            </div>
        </div>
</section>

<?php get_footer();?>
