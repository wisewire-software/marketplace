<?php
/**
 * Template Name: Whitepaper Landing Page
 */

?>

<style>
.cd-banner {
    background-image: url("/wp-content/themes/wisewire/img/online-course/oc-banner-1-md.jpg");
    background-repeat:no-repeat;
    background-size: cover;
}

@media (min-width: 768px) {
  .row.equal {
    display: flex;
    flex-wrap: wrap;
  }
}

.headline-block {
	color:white;
	padding-top:15%;
	padding-left:75px;
	padding-right:25px;
	padding-bottom:5%;
}

div.headline-block > h1 {
        color: white;
        font-size:20pt;
}

div.headline-block > h5 {
        color:white;
        font-size:16pt;
}

@media (min-width:992px ) {
div.headline-block > h1 {
	color: white;
	font-size:27pt;
}
div.headline-block > h5 {
        color:white;
        font-size:18pt;
}
}

 .left-course-hero {
   background-color:#00abc6;
   height:100%;
}

.headline-block {
padding-left: 35px
}
</style>
<?php get_header();?>
        <div class="jumbotron" style="padding:0px 0px 0px 0px;">
            <div class="headline row equal">
               <div class="col-xs-12 visible-xs cd-banner" style="background-repeat:no-repeat;background-size: cover;background-position-x: 50%;background-position-y: 50%;width: 100%;height:60%">
               &nbsp;
                </div>
               <div class="col-xs-12 col-sm-6 left-course-hero" style="background-color:#00abc6;height:100%">
                <div class="headline-block"> 
		<h1>4 Keys to Design for Global Health Education</h1>
                  <h5>Wisewire has created a guide to creating effective Health Education learning materials.  Use the 4 keys to Global Health Education to engineer learning materials to acheive your learning goals.</h5>
                  <a class="btn btn-primary buttons-banner btn-pink" href="https://static.wisewire.com/Wisewire+Tips_Public+Health_Web.pdf" style="color:white;"
                    role="button">Download</a>
		</div>
		</div>
               <div class="col-sm-6 hidden-xs cd-banner">
	       &nbsp;
		</div>  
	  </div>
        </div>
<div style="background-color:white;height:65px;">&nbsp;</div>
<?php get_footer();?>
