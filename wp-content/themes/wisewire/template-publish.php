<?php
/**
 * Template Name: Publish
 */
?>

<?php get_header(); ?>  

    <?php
      
      /* 
        TODO
        Retina Images for Intro, Banner
      */

      /* Banner */
      $banner_desktop_image = get_field('banner_desktop_image');
      $banner_desktop_text_image = get_field('banner_desktop_text_image');
      $banner_desktop_image_retina = get_field('banner_desktop_image_retina');
      $banner_desktop_text_image_retina = get_field('banner_desktop_text_image_retina');
      $banner_mobile_image = get_field('banner_mobile_image');
      $banner_mobile_text_image = get_field('banner_mobile_text_image');
      $banner_mobile_image_retina = get_field('banner_mobile_image_retina');
      $banner_mobile_text_image_retina = get_field('banner_mobile_text_image_retina');
      $banner_mobile_text = get_field('banner_mobile_text');
      $read_more_text = get_field('read_more_text');
      
    ?>
    
    <section class="intro banner-responsive">
      <div class="hidden-xs">
        <?php if ($banner_desktop_image) { ?>
        	<img src="<?php echo $banner_desktop_image; ?>" alt="" class="img-responsive img-bg" />
        <?php } ?>
        <?php if ($banner_desktop_text_image) { ?>
          <img src="<?php echo $banner_desktop_text_image; ?>" alt="" class="img-responsive img-content" />
        <?php } ?>
      </div>
      
      <div class="visible-xs-block">
        <?php if ($banner_mobile_image) { ?>
        	<img src="<?php echo $banner_mobile_image; ?>" alt="" class="img-responsive img-bg" />
        <?php } ?>
        <?php if ($banner_mobile_text_image) { ?>
        	<img src="<?php echo $banner_mobile_text_image; ?>" alt="" class="img-responsive img-content" />
        <?php } ?>
        <?php if ($banner_mobile_text) { ?>        	
          <div class="text">
            <p>
              <?php echo $banner_mobile_text; ?>
            </p>
          </div>         	
        <?php } ?>
      </div>
    </section><!-- /intro -->

      
      
    <div class="visible-xs-block">

      <?php if( have_rows('content_repeater') ): ?>
                  
      <section class="publish">
        
        <div class="mobile-accordion" id="publish-accordion-1" role="tablist" aria-multiselectable="true">
         
        <?php $i = 1; ?>
      	<?php while( have_rows('content_repeater') ): the_row();  ?>
            
          <?php
            // Fields            
            $icon = get_sub_field('icon');
            $headline_1 = get_sub_field('headline_1');
            $content_1 = get_sub_field('content_1');
            $content_2 = get_sub_field('content_2');
            $cover_video = get_sub_field('cover_video');
            $url_video = get_sub_field('url_video');
            $button_type = get_sub_field('button_type');
            $cta_button_text = get_sub_field('cta_button_text');
          ?>
                    
          <div class="panel panel-default">
            
            <div class="panel-heading" role="tab" id="publishItemHeading<?php echo $i; ?>">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#publish-accordion-<?php echo $i; ?>" href="#publishItem<?php echo $i; ?>" aria-expanded="true" aria-controls="publishItem<?php echo $i; ?>" class="collapsed">
                <?php if ($headline_1) { ?>
                  <?php echo $headline_1; ?>
                <?php } ?>
                </a>
              </h4>
            </div>
            
            <div id="publishItem<?php echo $i; ?>" class="panel-collapse collapse col-style-<?php if ($column == 'left') echo '1'; else echo '2'; ?>" role="tabpanel" aria-labelledby="publishItemHeading<?php echo $i; ?>">
              <div class="panel-body">
  
                <article class="item">
                  
                  <?php if ($icon) { ?>
                  <div class="article-icon <?php echo "article-icon-".$i ?>">
                    <img src="<?php echo $icon; ?>" alt="" />
                  </div>
                  <?php } ?>
                    
                  <?php if ($headline_1) { ?>
                  <div class="article-title <?php echo "article-title-".$i ?>">
                    <h3>
                      <?php echo $headline_1; ?>
                    </h3>
                  </div>
                  <?php } ?>
                  
                  <?php if ($content_1) { ?>
                  	<?php echo $content_1; ?>
                  <?php } ?>

                  
                  
                  <?php  $url_video = get_sub_field('url_video'); ?>
                  <?php if(!empty($url_video)):?>
                    <!--<article class="item" style="margin:30px 0 35px">                                
                      <div class="embed-responsive embed-responsive-16by9">
                        <?php //$attr_video = array('src'=>$url_video , 'poster'=>$cover_video)?>
                        <?php //$video = wp_video_shortcode( $attr_video ) ?> 
                        <?php //echo str_replace("wp-video","wp-video embed-responsive-item" ,$video)?>
                        <div class="left_video"></div>
                        <div class="right_video"></div>
                      </div>              
                    </article>-->
                    <div id="publishVideoIframe" style="width:100%"><iframe width="560" height="315" src="https://www.youtube.com/embed/dHYVRGysj8g" frameborder="0" allowfullscreen></iframe></div>
                    <!--<iframe id="publishVideoIframe" src="" width="100%"  frameborder="0"></iframe>-->
                  <?php endif?> 


                  <?php if ($content_2) { ?>
                    <?php if( $button_type == 'publish'  ){ ?><span style="font-style:italic; padding-top:10px"><?php } ?>
                    <?php echo $content_2; ?>
                    <?php if( $button_type == 'publish'  ){ ?></span><?php } ?>
                  <?php } ?>

                  <div class="learning-more">
                    
                    <?php if ($cta_button_text) { ?>
                      <?php if ($button_type == 'contact'){ ?>                        
                        <a href="#" class="btn btn_<?php echo $button_type ?>" data-toggle="modal" data-target="#contactModal"><?php echo $cta_button_text; ?></a>
                      <?php } else{?>
                        <?php if ( is_user_logged_in() ) { ?>
                          <a href="/platform-<?php echo $button_type ?>"
                             class="btn btn_<?php echo $button_type ?>"
                             target="_blank">
                            <?php echo $cta_button_text; ?>
                          </a>
                        <?php } else {?>
                          <a href="#" class="btn btn-publish-not-loggedin btn_<?php echo $button_type ?>"
                             data-toggle="popover" 
                             data-content='<p class="info">You must be logged in to create</p><p class="clearfix"><a href="/user-login/?publish" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&publish" class="btn">Create account</a></p>'><?php echo $cta_button_text; ?></a>
                        <?php } ?>  
                      <?php } ?>
                    <?php } ?>                    
                  </div>
                         
                </article><!-- /item -->
                
                                 
                
              </div>
            </div>
          </div>
          
          <?php $i++; ?>
      	<?php endwhile; ?>
      
        </div><!-- /mobile-accordion -->
        
      </section><!-- /publish -->
      
      <?php endif; ?>      
            
    </div><!-- /vidible-xs-block -->



        
    <!-- Hidden on <768px -->
      
    <div class="hidden-xs">
        
      <?php if( have_rows('content_repeater') ): ?>
      
      <?php $i = 1; ?>
      <?php while( have_rows('content_repeater') ): the_row();  ?>          

        <section class="publish publish-desktop" style="<?php echo $i!=1? 'background:#f2f2f2':'' ?>">
                    
          <div class="container">
            
            <div class="row row_<?php echo $i; ?>">
              
            <?php
              // Fields
              $icon = get_sub_field('icon');
              $headline_1 = get_sub_field('headline_1');
              $content_1 = get_sub_field('content_1');
              $content_2 = get_sub_field('content_2');
              $cover_video = get_sub_field('cover_video');
              $url_video = get_sub_field('url_video');
              $button_type = get_sub_field('button_type');
              $cta_button_text = get_sub_field('cta_button_text');
            ?>
              <article> 

                <div class="col col-sm-4" >              

                  <div style="align:center">
                    <?php if ($icon) { ?>
                    <div class="article-icon">
                      <img src="<?php echo $icon; ?>" alt="" class="<?php echo "article-icon-".$i ?>" />
                    </div>
                    <?php } ?>
                    
                    <?php if ($headline_1) { ?>
                    <div class="article-title <?php echo "article-title-".$i ?>">
                      <h3>
                        <?php echo $headline_1; ?>
                      </h3>
                    </div>
                    <?php } ?>
                  </div>
                  
                  <?php if ($content_1) { ?>
                  	<?php echo $content_1; ?>
                  <?php } ?>
                  
                  <?php if ($cta_button_text && $i==1) { ?>
                      <?php if($button_type == 'publish') {?>
                        <?php if ( is_user_logged_in() ) { ?>
                          <a href="/platform-<?php echo $button_type ?>"
                             class="btn btn_<?php echo $button_type ?>"
                             target="_blank">
                                <?php echo $cta_button_text; ?>
                          </a>
                        <?php } else {?>
                          <a href="#" class="btn btn-publish-not-loggedin btn_<?php echo $button_type ?>" data-toggle="popover" 
                           data-content='<p class="info">You must be logged in to create</p><p class="clearfix"><a href="/user-login/?publish" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&publish" class="btn">Create account</a></p>'
                        ><?php echo $cta_button_text; ?></a>
                        <?php } ?>  
                      <?php } ?>
                    <?php } ?>  

                </div>

                <div class="col col-sm-8"> 

                  
                  
                   <?php if(!empty($url_video)):?>
                    <!--<article class="item">                                
                      <div class="embed-responsive embed-responsive-16by9">
                        <?php //$attr_video = array('src'=>$url_video , 'poster'=>$cover_video )?>
                        <?php //$video = wp_video_shortcode( $attr_video ) ?> 
                        <?php //echo str_replace("wp-video","wp-video embed-responsive-item" ,$video)?>
                        <div class="left_video"></div>
                        <div class="right_video"></div>
                      </div>              
                    </article>-->
                    <div id="publishVideoIframe2" style="width:100%; height:375px"><iframe width="560" height="315" src="https://www.youtube.com/embed/dHYVRGysj8g" frameborder="0" allowfullscreen></iframe></div>
                  <?php endif?>

                  <?php if ($content_2) { ?>
                    <?php if( $button_type == 'publish' && $i==1 ){ ?><span style="font-style:italic; padding-top:10px; display:block; line-height:20px"><?php } ?>
                    <?php echo $content_2; ?>
                    <?php if( $button_type == 'publish' && $i==1 ){ ?></span><?php } ?>
                  <?php } ?>

                  <div class="learning-more">
                     
                    <?php if ($cta_button_text && $i!=1) { ?>
                      <?php if ($button_type == 'contact'){ ?>                        
                        <a href="#" class="btn btn_<?php echo $button_type ?>" data-toggle="modal" data-target="#contactModal"><?php echo $cta_button_text; ?></a>
                      <?php } else {?>
                        <?php if ( is_user_logged_in() ) { ?>
                          <a href="/platform-<?php echo $button_type ?>"
                             class="btn btn_<?php echo $button_type ?>"
                             target="_blank" >
                                <?php echo $cta_button_text; ?>
                          </a>
                        <?php } else{?>                        
                          <a href="#"
                             class="btn btn-publish-not-loggedin btn_<?php echo $button_type ?>"
                             data-toggle="popover" 
                             data-content='<p class="info">You must be logged in to create</p><p class="clearfix"><a href="/user-login/?publish" class="btn btn-login">Log in</a><a href="/user-login/?action=create-account&publish" class="btn">Create account</a></p>'
                          ><?php echo $cta_button_text; ?></a>
                        <?php } ?>  
                      <?php } ?>
                    <?php } ?>
                  </div>

                </div>

              </article>
                  
            </div>

          </div>
          
        </section><!-- /publish -->
        <?php $i++; ?>

      <?php endwhile; ?>
      
      <?php endif; ?>
                  
    </div><!-- /hidden-xs -->
        
    <?php  if(!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],'/user-login/')!== false && isset($_GET['scroll']) ):?>
    <script type="text/javascript">
      if($( window ).width()<768 ){       
        $('#publishItemHeading1 .panel-title a').removeClass('collapsed');
        $('#publishItem1').addClass('in');
        $('html,body').animate({scrollTop: $('#publishItemHeading1').offset().top}, 800); 
      }else{
        $('html,body').animate({scrollTop: $('.publish-desktop .row_1').offset().top}, 800);   
      }   


    </script>
    <?php endif; ?>
    
   
<?php get_footer(); ?>


 <!--<script type="text/javascript">

        if ( $(window).width() > 768 ){
              $('#publishVideoIframe2').player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');

              $('#publishVideoIframe2').bind(uplynk.events.PLAYER_ERROR, function(e, arg) {
                  console.log(e, arg);
              });
        } else {
              $('#publishVideoIframe').player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');
        }


        $( window ).resize(function() {

          if ( $(window).width() > 768){
              $('#publishVideoIframe2').player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');

          } else {
              $('#publishVideoIframe').player('load', 'https://content.uplynk.com/60fa53f33faf42dda5baebf3c032e73e.m3u8');
          }

        });
    </script>-->